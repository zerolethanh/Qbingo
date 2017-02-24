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
    <ol class="breadcrumb">
        <li><a href="/master/control">マスター管理</a></li>
        <li class="active">店舗管理</li>
    </ol>
    <h1> 店舗管理</h1>
</div>
<div class="container">
    <button onclick="location.href='/master/shops/register'" class="btn btn-default">新規登録</button>
    <hr>
    @include('master.shop_search_panel')
    <hr>

    <div id="{{ \App\Http\Controllers\ShopController::SHOP_TABLE_HTML_ID }}">
        @include(\App\Http\Controllers\ShopController::SHOP_TABLE_VIEW )
    </div>

</div>

</body>
</html>