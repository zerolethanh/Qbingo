<div class="container">

    <div class="pull-right">
        <p style="font-size: xx-large">{{ $shop->reg_name }}</p>
        <p style="font-size: large"> ID <b>{{ $shop->id }}</b>
            &nbsp; PASS <b>{{ $shop->raw_password }}</b>
            &nbsp; 登録日 <b>{{ $shop->reg_date }} </b>
        </p>
    </div>
    <br>
    <button onclick="location.href='/master/shops'">
        店舗管理に戻る
    </button>
</div>