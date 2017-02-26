<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>店舗ベージ</title>
    @include('bootstrap.sources')

    <style>

    </style>
</head>
<body>
@include('shop.info')
<hr>
@include('shop.update_form')
<hr>
@include('shop.ticket_create_form')
@include('shop.search_ticket_form')
<hr>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div id="{{ \App\Http\Controllers\TicketController::TICKET_TABLE_HTML_ID }}">
                @include( \App\Http\Controllers\TicketController::TICKET_TABLE_VIEW )
            </div>
        </div>
    </div>
</div>

@include('master.shops.ticket_delete_modal')

</body>
</html>