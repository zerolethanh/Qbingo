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
    <input type="text" name="url" value="{{ $url }}" class="form-control"/>
    <input type="text" name="qrcode" value="qrcode" class="form-control">

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
</body>
</html>