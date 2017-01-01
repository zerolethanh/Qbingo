<button onclick="face_shuffle()">
    顔シャルフボタン
</button>

<script>
    function face_shuffle() {
        $.post(
            '/start/face_shuffle',
            {_token: "{{csrf_token()}}"},
            function (res, status) {
                console.log(res);
                document.getElementById('face_img').src = "/getphoto/" + res.face.user_photo;
            }
        )
    }
</script>