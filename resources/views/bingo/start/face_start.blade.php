<button onclick="return startFace(event);" class="btn btn-success btn-lg">
    フェイススロット<br>スタート
</button>

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
</script>