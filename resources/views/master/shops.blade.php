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
    <h1>ユーザー管理</h1>

    <button onclick="location.href='/master/shops/register'">新規登録</button>
    <hr>

    <table class="table table-bordered">
        {{--header--}}
        <tr>
            @foreach($headers_trans as $h)
                {!!  "<th>$h</th>"  !!}
            @endforeach
            <th></th>
            <th></th>
            <th></th>
        </tr>
        @foreach($shops as $s)
            <tr>
                @foreach($headers as $h)
                    {!!  "<td>{$s[$h]}</td>"  !!}
                @endforeach
                <td><a href="/master/shops/{{ $s->id }}" class="center-block text-center">詳細</a></td>
                <td>
                    <button onclick="stop_shop()" class="btn btn-warning center-block">停止</button>
                </td>
                <td>
                    <button onclick="del_shop()" class="btn btn-danger center-block">削除</button>
                </td>
            </tr>

        @endforeach
    </table>

</div>

<script>
    function stop_shop() {
        console.log(event);
    }
    function del_shop() {
        console.log(event);
    }
</script>
</body>
</html>