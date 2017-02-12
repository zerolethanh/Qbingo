<?php
$SHOP_SEARCH_KEYWORD = \App\Http\Controllers\ShopController::SHOP_SEARCH_KEYWORD;
$SHOP_SEARCH_REG_DATE = \App\Http\Controllers\ShopController::SHOP_SEARCH_REG_DATE;
$SHOP_SEARCH_ID = \App\Http\Controllers\ShopController::SHOP_SEARCH_ID;
$SHOP_SEARCH_ACTION = \App\Http\Controllers\ShopController::URL_SHOP_SEARCH_ACTION;
?>
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

            <form class="form-horizontal form-inline text-center" id="shop_search_panel" role="form" method="POST"
                  action="/shop/search">

                <div class="form-group col-md-3">
                    <label for="{{ $SHOP_SEARCH_KEYWORD }}" class="col-md-3 control-label"></label>
                    <input id="{{ $SHOP_SEARCH_KEYWORD }}" type="text" class="form-control"
                           placeholder="キーワード"
                           name="{{ $SHOP_SEARCH_KEYWORD }}"/>
                </div>
                <br><br>
                <div class="form-group col-md-3">
                    <label for="{{ $SHOP_SEARCH_REG_DATE }}" class="col-md-3 control-label">登録日</label>
                    <div>
                        <input id="{{ $SHOP_SEARCH_REG_DATE }}" type="date" class="form-control"
                               {{--value="{{ date('Y-m-d') }}"--}}
                               name="{{ $SHOP_SEARCH_REG_DATE }}"/>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="{{ $SHOP_SEARCH_ID }}" class="col-md-3 control-label">ID</label>
                    <div>
                        <input id="{{ $SHOP_SEARCH_ID }}" type="number" class="form-control"
                               name="{{ $SHOP_SEARCH_ID }}"/>
                    </div>
                </div>
                <div class="form-group  col-md-3">
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary" onclick="shop_search(this.form)">
                            絞り込み
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    function shop_search(form) {
        event.preventDefault();
        const shop_search = $(form).serializeArray();
        $.post('{{ $SHOP_SEARCH_ACTION }}', shop_search, function (res) {
            updateView(res)
        })
    }
</script>