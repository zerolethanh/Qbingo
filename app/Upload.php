<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Helper;

class Upload extends Model
{
    use Helper;
    //
    protected $guarded = ['id'];
}
