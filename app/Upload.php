<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Helper;
use Illuminate\Http\UploadedFile;

class Upload extends Model
{
    use Helper;
    //
    protected $guarded = ['id'];

    const UPLOAD_DIR = 'upload';

    static function savePhoto($file_name = 'user_photo')
    {
        $photo = request()->file($file_name);
        if ($photo && $photo->isValid()) {
            return $photo->storeAs(static::UPLOAD_DIR, self::getPhotoSaveName($photo));
        }
    }

    static function getPhotoSaveName(UploadedFile $photo)
    {
        return implode('.', [date('YmdHis'), uniqid(), $photo->getClientOriginalName()]);
    }

//    public function scopeQuizzes($q, $happy_uuid)
//    {
//        return Quiz::where([
//            'happy_uuid' => $happy_uuid,
//        ]);
//    }

}
