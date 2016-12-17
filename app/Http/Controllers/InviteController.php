<?php

namespace App\Http\Controllers;

use App\Happy;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    //

    public function invite()
    {
        $happy = Happy::where(request()->all())->first();

    }
}
