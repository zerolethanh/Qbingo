<?php

namespace App\Http\Controllers;

//use Log;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{
    const REQUEST_USER_PHOTO_KEY = 'user_photo';
    public static $user_photo;

    static function user_photo()
    {
        return self::$user_photo = request()->file(self::REQUEST_USER_PHOTO_KEY);
    }

    public function getphoto($photoname)
    {
//        $file = Upload::uploadPath($photoname);
//        self::sendToBrowser($file)
        //update 2017-02-19
        return $this->getPhotoByName($photoname);
    }

    public function getThumbPhoto($photoname)
    {
//        $file = Upload::uploadThumbPath($photoname);
//        self::sendToBrowser($file);
        //update 2017-02-19
        return $this->getPhotoThumbByName($photoname);
    }

    public static function sendToBrowser($file)
    {
        self::downloadAndCacheBrowser($file);
    }

    static public function downloadAndCacheBrowser($file)
    {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Cache-Control: max-age=37739520, public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    function no_photo()
    {
        return storage_path('app/nophoto.jpg');
    }

    function getPhotoByName($name)
    {
        $photo = self::fullPhotoPath($name);
        if (!file_exists($photo)) {
            $photo = $this->no_photo();
        }
        self::downloadAndCacheBrowser($photo);
    }

    function getPhotoThumbByName($name)
    {
        $photo = self::fullThumbPath($name);
        if (!file_exists($photo)) {
            $photo = $this->no_photo();
        }
        self::downloadAndCacheBrowser($photo);
    }

    static function photoName()
    {
        static $uniqid;
        if (!$uniqid) {
            $uniqid = uniqid();
        }
        if (self::user_photo()) {
            return $uniqid . '_' . self::user_photo()->getClientOriginalName();
        }
        throw new \Exception(self::REQUEST_USER_PHOTO_KEY . ' can not be found in request');
    }

    static function fullPhotoPath($name = '')
    {
        if (file_exists($name))
            return $name;
        $name = $name ?: self::photoName();
        $dir = storage_path('app/upload/' . Auth::user()->happy_uuid);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir . DIRECTORY_SEPARATOR . $name;
    }

    static function fullThumbPath($name = '')
    {
        if (file_exists($name))
            return $name;
        $name = $name ?: self::photoName();
        $dir = storage_path('app/upload/' . Auth::user()->happy_uuid . '/thumb');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir . DIRECTORY_SEPARATOR . $name;
    }

    public static function savePhoto()
    {
        //if photo is $resource, save $resource
        if ($resource = self::fixPhotoRotation(self::user_photo())) {
            //save image highest quality (100)
            imagejpeg($resource, self::fullPhotoPath(), 100);
            self::savePhotoThumb($resource);
            if (is_resource($resource)) {
                imagedestroy($resource);
            }
        } else {
            //else save photo
            Image::make(self::user_photo())->save(self::fullPhotoPath());
            self::savePhotoThumb(self::user_photo());
        }
    }

    static function savePhotoThumb($photo = null)
    {
        $photo = $photo ?? self::user_photo();
        $img = Image::make($photo)->heighten(Upload::UPLOAD_THUMB_HEIGHT);
        $img->save(self::fullThumbPath());
    }

    /**
     * @param UploadedFile $photo
     * @return null|resource
     */
    static function fixPhotoRotation(UploadedFile $photo = null)
    {
        $photo = $photo ?: self::user_photo();
        $exif = @exif_read_data($photo->getRealPath());
        if (!empty($exif['Orientation']) && in_array($exif['Orientation'], [8, 3, 6])) {
            $resource = imagecreatefromstring(file_get_contents($photo->getRealPath()));
            switch ($exif['Orientation']) {
                case 8:
                    $resource = imagerotate($resource, 90, 0);
                    break;
                case 3:
                    $resource = imagerotate($resource, 180, 0);
                    break;
                case 6:
                    $resource = imagerotate($resource, -90, 0);
                    break;
            }
            return $resource;
        }
        return null;
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.

    }


}
