<?php

namespace App\Http\Controllers;

use App\Master;
use App\Upload;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ViewErrorBag;

class UploadController extends Controller
{
    //
    const IMG_W = 352;
    const IMG_H = 308;
    private $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return '招待リンクからアクセスしてください。';
    }

    public function upload()
    {
        if (!($origin_image_fullpath = session('origin_image_fullpath'))
            || !($editted_image_fullpath = session('editted_image_fullpath'))
        ) {
            return back()->withErrors('ファイルを選択して下さい。');
        }
        $this->validate($this->request, [
            'user_name' => 'required',
            'user_sex' => 'required',
            'user_message' => 'required',
            PhotoController::REQUEST_USER_PHOTO_KEY => 'required|file|image',
            'happy_uuid' => 'required|exists:happies'
        ], [
                'user_name.required' => '名前が必須です。',
                'user_message.required' => 'お祝いメッセージが必須です。',
                PhotoController::REQUEST_USER_PHOTO_KEY . '.required' => 'ファイルを選択して下さい。'
            ]
        );

        $data = $this->request->only(Upload::getColumnListing());

        //db begin transaction
        DB::beginTransaction();
        //save photo
//        PhotoController::savePhoto();
        //get full photo path
        $user_photo = PhotoController::fullPhotoPath();
        copy($origin_image_fullpath, $user_photo);
        //get full photo thumb path
        $thumb = PhotoController::fullThumbPath();
        copy($editted_image_fullpath, $thumb);
        //get upload's serial number be saved
        $number = Upload::where('happy_uuid', $this->request->happy_uuid)->max(('number')) + 1;
        //create upload
        $upload = Upload::create(array_merge($data, compact('user_photo', 'thumb', 'number')));
        //commit database
        DB::commit();

        if ($upload) {
            return view('upload.form.upload_success');
        }
    }

    public function uploadConfirm()
    {

    }

    public function updateDbNumber()
    {
        //master only can update
        if ($master = Master::user()) {
            $uploads = Upload::latest()->get();
            $collect = collect($uploads)->groupBy('happy_uuid');
            $updated = [];
            foreach ($collect as $happy => $uploads) {
                foreach ($uploads as $idx => $upload) {
                    $updated[] = $upload->update(['number' => $idx + 1]);
                }
            }
            return $updated;
        }
        return 'can be access by master only';
    }

}
