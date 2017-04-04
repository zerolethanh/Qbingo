<script src="/js/roulette.min.js"></script>

<div id="face_imgs">
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
</div>