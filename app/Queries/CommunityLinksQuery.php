<?php


namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{


    public function getByChannel(Channel $channel)
    {
        # code...
        $links = CommunityLink::where('channel_id', $channel->id)->where('approved', 1)->latest('updated_at')->paginate(25);
        return $links;
    }

    public function getAll()
    {
        # code...
        $links = CommunityLink::where('approved', 1)->latest('updated_at')->paginate(25);
        return $links;
    }

    public function getMostPopular()
    {
        # code...
        $links = CommunityLink::where('approved', 1)->withCount("users")->orderBy("users_count", "desc")->paginate(25);
        return $links;
    }
}
