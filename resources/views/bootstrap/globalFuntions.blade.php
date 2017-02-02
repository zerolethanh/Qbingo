<meta name="csrf-token" content="{{ csrf_token() }}">
@include('bootstrap.Components.Confirm')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        , cache: true
    });
    function id(id) {
        var el = document.getElementById(id);
        if (el) {
            return el
        }
        console.log('element with id:' + id + ' not found');
    }
    function notifySuccess(content) {
        $.notify(content, 'success');
    }
    function notifyFail(content) {
        $.notify(content);
    }
    /**
     * PJAX update for view
     * @param res : response = {id:$view_id, data:$view_html}
     *
     */
    function updateView(res) {
        document.getElementById(res["{{ $UPDATE_VIEW_HTML_ID }}"]).innerHTML = res[res["{{$UPDATE_VIEW_HTML_ID}}"]];
    }
    function objectValues(obj) {
        return Object.keys(obj).map(function (k) {
            return obj[k]
        })
    }
    function notifyErrors(res) {
        try {
            let errsString = objectValues(res.responseJSON).join().split('\n');
            $.notify(errsString);
        } catch (e) {
            console.log(e);
        }
    }

</script>