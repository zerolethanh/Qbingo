<?php

namespace App;


use App\Model\Helper;
use Illuminate\Contracts\Encryption\DecryptException;
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
    const REQUEST_HEADER_MASTER_ID_KEY = 'X-MASTER-ID';

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

    public static function fromRequest()
    {
        try {
            $master_id = decrypt(request()->header(self::REQUEST_HEADER_MASTER_ID_KEY));
            return self::find($master_id);
        } catch (DecryptException $e) {
            return null;
        }
    }
    static function fromHeader()
    {
        return static::fromRequest();
    }

}
