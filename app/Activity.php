<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $guarded = ['id'];
    protected $dates = ['last'];

    public function happy()
    {
        return $this->belongsTo(Happy::class);
    }
}
