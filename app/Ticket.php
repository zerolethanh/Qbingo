<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    //
    use SoftDeletes;
    protected $guarded = ['id'];

    protected $dates = ['use_date', 'deleted_at'];

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

    public function happy()
    {
        return $this->hasOne(Happy::class);
    }

    public static function id($id)
    {
        return Master::user()->tickets()->where('tickets.id', $id)->first();
    }
}