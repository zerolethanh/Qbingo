
<script src="/js/roulette.min.js"></script>

<div class="roulette" style="display:none;">

    <?php
    $faces = request()->user()->uploads;

    $face_imgs = [];
    $face_idxs = [];


    foreach ($faces as $face) {
        $face_idxs[] = $face->id;
        $f = "<img src='/getphoto/{$face->user_photo}' id='face-{$face->id}' width='150px' class='img-responsive' />";
        $face_imgs[] = $f;
    }

    $face_idxs = json_encode($face_idxs);
    echo "<meta name='face_idxs' content= '$face_idxs'/>";
    echo implode('', $face_imgs);
    ?>
</div>
<div class="btn_container">
    <p>
        <button class="btn btn-large btn-primary start"> START</button>
        <button class="stop btn-large btn btn-warning"> STOP</button>
    </p>
</div>

<script>

    var face_idxs = JSON.parse(document.getElementsByName('face_idxs')[0].getAttribute('content'));
    console.log(face_idxs);

    // roulette 設定

    var option = {
        speed: 10,
        duration: 3,
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

    function roll(stopFaceIndex) {
        option['stopImageNumber'] = Number(stopFaceIndex);
        console.log(option);
        rouletter.roulette('option', option);
        rouletter.roulette('start');
    }
</script>