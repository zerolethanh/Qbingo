<!-- モーダル・ダイアログ -->
<div class="modal fade" id="hit_details" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title">Hit Details</h4>
            </div>
            <div class="modal-body">
                <p>hitdetails</p>
            </div>
        </div>
    </div>
</div>

<script>
    function hit_details(hit_number) {

        $.post('/start/hit_details',
            {
                _token: "{{ csrf_token() }}",
                hit_number: hit_number
            },
            function (res, status) {
                console.log(res);
                var face_img = "<p><img class='img-responsive' src='/getphoto/"
                        + res.start.face.user_photo
                        + "'></p>"
                    ;
                var user_message =
                    "<p><b>新郎新婦へのメッセージ：</b><br>" +
                    res.start.face.user_message
                    + "</p>";

                var quiz_text =
                    "<p><b>答えたクイズ：</b><br>" +
                    res.start.quiz.quiz_text
                    + "</p>";

                var quiz_answer =
                    "<p><b>答えた数字：</b><br>" +
                    res.start.hit
                    + "</p>";

                var title = document.querySelector('#hit_details .modal-title');
                title.innerHTML = res.start.face.user_name;

                var body = document.querySelector('#hit_details .modal-body');
                body.innerHTML = face_img + user_message + quiz_text + quiz_answer;
            }
        );
    }
</script>