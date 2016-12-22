<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    //

    public function save(Request $request)
    {
        $this->validate($request, [
            'upload_id' => 'required_if:quiz_method,a',
            'quiz_text' => 'required'
        ]);

        $happy_uuid = $request->user()->happy_uuid;
        $quiz_number = $request->get('quiz_number');

        $quiz = Quiz::number($quiz_number)->first();

        $data = $request->only(Quiz::getColumnListing());
        $data = array_merge($data, ['happy_uuid' => $happy_uuid]);

        if ($request->quiz_method == 's') {
            //シャッフル
            $data['upload_id'] = null;
        }

        if ($quiz) {
            $quiz->update($data);
        } else {
            $quiz = Quiz::create($data);
        }

        return $quiz;
    }

}
