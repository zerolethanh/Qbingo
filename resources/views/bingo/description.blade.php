<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>説明書</title>
    @include('bootstrap.sources')
    <style>
        .control-buttons {
            background-size: 100%;
            width: 105px;
            height: 52px;
            border: none;
        }
        .logo {
            width: 195px;
            height: 115px;
            position: absolute;
            top: 0;
            float: left;

        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="display: inline;">
        <img src="/img/rogo975-575.png" class="logo">
        @include('bingo.components.nav_buttons')
    </div>
    <div class="text-center">
        <img src="/img/des.jpg" alt="" class="img-responsive center-block">
        {{--<img src="/img/des1.jpg" alt="" class="img-responsive center-block">--}}
        {{--<img src="/img/des2.jpg" alt="" class="img-responsive center-block">--}}
        {{--<img src="/img/des3.jpg" alt="" class="img-responsive center-block">--}}
        {{--<img src="/img/des4.jpg" alt="" class="img-responsive center-block">--}}
    </div>
</div>
</body>
</html>