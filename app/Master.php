<?php

namespace App;


use App\Model\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Master extends Authenticatable
{
    //
    use Helper;
    use Notifiable;

    protected $table = 'masters';

    protected $guarded = ['id'];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
