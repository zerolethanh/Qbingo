<?php

namespace App\Http\Controllers;

use App\Gift;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    use SoftDeletes;

    //
    public function gift()
    {
        $row = 100;

        return
            view('bingo.gift',
                compact(
                    'row'
                )
            );
    }

    public function upload()
    {
        $imgPath = $this->imgPath();
        $path = \request()->file('qqfile')->storeAs(
            $imgPath['dir'], $imgPath['filename']
        );
        if ($path) {
            $gift = Auth::user()->gifts()->find(\request('id'));
            if ($gift) {
                $gift->num = \request('id');
                $gift->img = $path;
                $gift->save();
            } else {
                $gift = Auth::user()->gifts()->create([
                    'num' => \request('id'),
                    'img' => $path
                ]);
            }
            return [
                'gift' => $gift,
                'path' => $path,
                'success' => true
            ];
        }
        return [
            'success' => false
        ];
    }

    function imgPath()
    {
        $ext = pathinfo(\request('qqfilename'), PATHINFO_EXTENSION);
        $filename = \request('id') . '.' . $ext;
        $dir = 'upload/' . Auth::user()->happy_uuid . '/gifts';
        return compact('dir', 'filename');
    }
}