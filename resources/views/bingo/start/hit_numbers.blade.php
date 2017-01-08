<label for="">Hit Numbers:</label><br>
<?php

foreach ($hits as $h) {
    echo "<button  data-toggle='modal'
 style='font-weight: bold;font-size: 50px'
class='btn btn-lg btn-default'
 data-target='#hit_details'
 onclick='hit_details($h)'>" . $h . "</button>";
}
?>
