<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Start extends Model
{
    //
    protected $table = 'starts';

    protected $guarded = ['id'];

    protected $casts = [
        'hit' => 'int'
    ];

    public function scopeMaxQuizNumber($q)
    {
        return $q->where('happy_uuid', Auth::user()->uuid)->max('quiz_number');
    }

    public function scopeQuizNumber($q, $quiz_number)
    {
        return $q->where(['quiz_number' => $quiz_number]);
    }

    public function upload()
    {
        return $this->hasOne(Upload::class, 'id', 'upload_id');
    }

    public function face()
    {
        return $this->upload();
    }

    public function quiz()
    {
        return $this
            ->hasOne(Quiz::class, 'quiz_number', 'quiz_number')
            ->where('happy_uuid', Auth::user()->happy_uuid);
    }
}
