<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>アップロードリスト</title>
    @include('bootstrap.sources')
</head>
<body>

<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">アップロード</div>
                <div class="panel-body">

                    <div class="input-group">
                        <input type="text" id="invite_url" name="url" value="{{ $url }}" class="form-control"/>
                        <span class="input-group-btn">
                            <button class="btn btn-warning" onclick="invite_link_open(event)">
                                招待リンクを開く
                            </button>
                        </span>
                    </div>
                    <img src="/getqr/{{ \Illuminate\Support\Facades\Auth::user()->happy_uuid }}.png">

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendMailModal">
                        招待リンクを送る
                    </button>
                    <button type="button" class="btn btn-success" onclick="window.open('/bingo/quizzes','_blank');">
                        クイズ作成画面へ
                    </button>

                    <button type="button" class="btn btn-success" onclick="window.open('/bingo/start','_blank');">
                        ビンゴスタート画面へ
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- モーダル・ダイアログ -->
    <div class="modal fade" id="sendMailModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                    <h4 class="modal-title">招待リンク送信</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="invite_send_url(event);return false">
                        <div class="input-group">
                            <input type="email" id="invite_send_url_email" required placeholder="EMAIL"
                                   class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-primary">送信</button>
                            </span>
                        </div>
                    </form>
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
                $tdFields = ['id', 'user_name', 'user_sex', 'user_photo', 'user_message'];
                $datas = [];
                foreach ($tdFields as $tdf) {
                    if ($tdf == 'user_photo') {
                        $user_photo = $upload[$tdf];
                        $d = "<img src='/getphoto/$user_photo' width='80' class='img-responsive'/>";
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
</script>
</body>
</html>