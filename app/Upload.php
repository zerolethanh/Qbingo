<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Helper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Upload extends Model
{
    use Helper;
    //
    protected $guarded = ['id'];

    const UPLOAD_DIR = 'upload';

    static $upload_filename;

    static $photo_save_name;

    const UPLOAD_THUMB_HEIGHT = 500;

    /**
     * @param string $file_name
     * @return false|string : path of saved photo
     */
    static function savePhoto($file_name = 'user_photo')
    {
        $photo = request()->file($file_name);

        static::$upload_filename = $photo->getClientOriginalName();

        $exif = @exif_read_data($photo->getRealPath());
        if (!empty($exif['Orientation']) && in_array($exif['Orientation'], [8, 3, 6])) {
            $source = imagecreatefromstring(file_get_contents($photo->getRealPath()));
            switch ($exif['Orientation']) {
                case 8:
                    $photo = imagerotate($source, 90, 0);
                    break;
                case 3:
                    $photo = imagerotate($source, 180, 0);
                    break;
                case 6:
                    $photo = imagerotate($source, -90, 0);
                    break;
            }
            // save new rotated image to storage/upload/ directory
            $done = imagejpeg($photo, self::uploadPath(self::getPhotoSaveName()));
            if ($done) {
                imagedestroy($source);
                imagedestroy($photo);
                //save thumb img
                $thumb_path = self::saveUploadThumb();

                //img path
                $upload_path = static::UPLOAD_DIR . '/' . self::getPhotoSaveName();

            }

        } else {

            //save img
            $upload_path = $photo->storeAs(static::UPLOAD_DIR, self::getPhotoSaveName());

            //save thumb img
            $thumb_path = self::saveUploadThumb();

        }

        return [$upload_path, $thumb_path];
    }

    static function saveUploadThumb($uploadPath = null)
    {
        if (is_null($uploadPath) || !is_file($uploadPath))
            $uploadPath = self::uploadPath(self::getPhotoSaveName());
        $img = Image::make($uploadPath)->heighten(static::UPLOAD_THUMB_HEIGHT);

        $thumb_path = self::uploadThumbPath();
        $img->save($thumb_path);

        return self::getPhotoSaveName();
    }

    static function uploadPath($path = null)
    {
        return storage_path('app/upload/' . ($path ?? ''));
    }

    static function uploadThumbPath($path = null)
    {
        $thumb_dir = storage_path('app/upload/thumb/');
        if (!is_dir($thumb_dir)) {
            $created_thumb_dir = mkdir($thumb_dir);
            if (!$created_thumb_dir) {
                return 'can not create ' . $thumb_dir;
            }
        }
        if (is_null($path))
            $path = self::getPhotoSaveName();
        return $thumb_dir . '/' . ($path ?? '');
    }


    static function getPhotoSaveName()
    {
        if (!static::$photo_save_name) {
            return static::$photo_save_name = implode('.', [date('YmdHis'), uniqid(), static::$upload_filename]);
        }
        return static::$photo_save_name;
    }

//    public function scopeQuizzes($q, $happy_uuid)
//    {
//        return Quiz::where([
//            'happy_uuid' => $happy_uuid,
//        ]);
//    }

}
