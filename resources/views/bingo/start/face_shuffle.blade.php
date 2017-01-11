<button onclick="face_shuffle()" class="btn btn-warning">
    顔シャッフル
</button>

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