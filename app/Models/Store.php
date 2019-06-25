<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'id',
        'name',
        'url',
        'description',
    ];


    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
