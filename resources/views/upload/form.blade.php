<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アップロード</title>
    @include('bootstrap.sources')
</head>
<body>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">アップロード</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/upload') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" value="{{$happy->happy_uuid}}" name="happy_uuid">
                        <div class="form-group">
                            <label for="user_name" class="col-md-4 control-label">名前：</label>
                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control" name="user_name"
                                       value="{{ Faker\Provider\ja_JP\Person::firstKanaName(). Faker\Provider\ja_JP\Person::lastKanaName() }}"
                                       required
                                       autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_sex" class="col-md-4 control-label">性別:</label>

                            <div class="col-md-6">
                                {{--<input id="password" type="password" class="form-control" name="password" required>--}}
                                <label class="radio-inline"><input type="radio" name="user_sex" value="M"
                                                                   checked="checked">男</label>
                                <label class="radio-inline"><input type="radio" name="user_sex" value="F">女</label>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_message" class="col-md-4 control-label">お祝い<br>メッセージ</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="user_message" name="user_message"
                                          placeholder="Message"
                                          required
                                          rows="5">{{ \App\Shiawase::gift() }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="user_photo" class="col-md-4 control-label">自撮り</label>
                            <div class="col-md-6">
                                <input type="file" id="user_photo" name="user_photo" accept="image/*" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-6">
                                <button type="submit" class="btn btn-primary">
                                    OK
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
