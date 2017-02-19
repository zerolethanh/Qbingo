<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ユーザー管理</title>

    @include('bootstrap.sources')
</head>
<body>
<div class="container">
    <ol class="breadcrumb">
        <li><a href="/master/control">マスター管理</a></li>
        <li class="active">ユーザー管理</li>
    </ol>
    <h1>ユーザー管理</h1>
</div>
{{-- ticket create form --}}
@include('master.users_component.master_ticket_create_form')
{{--search ticket form--}}
@include('master.users_component.search_ticket_form')
{{-- ticket table --}}
<div class="container">
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div id="{{ \App\Http\Controllers\TicketController::MASTER_TICKET_TABLE_HTML_ID }}">
                @include('master.users_component.master_tickets_table')
            </div>
        </div>
    </div>

</div>
</body>
</html>