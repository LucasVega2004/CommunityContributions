<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

    use HasFactory;

    public function communitylinks()
    {
        return $this->hasMany(CommunityLink::class);
    }

    protected $fillable = [
        'channel_id',
        'title',
        'slug',
        'color'
    ];
}
