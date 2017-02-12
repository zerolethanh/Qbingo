
<div class="container">
    <hr>
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
<script>
    function ticket_create(form) {
        event.preventDefault();
        var data = $(form).serializeArray();
        data.push({name: 'by_master', value: 1})
        $.post('/ticket/create', data, function (res, status) {
            notifySuccess('ユーザーを作成しました。');
            updateView(res)
        }).fail(function (res) {
            notifyErrors(res)
        })
    }
</script>