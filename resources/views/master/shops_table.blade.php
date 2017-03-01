<?php
$SHOP_SEARCH_FOUND = $data ?? session('SHOP_SEARCH_FOUND');
$shops = $SHOP_SEARCH_FOUND ?? \App\Shop::latestOrder();
$headers = ['id', 'raw_password', 'reg_name', 'reg_date'/*from Shop model*/];
$headers_trans = ['ID', 'PASS', '登録名 ( 契約店舗)', '登録日'];

?>
@if($SHOP_SEARCH_FOUND)
    <button type="button" class="btn btn-success" onclick="shop_stop_search()">全て表示</button>
    <br>
    <label for="" class="text-center center-block" style="font-size: large">検索結果</label>
@endif
<table class="table table-bordered">
    {{--header--}}
    <tr>
        @foreach($headers_trans as $h)
            <th>{!!  $h  !!}</th>
        @endforeach
        <th></th>
        <th></th>
        @if($SHOP_SEARCH_FOUND)
            <th></th>
        @endif
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
            {{--<td><a href="{{ $shopURL }}" class="center-block text-center">詳細</a></td>--}}
            <td>
                @if( $s->is_stopping )
                    <button onclick="stop_shop({{ $s->id }})"
                            class="btn btn-warning center-block">停止中
                    </button>
                @else
                    <button onclick="stop_shop({{ $s->id }})"
                            class="btn  btn-success center-block">稼働中
                    </button>
                @endif
            </td>
            <td>
                <button onclick="del_shop( {{ $s->id }} )" class="btn btn-danger center-block">削除</button>
            </td>
            @if(isset($s->filted_tickets_html))
                <td>
                    <a href="#"
                       id="show_activity_users_{{ $s->id }}"
                       onclick="show_activity_users( {{ $s->id }})"
                       data-toggle="popover"
                       {{--title="クイズにクリックして選択できます"--}}
                       data-content="<?php echo nl2br($s->filted_tickets_html) ?>"
                    >{{ count($s->filted_tickets) }}ユーザー</a>
                </td>
            @endif
        </tr>
    @endforeach
</table>
<script>
    function stop_shop(shop_id) {
        $.post('/shop/stop', {shop_id},
            function (res, status, xhr) {
//                console.log(res);
//                updateView(res, status, xhr)
                location.reload();
            });
    }
    function del_shop(shop_id) {
        Confirm.delete(
            () => {
                $.post('/shop/delete', {shop_id}, function (res) {
//                    updateView(res)
//                    notifyFail('店舗を削除しました。')
                    location.reload();
                })
            })
    }
    function shop_stop_search() {
        event.preventDefault();
        $.post('/shop/stop_search', function (res) {
//            location.reload();
            updateView(res)
        })
    }


    function show_activity_users(shop_id) {
//        $.post('/shop/show_activity_users', {shop_id}, function (res) {
//            console.log(res);
//            try {
//                let a = $('#show_activity_users_' + shop_id);
//                a.attr('data-content', pluckField(res.found_use_date_from_happies, 'happy_id', true));
//                a.popover('show');
//            } catch (e) {
//                console.log(e);
//            }
//
//        });
        let a = $('#show_activity_users_' + shop_id);
        a.popover({html: true});
        a.popover('show');
    }

    function pluckField(array, field, returnString = false) {
        var result = [];
        for (let i = 0; i < array.length; i++) {
            result.push(array[i][field]);
        }
        if (returnString) {
            return result.join().split('\n');
        }
        return result;
    }
</script>