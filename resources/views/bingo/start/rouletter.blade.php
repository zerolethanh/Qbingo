<script src="/js/roulette.min.js"></script>

<div class="roulette">

    <?php
    $faces = $uploads;

    $face_imgs = [];
    $face_idxs = [];
    $thumb_heigth = \App\Upload::UPLOAD_THUMB_HEIGHT;

    foreach ($faces as $face) {
        $face_idxs[] = $face->id;
        $f = "<img src='/thumb/{$face->thumb}' id='face-{$face->id}' height='$thumb_heigth'/>";
        $face_imgs[] = $f;
    }

    $face_idxs = json_encode($face_idxs);
    echo "<meta name='face_idxs' content= '$face_idxs'/>";
    echo implode('', $face_imgs);
    ?>
</div>
{{--<div class="btn_container">--}}
{{--<p>--}}
{{--<button class="btn btn-lg btn-primary start" onclick="roll(Math.floor(Math.random() * face_idxs.length) + 1  )"> START</button>--}}
{{--<button class="stop btn-large btn btn-warning"> STOP</button>--}}
{{--</p>--}}
{{--</div>--}}

<script>

    var face_idxs = JSON.parse(document.getElementsByName('face_idxs')[0].getAttribute('content'));
    console.log(face_idxs);

    // roulette 設定

    var option = {
        speed: 20,
        duration: 1,
        stopImageNumber: 0,
        startCallback: function () {
            console.log('start');
        },
        slowDownCallback: function () {
            console.log('slowDown');
        },
        stopCallback: function ($stopElm) {
            console.log('stop');
        }
    };

    var rouletter = $('div.roulette');
    rouletter.roulette('option', option);

    function roll(stopFaceIndex, whenRollEnded, whenRollStart) {
        option['stopImageNumber'] = Number(stopFaceIndex);
        option.stopCallback = whenRollEnded;
        option.startCallback = whenRollStart;

        console.log(option);
        rouletter.roulette('option', option);
        rouletter.roulette('start');
    }
</script>