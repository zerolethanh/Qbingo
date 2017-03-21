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

    <style>

        body {
            background-image: url("/img/bg980-550.jpg");
            background-position: center top;
            background-size: 100% auto;
        }

        .btn-background {
            background: url('/img/bn107-32.jpg');
            background-size: 100% 100%;
        }

        .buttons-container {
            position: absolute;
            right: 100px;
            bottom: 20px;
            width: 850px;
            height: 65px;
        }

        .buttons-container-buttons {
            position: absolute;
            right: 120px;
            bottom: 35px;
        }

        .top-image {
            width: 100%;
            height: 105px;
        }

        .top-bingo-image {
            width: 220px;
            height: auto;
            position: absolute;
            left: 50px;
            top: 10px;
        }

        .face-slot-bg-image {
            position: absolute;
            top: 70px;
            height: 320px;
            width: auto;
        }

        .face-container {
            position: absolute;
            top: 75px;
            left: 7px;
        }

        .mondai-img {
            position: absolute;
            top: 13px;
            left: 60px;
            width: 260px;
        }

        .name-img {
            position: absolute;
            top: 55px;
            width: 104%;
            height: 70px
        }

        .start-buttons {
            position: absolute;
            top: 100px;
        }

        .hitnumbers-container {
            left: 250px;
            width: 60%;;
        }

        .bottom-containers {
            position: fixed;
            bottom: 20px;
        }

        .suuji {
            background-image: url('/img/suuzi20-20.jpg');
            width: 30px;
            height: 30px;
            /*position: absolute;*/
            border: none;
            font-weight: bold;
            /*margin: 3px;;*/
            /*top: 10px;*/
            /*left: 20px;;*/
        }

        .user-name-field {

            position: relative;
            top: 75px;
            left: 5px;
            height: 30px;
            width: 100%;
            background-color: black;
            border: none;
            color: white;
            font-size: 2em;
            font-weight: bold;
            text-align: center;
        }
    </style>

</head>
<body>

{{-- nav bar --}}
{{--@include('bingo.start.nav')--}}

<div class="container-fluid">
    <div class="row" style="position: relative;">

        <img src="/img/head980-105.jpg" alt="" class="top-image">
        <div>
            <img src="/img/rogo975-575.png" alt="" class="top-bingo-image">
        </div>

        <div>
            <img src="/img/heads620-65.jpg" alt="" class="buttons-container">
            <div class="buttons-container-buttons">
                @include('bingo.start.views_size')
            </div>
        </div>
    </div>
</div>

<div class="container">
    {{-- row 1--}}
    <div class="row center-block" id="main_slots">

        {{--left panel face photo --}}
        <div class="col-sm-4">

            <div style="position: relative; ">
                <img src="/img/name250-50.jpg" alt="" class="name-img">
                <input type="text" id="user_name" value="{{$face->user_name or ''}}" class="user-name-field" disabled>
            </div>
            <div style="position: relative; top: 30px;">
                <img src="/img/bgw240-210.jpg" alt="" class="face-slot-bg-image">
                <div id="face_img_div" class="face-container">
                    @include('bingo.start.rouletter')
                    <img src="" alt="" id="face_img" hidden>
                </div>

            </div>
        </div>

        {{--right 1 panel quiz text --}}
        <div class="col-sm-4">
            <div style="position: relative; ">
                <img src="/img/mondai705-300.png" alt="" class="mondai-img">
            </div>
            <div id="quiz_text_div" style="position: relative; top: 60px;">

                <img src="/img/bgw240-210.jpg" alt="" class="face-slot-bg-image">

                {{--<p class="pull-left">--}}
                <div class="face-container">
                    <textarea name="quiz_text" id="quiz_text"
                              style="font-size: xx-large; width: 352px;height: 305px"
                              class="form-control" disabled>{{ isset($quiz) ? $quiz->quiz_text : ''}}</textarea>

                    <div id="quiz_imgs">
                        <div class="quiz_imgs">
                            @foreach($quizzes as $q)
                                <img src="/quiz/img/{{$q->quiz_number}}" id="quiz_img_{{$q->quiz_number}}"
                                     width="{{\App\Http\Controllers\UploadController::IMG_W}}px"
                                     height="{{\App\Http\Controllers\UploadController::IMG_H}}px" alt="">
                            @endforeach
                        </div>
                    </div>
                    <script>
                        //                        $("#quiz_text").hide();
                        console.log($("#quiz_imgs"));
                        $("#quiz_imgs").hide();
                        var quiz_imgs_option = {
                            speed: 20,
                            duration: 1,
                            stopImageNumber: 0,
                            startCallback: function () {
                                console.log('start');
                            },
                            slowDownCallback: function () {
                                console.log('slowDown');
                            },
                            stopCallback: function ($stopElm) {
                                console.log('stop');
                            }
                        };

                        var quiz_imgs_r = $("div.quiz_imgs");
                        quiz_imgs_r.roulette('option', quiz_imgs_option);

                        function quiz_imgs_roll(stopFaceIndex, whenRollEnded, whenRollStart) {
                            quiz_imgs_option.stopImageNumber = Number(stopFaceIndex);
                            quiz_imgs_option.stopCallback = whenRollEnded;
                            quiz_imgs_option.startCallback = whenRollStart;

                            console.log(quiz_imgs_option);
                            quiz_imgs_r.roulette('option', quiz_imgs_option);
                            quiz_imgs_r.roulette('start');
                        }
                    </script>
                </div>
                {{--</p>--}}

            </div>

        </div>

        {{-- right sidebar panel--}}
        <div class="col-sm-4">

            <div style="position: relative; ">
                <img src="/img/live705-300.png" alt="" class="mondai-img">
            </div>


            <div style="position: relative; top: 60px;">

                <img src="/img/bgw240-210.jpg" alt="" class="face-slot-bg-image">

                <div class="face-container">
                    @include('bingo.start.camera')
                </div>

            </div>
        </div>


    </div>
</div>

<div class="container-fluid" style="position: relative; top: 400px;">

    <div class="row">

        @include('bingo.start.hit_details_modal')

        <div style="position: absolute; left: 100px; top: 100px;">
            <img src="/img/hit145-110.png" class="bottom-containers" style="left: 100px;">
        </div>

        <div class="col-sm-3 col-sm-offset-2">

            <div style="position: absolute; left: 10px;">
                @include('bingo.start.face_start')
            </div>

            <img src="/img/heads620-65.jpg" class="hitnumbers-container bottom-containers"
                 style="height: 150px;z-index: -1">

            <div id="hit_numbers" class="hitnumbers-container bottom-containers" style="bottom: 50px;left: 255px;">
                @include('bingo.start.hit_numbers')
            </div>
        </div>


        <div class="col-sm-2 ">
            <div>
                @include('bingo.start.quiz_start')
            </div>
        </div>

        <div class="col-sm-3">

            @include('bingo.start.face_shuffle')
            @include('bingo.start.restart_game_button')
        </div>

        <div class="col-sm-2">
            <div id="numbers">
                @include('bingo.start.numbers')
            </div>
        </div>
    </div>
</div>

</body>
</html>