<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $guarded = ['id'];

    protected $dates = ['use_date'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getIssuedPasswordDateAttribute()
    {
        return $this->created_at->format('Y/m/d');
    }

    public function getFormattedUseDateAttribute()
    {
        return $this->use_date->format('Y/m/d');
    }
}
