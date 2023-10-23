<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Articulo;

class Escritor extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->hasMany(Articulo::class);
    }

    protected $fillable = [
        'id',
        'name',
    ];
}
