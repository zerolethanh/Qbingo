<style>
    .btn-restart {
        background: url('/img/rest475-310.png');
        background-size: 100% 100%;
        width: 120px;
        height: 80px;

        border: none;
        right: 20%;
    }
</style>

<button onclick="restart_game()" class="btn-restart start-buttons">
</button>

<script>
    function restart_game() {
        var restart = confirm('ゲームを最初からスタートしますか?');

        if(restart){
            $.post('/start/restart_game',
                {_token: "{{ csrf_token() }}"},
                function (res, status) {
                    console.log(res);
                    location.reload();
                }
            );
        }

    }
</script>