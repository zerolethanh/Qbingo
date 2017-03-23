<style>
    .fullscreen {
        z-index: 9999;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
    }

    .btn-screens {
        background: url('/img/bn107-32.jpg');
        background-size: 100% 100%;
        width: 107px;
        height: 32px;
        border: 0px;
        font-weight: bold;

    }
    /*Bootstrap 3*/
    .modal .modal-lg {
        width: 80%;
    }
    /*#quiz_text_div{background:#cc0000}*/
</style>
<div>
    <button
            {{--data-toggle="modal" --}}
            {{--data-target="#fullscreen_modal" --}}
            onclick="all_fullscreen()"
            class=" btn-screens">全画面
    </button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="face_quiz_fullscreen()" class=" btn-screens"
            style="width: 150px">フェイスクイズ画面
    </button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="face_fullscreen()" class=" btn-screens"
            style="width: 120px">フェイス1画面
    </button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="quiz_fullscreen()" class=" btn-screens">
        クイズ1画面
    </button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="hit_numbers_fullscreen()" class=" btn-screens">
        数字1画面
    </button>
    <button data-toggle="modal" data-target="#fullscreen_modal" onclick="camera_fullscreen()" class=" btn-screens"
            style="width: 180px">外付けカメラ１画面
    </button>
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
                {{--<p>hitdetails</p>--}}
            </div>
        </div>
    </div>
</div>
<script>

    function all_fullscreen() {
        toggleFullScreen();
    }
    function toggleFullScreen() {
        if ((document.fullScreenElement && document.fullScreenElement !== null) ||
            (!document.mozFullScreen && !document.webkitIsFullScreen)) {
            if (document.documentElement.requestFullScreen) {
                document.documentElement.requestFullScreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullScreen) {
                document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            }
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }
        }
    }
    function face_quiz_fullscreen() {
        var face_src =
            "<img src='"
            + document.getElementById('face_img').src
            + "' class='img-responsive'/>";

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

//        var hit_numbers = document.getElementById('hit_numbers').innerHTML;
        var hit_numbers_html = '<div>';
        for (var i = 0; i < hit_numbers.length; ++i) {
            var hit = hit_numbers[i];
            hit_numbers_html +=
                "<button  data-toggle='modal'" +
//                " class='suuji'" +
                " class='btn-warning'" +
                " data-target='#hit_details'" +
                " style='font-size: 10em;margin: 5px;color: black;'" +
                " onclick='hit_details(" + hit + ")'>" + hit + "</button>";
        }
        hit_numbers_html += '</div>';
        setFullScreenBody(
            hit_numbers_html
        )
    }
    function camera_fullscreen() {
//        var camera_region = document.getElementById('camera_region').innerHTML;
        var camera =
            "<video src='"
            + document.getElementById('camera').src
            + "' width='100%' autoplay></video>";
        setFullScreenBody(
            camera
        )

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
            content_el.innerHTML = content;
        } catch (e) {
            console.log(e)
        }
    }
</script>