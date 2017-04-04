<style>
    .btn-slot {
        background: url('/img/srot710-385.png');
        background-size: 100% 100%;
        position: absolute;
        width: 200px;
        height: 108px;
        border: 0;
        z-index: 999;
    }

</style>
<button onclick="return startFace(event);" class="btn-slot start-buttons" id="start_face_button"></button>
<audio id="start_audio" src="/audio/tympani-roll1.mp3" preload="metadata"></audio>
<audio id="end_audio" src="/audio/question1.mp3" preload="metadata"></audio>
<script>
    var face_idxs = JSON.parse(document.getElementsByName('face_idxs')[0].getAttribute('content'));
    console.log(face_idxs.length);

    // roulette 設定

    var option = {
        speed: face_idxs.length * 10,
        duration: 4,
        stopImageNumber: 0,
        startCallback: function () {
            console.log('start');
        },
        slowDownCallback: function () {
            console.log('slowDown');
        },
        stopCallback: function ($stopElm) {
            console.log('stop');
        },
    };

    var rouletter = $('div.roulette');
    rouletter.roulette('option', option);

    function roll(stopFaceIndex, whenRollEnded, whenRollStart) {
        option['stopImageNumber'] = Number(stopFaceIndex);
        option.stopCallback = whenRollEnded;
        option.startCallback = whenRollStart;

        console.log(option);
        rouletter.roulette('option', option);
        rouletter.roulette('start');
    }
    /// start face
    function startFace(event) {
        event.preventDefault();

        // fetch image and quiz
        $.post('/start/face', {
                _token: "{{ csrf_token() }}",
                slot_started: 1
            },
            function (res, status) {
                console.log(res);
                if (res.error) {
                    $.notify(res.error, 'error');
                    return;
                }
                if (res.game_ended) {
                    $.notify('ゲームが終了しました。\n再度ゲームをしたい時がゲームリスタートボタンをクリックしてください。');
                    try {
                        document.getElementById('face_img').src = '';
                        document.getElementById('quiz_text').value = '';
                    } catch (e) {
                        console.log(e);
                    }
                    return;
                }

                try {
                    var userNameField = document.getElementById('user_name');
                    var faceImageEle = document.getElementById('face_img');
                    var quizTextField = document.getElementById('quiz_text');

                    var start_audio = document.getElementById('start_audio');

                    var start_time, stop_time;
                    var whenRollStart = function () {
                        start_time = new Date().getTime();
                        if (res.start.quiz_started) {
                            $("#quiz_text").hide();
                            $("#quiz_imgs").show();
                        } else {
                            $("#quiz_text").hide();
                            $("#quiz_imgs").hide();
                        }
                        $("#face_img").hide();
                        $("#face_imgs").show();
                        userNameField.value = '';
                        faceImageEle.src = '';
                        quizTextField.value = '';
                        //play start audio
                        start_audio.play();
                        document.getElementById('face_shuffle_button').disabled = true;
                        document.getElementById('start_face_button').disabled = true;
                        document.getElementById('start_quiz_button').disabled = true;
                    };
                    var whenRollEnded = function () {
                        stop_time = new Date().getTime();
                        console.log('roll_time: ', (stop_time - start_time) / 1000, ' s');
                        // when roll stop then set text, user name , face img
                        userNameField.value = res.face.user_name;
                        console.log(res.start.quiz_started);
                        if (res.start.quiz_started) {
                            quizTextField.value = res.quiz.quiz_text;
                        }
                        faceImageEle.src = "/thumb/" + res.face.user_photo;

                        //stop roulet audio
                        //play "stop" audio
                        start_audio.pause();
                        start_audio.currentTime = 0;
                        document.getElementById('end_audio').play();
                        document.getElementById('face_shuffle_button').disabled = false;
                        document.getElementById('start_face_button').disabled = false;
                        document.getElementById('start_quiz_button').disabled = false;

                    };

                    roll(res.face_index, whenRollEnded, whenRollStart);

                } catch (e) {
                    console.log(e);
                }


            }
        ).fail(function (res, status) {
            console.log(arguments);
        })
    }
</script>