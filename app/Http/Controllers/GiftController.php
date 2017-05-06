<?php

namespace App\Http\Controllers;

use App\Gift;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GiftController extends Controller
{
    use SoftDeletes;

    //
    public function gift()
    {
        $row = 100;
        $gifts = Auth::user()->gifts;
        $img_paths = $gifts->pluck('img_path', 'num');
        return
            view('bingo.gift',
                compact(
                    'row',
                    'gifts',
                    'img_paths'
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
            //orient
            $this->autoOrient($this->fullImgPath($imgPath));
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

    public function autoOrient($img)
    {
        $cmd = <<<EOD
magick $img -auto-orient $img
EOD;
        info(compact('cmd'));
        $process = new \Symfony\Component\Process\Process($cmd);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
        }
        return true;
    }

    function imgPath($fullPath = false)
    {
        $ext = pathinfo(\request('qqfilename'), PATHINFO_EXTENSION);
        $filename = \request('id') . '.' . $ext;
        $dir = 'upload/' . Auth::user()->happy_uuid . '/gifts';
        if ($fullPath)
            $dir = storage_path('app/' . $dir);

        return compact('dir', 'filename');
    }

    function fullImgPath(array $path)
    {
        if (!isset($path['dir']) || !isset($path['filename'])) {
            throw new \Error('$path must have dir and filename');
        }
        return storage_path('app/' . $path['dir'] . '/' . $path['filename']);
    }

    public function img()
    {
        $path = \request('path');
        $fpath = storage_path('app/' . $path);
        return response()->download($fpath);
    }
}