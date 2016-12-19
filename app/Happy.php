<?php

namespace App;

use App\Model\Helper;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Happy extends Authenticatable
{
    //
    use Helper;
    use Notifiable;

    protected $guarded = ['id'];
    protected $table = 'happies';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function uploads()
    {
        return $this->hasMany(Upload::class, 'happy_uuid', 'happy_uuid');

    }
}
