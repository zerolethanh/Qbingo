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
      <button style="background-image: url('/botann/newボタン1.png'); "
              onclick="window.open().location.href = '/bingo/description'" class="control-buttons">
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
    <h3 style="text-align: left;padding-left: 15px">まず初めにクイズに参加する人を登録します。</h3>
    {{--登録してもらう--}}
    <div class="col-sm-6">
      <div class="panel panel-default">

        <div class="panel-heading">参加してもらう人に登録してもらう</div>
        <div class="panel-body">
          <span style="font-size: large">登録用のURLをコピーして参加する人にメールかライン等で送ってください。</span><br>
          <span style="font-weight: bold;font-size: 20px;">写真、コメント登録用URL</span>
          <input type="text" id="invite_url" name="url" value="{{ $url }}" class="form-control"/>
          <div style="display: flex;justify-content: flex-start ; align-items: center">
            <img src="/getqr/{{ request()->user()->happy_uuid }}.png" style="display: inline-block">
            <div style="display: flex;flex-wrap: wrap;align-items: center">
              <button type="button" class="btn btn-primary" onclick="copyInviteLink(this)" >
                リンクをコピー
              </button>
              <p style="font-weight: bold;background-color: white;border:none;text-align: left; display: inline;padding: 10px 0 0 10px;">
                ラインで連絡する場合は上記<br>のURLをコピーして送って下さい。
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{--/登録してもらう--}}
    {{--自分で登録する場合--}}
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading">自分で登録する場合がこちらから</div>
        <div class="panel-body" style="height: 338px;">
          <div style="display: flex;justify-content: center;align-items: center; height: 100%">
            <button class="btn btn-warning btn-lg" onclick="invite_link_open(event)">自分で登録する場合がこちらから</button>
          </div>
        </div>
      </div>
    </div>
    {{--/自分で登録する場合--}}
    <h3 style="text-align: center;padding-top: 15px;padding-bottom: 10px;clear: both;margin: 0;"> ↓登録が完了した方はこちらに表示されます。</h3>

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