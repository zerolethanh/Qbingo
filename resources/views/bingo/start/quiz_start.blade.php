<style>
    .btn-quiz {
        background: url('/img/cuizu710-385.png');
        background-size: 100% 100%;
        width: 200px;
        height: 108px;
        border: none;
        position: relative;
    }
</style>
<button onclick="return startQuiz(event);"  class="btn-quiz start-buttons">

</button>

<script>

    function startQuiz(event) {
        event.preventDefault();
        startFace(event);
    }
</script>