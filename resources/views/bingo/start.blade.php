<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bingo</title>

    <link rel="stylesheet" href="/css/sidebar.css">
    @include('bootstrap.sources')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js"></script>

</head>
<body>


<div class="container">
    BingoStart

    <div class="row">

        {{--left panel--}}
        <div class="col-sm-4 col-sm-offset-1">
            <p class="text-right">
                <button onclick="return startFace(event);">
                    フェイススロットスタート
                </button>
            </p>
            <p class="pull-right">
                <img src="{{ isset($face) ? ('/getphoto/'. $face->user_photo) : '' }}" id="face_img" alt="フェイススロット"
                     width="150px"
                     class="img-responsive">
            </p>
        </div>

        {{--right 1 panel--}}
        <div class="col-sm-4">

            <p class="text-left">
                <button onclick="return startQuiz(event);">
                    クイズスロットスタート
                </button>
            </p>
            <p class="pull-left">
                <textarea name="quiz_text" id="quiz_text" cols="30"
                          rows="10">{{ isset($quiz) ? $quiz->quiz_text : ''}}</textarea>
            </p>
        </div>

        {{-- right sidebar panel--}}
        <div class="col-sm-3">
            <table class="table">

                <tr>
                    <td>@include('bingo.start.restart_game_button')</td>
                </tr>
                <tr>
                    <td>@include('bingo.start.undo')</td>
                </tr>
                <tr>
                    <td>@include('bingo.start.face_shuffle')</td>
                </tr>

            </table>
        </div>
    </div>

    <div class="row">
        {{-- left panel, right align--}}
        <div class="col-sm-4 col-sm-offset-1 text-right">
            <div id="hit_numbers">
                @include('bingo.start.hit_numbers')
            </div>
        </div>

        {{--right 1 panel , left align--}}
        <div class="col-sm-4">
            <div class="col-sm-4">
                外付けカメラ
                {{--                @include('bingo.start.camera')--}}
            </div>
        </div>
        {{-- no hit bingo numbers, sidebar panel --}}
        <div class="col-sm-3">
            <table class="table">
                <tr>
                    <td>
                        <div id="numbers">
                            @include('bingo.start.numbers')
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    @include('bingo.start.hit_details_modal')
</div>

<script>


    /// start face
    function startFace(event) {
        event.preventDefault();

        // fetch image and quiz
        $.post('/start/face',
            {_token: "{{ csrf_token() }}"},
            function (res, status) {
                console.log(res);
                if (res.error) {
                    $.notify(res.error, 'error');
                    return;
                }
                if (res.game_ended) {
                    $.notify('ゲームが終了しました。\n再度ゲームをしたい時がゲームリスタートボタンをクリックしてください。');
                    document.getElementById('face_img').src = '';
                    document.getElementById('quiz_text').value = '';
                    return;
                }

                document.getElementById('face_img').src = "/getphoto/" + res.face.user_photo;
                document.getElementById('quiz_text').value = res.quiz.quiz_text;

            }
        ).fail(function (res, status) {
            console.log(arguments);
        })
    }

    function startQuiz(event) {
        event.preventDefault();
        startFace(event);
    }

</script>
</body>
</html>