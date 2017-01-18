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
<button onclick="face_shuffle()" class=" start-buttons btn-shuffle"></button>

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
                    var whenRollEnded = function () {
                        // when roll stop then set text, user name , face img
                        userNameField.value = res.face.user_name;
                        faceImageEle.src = "/getphoto/" + res.face.user_photo;
                    };
                    var whenRollStart = function () {
                        userNameField.value = '';
                        faceImageEle.src = '';
                    };
                    roll(res.face_index, whenRollEnded, whenRollStart);
//                    document.getElementById('face_img').src = "/getphoto/" + res.face.user_photo;
                } catch (e) {
                    console.log(e);
                }
            }
        )
    }
</script>