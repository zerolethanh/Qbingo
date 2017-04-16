<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アップロード</title>
    @include('bootstrap.sources')
    <script src="/js/jquery.guillotine.min.js"></script>
    <script src="/js/jquery-input-file-text.js"></script>
    <link rel="stylesheet" href="/css/jquery.guillotine.css">
    <link href='//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css' rel='stylesheet'>
    <style>
        html, body {
            margin-top: 10px;
        }

        .frame {
            /*border: 1px solid #ccc;*/
            padding: 5px
        }

        .frame > img {
            display: block;
            width: 100%
        }

        #controls {
            background-color: #1b1b1b;
            text-align: center
        }

        #controls a {
            display: inline-block;
            padding: 0 5%;
            height: 50px;
            line-height: 50px;
            font-size: 20px;
            font-weight: 300;
            color: #888
        }

        #controls a:hover {
            color: #fff;
            text-decoration: none
        }
    </style>
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">アップロード</div>
                <div class="panel-body">

                    {{-- show if has errors --}}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="text-center">
                        <h2>新郎新婦のお二人にお祝いのメッセージを!!<br></h2>
                        <h4>顔写真を自分撮りするかファイルから選択して<br></h4>
                        <h4>コメントを添えて送ってください。</h4><br>
                    </div>
                    {{-- upload form --}}
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/upload') }}"
                          id="upload_form"
                          name="upload_form"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        {{-- user name --}}
                        <input type="hidden" value="{{$happy->happy_uuid}}" name="happy_uuid">
                        <div class="form-group">
                            <label for="user_name" class="col-md-4 control-label">名前：</label>
                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control" name="user_name"
                                       {{--value="{{ Faker\Provider\ja_JP\Person::firstKanaName(). Faker\Provider\ja_JP\Person::lastKanaName() }}"--}}
                                       required
                                       autofocus>
                                <p style="color:red" id="user_name_validation_message"></p>
                            </div>
                        </div>

                        {{-- user sex --}}
                        <div class="form-group">
                            <label for="user_sex" class="col-md-4 control-label">性別:</label>
                            <div class="col-md-6">
                                <label class="radio-inline"><input type="radio" id="user_sex"
                                                                   name="user_sex" value="M"
                                                                   checked="checked">男</label>
                                <label class="radio-inline"><input type="radio" name="user_sex" value="F">女</label>
                                <p style="color:red" id="user_sex_validation_message"></p>
                            </div>
                        </div>

                        {{-- user message--}}
                        <div class="form-group">
                            <label for="user_message" class="col-md-4 control-label">お祝い<br>メッセージ:</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="user_message" name="user_message"
                                          {{--placeholder="Message"--}}
                                          required
                                          rows="5">{{--{{ \App\Shiawase::gift() }}--}}</textarea>
                                <p style="color:red" id="user_message_validation_message"></p>
                            </div>
                        </div>

                        {{-- user photo --}}
                        <div class="form-group">
                            <?php $user_photo = \App\Http\Controllers\PhotoController::REQUEST_USER_PHOTO_KEY; ?>
                            <label for="" class="col-md-4 control-label"></label>
                            <div class="col-md-6">
                                <input type="file" id="{{$user_photo}}"
                                       value="自撮りorファイルを選択"
                                       onchange="userPhotoPreview('preview_user_photo')"
                                       name="{{$user_photo}}" accept="image/*" required>
                                <div style="max-width: 100%;margin-top: 10px;">
                                    <img src="/image/load.gif" alt="" id="loading_img" class="img-responsive"
                                         style="display: none;">
                                    <img src="" alt="" id="preview_user_photo" class="frame img-responsive">
                                </div>
                                <p style="color:red" id="user_photo_validation_message"></p>
                            </div>
                        </div>
                        {{----}}

                        <div class="form-group">

                            <div id='controls' class='hidden col-md-6 col-md-offset-4'>
                                <a href='#' id='rotate_left' title='Rotate left'><i class='fa fa-rotate-left'></i></a>
                                <a href='#' id='zoom_out' title='Zoom out'><i class='fa fa-search-minus'></i></a>
                                <a href='#' id='fit' title='Fit image'><i class='fa fa-arrows-alt'></i></a>
                                <a href='#' id='zoom_in' title='Zoom in'><i class='fa fa-search-plus'></i></a>
                                <a href='#' id='rotate_right' title='Rotate right'><i
                                            class='fa fa-rotate-right'></i></a>
                                {{--<button id='save_cropped_image' onclick="event.preventDefault();"--}}
                                {{--style="background-color: white">Save--}}
                                {{--</button>--}}
                            </div>
                        </div>

                        {{--<ul id='data' class='hidden'>--}}
                        {{--<div class='column'>--}}
                        {{--<li>x: <span id='x'></span></li>--}}
                        {{--<li>y: <span id='y'></span></li>--}}
                        {{--</div>--}}
                        {{--<div class='column'>--}}
                        {{--<li>width: <span id='w'></span></li>--}}
                        {{--<li>height: <span id='h'></span></li>--}}
                        {{--</div>--}}
                        {{--<div class='column'>--}}
                        {{--<li>scale: <span id='scale'></span></li>--}}
                        {{--<li>angle: <span id='angle'></span></li>--}}
                        {{--</div>--}}
                        {{--</ul>--}}
                        {{----}}
                        {{--  validation & show confirm form --}}
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-6">

                                @include('upload.form.confirm_upload_modal')
                                <button id="confirm_screen_button"
                                        type="submit" class="btn btn-primary"
                                        data-toggle="modal" data-target="#confirm_upload_modal"
                                        {{--onclick="confirm_upload()"--}}
                                >
                                    確認画面へ
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#{{$user_photo}}").inputFileText({
        text: '自撮りorファイルを選択',
//        buttonClass: 'btn',
//        textClass: ''
    });
    var last_file_name;
    function userPhotoPreview(preview_element_id, input_id) {
        if (!!window.FileReader) {
            input_id = input_id || 'user_photo';
            var file = document.getElementById(input_id).files[0];
            var reader = new FileReader();
            var picture = $('#' + preview_element_id);  // Must be already loaded or cached!
            try {
                picture.attr('src', '');
                picture.guillotine('remove');
            } catch (e) {
                console.log(e);
            }
            if (file) {
//                console.log('file size: ', file.size / 1024, ' kb');
                //on load file ended
                reader.onloadend = function () {
                    //create new image
                    var img = new Image();
                    //2. on image src setted
                    img.onload = function () {
                        var mime_type = 'image/jpeg', quality = 30;
                        //make canvas
                        var cvs = document.createElement('canvas');
                        cvs.width = this.naturalWidth;
                        cvs.height = this.naturalHeight;
                        var ctx = cvs.getContext("2d").drawImage(this, 0, 0);
                        //3. compress image data
                        var compressedData = cvs.toDataURL(mime_type, quality / 100);
                        console.log('compressedData size : ', Math.round(compressedData.length * 6 / 8 / 1024), ' kb');
//                        notifySuccess(`画像アップロード中です。
//                            しばらくお待ちください。`);
                        $('#loading_img').css('display', 'block');
                        //4. upload compressed data
                        uploadBlob(compressedData, function (res) {
                            $('#loading_img').css('display', 'none');
                            last_file_name = res.file_name;
                            $('#confirm_screen_button').click(function (e) {
                                e.preventDefault();
                                var cropped_data = picture.guillotine('getData');
                                cropped_data.file_name = res.file_name;
                                cropped_data.origin_image_url = res.download_url;
                                console.log(cropped_data);
                                if (last_file_name === res.file_name) {
                                    $('#confirm_user_photo_preview').hide();
                                    $('#confirm_loading_img').show();
                                    $.post('save_cropped_image', {cropped_data: cropped_data}, function (res) {
                                        console.log(res);
                                        $('#confirm_loading_img').hide();
                                        $('#confirm_user_photo_preview')
                                            .attr('src', res.editted_image_url)
                                            .show();
                                    })
                                }

                            });

                            var camelize = function () {
                                var regex = /[\W_]+(.)/g;
                                var replacer = function (match, submatch) {
                                    return submatch.toUpperCase()
                                };
                                return function (str) {
                                    return str.replace(regex, replacer)
                                }
                            }();

                            picture.on('load', function () {
                                picture.guillotine({
                                    eventOnChange: 'guillotinechange',
                                    width: "{{ \App\Http\Controllers\UploadController::IMG_W * 2 }}",
                                    height: "{{\App\Http\Controllers\UploadController::IMG_H * 2 }}",
                                })
                                picture.guillotine('fit')

                                // Show controls and data
                                $('.notice, #controls, #data').removeClass('hidden')

                                // Bind actions
                                $('#controls a').click(function (e) {
                                    e.preventDefault()
                                    var action = camelize(this.id)
                                    picture.guillotine(action)
                                })

                                // Update data on change
                                picture.on('guillotinechange', function (e, data, action) {
                                    console.log(action, data);
                                })
                            })
                            picture.attr('src', res.download_url);
                        });

                    }
                    //set image src
                    img.src = reader.result;
                    //clear invalid message
                    id("user_photo_validation_message").innerHTML = '';
                };
                //1. start load file
                reader.readAsDataURL(file);
            } else {
//                preview.src = '';
            }
        } else {
            console.log('FileReader not supported');
        }
    }
    function uploadBlob(blob, callback) {
        $.post('/saveblob', {blobdata: blob}, function (res) {
            console.log(res);
            if (callback) {
                callback(res);
            }
        }).fail(function (res, status, err) {
            notifyFail(`エラーが発生しました
            画像を確認した上再実行してください。`);
//            console.log(res, status, err);
        }).always(function () {
            $('#loading_img').css('display', 'none');
        })
    }
    function compressImage(source_img_obj, quality, output_format, then) {

        var mime_type = "image/jpeg";
        if (typeof output_format !== "undefined" && output_format === "png") {
            mime_type = "image/png";
        }

        var cvs = document.createElement('canvas');
        cvs.width = source_img_obj.naturalWidth;
        cvs.height = source_img_obj.naturalHeight;
        var ctx = cvs.getContext("2d").drawImage(source_img_obj, 0, 0);
        var newImageData = cvs.toDataURL(mime_type, quality / 100);
        if (then) {
            then(newImageData);
        }
        source_img_obj.src = newImageData;
//        return newImageData;
//        var result_image_obj = new Image();
//        result_image_obj.src = newImageData;
//        return result_image_obj;
    }

    $('#confirm_upload_modal').on('show.bs.modal', function (e) {
        if (!checkFormIsValid())
            return e.preventDefault(); // stops modal from being shown
//        userPhotoPreview('preview_user_photo');
        confirm_upload();
    });

    function confirm_upload() {
        event.preventDefault();

        var user_name = document.getElementById('user_name').value;

        var user_sex_radios = document.getElementsByName('user_sex');
        var user_sex = '';
        for (var i = 0; i < user_sex_radios.length; i++) {
            if (user_sex_radios[i].checked) user_sex = user_sex_radios[i].value;
        }

        var user_message = document.getElementById('user_message').value;

        var user_name_el = buildElement('名前', user_name);
        var user_sex_el = buildElement('性別', user_sex == 'M' ? '男' : '女');
        var user_message_el = buildElement('お祝いメッセージ', user_message);

        // set modal values
        setModalTitle('confirm_upload_modal', '確認画面');
        document.getElementById('confirm_user_name').innerHTML = user_name_el;
        document.getElementById('confirm_user_sex').innerHTML = user_sex_el;
        document.getElementById('confirm_user_message').innerHTML = user_message_el;
//        userPhotoPreview('confirm_user_photo_preview');

    }


    function checkFormIsValid() {
        var check_el_ids = ['user_name', 'user_sex', 'user_message', 'user_photo'];

        for (var i = 0; i < check_el_ids.length; i++) {
            if (!isValid(check_el_ids[i])) {
                check_el_ids.forEach(function (id) {
                    setValidationMessage(id, eval(id + '.validationMessage'));
                });
                return false;
            }
        }

        check_el_ids.forEach(function (id) {
            setValidationMessage(id, '');
        });

        return true;
    }

    function setValidationMessage(el_id, validation_message) {
        try {
            var messages = {'user_name': '名前を入力してください。', 'user_message': 'メッセージを入力してください。'}
            if (el_id in messages) {
                document.getElementById(el_id + '_validation_message').innerHTML = messages[el_id];
            }
        } catch (e) {
            console.log(e);
        }
    }
    function isValid(id) {
        try {
            return document.getElementById(id).checkValidity();
        } catch (e) {
            console.log(e);
        }
        return false;
    }

    function buildElement(label, content) {
        return '<p><b>' + label + ':</b><br> ' + content + '</p>';
    }

    function save_cropped_image() {
        event.preventDefault();
    }
</script>
</body>
</html>
