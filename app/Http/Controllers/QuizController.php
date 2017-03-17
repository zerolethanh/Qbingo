<?php

namespace App\Http\Controllers;

use App\Happy;
use App\Quiz;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class QuizController extends Controller
{
    //

    public function save(Request $request)
    {
        $this->validate($request, [
            'upload_id' => 'required_if:quiz_method,a',
            'quiz_text' => 'required'
        ]);

        DB::beginTransaction();
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

        $this->saveQuizImg($quiz->quiz_number, $quiz->quiz_text);

        DB::commit();
        return $quiz;
    }

    public function saveQuizImg($quiz_number, $quiz_text)
    {
        //convert -font ~/Qbingo/public/fonts/IPAfont00303/ipag.ttf -pointsize 40 -size 352x  caption:日本語Englishベトナム語 caption.gif
        $saveTo = Happy::uploadPath("quizzes", "$quiz_number.gif");
        $text_font = public_path("fonts/IPAfont00303/ipag.ttf");
        $pointsize = 40;
        $size = "352x";
        $caption = $quiz_text;

        //save image
        $cmd = "convert -font $text_font -pointsize $pointsize -size $size caption:'{$quiz_text}' $saveTo";
        info($cmd);

        $process = new Process($cmd);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        //resize image for used in routllet
        $this->resizeQuizImg($saveTo);
        return $saveTo;
    }

    public function resizeQuizImg($originalQuizImgPath)
    {
        $w = UploadController::IMG_W;
        $h = UploadController::IMG_H;
        return system(escapeshellcmd(
            "convert $originalQuizImgPath -background white -gravity center -extent {$w}x{$h} $originalQuizImgPath"
        ));
    }

    public function img($number)
    {
        return PhotoController::downloadAndCacheBrowser(
            Happy::uploadPath('quizzes', "$number.gif")
        );
    }

}
