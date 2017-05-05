<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>景品登録</title>
  @include('bootstrap.sources')
</head>
<body>
<div class="container">
  <div class="row" style="display: inline;">
    <div style="float: left;"><h1>商品登録</h1></div>
    @include('bingo.components.nav_buttons')
  </div>
  <div class="row">
    <table class="table table-bordered">
      <tr class="text-center">
        <th class="text-center"><h4><b>景品の当たる</b></h4>
          <h3><b>順番</b></h3></th>
        <th class="text-center"><h4><b>景品名前</b></h4></th>
        <th class="text-center"><h4><b>写真</b></h4></th>
        <th class="text-center"><h4><b>写真アップロード</b></h4></th>
        <th class="text-center"></th>
      </tr>
      @for($i = 1 ; $i <= $row; $i++)
        <tr class="text-center">
          {{-- 回目 --}}
          <td width="190"><h3>{{$i }}&nbsp;回目</h3></td>
          {{--景品名--}}
          <td>
            <textarea name="gift_name{{$i}}" id="gift_name{{$i}}" rows="5" class="form-control"></textarea>
          </td>
          {{--写真--}}
          <td>
            <img src="" alt="" id="img{{$i}}">
          </td>
          {{--写真アップロード--}}
          <td width="200">
            @include('bingo.gift_fine_uploader',['id'=>$i])
          </td>
          {{--保存　全て保存--}}
          <td>
            <div style="margin-bottom: 10px">
              <button class="btn btn-primary" onclick="save({{$i}})" id="save{{$i}}">保存</button>
            </div>
            <div>
              <button class="btn btn-primary" onclick="saveAll({{$i}})">全て保存</button>
            </div>
          </td>
        </tr>
      @endfor
    </table>
  </div>
</div>
<script>
  function save() {
    console.log('save');
  }
  function saveAll() {
    console.log('saveAll');
  }
</script>
</body>
</html>