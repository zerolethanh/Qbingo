{{--<label for="">Numbers:</label><br>--}}
<?php

$no_hits->each(function ($n) {
    echo "<button onclick='hit_number($n)' class='btn-screens' style='width: 30px;font-weight: bold'>$n</button>";
});
?>


<script>
    function hit_number($n) {
        $.post('/start/hit', {
            '_token': '{{ csrf_token() }}',
            'number': $n
        }, function (res, status) {
            console.log(res);

            if (!res.start) {
                //game is not be started
                return;
            }
            var hit_elements = [/*'<label for="">Hit Numbers:</label><br>'*/];
            var no_hit_elements = [/*'<label for="">Numbers:</label><br>'*/];
            res.hits.forEach(function (hit) {
                hit_elements.push("<button  data-toggle='modal' style='font-weight: bold;'" +
                    " class='suuji'" +
                    " data-target='#hit_details'" +
                    " onclick='hit_details(" +
                    hit
                    + ")'>" + hit + "</button>");
            });
            res.no_hits.forEach(function (no_hit) {
//                var hit_number_function = new Function('hit_number(' + no_hit + ')');
                no_hit_elements.push('<button class="btn-screens" style="width: 30px;font-weight: bold" ' +
                    'onclick="hit_number(' + no_hit + ')">' + no_hit + '</button>');
            });

            document.getElementById('hit_numbers').innerHTML = hit_elements.join('');
            document.getElementById('numbers').innerHTML = no_hit_elements.join('');

//            document.getElementById("raw_hit_numbers").innerHTML = res.hits.join('&nbsp;&nbsp;&nbsp;&nbsp;')
        })
    }
</script>