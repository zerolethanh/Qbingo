<div class="modal fade" id="confirm_upload_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                <h4 class="modal-title">Confirm Upload Modal</h4>
            </div>
            <div class="modal-body">
                <p id="confirm_user_name"></p>
                <p id="confirm_user_sex"></p>
                <p id="confirm_user_message"></p>
                <p id="confirm_user_photo">
                    <img src="" alt="" id="confirm_user_photo_preview" class="img-responsive">
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"
                        onclick="document.getElementById('upload_form').submit();">このままに送信
                </button>
                <button type="button" class="btn btn-warning pull-left" data-dismiss="modal">編集</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setModalTitle(modal_id, title) {
        var selector = '#' + modal_id + ' .modal-title';
        var modal_title = document.querySelector(selector);
        if (modal_title) {
            modal_title.innerHTML = title;
        } else {
            console.log(selector + ' not found');
        }
    }

    //    function setModalBody(modal_id, body_content) {
    //        var selector = '#' + modal_id + ' .modal-body';
    //        var modal_body = document.querySelector(selector);
    //        if (modal_body) {
    //            modal_body.innerHTML = body_content;
    //        }else{
    //            console.log(selector + ' not found');
    //        }
    //    }


</script>
