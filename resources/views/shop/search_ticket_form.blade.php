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

            <form class="form-horizontal form-inline text-center" id="shop_search_panel" role="form" method="POST">

                <div class="form-group col-md-3">
                    <label for="ticket_keyword" class="col-md-3 control-label"></label>
                    <input id="ticket_keyword" type="text" class="form-control"
                           placeholder="キーワード"
                           name="ticket_keyword"/>
                </div>
                <br><br>
                <div class="form-group col-md-3">
                    <label for="ticket_created_date" class="col-md-3 control-label">登録日</label>
                    <div>
                        <input id="ticket_created_date" type="date" class="form-control"
                               {{--value="{{ date('Y-m-d') }}"--}}
                               name="ticket_created_date"/>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="ticket_id" class="col-md-3 control-label">ID</label>
                    <div>
                        <input id="ticket_id" type="number" class="form-control"
                               name="ticket_id"/>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="ticket_use_date_from" class="col-md-3 control-label">使用日</label>
                    <div class="col-md-6 form-inline">
                        <input id="ticket_use_date_from" type="date" class="form-control col-md-6"
                               name="ticket_use_date_from"/>
                        ~<input id="ticket_use_date_to" type="date" class="form-control col-md-6"
                                name="ticket_use_date_to"/>
                    </div>
                </div>
                <div class="form-group">
                    {{--<label for="" class="col-md-4 control-label"></label>--}}
                    <div class="col-md-12">
                        <button class="btn btn-success pull-left" onclick="ticket_search(this.form)">絞り込み</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    function ticket_search(form) {
        event.preventDefault();
        var url = '{{ \App\Http\Controllers\TicketController::URL_TICKET_SEARCH }}';
        var data = $(form).serializeArray();
        $.post(url, data, function (res) {
            console.log(res);
            updateView(res);
        })
            .fail(function (res) {
                notifyErrors(res);
            });
    }
</script>