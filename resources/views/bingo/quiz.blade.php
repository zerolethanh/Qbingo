<?php
$quiz_samples = collect($quiz_samples)->map(function ($q) {
    return "<a href='#' onclick='sample_quiz_select()' class='list-group-item'>$q</a>";
});
$quiz_samples = implode($quiz_samples->toArray());
$quiz_samples_html =
    <<<EOD
    <div class="list-group">
$quiz_samples
</div>
EOD;

?>
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
            $upload_id_options .= "<option value='{$upload->id}'>{$upload->id} 番 {$upload->user_name}</option>";
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

                                    //user_name
                                    $user_name = '';
                                    $upload = collect($uploads)->first(function ($u) use ($id) {
                                        return $id == $u->id;
                                    });

                                    $user_name = $upload->user_name ?? '';
                                    $number = $upload->number ?? '';

                                    echo "<option value='{$id}' {$selected}>{$number} 番 {$user_name}</option>";
                                }
                                ?>

                            </select>
                            {{--{!! $forWhoSelection !!}--}}
                        </div>
                    </td>

                    {{-- QUIZ text--}}
                    <td width="50%">
                        <textarea class="form-control" rows="4" name="quiz_text"
                                  id="quiz_text_{{$row}}"
                                  required>{{  $quiz_text }}</textarea>
                    </td>

                    {{--SAVE buttons--}}
                    <td>
                        <div>
                            <button class="btn btn-primary btn-sm" onclick="save(event, this.form)">保存</button>
                        </div>
                        <br>
                        <button class="btn btn-default btn-sm" onclick="saveAll(event, this.form)">全て保存</button>
                        <button class="btn btn-warning btn-sm"
                                onclick="show_quiz_samples(this.form)"
                                data-toggle="popover"
                                title="クイズにクリックして選択できます"
                                data-content="{{ $quiz_samples_html }}"
                        >クイズ定型文から選ぶ
                        </button>
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

    function isFormDataValid(form, isNotify = true) {
        try {
            var data = formNameValues(form);

            if (data['quiz_text'] == '' || data['quiz_text'].replace(/\s/g, '') == '') {
                if (isNotify) {
                    $.notify('クイズ内容を入力してください', 'error');
                }
                return false;
            }
            if (data['quiz_method'] == 'a' && data['upload_id'] == '') {
                if (isNotify) {
                    $.notify('指定番号を選択してください', 'error')
                }
                return false;
            }
            return true;

        } catch (e) {
            console.log(e);
            return false
        }
    }

    /**
     * quiz sample select
     */
    var selecting_form_id;
    function show_quiz_samples(form) {
        event.preventDefault();
        selecting_form_id = form.id.split('_')[1];
    }
    function sample_quiz_select() {
        event.preventDefault();
        document.getElementById('quiz_text_' + selecting_form_id).value = event.target.innerText;
        $('[data-toggle="popover"]').popover('hide');
    }
</script>
</body>
</html>