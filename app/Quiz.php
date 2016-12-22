<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Model\Helper;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    //
    use Helper;

    protected $table = 'quizzes';

    protected $guarded = ['id'];

    public function scopeNumber($q, $quiz_number)
    {
        return $q->where(
            [
                'happy_uuid' => Auth::user()->happy_uuid,
                'quiz_number' => $quiz_number
            ]);
    }
}

