<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    //

    public function save(Request $request)
    {
        $this->validate($request,[
           'upload_id' => 'required_if:quiz_method,a',
            'quiz_text'=>'required'
        ]);
        return $request->all();
    }
}
