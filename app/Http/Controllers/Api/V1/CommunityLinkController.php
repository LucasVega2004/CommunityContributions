<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityLinkForm;
use App\Models\Channel;
use App\Models\CommunityLink;
use App\Queries\CommunityLinksQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class CommunityLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    public function index(Channel $channel = null)
    {
        //
        $query = new CommunityLinksQuery();
        if ($channel != null) {
            if (request()->exists('popular')) {
                $links = $query->getByChannelPopular($channel);
            } else {
                $links = $query->getByChannel($channel);
            }
        } else if (request()->exists('popular')) {
            $links = $query->getMostPopular();
        } else if (request()->exists('search')) {
            $links = $query->getBySearch(trim(request()->get('search')));
        } else {
            $links = $query->getAll();
        }
        $channels = Channel::orderBy('title', 'asc')->get();
        return response()->json(['Links' => $links], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommunityLinkForm $request)
    {


        $user_id = $request->input('user_id');
        $data = $request->validated();


        $approved = Auth::user()->isTrusted();

        $data['user_id'] = $user_id;

        $data['approved'] = $approved;

        $link = new CommunityLink();

        $link->user_id = Auth::id();



        // $data['channel_id'] = 1;
        // dd($data);
        // CommunityLink::create($data);
        // return back()->with('success', 'Item created successfully!');


        if ($link->hasAlreadyBeenSubmitted($data['link'])) {
            if ($approved === false) {
                return response()->json(['info' => 'El enlace ya está publicado y aprobado, pero usted es un usuario no verificado, por lo que no se actualizará en la lista']);
            } elseif ($approved === true) {
                return response()->json(['success' => '¡Enlace actualizado correctamente!']);
            } else {
                return response()->json(['info' => 'Objeto actualizado con éxito, esperando que un moderador lo apruebe']);
            }
        } else {
            CommunityLink::create($data);
            if ($approved === true) {
                return response()->json(['success' => '¡Enlace creado exitosamente!']);
            } else {
                return response()->json(['message' => 'Su enlace será revisado por el administrador antes de su publicación. Gracias por su contribución.'], 201);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CommunityLinkForm $request)
    {
        $linkId = $request->input('link_id');

        // Verifica si el ID es un número entero válido
        if (!ctype_digit($linkId)) {
            return response()->json(['message' => 'Invalid link ID provided.'], 400);
            // El código de estado 400 representa una solicitud incorrecta (Bad Request)
        }

        $communityLink = CommunityLink::find($linkId);

        if (!$communityLink) {
            return response()->json(['message' => 'Link not found.'], 404);
            // El código de estado 404 representa que el recurso no fue encontrado (Not Found)
        }

        return response()->json($communityLink, 200);
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


    // ...

    public function destroy(CommunityLinkForm $request)
    {
        $linkId = $request->input('link_id');

        // Verifica si el ID es un número entero válido
        if (!ctype_digit($linkId)) {
            return response()->json(['message' => 'Invalid link ID provided.'], 400);
            // El código de estado 400 representa una solicitud incorrecta (Bad Request)
        }

        $communityLink = CommunityLink::find($linkId);

        if (!$communityLink) {
            return response()->json(['message' => 'Link not found.'], 404);
            // El código de estado 404 representa que el recurso no fue encontrado (Not Found)
        }

        // Elimina el enlace de la comunidad
        $communityLink->delete();

        return response()->json(['message' => 'Link deleted successfully.'], 200);
    }
}
