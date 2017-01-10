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

</head>
<body>

{{-- nav bar --}}
@include('bingo.start.nav')

<div class="container">
    {{-- row 1--}}
    <div class="row">

        {{--left panel face photo --}}
        <div class="col-sm-4 col-sm-offset-1">

            <p class="pull-right" id="face_img_div">
                <img src="{{ isset($face) ? ('/getphoto/'. $face->user_photo) : '' }}"
                     id="face_img"
                     alt="フェイススロット"
                     {{--width="150px"--}}
                     class="img-responsive">
            </p>
        </div>

        {{--right 1 panel quiz text --}}
        <div class="col-sm-4">
            <div id="quiz_text_div">
                <p class="pull-left">
                <textarea name="quiz_text" id="quiz_text" cols="30"
                          style="font-size: xx-large"
                          class="form-control"
                          rows="5">{{ isset($quiz) ? $quiz->quiz_text : ''}}</textarea>
                </p>
            </div>
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

                {{--<tr>--}}
                {{--<td>@include('bingo.start.undo')</td>--}}
                {{--</tr>--}}
                <tr>
                    <td>@include('bingo.start.face_shuffle')</td>
                </tr>
                <tr>
                    <td>@include('bingo.start.restart_game_button')</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- row 2 --}}
    <div class="row">
        {{-- left panel, right align, hit numbers panel --}}
        @include('bingo.start.hit_details_modal')
        <div class="col-sm-4 col-sm-offset-1 text-right">
            <div id="hit_numbers">
                @include('bingo.start.hit_numbers')
            </div>
        </div>

        {{--right 1 panel , left align, camera panel--}}
        <div class="col-sm-4">
            <div id="camera_region">
                {{--外付けカメラ--}}
                @include('bingo.start.camera')
            </div>
        </div>
        {{-- no hit bingo numbers, sidebar panel, bingo numbers panel --}}
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

    {{-- row 3--}}
    <div class="row ">
        <div class="col-sm-8 col-sm-offset-2">
            @include('bingo.start.views_size')
        </div>
    </div>

</div>

</body>
</html>