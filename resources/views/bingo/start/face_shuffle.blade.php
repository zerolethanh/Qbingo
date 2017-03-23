<style>
    .btn-shuffle {
        background: url('/img/face475-310.png');
        background-size: 100% 100%;
        width: 120px;
        height: 80px;
        border: none;
        left: 10%;
    }
</style>
<button onclick="face_shuffle()" class="start-buttons btn-shuffle"
        id="face_shuffle_button"></button>

<script>
    function face_shuffle() {
        $.post(
            '/start/face_shuffle',
            {_token: "{{csrf_token()}}"},
            function (res, status) {
                console.log(res);
                try {
                    var userNameField = document.getElementById('user_name');
                    var faceImageEle = document.getElementById('face_img');
                    var start_audio = document.getElementById('start_audio');
                    var whenRollEnded = function () {
                        // when roll stop then set text, user name , face img
                        userNameField.value = res.face.user_name;
                        faceImageEle.src = "/thumb/" + res.face.user_photo;
                        //stop roulet audio
                        //play "stop" audio
                        start_audio.pause();
                        start_audio.currentTime = 0;
                        document.getElementById('end_audio').play();
                        document.getElementById('face_shuffle_button').disabled = false;
                    };
                    var whenRollStart = function () {
                        userNameField.value = '';
                        faceImageEle.src = '';
                        //play start audio
                        start_audio.play();
                        document.getElementById('face_shuffle_button').disabled = true;
                    };
                    roll(res.face_index, whenRollEnded, whenRollStart);
//                    document.getElementById('face_img').src = "/thumb/" + res.face.user_photo;
                } catch (e) {
                    console.log(e);
                }
            }
        )
    }
</script>