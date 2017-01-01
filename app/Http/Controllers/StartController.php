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

            // get upload face
            switch ($quiz->quiz_method) {
                case self::QUIZ_METHOD_SHUFFLE:
                    //シャッフル
                    $face = Auth::user()->uploads->random();
                    break;

                default:
                    //番号指定
                    $face = Auth::user()->uploads()->where('id', $quiz->upload_id)->first();
                    break;
            }

            // write last quiz number to starts table
            Auth::user()->starts()->create([
                'quiz_number' => $quiz_number,
                'upload_id' => $face->id
            ]);

            session()->put('quiz_number', $quiz_number);
            session()->put('upload_id', $face->id);

            $game_ended = false;
            return compact('quiz', 'face', 'game_ended');
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
        $start = Auth::user()->starts()->where(['quiz_number' => session('quiz_number')])->first();

        if ($start) {
            $start->update([
                'hit' => request('number')
            ]);

            list($hits, $no_hits) = $this->hitsAndNoHits();
        }

        return compact('start', 'hits', 'no_hits');

    }

    public function lastStart()
    {
        return $start = Auth::user()->starts()->latest()->first();
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

        if ($start = $this->lastStart()) {
            $face = Auth::user()->uploads->random();
            $updated = $start->update(['upload_id' => $face->id]);
            if ($updated) {
                session()->put('upload_id', $face->id);
            }
        }
        return compact('face', 'start');
    }

    public function hit_details()
    {
        $start = Auth::user()->starts()->where('hit', request('hit_number'))->with('face', 'quiz')->first();

        return compact('start');
    }
}

