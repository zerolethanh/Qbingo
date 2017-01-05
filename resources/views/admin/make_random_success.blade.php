<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MAKE SUCCESS</title>
    @include('bootstrap.sources')
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">MAKE HAPPIER SUCCESS</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <p>新規ユーザーを作成しました。</p>
                                <p style="color: red;">ログイン情報を個人でメモを残してください。</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="happy_id" class="col-md-4 control-label">ID</label>
                            <div class="col-md-6">
                                <input id="happy_id" type="text" class="form-control" value="{{$happy_id or ''}}"
                                       disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">PASS</label>
                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control" value="{{csrf_token()}}"
                                       disabled/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <p><a href="/logout" class="btn btn-primary">ログイン</a>して楽しんでください。</p>
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