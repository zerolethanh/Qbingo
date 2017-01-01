
<style>

    #ezslots2 .window {
        font-size: 40px;
        font-family: arial, helvetica, sans-serif;
        border: 1px solid black;
        margin-top: 40px;
    }

</style>
<script src="/js/ezslots.js"></script>
<link href="/css/ezslots.css" rel="stylesheet" type="text/css"/>
{{-- ez slot --}}
<script src="/js/jquery.easing.1.3.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>

<div id="ezslots2"></div>
<button id="gogogo2">spin</button>
<button id="winwinwin2">win</button>


<?php
$faces = request()->user()->uploads;

$face_imgs = [];
$face_idxs = [];


$url = request()->getBaseUrl();
foreach ($faces as $face) {
    $face_idxs[] = $face->id;
    $f = '<img src="/getphoto/' . $face->user_photo . '" id="face-"'.$face->id . 'width="150px" class="img-responsive" />';
    $face_imgs[] = $f;
}

$face_idxs = json_encode($face_idxs);
$face_imgs_json = json_encode($face_imgs);

echo "<meta name='face_idxs' content= '$face_idxs' >";
echo "<meta name='face_imgs_json' content= '$face_imgs_json' >";

//    echo implode('', $face_imgs);
?>


<script>

    //setting up some sample set sof things we can make a slot machine of
    var images = JSON.parse(document.getElementsByName('face_imgs_json')[0].getAttribute('content'));

    console.log(images);
    //using images instead, and more reels
    var ezslot2 = new EZSlots("ezslots2", {
        "reelCount": 1,
        "winningSet": [2],
        "symbols": images,
        "height": 150,
        "width": 150
    });

    $("#gogogo2").click(function () {
        console.log(ezslot2.spin());
    });
    $("#winwinwin2").click(function () {
        console.log(ezslot2.win())
    });

</script>