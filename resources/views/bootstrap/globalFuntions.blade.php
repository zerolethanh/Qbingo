<meta name="csrf-token" content="{{ csrf_token() }}">
@include('bootstrap.Components.Confirm')
@include('bootstrap.updateView')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'X-MASTER-ID': "{!! isset($master) ? encrypt($master->id) : null !!}",
            'X-SHOP-ID': "{!! isset($shop) ? encrypt($shop->id) : null  !!}",
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
    $(document).ready(function () {
        try {
            $('[data-toggle="popover"]').popover({
                html: true,
                animation: false,
                placement: 'auto right'
            });
        } catch (e) {
            console.log(e)
        }
    });
    /**
     *
     * @param arr : [Object:{name:'a',value:'b'},Object:{name:'a1',value:'b1'}]
     * @returns {a:b,a1:b1}
     */
    function keyValueSerializeArray(arr) {
        var name, value, result = {};
        for (let i = 0; i < arr.length; i++) {
            name = arr[i].name;
            value = arr[i].value;
            result[name] = value;
        }
        return result;
    }
    function formNameValues(form) {
        return keyValueSerializeArray($(form).serializeArray());
    }
    // From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
    if (!Object.keys) {
        Object.keys = (function () {
            'use strict';
            var hasOwnProperty = Object.prototype.hasOwnProperty,
                hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
                dontEnums = [
                    'toString',
                    'toLocaleString',
                    'valueOf',
                    'hasOwnProperty',
                    'isPrototypeOf',
                    'propertyIsEnumerable',
                    'constructor'
                ],
                dontEnumsLength = dontEnums.length;

            return function (obj) {
                if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
                    throw new TypeError('Object.keys called on non-object');
                }

                var result = [], prop, i;

                for (prop in obj) {
                    if (hasOwnProperty.call(obj, prop)) {
                        result.push(prop);
                    }
                }

                if (hasDontEnumBug) {
                    for (i = 0; i < dontEnumsLength; i++) {
                        if (hasOwnProperty.call(obj, dontEnums[i])) {
                            result.push(dontEnums[i]);
                        }
                    }
                }
                return result;
            };
        }());
    }
    //    $(document).ready(function () {
    //        $('[data-toggle="popover"]').popover({html: true});
    //    });
</script>