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

                var photo, msg, quiz, hit, name;

                if (res.start.face) {
                    photo = res.start.face.user_photo;
                    msg = res.start.face.user_message;
                    name = res.start.face.user_name;
                } else {
                    photo = msg = name = '';
                }
                if (res.start.quiz) {
                    quiz = res.start.quiz.quiz_text;
                } else {
                    quiz = '';
                }
                hit = res.start.hit;

                var face_img = "<p><img class='img-responsive' src='/getphoto/"
                        + photo
                        + "'></p>"
                    ;
                var user_message =
                    "<p><b>新郎新婦へのメッセージ：</b><br>" +
                    msg
                    + "</p>";

                var quiz_text =
                    "<p><b>答えたクイズ：</b><br>" +
                    quiz
                    + "</p>";

                var quiz_answer =
                    "<p><b>答えた数字：</b><br>" +
                    `
                    <form action='/start/update-hit-number'>
                        <input value='${hit}' type='number' style='font-size: 100px;width: 100%;' id='hit_details_hit_number_field'/>
                        <button class='btn btn-warning' onclick='updateHitNumber(${hit})' '>修正する</button>
                    </form>`
                    + "</p>";

                var title = document.querySelector('#hit_details .modal-title');
                title.innerHTML = name;

                var body = document.querySelector('#hit_details .modal-body');
                body.innerHTML = face_img + user_message + quiz_text + quiz_answer;
            }
        );
    }

    function updateHitNumber(oldNumber) {
        event.preventDefault();
        var newNumber = document.getElementById('hit_details_hit_number_field').value;
        var _token = "{{ csrf_token() }}";
        console.log(newNumber, oldNumber);
        $.post('/start/update-hit-number', {
            oldNumber, newNumber, _token
        }, function (res, status) {
            //update success
            location.reload();
            console.log(res);
        })
            .fail(function (res) {

                //update failed
                console.log(res);
                var err_json = res.responseJSON;

                $.notify(Object.values(err_json).join(''));
            })

    }
</script>