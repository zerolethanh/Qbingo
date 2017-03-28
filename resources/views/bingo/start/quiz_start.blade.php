<style>
    .btn-quiz {
        background: url('/img/cuizu710-385.png');
        background-size: 100% 100%;
        width: 200px;
        height: 108px;
        border: none;
        position: relative;
    }
</style>
<button onclick="return startQuiz(event);" class="btn-quiz start-buttons" id="start_quiz_button">

</button>

<script>

    function startQuiz(event) {
        event.preventDefault();
//        startFace(event);
        // fetch image and quiz
        $.post('/start/face', {
                _token: "<?php echo e(csrf_token()); ?>",
                quiz_started: 1
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
                    var whenRollStart = function () {
                        $("#quiz_text").hide();
                        $("#quiz_imgs").show();

                        if (res.start.slot_started) {
                            $("#face_imgs").show();
                            $("#face_img").hide();
//                            userNameField.value = '';
                        } else {
                            $("#face_imgs").hide();
                            $("#face_img").hide();
                            userNameField.value = '';
                        }

                        faceImageEle.src = '';
                        quizTextField.value = '';
                        start_audio.play();
                        document.getElementById('face_shuffle_button').disabled = true;
                        document.getElementById('start_face_button').disabled = true;
                        document.getElementById('start_quiz_button').disabled = true;
                    };
                    var whenRollEnded = function () {
                        // when roll stop then set text, user name , face img
//                        userNameField.value = res.face.user_name;
                        quizTextField.value = res.quiz.quiz_text;
                        faceImageEle.src = "/thumb/" + res.face.user_photo;
                        start_audio.pause();
                        start_audio.currentTime = 0;
                        document.getElementById('end_audio').play();
                        document.getElementById('face_shuffle_button').disabled = false;
                        document.getElementById('start_face_button').disabled = false;
                        document.getElementById('start_quiz_button').disabled = false;

                    };

                    quiz_imgs_roll(res.quiz_index, whenRollEnded, whenRollStart);

                } catch (e) {
                    console.log(e);
                }


            }
        ).fail(function (res, status) {
            console.log(arguments);
        })
    }
</script>