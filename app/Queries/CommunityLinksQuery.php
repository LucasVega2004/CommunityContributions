<?php


namespace App\Queries;

use App\Models\Channel;
use App\Models\CommunityLink;

class CommunityLinksQuery
{
    public function getByChannel(Channel $channel)
    {
        $query = $channel->CommunityLinks()->where('approved', true)->latest('updated_at')->paginate(25);
        return $query;
    }
    public function getByChannelPopular(Channel $channel)
    {
        $query = $channel->CommunityLinks()->where('approved', true)->withCount('users')->orderBy('users_count', 'desc')->paginate(25);
        return $query;
    }

    public function getBySearch($search)
    {
        $query = CommunityLink::where('approved', true)->where('title', 'like', '%' . $search . '%')->latest('updated_at')->paginate(25);
        return $query;
    }

    public function getAll()
    {
        $query = CommunityLink::where('approved', true)->latest('updated_at')->paginate(25);
        return $query;
    }
    public function getMostPopular()
    {
        $query = CommunityLink::where('approved', true)->withCount('users')->orderBy('users_count', 'desc')->paginate(25);
        return $query;
    }
}
