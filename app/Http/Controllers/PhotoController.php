<?php

namespace App\Http\Controllers;

//use Log;
use App\Upload;
use Illuminate\Http\Request;

class PhotoController extends Controller
{

    //
    public function getphoto($photoname)
    {
        $file = Upload::uploadPath($photoname);
        $this->sendToBrowser($file);
    }

    public function getThumbPhoto($photoname)
    {
        $file = Upload::uploadThumbPath($photoname);
        $this->sendToBrowser($file);
    }

    public function sendToBrowser($file)
    {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
            header('Cache-Control: max-age=37739520, public');
//            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

}
