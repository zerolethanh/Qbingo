<label for="">Hit Numbers:</label><br>
<?php

foreach ($hits as $h) {
    echo "<button  data-toggle='modal'
 data-target='#hit_details'
 onclick='hit_details($h)'>" . $h . "</button>";
}
?>
