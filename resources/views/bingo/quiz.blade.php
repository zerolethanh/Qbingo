<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>クイズ作成</title>
    @include('bootstrap.sources')
</head>
<body>

<div class="container">

    <div class="text-center">
        クイズ作成
    </div>

    <table class="table table-bordered">
        {{-- quiz head --}}
        <thead>
        <tr>
            <th></th>
            <th>誰に？</th>
            <th>クイズ</th>
            <th></th>
        </tr>
        </thead>

        {{-- quiz body --}}
        <tbody>

        <?php
        $uploads = \Illuminate\Support\Facades\Auth::user()->uploads->all();
        $numOfQuiz = 40;

        $forWhoSelection = '<select name="upload_id"><option value=""></option>';
        foreach ($uploads as $idx => $upload) {
            $forWhoSelection .= "<option value='{$upload->id}'>{$upload->id} 番</option>";
        }
        $forWhoSelection .= "</select>";

        ?>

        @for($row = 1 ; $row <= $numOfQuiz ; $row++)
            <form action="/quiz" method="post" id="form_{{$row}}">
                {{ csrf_field() }}
                <tr>
                    {{--@if (count($errors) > 0)--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--<ul>--}}
                                {{--@foreach ($errors->all() as $error)--}}
                                    {{--<li>{{ $error }}</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                    {{--問目--}}
                    <td width="70px">{{ $row }} 問目</td>
                    <input type="hidden" value="{{$row}}" name="quiz_number" required/>

                    {{--クイズ選択方法--}}
                    <?php $method = "quiz_method" ?>
                    <td width="150px">
                        <div class="radio">
                            <label><input type="radio" name="quiz_method" value="s" checked>シャッフル</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="quiz_method" value="a">指定</label>
                        </div>
                        <div>{!! $forWhoSelection !!}</div>
                    </td>

                    {{-- QUIZ textfields--}}
                    <td>
                        <textarea class="form-control" rows="4" name="quiz_text" required></textarea>
                    </td>
                    <td>
                        <button>SAVE</button>
                    </td>
                </tr>
            </form>
        @endfor
        </tbody>

    </table>

</div>

<script>

</script>
</body>
</html>