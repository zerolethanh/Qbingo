<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $guarded = ['id'];

    protected $hidden = ['password'];

    public function master()
    {
        return $this->belongsTo(Master::class);
    }
}
