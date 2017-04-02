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
        <div style="float: right;">

            <button style="background-image: url('/botann/newボタン1.png'); " onclick="window.open().location.href = '/bingo/description'" class="control-buttons">
            </button>
            <button onclick="location.href = '/bingo/upload-list'" style="background-image: url('/botann/newボタン2.png')" class="control-buttons">

            </button>

            <button onclick=" location.href = '/bingo/quizzes'" style="background-image: url('/botann/newボタン3.png');" class="control-buttons">

            </button>
            <button onclick=" location.href = '/bingo/start'" class="control-buttons" style="background-image: url('/botann/newボタン41.png')">

            </button>

        </div>
    </div>
    <div class="text-center">
        <img src="/img/des1.jpg" alt="" class="img-responsive center-block">
        <img src="/img/des2.jpg" alt="" class="img-responsive center-block">
        <img src="/img/des3.jpg" alt="" class="img-responsive center-block">
        <img src="/img/des4.jpg" alt="" class="img-responsive center-block">
    </div>
</div>
</body>
</html>