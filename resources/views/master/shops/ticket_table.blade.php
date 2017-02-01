{{-- $shop, $ticket_fields_trans, $ticket_fields--}}
<?php
if (!isset($shop)) {
    $shop = session('shop');
}
if (!isset($shop)) {
    return;
}
$ticket_fields = ['issued_id', 'issued_password_date', 'user', 'user_email', 'formatted_use_date', 'issued_password'];
$ticket_fields_trans = ['ID', 'パスワード発行日', '使用名', '使用者メールアドレス', '使用日時', 'ユーザーパスワード'];
?>
<tr>
    @foreach($ticket_fields_trans as $f)
        <th>{{ $f }}</th>
    @endforeach
    <th></th>
    <th></th>
</tr>
@foreach($shop->tickets()->latest()->get() as $t)
    <tr>
        @foreach($ticket_fields as $f)
            <td>{{ $t->{$f} }}</td>
        @endforeach
        <td>
            @if($t->is_expired)
                <button class="btn btn-success center-block" onclick="ticket_stop({{ $t->id }})">稼働</button>
            @else
                <button class="btn btn-warning center-block" onclick="ticket_stop({{ $t->id }})">停止</button>
            @endif
        </td>
        <td>
            <button class="btn btn-danger center-block" onclick="ticket_delete({{ $t->id }})">削除</button>
        </td>
    </tr>
@endforeach