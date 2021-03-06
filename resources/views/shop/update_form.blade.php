<?php
$ja_fields = [
    'reg_name' => '登録名',
    'company_name' => '会社名',
    'address' => '住所',
    'tel' => 'TEL',
    'email' => 'E-mail',
    'staff' => '担当者名',
    'staff_contact' => '担当者連絡先',
    'register' => '登録する'
]
?>
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
            <form class="form-horizontal" role="form" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="reg_name" class="col-md-4 control-label">{{ $ja_fields['reg_name'] }}</label>
                    <div class="col-md-6">
                        <input id="reg_name" type="text" class="form-control" name="reg_name"
                               value="{{ $shop->reg_name }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company_name" class="col-md-4 control-label">{{ $ja_fields['company_name'] }}</label>
                    <div class="col-md-6">
                        <input id="company_name" type="text" class="form-control" name="company_name"
                               value="{{ $shop->company_name }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-md-4 control-label">{{ $ja_fields['address'] }}</label>
                    <div class="col-md-6">
                        <input id="address" type="text" class="form-control" name="address"
                               value="{{ $shop->address }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-md-4 control-label">{{ $ja_fields['tel'] }}</label>
                    <div class="col-md-6">
                        <input id="tel" type="text" class="form-control" name="tel"
                               value="{{ $shop->tel }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-4 control-label">{{ $ja_fields['email'] }}</label>
                    <div class="col-md-6">
                        <input id="email" type="text" class="form-control" name="email"
                               value="{{ $shop->email }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="staff" class="col-md-4 control-label">{{ $ja_fields['staff'] }}</label>
                    <div class="col-md-6">
                        <input id="staff" type="text" class="form-control" name="staff"
                               value="{{ $shop->staff }}"
                        />
                    </div>
                </div>
                <div class="form-group">
                    <label for="staff_contact" class="col-md-4 control-label">{{ $ja_fields['staff_contact'] }}</label>
                    <div class="col-md-6">
                        <input id="staff_contact" type="text" class="form-control" name="staff_contact"
                               value="{{ $shop->staff_contact }}"
                        />
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-8 col-md-offset-6">
                        <button class="btn btn-warning" onclick="shop_update(this.form);">編集
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    @if($detail_update_success = session('update_success'))
        notifySuccess("{{ $detail_update_success }}");
    @endif

    function shop_update(form) {
        event.preventDefault();
        var data = $(form).serializeArray();
        $.post('/shop/update', data, function (res) {
            location.reload();
//            if (res.updated) {
//                notifySuccess(res.message);
//            } else {
//                notifyFail(res.message);
//            }
        }).fail(function (res) {
            notifyErrors(res)
        })
    }
</script>