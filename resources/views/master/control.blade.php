<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MASTER CONTROL</title>
    @include('bootstrap.sources')
    <style>
        .position-ref {
            position: relative;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .full-height {
            height: 100vh;
        }

        .button-background {
            background-size: 100% 100%;
            background-repeat: no-repeat;
            width: 420px;
            height: 210px;
            border: none;
        }
    </style>
</head>
<body>

<div class="position-ref flex-center full-height">
    <button class="btn btn-success" onclick="location.href='/master/users'">ユーザー管理</button>
    <button class="btn btn-success" onclick="location.href='/master/shops'">店舗管理</button>
</div>
</body>
</html>