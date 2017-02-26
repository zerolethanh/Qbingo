<?php

namespace App;

use App\Model\Helper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

//use Illuminate\Database\Eloquent\Model;

class Shop extends Authenticatable
{
    //
    use SoftDeletes;
    use Helper;
    const SESSION_SHOP_KEY = 'shop';
    const REQUEST_HEADER_SHOP_ID_KEY = 'X-SHOP-ID';
    protected $guarded = ['id'];

    protected $hidden = ['password'];

    static public function user()
    {
        return Auth::guard('shop')->user();
    }

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

    public function happies()
    {
        return $this->hasManyThrough(Happy::class, Ticket::class);
    }

//    public function happies_activities()
//    {
//        $tickets = $this->happies()->with('activities')->get();
//        return $tickets;
//    }

    public static function findId($id = null)
    {
        $shop = Master::user()->shops()->find($id);
        session(compact(static::SESSION_SHOP_KEY));
        view()->share(compact(static::SESSION_SHOP_KEY));
        return $shop;
    }

    public static function latestOrder()
    {
        return Master::user()->shops()->latest()->get();
    }

    public static function fromRequest()
    {
        try {
            $shop_id = decrypt(request()->header(self::REQUEST_HEADER_SHOP_ID_KEY));
            return self::find($shop_id);
        } catch (DecryptException $e) {
            return null;
        }
    }

    static function fromHeader()
    {
        return static::fromRequest();
    }

    public static function fromSessionOrRequest()
    {
        return session(static::SESSION_SHOP_KEY) ?: static::fromRequest();
    }

}
