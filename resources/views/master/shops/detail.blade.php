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
<div class="container">
    <ol class="breadcrumb">
        <li><a href="/master/control">マスター管理</a></li>
        <li><a href="/master/shops">店舗管理</a></li>
        <li class="active">店舗ページ</li>
    </ol>
    <h1> 店舗ページ</h1>
</div>
@include('master.shops.detail_components.shop_info')
<hr>
@include('master.shops.detail_components.shop_update_form')
<hr>
@include('master.shops.detail_components.ticket_create_form')
@include('master.users_component.search_ticket_form')
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