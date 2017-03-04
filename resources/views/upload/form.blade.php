<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アップロード</title>
    @include('bootstrap.sources')
    <style>
        html, body {
            margin-top: 10px;
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
                                       value="{{ Faker\Provider\ja_JP\Person::firstKanaName(). Faker\Provider\ja_JP\Person::lastKanaName() }}"
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
                                          placeholder="Message"
                                          required
                                          rows="5">{{ \App\Shiawase::gift() }}</textarea>
                                <p style="color:red" id="user_message_validation_message"></p>
                            </div>
                        </div>

                        {{-- user photo --}}
                        <div class="form-group">
                            <?php $user_photo = \App\Http\Controllers\PhotoController::REQUEST_USER_PHOTO_KEY; ?>
                            <label for="" class="col-md-4 control-label">自撮り</label>
                            <div class="col-md-6">
                                <input type="file" id="{{$user_photo}}"
                                       onchange="userPhotoPreview('preview_user_photo')"
                                       name="{{$user_photo}}" accept="image/*" required>
                                <img src="" alt="" id="preview_user_photo" class="img-responsive">
                                <p style="color:red" id="user_photo_validation_message"></p>
                            </div>
                        </div>

                        {{--  validation & show confirm form --}}
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-6">

                                @include('upload.form.confirm_upload_modal')
                                <button type="submit" class="btn btn-primary"
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


    function userPhotoPreview(preview_element_id, input_id) {
        input_id = input_id || 'user_photo';
        var file = document.getElementById(input_id).files[0];
        var reader = new FileReader();

        var preview = document.getElementById(preview_element_id);
        if (file) {
            reader.onloadend = function () {
                preview.src = reader.result;
                id("user_photo_validation_message").innerHTML = '';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
        }
    }

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
        userPhotoPreview('confirm_user_photo_preview');

    }

    $('#confirm_upload_modal').on('show.bs.modal', function (e) {
        if (!checkFormIsValid()) return e.preventDefault(); // stops modal from being shown
        confirm_upload();
    });

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
            document.getElementById(el_id + '_validation_message').innerHTML = validation_message;
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
</script>
</body>
</html>
