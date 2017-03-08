<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop Register</title>
    @include('bootstrap.sources')
    <style>
        html, body {
            margin-top: 10px;
        }
    </style>
</head>
<body>
@if(isset($shop))
    <script>
        $.notify('{{ $shop->reg_name .'を登録しました。' }}', 'success');
    </script>
@else

@endif
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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> Shop Register</div>
                <div class="panel-body">
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

                        <?php

                        $faker = Faker\Factory::create('ja_JP');

                        ?>
                        <div class="form-group">
                            <label for="reg_name" class="col-md-4 control-label">{{$ja_fields['reg_name']}}</label>
                            <div class="col-md-6">
                                <input id="reg_name" type="text" class="form-control" name="reg_name"
                                       value="{{ old('reg_name') ?: str_random(5) }}"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_name"
                                   class="col-md-4 control-label">{{ $ja_fields['company_name'] }}</label>
                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control" name="company_name"
                                       value="{{ old('company_name') ?: $faker->company }}"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-md-4 control-label">{{$ja_fields['address']}}</label>
                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address"
                                       value="{{ old('address') ?: $faker->address }}"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="col-md-4 control-label">{{$ja_fields['tel']}}</label>
                            <div class="col-md-6">
                                <input id="tel" type="text" class="form-control" name="tel"
                                       value="{{ old('tel') ?: $faker->phoneNumber }}"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">{{$ja_fields['email']}}</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email"
                                       value="{{ old('email') ?: $faker->email }}"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staff" class="col-md-4 control-label">{{$ja_fields['staff']}}</label>
                            <div class="col-md-6">
                                <input id="staff" type="text" class="form-control" name="staff"
                                       value="{{ old('staff') ?: $charge_name = $faker->name }}"
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="staff_contact"
                                   class="col-md-4 control-label">{{$ja_fields['staff_contact']}}</label>
                            <div class="col-md-6">
                                <input id="staff_contact" type="text" class="form-control" name="staff_contact"
                                       value="{{ old('staff_contact') ?: $faker->title.' '. $charge_name }}"
                                />
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ $ja_fields['register'] }}
                                </button>

                            </div>
                        </div>

                    </form>

                    <button onclick="location.href='/master/shops'" class="btn btn-warning pull-left">店舗管理へ戻る
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>