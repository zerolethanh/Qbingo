<?php

namespace App\Http\Controllers;

use App\Master;
use App\Upload;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    //

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
        $this->validate($this->request, [
            'user_name' => 'required',
            'user_sex' => 'required',
            'user_message' => 'required',
            PhotoController::REQUEST_USER_PHOTO_KEY => 'required|file|image',
            'happy_uuid' => 'required|exists:happies'
        ]);

        $data = $this->request->only(Upload::getColumnListing());

        DB::beginTransaction();
//        list($user_photo, $thumb) = Upload::savePhoto('user_photo');
        PhotoController::savePhoto();
        $user_photo = PhotoController::fullPhotoPath();
        $thumb = PhotoController::fullThumbPath();
        $number = Upload::where('happy_uuid', $this->request->happy_uuid)->max(('number')) + 1;
        $upload = Upload::create(array_merge($data, compact('user_photo', 'thumb', 'number')));
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
        if ($master = Master::fromRequest()) {
            $uploads = Upload::latest()->get();
            $collect = collect($uploads)->groupBy('happy_uuid');

            foreach ($collect as $happy => $uploads) {
                foreach ($uploads as $idx => $upload) {

                    $upload->update(['number' => $idx + 1]);
                }
            }
        }
    }

}
