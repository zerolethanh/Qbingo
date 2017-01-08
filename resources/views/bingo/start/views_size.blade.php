<style>
    .fullscreen {
        z-index: 9999;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
    }

    /*#quiz_text_div{background:#cc0000}*/
</style>
<div>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="all_fullscreen()">全画面</button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="face_quiz_fullscreen()">フェイスクイズ画面</button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="face_fullscreen()">フェイス1画面</button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="quiz_fullscreen()">クイズ1画面</button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="hit_numbers_fullscreen()">数字1画面</button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="camera_fullscreen()">外付けカメラ１画面</button>
</div>
<!-- モーダル・ダイアログ -->
<div class="modal" id="fullscreen_modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                {{--<h4 class="modal-title">Hit Details</h4>--}}
            </div>
            <div class="modal-body">
                <p>hitdetails</p>
            </div>
        </div>
    </div>
</div>
<script>

    function all_fullscreen() {

    }

    function face_quiz_fullscreen() {
        var face_src =
            "<img src='"
            + document.getElementById('face_img').src
            + "' class='img-responsive'/>"

        var quiz_text =
            "<h1 style='font-size: 100px;'>" +
            document.getElementById('quiz_text').value
            + "</h1>";

        setFullScreenBody(face_src + quiz_text)
    }
    function quiz_fullscreen() {
        var quiz_text =
            "<h1 style='font-size: 100px;'>" +
            document.getElementById('quiz_text').value
            + "</h1>";

        setFullScreenBody(quiz_text)
    }

    function face_fullscreen() {
        var face_src = document.getElementById('face_img').src;
        setFullScreenBody(
            "<img src='" + face_src + "' class='img-responsive'/>"
        )
    }

    function hit_numbers_fullscreen() {

        var hit_numbers = document.getElementById('hit_numbers').innerHTML;

        setFullScreenBody('' +
            hit_numbers
        )
    }
    function camera_fullscreen() {

    }

    function setFullScreenTitle(title) {
        try {
            var title_el = document.querySelector('#fullscreen_modal .modal-title');
            title_el.innerHTML = title;
        } catch (e) {
            console.log(e)
        }
    }
    function setFullScreenBody(content) {
        try {
            var content_el = document.querySelector('#fullscreen_modal .modal-body');
            content_el.innerHTML =

                content


        } catch (e) {
            console.log(e)
        }
    }
</script>