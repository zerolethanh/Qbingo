<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Helper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    use Helper;
    //
    protected $guarded = ['id'];

    const UPLOAD_DIR = 'upload';

    static $upload_filename;

    /**
     * @param string $file_name
     * @return false|string : path of saved photo
     */
    static function savePhoto($file_name = 'user_photo')
    {
        $photo = request()->file($file_name);

        static::$upload_filename = $photo->getClientOriginalName();

        $exif = @exif_read_data($photo->getRealPath());
        if (!empty($exif['Orientation'])) {
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
            $user_photo = static::UPLOAD_DIR . '/' . self::getPhotoSaveName();
            $done = imagejpeg($photo, storage_path('app/' . $user_photo));
            if ($done) {
                return $user_photo;
            }
        } else {

            if ($photo && $photo->isValid()) {
                return $photo->storeAs(static::UPLOAD_DIR, self::getPhotoSaveName());
            }
        }
    }

    static function getPhotoSaveName()
    {
        return implode('.', [date('YmdHis'), uniqid(), static::$upload_filename]);
    }

//    public function scopeQuizzes($q, $happy_uuid)
//    {
//        return Quiz::where([
//            'happy_uuid' => $happy_uuid,
//        ]);
//    }

}
