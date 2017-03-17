<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JavaScript;
use PHPQRCode\Constants;

class BingoController extends Controller
{
    //

    function __construct()
    {
        $this->middleware('must_logged_in');
    }

    public function index()
    {
        return redirect('/');
    }

    public function uploadList()
    {
        $uploads = Auth::user()->uploads()->orderBy('number', 'desc')->get()->toArray();
        $url = $this->getUrl();
        \PHPQRCode\QRcode::png($url, $this->QRSavePath(), Constants::QR_ECLEVEL_L, 4, 2);
        return $this->uploadList_view()->with(compact('uploads', 'url'));
    }

    function uploadList_view()
    {
        if (IS_MOBILE) {
            switch ($view = session('upload_list_view')) {
                case 'rec2':
                    return view("mobile.{$view}");
                case 'rec':
                    return view("mobile.{$view}");
                case 'pdf':
                    return view("mobile.{$view}");
                default:
                    return view("mobile.rec2");
            }
        }
        return view('bingo.uploadList');
    }

    public function QRSavePath()
    {
        $dir = storage_path('app/qr/');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir . Auth::user()->happy_uuid . '.png';

    }

    public static function getUrl()
    {
        $happy_id = Auth::user()->happy_id;
        $happy_code = Auth::user()->happy_code;

        $query = http_build_query(get_defined_vars());
        $url = url('/invite?' . $query);//InviteControllerへ
        return $url;
    }

    public function quizzes()
    {
        $quizzes = request()->user()->quizzes;
        $quiz_samples = Quiz::quiz_samples();
        return $this->quizzes_view()
            ->with(compact('quizzes', 'quiz_samples'));
    }

    function quizzes_view()
    {
        if (IS_MOBILE) {
            return view('mobile.quiz');
        }
        return view('bingo.quiz');
    }

    public function start()
    {
        $uploads = Auth::user()->uploads;
        $faces = $uploads->pluck('user_photo');
        $quizzes = Auth::user()->quizzes()->orderBy('quiz_number','asc')->get();


        // hits and no hits numbers
        $hits = request()->user()->starts()->pluck('hit');
        $hits = $hits->filter(function ($h) {
            return isset($h);
        });

        $no_hits = collect(range(1, 75))->diff($hits);

        if (
            ($quiz_number = session('quiz_number'))
            && ($face_id = session('upload_id'))
        ) {
            $start = Auth::user()->starts()->where('quiz_number', $quiz_number)->first();
            if ($start) {
                $quiz = Auth::user()->quizzes()->where('quiz_number', $quiz_number)->first();
                $face = Auth::user()->uploads()->where('id', $face_id)->first();

            }
        }

//        JavaScript::put(['bingo_hit_numbers' => $hits]);
//        foreach ($uploads as $upload) {
//            Upload::createThumbFromUpload($upload);
//        }
        return view('bingo.start', compact('faces', 'quizzes', 'hits', 'no_hits', 'start', 'face', 'quiz', 'uploads'));
    }

    function description()
    {
        if (IS_MOBILE)
            return view('mobile.bingo');
        return view('bingo.description');
    }

    public function face()
    {

    }

    public function quiz()
    {

    }
}
