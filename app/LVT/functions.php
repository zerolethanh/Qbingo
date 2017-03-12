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
        list($type, $blobdata) = explode(';', $blobdata);
        list(, $blobdata) = explode(',', $blobdata);
        $blobdata = base64_decode($blobdata);

        $download_key = \Faker\Provider\Uuid::uuid() . date('_Y_m_d');
        $fileExtension = last(explode('/', $type));

        if (!is_dir($dir) || !is_dir(public_path($dir))) {
            $save_dir = public_path($dir);
            mkdir($save_dir, 0777, true);
        }
        $file_name = "{$download_key}.{$fileExtension}";
        $save_to = "{$dir}/{$file_name}";

        $write = file_put_contents($save_to, $blobdata);

        if ($write) {
            \Intervention\Image\Facades\Image::make($save_to)
                ->orientate()
                ->save($save_to, 100);
            return [
                'saved' => true,
                'download_url' => url("/{$save_to}"),
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

        $img = Intervention\Image\Facades\Image::make($file_full_path);
        $width = $img->width();
        $height = $img->height();

        $blobdata = 'blobdata';
        if (!is_dir($public_blobdata = public_path($blobdata))) {
            mkdir($public_blobdata, 0777, true);
        }
        $editted_file_name = "editted_{$file_name}";
        $img->resize(intval($width * $scale), intval($height * $scale))
            ->rotate(-$angle)
            ->crop($w, $h, $x, $y)
            ->save("$public_blobdata/$editted_file_name", (int)100);

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