<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control</title>
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
    <div>
        <div>
            <button style="background-image: url('/botann/newボタン1.png') ;
                    margin-right: 10px; margin-bottom: 5px;"
                    onclick="window.open().location.href = '/bingo/description'"
                    class="button-background">
            </button>
            <button onclick="window.open().location.href = '/bingo/upload-list'" style="background-image: url('/botann/newボタン2.png')"
                    class="button-background">

            </button>
        </div>
        <div>
            <button onclick="window.open().location.href = '/bingo/quizzes'"
                    style="background-image: url('/botann/newボタン3.png'); margin-right: 10px;"
                    class="button-background">

            </button>
            <button onclick="window.open().location.href = '/bingo/start'" class="button-background"
                    style="background-image: url('/botann/newボタン41.png')">

            </button>
        </div>
    </div>
</div>

</body>
</html>