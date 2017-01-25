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

    public function getRegDateAttribute()
    {
        return $this->created_at->format('Y/m/d');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
