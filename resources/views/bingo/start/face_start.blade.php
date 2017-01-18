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

                    var whenRollStart = function () {
                        userNameField.value = '';
                        faceImageEle.src = '';
                        quizTextField.value = '';
                    };
                    var whenRollEnded = function () {
                        // when roll stop then set text, user name , face img
                        userNameField.value = res.face.user_name;
                        quizTextField.value = res.quiz.quiz_text;
                        faceImageEle.src = "/getphoto/" + res.face.user_photo;
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