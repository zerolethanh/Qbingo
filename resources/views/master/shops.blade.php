<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>店舗管理画面</title>

    @include('bootstrap.sources')
</head>
<body>

<div class="container">
    <h1>ユーザー管理</h1>

    <button onclick="location.href='/master/shops/register'">新規登録</button>
    <hr>

    <div id="shops_table">
        @include('master.shops_table')
    </div>

</div>

</body>
</html>