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
        .centered {
            position: fixed;
            top: 40%;
            left: 50%;
            /* bring your own prefixes */
            transform: translate(-50%, -50%);
        }
    </style>

</head>
<body>

<div class="container centered">

    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <table class="table table-bordered">

                <tr>
                    <td>
                        <button style="width: 100%; height: 100%;" >Q&ビンゴ<br>説明書</button>
                    </td>
                    <td>
                        <button onclick="location.href = '/bingo/upload-list'" style="width: 100%; height: 100%;"
                        >
                            顔写真<br>メッセージ<br>アップロード
                        </button>

                    </td>
                </tr>
                <tr>
                    <td>
                        <button onclick=" location.href = '/bingo/quizzes'"
                                style="width: 100%; height: 100%;">
                            クイズ作成
                        </button>
                    </td>
                    <td>
                        <button onclick=" location.href = '/bingo/start'"
                                style="width: 100%; height: 100%;">
                            Q＆ビンゴ<br>スタート
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>