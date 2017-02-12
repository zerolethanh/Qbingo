<script>
    function updateView(res, status, xhr) {
        try {
            if (res.err !== undefined && res.err == true) {
                notifyErrors(res.err_message);
                return;
            }
            document.getElementById(res["{{ $UPDATE_VIEW_HTML_ID }}"]).innerHTML = res[res["{{$UPDATE_VIEW_HTML_ID}}"]];
//            location.reload();
//            window.location.replace(document.referrer)
//            console.log(res['time']);
            {{--var UPDATE_VIEW_HTML_ID = res["{{ $UPDATE_VIEW_HTML_ID }}"];--}}
//            history.pushState(null, null, '#' + UPDATE_VIEW_HTML_ID + String(res['time']));

        } catch (e) {
//            console.log(res);
            notifyErrors(res);
            notifyFail(e);
        }
    }
</script>