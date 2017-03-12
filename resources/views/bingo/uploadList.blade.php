<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アップロードリスト</title>
    @include('bootstrap.sources')

    <style>
        html, body {
            margin-top: 10px;
        }

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

            <button style="background-image: url('/botann/newボタン1.png'); " class="control-buttons">
            </button>
            <button onclick="location.href = '/bingo/upload-list'"
                    style="background-image: url('/botann/newボタン2.png')"
                    class="control-buttons">

            </button>

            <button onclick=" location.href = '/bingo/quizzes'"
                    style="background-image: url('/botann/newボタン3.png');"
                    class="control-buttons">

            </button>
            <button onclick=" location.href = '/bingo/start'" class="control-buttons"
                    style="background-image: url('/botann/newボタン41.png')">

            </button>

        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">アップロード</div>
                <div class="panel-body">
                    <span style="font-weight: bold;font-size: 2em;">写真、コメント登録用URL</span>
                    <div class="input-group">
                        <input type="text" id="invite_url" name="url" value="{{ $url }}" class="form-control"/>
                        <span class="input-group-btn">
                            <button class="btn btn-warning" onclick="invite_link_open(event)">
                                招待リンクを開く
                            </button>

                        </span>
                    </div>

                    <div style="display: inline;">
                        <img src="/getqr/{{ request()->user()->happy_uuid }}.png">
                        <button type="button" class="btn btn-primary" onclick="copyInviteLink(this)">
                            リンクをコピー
                        </button>
                        <button style="font-weight: bold;background-color: white;border:none;text-align: left; ">
                            ラインで連絡する場合は上記<br>のURLをコピーして送って下さい。
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>番号</th>
            <th>名前</th>
            <th>性別</th>
            <th>写真</th>
            <th>コメント</th>
        </tr>
        </thead>

        <tbody>
        @foreach($uploads as $upload)
            <tr>
                <?php
                $tdFields = ['number', 'user_name', 'user_sex', 'user_photo', 'user_message'];
                $datas = [];
                foreach ($tdFields as $tdf) {
                    if ($tdf == 'user_photo') {
                        $user_photo = $upload[$tdf];
                        $basename = pathinfo($user_photo, PATHINFO_BASENAME);
//                        $d = "<img src='/getphoto/$user_photo' width='80' class='img-responsive'/>";
                        $d = "<img src='/thumb/$basename' width='120' class='img-responsive'/>";
                        $datas[$tdf] = $d;
                    } elseif ($tdf == 'user_sex') {
                        switch ($upload[$tdf]) {
                            case 'M':
                                $sex = '男';
                                break;
                            case 'F':
                                $sex = '女';
                                break;
                            default:
                                $sex = '';
                        }
                        $datas[$tdf] = $sex;
                    } else {
                        $datas[$tdf] = $upload[$tdf];
                    }
                }
                ?>
                @foreach($datas as $tdf => $val)
                    @if($tdf != 'user_photo')
                        <td>{{ $val }}</td>
                    @else
                        <td>{!!  $val  !!}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>

    </table>

</div>

<script>

    function invite_send_url(e) {
        e.preventDefault();
        var url = '/invite/send_url/?' +
            'email=' + encodeURIComponent(document.getElementById('invite_send_url_email').value);

        $.ajax({
            url: url,
            success: function (data) {
                console.log(data)
            }
        })
    }

    function invite_link_open(e) {
        e.preventDefault();
        var url = document.getElementById('invite_url').value;
        var win = window.open(url, '_blank');
//        win.focus();
    }

    function copyInviteLink(el) {
        document.getElementById('invite_url').select();
        document.execCommand('copy');
        $.notify('招待リンクをクリップボードにコピーしました。', 'success');

    }
</script>
</body>
</html>