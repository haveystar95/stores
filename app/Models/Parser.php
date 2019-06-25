<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    protected $fillable = [
        'id',
        'link_id',
        'level',
        'pattern',
        'property',
        'field',
    ];


    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
