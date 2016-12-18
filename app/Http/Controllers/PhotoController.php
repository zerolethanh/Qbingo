<?php

namespace App\Http\Controllers;

//use Log;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    //
    public function getphoto($photoname)
    {

        $file = storage_path("app/upload/$photoname");
//        Log::info($file);

        if (file_exists($file)) {
            $fp = fopen($file, 'rb');
            header("Content-Type: image/*");
            header("Content-Length: " . filesize($file));
            fpassthru($fp);

        }

        return 'photo not exists in storage/app/upload';
    }

}
