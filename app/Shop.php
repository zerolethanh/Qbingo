<?php

namespace App;

use App\Model\SafeModel;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Illuminate\Database\Eloquent\Model;

class Shop extends SafeModel
{
    //
    use SoftDeletes;

    const SESSION_SHOP_KEY = 'shop';
    const REQUEST_HEADER_SHOP_ID_KEY = 'SHOP-ID';
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

    public static function id($id)
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

    public static function fromSessionOrRequest()
    {
        return session(static::SESSION_SHOP_KEY) ?: static::fromRequest();
    }

}
