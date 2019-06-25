<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'id',
        'name',
        'store_id',
        'url',
        'description',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function parsers()
    {
        return $this->hasMany(Parser::class);
    }
}
