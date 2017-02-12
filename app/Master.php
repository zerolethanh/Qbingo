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

    const SESSION_MASTER_KEY = 'master';
    protected $table = 'masters';

    protected $guarded = ['id'];

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public static function user($guard = 'master')
    {
        $master = Auth::guard($guard)->user();
        return $master;
    }

    public static function fromSession()
    {
        return session(self::SESSION_MASTER_KEY);
    }

    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, Shop::class);
    }

}
