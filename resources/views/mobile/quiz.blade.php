<?php
$quiz_samples = collect($quiz_samples)->map(function ($q) {
    return "<option value='$q' >$q</option>";
});
$quiz_samples_html = implode($quiz_samples->toArray());
//dd($quiz_samples_html);
?>
        <!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>クイズ＆ビンゴ</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/css.css" rel="stylesheet" type="text/css">
    @include('bootstrap.jquery')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js"></script>
    <script type="text/javascript" src="/js/top.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    {{--    @include('bootstrap.sources')--}}
</head>
<body>
<header><a href="/"><img src="/image/rogo195-115.png" width="48" height="32" alt="rogo"></a>
    <h1>クイズ作成</h1>
</header>
<div id="nav">
    <ul>
        <li><a href="/">説明書</a></li>
        <li><a href="/mobile/rec2">ゲスト登録</a></li>
        <li><a href="/mobile/quiz">クイズ作成</a></li>
        <li><a href="/mobile/start">ビンゴスタート</a></li>
    </ul>
</div>
<article>
    <div class="coment">
        コチラのページで誰がどのクイズに答えるか作成できます。
    </div>
<?php
$numOfQuiz = 40;
$uploads = request()->user()->uploads;
$upload_id_list = $uploads->pluck('id');
$upload_id_options = '';
foreach ($uploads as $upload) {
    $upload_id_options .= "<option value='{$upload->id}'>{$upload->id} 番 {$upload->user_name}</option>";
}

?>
<!--    40 クイズループ　-->
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
    <!--    HTML-->
        <form action="/quiz" method="post" id="form_{{$row}}">
            {{--token field--}}
            {{ csrf_field() }}
            {{--quiz number--}}
            <input type="hidden" name="quiz_number" value="{{$row}}" required/>
            {{-- quiz 問目--}}
            <div class="heading3">{!!  $row  !!} 問目</div>
            {{-- quiz table--}}
            <div class="MyTable2">
                <div class="row">
                    <div class="cell1">誰に？</div>
                    <div class="cell2">
                        {{-- quiz shuffle or assign--}}
                        <input type="radio" name="quiz_method"
                               value="s" {{ $quiz_method =='s' ? 'checked':'' }}>シャッフル<br/>
                        <input type="radio" name="quiz_method"
                               value="a" {{ $quiz_method == 'a' ? 'checked':'' }}>指定
                        {{--quiz answer user number--}}
                        <select id="upload_id" name="upload_id">
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
                        </select>さんが答える
                    </div>
                </div>
            </div>
            {{-- quiz text content--}}
            <div class="section4">問題を作って下さい。
                <textarea name="quiz_text"
                          id="quiz_text_{{$row}}"
                          required>{{  $quiz_text }}</textarea>
                {{-- quiz samples--}}
                <select id="language_{{$row}}" name="language_{{$row}}"
                        onchange="quiz_sample_change(this)">
                    <option value="en" selected>クイズ定型文から選ぶ</option>
                    {!! $quiz_samples_html !!}
                    <optgroup label=""></optgroup>
                </select>
            </div>
            {{-- quiz save buttons--}}
            <section2>
                <button class="btn3" onclick="save(event, this.form)">保存</button>
                <button class="btn3" onclick="saveAll(event, this.form)">すべて保存</button>
            </section2>
            <br><br><br>
        </form>
        <!--問題終わり--------------------------------------------->
    @endfor

    <br><br><br><br><br>
    </section>
    <!--コメント終わり--------------------------------------------->
    <section>
    </section>
</article>
<p id="pageTop"><a href="#">top</a></p>
<footer>
    <address>Copyright(C)2017 クイズ＆ビンゴAllright Reserved.</address>
</footer>

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
    /*
     sample option selected
     */
    function quiz_sample_change(sel) {
        console.log(sel.value);
        document.getElementById('quiz_text_' + sel.id.split('_').slice(-1)[0]).value = sel.value;
    }
</script>
</body>
</html>
