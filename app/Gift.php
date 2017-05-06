<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    //
    protected $guarded = ['id'];
    protected $appends = ['img_path'];

    public function getImgPathAttribute()
    {
        return '/bingo/gift/img?path=' . ($this->img ?? '') . '&_t=' . time();
    }
}
