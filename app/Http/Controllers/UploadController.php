<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UploadController extends Controller
{
    //

    public function index()
    {
        return view('upload.form');
    }

    public function upload()
    {
        $this->validate(request(), [
            'user_name' => 'required',
            'user_sex' => 'required',
            'user_message' => 'required',
            'user_photo' => 'required|file|image',
        ]);
        $data = request()->only(Upload::getColumnListing());

        $user_photo = request()->file('user_photo')->store('upload');

        return Upload::create(
            array_merge($data, compact('user_photo'))
        );
    }
}
