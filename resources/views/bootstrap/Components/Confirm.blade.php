<script>
    /**
     * Created by ZE on 2017/02/02.
     */
    class Confirm {
        static delete(yesCallBack, noCallBack = null) {
            $.getScript('https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js',
                function () {
                    bootbox.confirm({
                        size: "small",
                        message: "<h1>削除しますか?</h1>",
                        buttons: {
                            confirm: {
                                label: 'はい、削除する',
                                className: 'btn-danger'
                            },
                            cancel: {
                                label: 'いいえ',
                                className: 'btn-primary'
                            }
                        },
                        callback: function (ok) {
                            /* result is a boolean; true = OK, false = Cancel*/
                            try {
                                if (ok) {
                                    //yes = delete
                                    if (yesCallBack) {
                                        yesCallBack();
                                    }
                                } else {
                                    // no = cancel
                                    if (noCallBack) {
                                        noCallBack()
                                    }
                                }
                            } catch (e) {
                                console.log(e)
                            }
                        }
                    })
                }
            )
        }
    }

</script>