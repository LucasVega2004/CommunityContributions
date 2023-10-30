<?php

namespace App\Http\Controllers;

use App\Models\CommunityLink;
use App\Queries\CommunityLinksQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Channel;
use App\Http\Requests\CommunityLinkForm;


class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Channel $channel = null)
    {


        $query = new CommunityLinksQuery;


        if (request()->exists('popular')) {
            $links = $query->getMostPopular();
        } else {
            if ($channel == null) {
                $links = $query->getAll();
            } else {
                $links = $query->getByChannel($channel);
            }
        }

        $channels = Channel::orderBy('title', 'asc')->get();

        return view('community/index', compact('links', 'channels', 'channel'));

        // Obtenemos la lista de todos los canales

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityLinkForm $request)
    {

        $data = $request->validated();
        $approved = Auth::user()->isTrusted();
        $data['user_id'] = Auth::id();
        $data['approved'] = $approved;
        $link = new CommunityLink();
        $link->user_id = Auth::id();



        // $data['channel_id'] = 1;
        // dd($data);
        // CommunityLink::create($data);
        // return back()->with('success', 'Item created successfully!');


        if ($link->hasAlreadyBeenSubmitted($data['link'])) {

            if ($approved == false) {
                return back()->with('info', 'El enlace ya está publicado y aprobado pero usted es un usuario no verificado, por lo que no se actualizará en la lista');
            }
            if ($approved == true) {
                return back()->with('success', 'link actualizado correctamente!');
            } else {
                return back()->with('info', 'object successfully updated, waiting for a moderator to accept it');
            }
        } else {
            CommunityLink::create($data);
            if ($approved == true) {
                return back()->with('success', 'link created successfully!');
            } else {
                return back()->with('info', 'object successfully created, waiting for a moderator to accept it');
            }
        }

        // return back();
    }




    /**
     * Display the specified resource.
     */
    public function show(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommunityLink $communityLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommunityLink $communityLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommunityLink $communityLink)
    {
        //
    }
}
