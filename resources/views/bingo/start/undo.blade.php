<button onclick="return undo()">
    やり直し
</button>
<script>
    function undo() {
        $.post('/start/undo',
            {_token: "{{ csrf_token() }}"},
            function (res, status) {
                if (!res.error) {
                    location.reload();
                }
            }
        );
    }
</script>