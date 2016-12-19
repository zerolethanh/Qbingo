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
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
            header( 'Cache-Control: max-age=37739520, public' );
//            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
        /*
        $file = storage_path("app/upload/$photoname");

        if (file_exists($file)) {
            $fp = fopen($file, 'rb');
            header("Content-Type: image/*");
            header("Content-Length: " . filesize($file));
            fpassthru($fp);

        }

        return 'photo not exists in storage/app/upload';
        */
    }

}
