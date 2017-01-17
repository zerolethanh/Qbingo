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
                    roll(res.face_index);
//                    document.getElementById('face_img').src = "/getphoto/" + res.face.user_photo;
                } catch (e) {
                    console.log(e);
                }
            }
        )
    }
</script>