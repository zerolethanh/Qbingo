<?php

namespace App\Http\Controllers;

use App\Happy;
use App\Start;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    //

    const QUIZ_METHOD_SHUFFLE = 's';
    const QUIZ_METHOD_ASSIGN = 'a';

    /**
     * @param $isRefresh : ブラウザーがリフレッシュするかどうか？
     * @return array
     */
    public function face()
    {
        //check start record is setting hit
        $start = Auth::user()->starts()->where(['quiz_number' => session('quiz_number')])->first();
        if ($start && !$start->hit) {
            return ['error' => '１つの数字を選んでください。'];
        }

        $quizzes = Auth::user()->quizzes()->orderBy('quiz_number', 'asc')->get();

        $q_numbers = $quizzes->pluck('quiz_number');

        $start_max_quiz_number = Auth::user()->starts()->max('quiz_number');

        if (!$start_max_quiz_number) {
            // first quiz number
            $quiz_number = $q_numbers->min();
        } else {
            // next quiz number
            $quiz_number = $q_numbers->first(function ($q_n) use ($start_max_quiz_number) {
                return $q_n > $start_max_quiz_number;
            });
        }

        if (isset($quiz_number)) {

            // get quiz from quiz number
            $quiz = $quizzes->first(function ($q) use ($quiz_number) {
                return $quiz_number == $q->quiz_number;
            });

            $uploads = Auth::user()->uploads;
            // get upload face
            switch ($quiz->quiz_method) {
                case self::QUIZ_METHOD_SHUFFLE:
                    //シャッフル
                    $face = $uploads->random();
                    break;

                default:
                    //番号指定
                    $face = Auth::user()->uploads()->where('id', $quiz->upload_id)->first();
                    break;
            }

            $face_index = array_search($face->id, $uploads->pluck('id')->toArray());
            $quiz_index = array_search($quiz->id, $quizzes->pluck('id')->toArray());

            // write last quiz number to starts table
            Auth::user()->starts()->create([
                'quiz_number' => $quiz_number,
                'upload_id' => $face->id
            ]);

            session()->put('quiz_number', $quiz_number);
            session()->put('upload_id', $face->id);

            $game_ended = false;
            return compact('quiz', 'face', 'game_ended', 'face_index', 'quiz_index');
        }

        $game_ended = true;
        return compact('game_ended');

    }

    public function quiz(Request $request)
    {
        return $this->face();

    }

    public function hit()
    {
        // 最後のstarts's record を更新
//        $start = $this->lastStart();//Auth::user()->starts()->where(['quiz_number' => session('quiz_number')])->first();
//        if ($start) {
//            $start->update([
//                'hit' => request('number')
//            ]);
//        }

        // update前のレコードか？レコードを追加していくか？
        // update when 前のレコードのhitが設定されない場合。
        // else new record
        $start = $this->lastQuestionedStartButNoHitNumberSetted();
        if ($start) {
            $start->update([
                'hit' => request('number')
            ]);
        } else {
            // レコード追加していく
            $start = Auth::user()->starts()->create(
                [
                    'hit' => request('number')
                ]
            );
        }

        list($hits, $no_hits) = $this->hitsAndNoHits();
        return compact('start', 'hits', 'no_hits');

    }

    public function lastStart()
    {
        return $start = Auth::user()->starts()->latest()->first();
    }

    public function lastQuestionedStartButNoHitNumberSetted()
    {
        return Auth::user()->starts()->whereNotNull('quiz_number')->whereNotNull('upload_id')->whereNull('hit')->latest()->first();
    }

    public function hitsAndNoHits()
    {
        $hits = Auth::user()->starts()->pluck('hit')->filter(function ($hit) {
            return isset($hit);
        })->values();

        $no_hits = collect(range(1, 75))->diff($hits)->values();

        return [$hits, $no_hits];
    }

    public function restart_game()
    {
        $restart = Auth::user()->starts()->delete();

        session()->flush();
        return compact('restart');
    }


    public function undo()
    {
        if ($start = $this->lastStart()) {
            $start->hit = null;
            $start->save();
        }
        return compact('start');
    }

    public function face_shuffle()
    {
        $uploads = Auth::user()->uploads;
        if ($start = $this->lastStart()) {
            $face = $uploads->random();
            $updated = $start->update(['upload_id' => $face->id]);
            if ($updated) {
                session()->put('upload_id', $face->id);
            }

            $face_index = array_search($face->thumb, $uploads->pluck('thumb')->toArray());
        }


        return compact('face', 'start', 'face_index');
    }

    public function hit_details()
    {
        $start = Auth::user()->starts()->where('hit', request('hit_number'))->with('face', 'quiz')->first();

        return compact('start');
    }

    public function update_hit_number(Request $request)
    {
        $this->validate($request, [
            'newNumber' => 'numeric | max:75',
            'oldNumber' => 'required'
        ]);
        $start = Auth::user()->starts()->where('hit', $request->oldNumber)->first();
        if ($start) {
            $start->update(
                [

                    'hit' => $request->newNumber
                ]
            );
        }

        return $start;
    }

}

