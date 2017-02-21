{{-- $shop, $ticket_fields_trans, $ticket_fields--}}
<?php

$cached_tickets = session('tickets');//setted by searching
if ($cached_tickets) {
    $tickets = $cached_tickets;
} else {
    $paginator = App\Ticket::latest()->with('shop')->simplePaginate(30);
    $tickets = $paginator->items();
}

//dd($tickets);

$tickets = collect($tickets)->filter(function ($t) {
    return
        isset($t->shop)
        || ($t->issued_id == \App\Http\Controllers\TicketController::NVIEW_DEFAULT_ISSUED_ID);
});
//dd($tickets);
$ticket_fields = ['issued_id', 'issued_password', 'shop_reg_name', 'issued_password_date', 'formatted_use_date', 'user', 'user_email'];
$ticket_fields_trans = ['ID', 'ユーザー<br>パスワード', '登録名 ( 契約店舗)', 'パスワード発行日', '使用日時', '使用名', '使用者<br>メールアドレス'];
?>
@if($cached_tickets)
    <button class="btn btn-success" onclick="clear_tickets_cache()">全て表示</button>
    <br><br>
@endif

@if(isset($paginator))
    @include('vendor.pagination.simple-default',compact('paginator'))
@endif

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
@if(isset($paginator))
    @include('vendor.pagination.simple-default',compact('paginator'))
@endif

<script>

    const by_master = 1;

    function ticket_stop(ticket_id) {
        event.preventDefault();
        $.post('/ticket/stop', {ticket_id, by_master},
            function (res, status) {
//                updateView(res);
                location.reload();
            }
        ).fail(function (res) {
            notifyErrors(res);
        })
    }

    function ticket_delete(ticket_id) {
        event.preventDefault();
        Confirm.delete(
            //yes button did push
            function () {
                $.post('/ticket/delete', {ticket_id, by_master},
                    function (res) {
//                        updateView(res);
//                        notifySuccess('削除しました。');
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

    function clear_tickets_cache() {
        $.post('/ticket/clear_tickets_cache', function (res) {
            location.reload();
        })
    }
    @if($deleted_ticket = session('deleted_ticket'))
        notifySuccess("ID {{ $deleted_ticket->issued_id }} を削除しました");
    @endif
</script>
