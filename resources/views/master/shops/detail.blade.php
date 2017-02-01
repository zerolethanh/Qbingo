<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop Detail</title>
    @include('bootstrap.sources')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>--}}
    <style>

    </style>
</head>
<body>

<div class="container">

    <div class="pull-right">
        <p style="font-size: xx-large">{{ $shop->reg_name }}</p>
        <p style="font-size: large"> ID <b>{{ $shop->id }}</b>
            &nbsp; PASS <b>{{ $shop->raw_password }}</b>
            &nbsp; 登録日 <b>{{ $shop->reg_date }} </b>
        </p>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ request()->url() }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="reg_name" class="col-md-4 control-label">reg_name</label>
                    <div class="col-md-6">
                        <input id="reg_name" type="text" class="form-control" name="reg_name"
                               value="{{ $shop->reg_name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_name" class="col-md-4 control-label">company_name</label>
                    <div class="col-md-6">
                        <input id="company_name" type="text" class="form-control" name="company_name"
                               value="{{ $shop->company_name }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-4 control-label">address</label>
                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control" name="address"
                               value="{{ $shop->address }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-md-4 control-label">tel</label>
                    <div class="col-md-6">
                        <input id="tel" type="text" class="form-control" name="tel"
                               value="{{ $shop->tel }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">email</label>
                    <div class="col-md-6">
                        <input id="email" type="text" class="form-control" name="email"
                               value="{{ $shop->email }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="staff" class="col-md-4 control-label">staff</label>
                    <div class="col-md-6">
                        <input id="staff" type="text" class="form-control" name="staff"
                               value="{{ $shop->staff }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="staff_contact" class="col-md-4 control-label">staff_contact</label>
                    <div class="col-md-6">
                        <input id="staff_contact" type="text" class="form-control" name="staff_contact"
                               value="{{ $shop->staff_contact }}"
                        />
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-8 col-md-offset-6">
                        <button type="submit" class="btn btn-warning">
                            編集
                        </button>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<hr>


<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal form-inline text-center" id="create_ticket_form" role="form" method="POST"
                  action="/ticket/create">
                {{ csrf_field() }}

                <?php  $f = \Faker\Factory::create('ja_JP'); ?>

                <div class="form-group col-md-3">
                    <label for="use_date" class="col-md-3 control-label small" style="word-break: keep-all;">使用
                        日時</label>
                    <div>
                        <input id="use_date" type="date" class="form-control" name="use_date"
                               value="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"/>
                    </div>

                </div>

                <div class="form-group col-md-3">
                    <label for="user" class="col-md-3 control-label small" style="word-break: keep-all;">使用者 名</label>
                    <div>
                        <input id="user" type="text" class="form-control" name="user"
                               value="{{ $f->name  }}"/>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="user_email" class="col-md-3 control-label small" style="word-break: keep-all;">使用者
                        メールアドレス</label>
                    <div>
                        <input id="user_email" type="email" class="form-control" name="user_email"
                               value="{{ $f->email }}"/>
                    </div>
                </div>


                <div class="form-group  col-md-3">
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary" onclick="ticket_create(this.form)">
                            パスワード発行する
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<hr>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <table class="table  table-bordered" id="ticket_table">
                @include('master.shops.ticket_table')
            </table>
        </div>
    </div>
</div>

@include('master.shops.ticket_delete_modal')
<script>

    @if($t = session('new_ticket') )

        $.notify("ユーザーを作成しました。", 'success');

    @endif

    @if($detail_update_success = session('update_success'))

        $.notify('アップデートしました。', 'success');
    @endif

    function ticket_create(form) {
        event.preventDefault();
        var data = $(form).serializeArray()
        $.post('/ticket/create', data, function (res, status) {
            notifySuccess('ユーザーを作成しました。');
            updateView(res)
        }).fail(function (res) {
            notifyFail(res.responseJSON.user_email[0]);
        })
    }

    function ticket_stop($ticket_id) {
        event.preventDefault();
        $.post('/ticket/stop', {
            '_token': "{{ csrf_token() }}",
            'ticket_id': $ticket_id
        }, function (res, status) {
//            console.log(res, status);
            updateView(res)
        })
    }

    function ticket_delete(ticket_id) {
        event.preventDefault();
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js',
            function () {

                bootbox.confirm({
                    size: "small",
                    message: "<h1>削除しますか?</h1>",
                    buttons: {
                        confirm: {
                            label: 'はい、削除する',
                            className: 'btn-danger'
                        },
                        cancel: {
                            label: 'いいえ',
                            className: 'btn-primary'
                        }
                    },
                    callback: function (ok) {
                        /* result is a boolean; true = OK, false = Cancel*/
                        if (ok) {
                            $.post('/ticket/delete', {ticket_id}, function (res) {
                                updateView(res)
                                notifySuccess('削除しました。')
                            });
                        }
                    }
                })
            }
        )
    }
</script>

</body>
</html>