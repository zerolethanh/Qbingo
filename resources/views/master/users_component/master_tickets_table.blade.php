{{-- $shop, $ticket_fields_trans, $ticket_fields--}}
<?php
$tickets = \App\Ticket::latest()->with('shop')->get();
$tickets = collect($tickets)->filter(function ($t) {
    return isset($t->shop) || $t->issued_id === 9999;
});
$ticket_fields = ['issued_id', 'issued_password', 'shop_reg_name', 'issued_password_date', 'formatted_use_date', 'user', 'user_email'];
$ticket_fields_trans = ['ID', 'ユーザー<br>パスワード', '登録名 ( 契約店舗)', 'パスワード発行日', '使用日時', '使用名', '使用者<br>メールアドレス'];
?>
<table class="table table-bordered">
    <tr>
        @foreach($ticket_fields_trans as $f)
            <th class="text-center">{!! $f !!}</th>
        @endforeach
        <th></th>
        <th></th>
    </tr>
    @foreach($tickets as $t)
        <tr>
            @foreach($ticket_fields as $f)
                <td>{{ $t->{$f} }}</td>
            @endforeach
            <td>
                @if($t->is_expired)
                    <button class="btn btn-warning center-block" onclick="ticket_stop({{ $t->id }})">停止中</button>
                @else
                    <button class="btn btn-success  center-block" onclick="ticket_stop({{ $t->id }})">稼働中</button>
                @endif
            </td>
            <td>
                <button class="btn btn-danger center-block" onclick="ticket_delete({{ $t->id }})">削除</button>
            </td>
        </tr>
    @endforeach
</table>

<script>

    function ticket_stop(ticket_id) {
        event.preventDefault();
        var from_master = 1;
        $.post('/ticket/stop', {ticket_id, from_master},
            function (res, status) {
                updateView(res)
            }
        ).fail(function (res) {
            notifyErrors(res)
        })
    }

    function ticket_delete(ticket_id) {
        event.preventDefault();
        Confirm.delete(
            //yes button did push
            function () {
                var from_master = 1;
                $.post('/ticket/delete', {ticket_id, from_master},
                    function (res) {
                        updateView(res)
                        notifySuccess('削除しました。')
                    }
                ).fail(
                    function (res) {
                        notifyErrors(res)
                    }
                )
            }
        )
    }

    @if($t = session('new_ticket') )
        notifySuccess("ユーザーを作成しました。");
    @endif
</script>
