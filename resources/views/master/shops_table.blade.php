<?php
$headers = ['id', 'raw_password', 'reg_name', 'reg_date'/*from Shop model*/];
$headers_trans = ['ID', 'PASS', '登録名 ( 契約店舗)', '登録日'];
?>
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
    {{-- shops--}}
    @foreach($shops as $s)
        <?php $shopURL = url("/master/shops/$s->id") ?>
        <tr>
            @foreach($headers as $h)
                @if($h == 'reg_name')
                    <td><a href='{{ $shopURL }}'>{{ $s->$h }}</a></td>
                @else
                    <td>{{ $s->$h }}</td>
                @endif
            @endforeach
            <td><a href="{{ $shopURL }}" class="center-block text-center">詳細</a></td>
            <td>
                @if( $s->is_stopping )
                    <button onclick="stop_shop({{ $s->id }})"
                            class="btn btn-success center-block">稼働
                    </button>
                @else
                    <button onclick="stop_shop({{ $s->id }})"
                            class="btn btn-warning center-block">停止
                    </button>
                @endif
            </td>
            <td>
                <button onclick="del_shop( {{ $s->id }} )" class="btn btn-danger center-block">削除</button>
            </td>
        </tr>

    @endforeach
</table>
<script>
    function stop_shop(shop_id) {
        $.post('/shop/stop', {shop_id},
            function (res) {
                console.log(res)
                updateView(res)
            });
    }
    function del_shop(shop_id) {
        Confirm.delete(
            () => {
                $.post('/shop/delete', {shop_id}, function (res) {
                    updateView(res)
                })
            })
    }
</script>