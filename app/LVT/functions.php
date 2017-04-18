<?php
/**
 * User: ZE
 * Date: 2017/01/30
 * Time: 20:34
 */

if (!function_exists('updateView')) {
    function updateView($view, $data = null, $UPDATE_VIEW_HTML_ID = null)
    {
        $UPDATE_VIEW_HTML_ID = $UPDATE_VIEW_HTML_ID ?: last(explode('.', $view));

        if (!view()->exists($view)) {
            throw  new ErrorException("$view not be found");
        }

        //render view string
        ${$UPDATE_VIEW_HTML_ID} = view($view, compact('data'))->render();
        $date = date('c');
        return get_defined_vars();
//            [
//            'UPDATE_VIEW_HTML_ID' => $html_id,
//            "$html_id" => $viewRenderString,
//            'time' => time(),
//            'vars' => get_defined_vars()
//        ];
//        return compact("$html_id", "UPDATE_VIEW_HTML_ID", 'data');
    }
}
if (!function_exists('dbStartLog')) {
    function dbStartLog()
    {
        app('db')->enableQueryLog();
    }
}
if (!function_exists('dbEndLog')) {
    function dbEndLog(Closure $closure = null)
    {
        $sqls = app('db')->getQueryLog();
        $sqls_string = "";

        foreach ($sqls as $sql) {
            $bindings = $sql['bindings'];
//            $time = $sql->time;
            $sql = $sql['query'];
            $sql = dbBindings($sql, $bindings);
            $sqls_string .= $sql . '; ' . PHP_EOL;
        }

        if (isset($sqls_string)) {
            app('log')->info($sqls_string);
            if (!is_null($closure)) {
                $closure($sqls_string);
            }
            return $sqls_string;
        }
        app('db')->disableQueryLog();
    }

    function dbBindings($sql, array $bindings)
    {
        if (empty($bindings)) {
            return $sql;
        }

        $placeholder = preg_quote('?', '/');
        foreach ($bindings as $binding) {
            $binding = is_numeric($binding) ? $binding : "'{$binding}'";
            $sql = preg_replace('/' . $placeholder . '/', $binding, $sql, 1);
        }

        return $sql;
    }
}

if (!function_exists('saveBlob')) {
    function saveBlob($blobdata = 'blobdata', $dir = 'blobdata')
    {
        //$blobdata head : data:image/jpeg;base64,
        $blobdata = request($blobdata);
//        info(strBytes($blobdata, 'kb') . ' kb');
        list($type, $blobdata) = explode(';', $blobdata);
        list(, $blobdata) = explode(',', $blobdata);
        $blobdata = base64_decode($blobdata);

        $filename = request()->session()->token();//\Faker\Provider\Uuid::uuid() . date('_Y_m_d');
        $fileExtension = last(explode('/', $type));

        $public_dir = public_path($dir);
        if (!is_dir($public_dir)) {
            mkdir($public_dir, 0777, true);
        }
        $file_name = "{$filename}.{$fileExtension}";
        $save_to = "{$public_dir}/{$file_name}";

        $write = file_put_contents($save_to, $blobdata);

        if ($write) {
            \Intervention\Image\Facades\Image::make($save_to)
                ->orientate()
                ->save($save_to, 100);
            return [
                'saved' => true,
                'download_url' => url("/{$dir}/{$file_name}?_t=" . time()),
                'file_name' => $file_name
            ];
        }
        return [
            'saved' => false,
            'err' => true,
            'err_message' => 'can not save to ' . $save_to
        ];
    }
}
if (!function_exists('saveBlob2')) {
    function saveBlob2($dir = 'blobdata')
    {
        $filename = request()->session()->token();//\Faker\Provider\Uuid::uuid() . date('_Y_m_d');
        $fileExtension = last(explode('.', request('qqfilename')));
        $public_dir = public_path($dir);
        if (!is_dir($public_dir)) {
            mkdir($public_dir, 0777, true);
        }
        $file_name = "{$filename}.{$fileExtension}";
        $save_to = "{$public_dir}/{$file_name}";
        $file = request()->file('qqfile');
//        dd($file->extension(), $file->path(), $_FILES["qqfile"]["tmp_name"]);
//        $write = $file->store($save_to);
        $write = false;
        if ($file->isValid()) {
            $write = move_uploaded_file($file->path(), $save_to);
            if ($write) {
//                \Intervention\Image\Facades\Image::make($save_to)
//                    ->orientate()
//                    ->save($save_to, 100);
                return [
                    'success' => $write,
                    'download_url' => url("/{$dir}/{$file_name}?_t=" . time()),
                    'file_name' => $file_name
                ];
            }
        }
        return [
            'success' => $write,
            'err' => true,
            'err_message' => 'can not save to ' . $save_to
        ];
    }
}
if (!function_exists('save_cropped_image')) {
    function save_cropped_image()
    {
        $cropped_data = request('cropped_data');
        $scale = $cropped_data['scale'];
        $angle = $cropped_data['angle'];
        $h = $cropped_data['h'];
        $w = $cropped_data['w'];
        $x = $cropped_data['x'];
        $y = $cropped_data['y'];
        $file_name = $cropped_data['file_name'];
        $origin_image_url = $cropped_data['origin_image_url'];

        $file_full_path = public_path("blobdata/{$file_name}");

        if (!file_exists($file_full_path)) {
            // file not found
            return [
                'err' => true,
                'err_message' => $file_name . ' not found'
            ];
        };

//        $img = Intervention\Image\Facades\Image::make($file_full_path);
//        $width = $img->width();
//        $height = $img->height();

        $blobdata = 'blobdata';
        if (!is_dir($public_blobdata = public_path($blobdata))) {
            mkdir($public_blobdata, 0777, true);
        }
        $editted_file_name = "editted_{$file_name}";
//        $img->resize(intval($width * $scale), intval($height * $scale))
//            ->rotate(-$angle)
//            ->crop($w, $h, $x, $y)
//            ->save("$public_blobdata/$editted_file_name", (int)100);
        $scale100 = 100 * $scale;
        $crop_cmd =
            escapeshellcmd("magick $file_full_path -resize '{$scale100}%' -rotate -$angle -crop {$w}x{$h}+{$x}+{$y} $public_blobdata/$editted_file_name");
        $output = '';
        $result = '';
        exec($crop_cmd, $output, $result);
        info(compact('crop_cmd', 'output', 'result'));
        session([
            'origin_image_fullpath' => $file_full_path,
            'editted_image_fullpath' => "$public_blobdata/$editted_file_name"
        ]);
        return [
            'saved' => true,
            'origin_image_url' => $origin_image_url,
            'editted_image_url' => url("$blobdata/$editted_file_name?_t=" . time())
        ];
    }
}
if (!function_exists('strBytes')) {
    /**
     * Count the number of bytes of a given string.
     * Input string is expected to be ASCII or UTF-8 encoded.
     * Warning: the function doesn't return the number of chars
     * in the string, but the number of bytes.
     * See http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
     * for information on UTF-8.
     *
     * @param string $str The string to compute number of bytes
     *
     * @return int The length in bytes of the given string.
     */
    function strBytes($str, $in = 'b')
    {
        // STRINGS ARE EXPECTED TO BE IN ASCII OR UTF-8 FORMAT

        // Number of characters in string
        $strlen_var = strlen($str);

        // string bytes counter
        $d = 0;

        /*
        * Iterate over every character in the string,
        * escaping with a slash or encoding to UTF-8 where necessary
        */
        for ($c = 0; $c < $strlen_var; ++$c) {
            $ord_var_c = ord($str{$c});
            switch (true) {
                case(($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
                    // characters U-00000000 - U-0000007F (same as ASCII)
                    $d++;
                    break;
                case(($ord_var_c & 0xE0) == 0xC0):
                    // characters U-00000080 - U-000007FF, mask 110XXXXX
                    $d += 2;
                    break;
                case(($ord_var_c & 0xF0) == 0xE0):
                    // characters U-00000800 - U-0000FFFF, mask 1110XXXX
                    $d += 3;
                    break;
                case(($ord_var_c & 0xF8) == 0xF0):
                    // characters U-00010000 - U-001FFFFF, mask 11110XXX
                    $d += 4;
                    break;
                case(($ord_var_c & 0xFC) == 0xF8):
                    // characters U-00200000 - U-03FFFFFF, mask 111110XX
                    $d += 5;
                    break;
                case(($ord_var_c & 0xFE) == 0xFC):
                    // characters U-04000000 - U-7FFFFFFF, mask 1111110X
                    $d += 6;
                    break;
                default:
                    $d++;
            };
        };
        switch (strtolower($in)) {
            case 'b':
                return $d;
            case 'kb':
                return $d / 1024;
            case 'mb':
                return $d / 1024 / 1024;
        }
        return $d;
    }
}