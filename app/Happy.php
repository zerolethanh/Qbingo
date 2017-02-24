<?php

namespace App;

use App\Model\Helper;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class Happy extends Authenticatable
{
    //
    use Helper;
    use Notifiable;

    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'happies';

    protected $dates = ['deleted_at'];
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

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'happy_uuid', 'happy_uuid');
    }

    public function starts()
    {

        return $this->hasMany(Start::class, 'happy_uuid', 'happy_uuid');
    }

    public function scopeQuizNumber($q, $quiz_number)
    {
        return Auth::user()->quizzes()->where('quiz_number', $quiz_number);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
