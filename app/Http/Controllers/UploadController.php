<?php

namespace App\Http\Controllers;

use App\Upload;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;

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
//        return view('upload.form');
        return 'Must be invited';
    }

    public function upload()
    {
        $this->validate($this->request, [
            'user_name' => 'required',
            'user_sex' => 'required',
            'user_message' => 'required',
            'user_photo' => 'required|file|image',
            'happy_uuid' => 'required|exists:happies'
        ]);

        $data = $this->request->only(Upload::getColumnListing());

        $user_photo = Upload::savePhoto('user_photo');
//        $happy_uuid = Uuid::uuid();//must match with happies.happy_uuid
        return Upload::create(
            array_merge($data, compact('user_photo'))
        );
    }
}
