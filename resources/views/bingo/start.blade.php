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

            <p class="pull-right">
                <img src="{{ isset($face) ? ('/getphoto/'. $face->user_photo) : '' }}" id="face_img" alt="フェイススロット"
                     width="150px"
                     class="img-responsive">
            </p>
        </div>

        {{--right 1 panel--}}
        <div class="col-sm-4">

            <p class="pull-left">
                <textarea name="quiz_text" id="quiz_text" cols="30"
                          rows="10">{{ isset($quiz) ? $quiz->quiz_text : ''}}</textarea>
            </p>
        </div>

        {{-- right sidebar panel--}}
        <div class="col-sm-3">
            <table class="table">

                <tr>
                    <td>@include('bingo.start.face_start')</td>
                </tr>
                <tr>
                    <td>@include('bingo.start.quiz_start')</td>
                </tr>
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
                {{--@include('bingo.start.camera')--}}
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

</body>
</html>