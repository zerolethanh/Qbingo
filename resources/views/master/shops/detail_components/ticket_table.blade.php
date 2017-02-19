{{-- $shop, $ticket_fields_trans, $ticket_fields--}}
<?php
$tickets = \App\Ticket::latestOrder();
$ticket_fields = ['issued_id', 'issued_password_date', 'user', 'user_email', 'formatted_use_date', 'issued_password'];
$ticket_fields_trans = ['ID', 'パスワード発行日', '使用名', '使用者メールアドレス', '使用日時', 'ユーザーパスワード'];
?>
<table class="table table-bordered">
    <tr>
        @foreach($ticket_fields_trans as $f)
            <th>{{ $f }}</th>
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
        $.post('/ticket/stop', {ticket_id},
            function (res, status) {
//                updateView(res)
                location.reload();
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
                $.post('/ticket/delete', {ticket_id},
                    function (res) {
//                        updateView(res);
//                        notifySuccess('削除しました。')
                        location.reload();
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
