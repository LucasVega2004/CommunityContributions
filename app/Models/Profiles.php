<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'imageUpload',
        'user_id',
    ];

    public function profiles(): BelongsTo
    {
        return $this->belongsTo(Profiles::class, 'user_id');
    }
}
