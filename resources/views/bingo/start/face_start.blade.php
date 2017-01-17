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
                    roll(res.face_index);
                    document.getElementById('quiz_text').value = res.quiz.quiz_text;
                    console.log(document.getElementById('face_img').src)
                    document.getElementById('face_img').src = "/getphoto/" + res.face.user_photo;
                } catch (e) {
                    console.log(e);
                }


            }
        ).fail(function (res, status) {
            console.log(arguments);
        })
    }
</script>