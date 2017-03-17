<style>
    .btn-slot {
        background: url('/img/srot710-385.png');
        background-size: 100% 100%;
        position: absolute;
        width: 200px;
        height: 108px;
        border: 0;

    }

</style>
<button onclick="return startFace(event);" class="btn-slot start-buttons"></button>
<audio id="start_audio" src="/audio/tympani-roll1.mp3" preload="metadata" loop></audio>
<audio id="end_audio" src="/audio/question1.mp3" preload="metadata"></audio>
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
                        $("#quiz_text").show();
                        $("#quiz_imgs").hide();
                        $("#face_img").hide();
                        $("#face_imgs").show();
                        userNameField.value = '';
                        faceImageEle.src = '';
                        quizTextField.value = '';
                        start_audio.play();
                    };
                    var whenRollEnded = function () {
                        // when roll stop then set text, user name , face img
                        userNameField.value = res.face.user_name;
                        quizTextField.value = res.quiz.quiz_text;
                        faceImageEle.src = "/thumb/" + res.face.user_photo;
                        start_audio.pause();
                        start_audio.currentTime = 0;
                        document.getElementById('end_audio').play();
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