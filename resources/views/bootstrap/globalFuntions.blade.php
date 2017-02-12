<meta name="csrf-token" content="{{ csrf_token() }}">
@include('bootstrap.Components.Confirm')
@include('bootstrap.updateView')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'MASTER-ID': "{!! isset($master) ? encrypt($master->id) : null !!}",
            'SHOP-ID': "{!! isset($shop) ? encrypt($shop->id) : null  !!}",
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

    function objectValues(obj) {
        return Object.keys(obj).map(function (k) {
            return obj[k]
        })
    }
    function notifyErrors(res) {
        try {
            if (typeof res === 'string') {
                $.notify(res);
                return;
            }
            const resJ = res.responseJSON;
            if (typeof resJ.err_message !== "undefined") {
                $.notify(resJ.err_message);
                return;
            }
            const errsString = objectValues(resJ).join().split('\n');
            $.notify(errsString);
        } catch (e) {
            console.log(e);
        }
    }

</script>