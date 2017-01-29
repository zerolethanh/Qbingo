{{--<label for="">Hit Numbers:</label><br>--}}

<?php

foreach ($hits as $h) {
    $hit_number_button = "<button  data-toggle='modal'
class='suuji'
 data-target='#hit_details'
 onclick='hit_details($h)'>" . $h . "</button>";
    echo $hit_number_button;
}
?>
