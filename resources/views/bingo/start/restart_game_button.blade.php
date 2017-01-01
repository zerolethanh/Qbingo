<button onclick="restart_game()">
    Restart Game
</button>

<script>
    function restart_game() {
        var restart = confirm('Are You Sure Restart Game?');

        if(restart){
            $.post('/start/restart_game',
                {_token: "{{ request()->session()->token() }}"},
                function (res, status) {
                    console.log(res);
                    location.reload();
                }
            );
        }

    }
</script>