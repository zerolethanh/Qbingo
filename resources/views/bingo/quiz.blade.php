<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>クイズ作成</title>
    @include('bootstrap.sources')
    {{--<script src="https://unpkg.com/vue/dist/vue.js"></script>--}}

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

        $numOfQuiz = 40;

        $uploads = request()->user()->uploads;
        $upload_id_list = $uploads->pluck('id');

        $upload_id_options = '';

        foreach ($uploads as $upload) {
            $upload_id_options .= "<option value='{$upload->id}'>{$upload->id} 番</option>";
        }

        ?>

        @for($row = 1 ; $row <= $numOfQuiz ; $row++)
            <?php

            $q = $quizzes->first(function ($q) use ($row) {
                return $q->quiz_number == $row;
            });
            $quiz_number = $q->quiz_number ?? null;
            $quiz_method = $q->quiz_method ?? 'a';
            $upload_id = $q->upload_id ?? null;
            $quiz_text = $q->quiz_text ?? null;

            ?>
            <form action="/quiz" method="post" id="form_{{$row}}">
                {{ csrf_field() }}
                <input type="hidden" name="quiz_number" value="{{$row}}" required/>

                <tr id="row_{{$row}}">
                    {{--QUIZ number--}}
                    <td width="70px">{{ $row }} 問目</td>

                    {{--QUIZ methods--}}

                    <td width="150px">
                        <div class="radio">
                            <label><input type="radio" name="quiz_method"
                                          value="s" {{ $quiz_method =='s' ? 'checked':'' }}>シャッフル</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="quiz_method"
                                          value="a" {{ $quiz_method == 'a' ? 'checked':'' }}>指定</label>
                        </div>

                        <div>
                            <select name="upload_id">
                                <option value=""></option>
                                <?php
                                foreach ($upload_id_list as $id) {
                                    $selected = '';
                                    if ($id == $upload_id) {
                                        $selected = 'selected';
                                    }
                                    echo "<option value='{$id}' {$selected}>{$id} 番</option>";
                                }
                                ?>

                            </select>
                            {{--{!! $forWhoSelection !!}--}}
                        </div>
                    </td>

                    {{-- QUIZ text--}}
                    <td>
                        <textarea class="form-control" rows="4" name="quiz_text"
                                  required>{{  $quiz_text }}</textarea>
                    </td>

                    {{--SAVE buttons--}}
                    <td>
                        <div>
                            <button class="btn btn-primary btn-sm" onclick="save(event, this.form)">保存</button>
                        </div>
                        <br>
                        <button class="btn btn-default btn-sm" onclick="saveAll(event, this.form)">全て保存</button>
                    </td>

                </tr>
            </form>
        @endfor
        </tbody>

    </table>

</div>

<script>


    function save(event, form) {

        event.preventDefault();

        if (!isFormDataValid(form)) {
            return;
        }
        var form_data = $(form).serializeArray();

        $.post(form.action, form_data, function (res) {
            console.log(res);
            $.notify(res.quiz_number + '問目を保存しました', 'success')
        }).fail(function (res, status) {
            console.log(res)
        })
    }

    function saveAll(event) {

        event.preventDefault();

        var all_forms = document.getElementsByTagName('form');

        for (var i = 0; i < all_forms.length; i++) {

            var form = all_forms[i];

            if (isFormDataValid(form, false)) {
                save(event, form)
            }
        }
    }

    function isFormDataValid(form, isNotify) {
        if (isNotify === undefined) isNotify = true;
        try {
            var form_data = new FormData(form);

            if (!form_data.get('quiz_text')) {
                if (isNotify) {
                    $.notify('クイズ内容を入力してください', 'error');
                }
                return false;
            }
            if (form_data.get('quiz_text') && form_data.get('quiz_text').replace(/\s/g, '') == '') {
                if (isNotify) {
                    $.notify('クイズ内容を入力してください', 'error')
                }
                return false;
            }

            if (form_data.get('quiz_method') == 'a' && form_data.get('upload_id') == '') {
                if (isNotify) {
                    $.notify('指定番号を選択してください', 'error')
                }
                return false
            }

        } catch (e) {
            console.log(e);
            return false

        }
        return true
    }
</script>
</body>
</html>