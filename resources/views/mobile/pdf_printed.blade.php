<!doctype html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>クイズ＆ビンゴ</title>
    <style>
        @charset "UTF-8";
        /* resetCSS Document */
        /*  html5doctor.com Reset Stylesheet v1.6.1 Last Updated: 2010-09-17 Author: Richard Clark - http://richclarkdesign.com  Twitter:















































































































        @rich                                                                                                                _clark */
        html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp, small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, figcaption, figure, footer, header, hgroup, menu, nav, section, summary, time, mark, audio, video {
            margin: 0;
            padding: 0;
            border: 0;
            outline: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
        }

        body {
            line-height: 1;
        }

        article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
            display: block;
        }

        nav ul {
            list-style: none;
        }

        blockquote, q {
            quotes: none;
        }

        blockquote:before, blockquote:after, q:before, q:after {
            content: '';
            content: none;
        }

        a {
            margin: 0;
            padding: 0;
            font-size: 100%;
            vertical-align: baseline;
            background: transparent;
        }

        /
        change colours to suit your needs

        /
        ins {
            background-color: #ff9;
            color: #000;
            text-decoration: none;
        }

        /
        change colours to suit your needs

        /
        mark {
            background-color: #ff9;
            color: #000;
            font-style: italic;
            font-weight: bold;
        }

        del {
            text-decoration: line-through;
        }

        abbr[title], dfn[title] {
            border-bottom: 1px dotted;
            cursor: help;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        /* change border colour to suit your needs  */
        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #cccccc;
            margin: 1em 0;
            padding: 0;
        }

        input, select {
            vertical-align: middle;
        }

        body {
            font: 14px/1.6 "Hiragino Kaku Gothic Pro", Osaka, "メイリオ", "ＭＳ Ｐゴシック", "MS PGothic", Verdana, Arial, sans-serif;
            width: 100%;
            background-color: #f9f9f9;
            margin: 0px;
        }

        header {
            width: 100%;
            height: 50px;
            background-color: #F6F6F6;
            margin: 0px;
        }

        header img {
            padding: 10px;
        }

        header h1 {
            text-align: center;
            font-size: 16px;
            margin-top: -45px;
            color: #666;

        }

        footer {
            width: 100%;
            height: 40px;
            padding-top: 15px;
            font-family: "Trebuchet MS", sans-serif;
            background-color: #9FD6D2;
            text-align: center;
            color: #333;
            font-size: 12px;
        }

        /*---下層ページの画像---*/
        .img_w {
            width: 100%;
        }

        @media screen and (orientation: landscape) {
            /* 横向きの場合のスタイル */
        }

        @media screen and (orientation: portrait) {
            /* 縦向きの場合のスタイル */
        }

        .urlrec {
            height: 150px;
            margin: 10px 10px;
            padding: 1em 5% 0em;
            text-align: center;
            color: #F69;
            font-size: 18px;
            border: 1px #9FD6D2 solid; /* 枠線を引く */
            　　border-radius: 50px; /* 角丸の指定 */
        }

        .urlrec2 {
            height: 25px;
            margin: 0px 0px;
            padding: 0em 5% 0em;
            background-color: #9FD6D2;
            font-size: 16px;
            text-align: center;
            color: #FFF;
            border: 1px #9FD6D2 solid; /* 枠線を引く */
            　　border-radius: 50px; /* 角丸の指定 */
        }

        .urlrec3 {
            height: 50px;
            margin: 0px 0px;
            padding: 10px 10px;
            background-color: #fff;
            font-size: 16px;
            text-align: center;
            color: #FFF;
        }

        .urlrec4 {

            margin: 10px 10px;
            padding: 1em 5% 0em;
            text-align: center;
            color: #F69;
            font-size: 18px;
            border: 1px #9FD6D2 solid; /* 枠線を引く */
            　　border-radius: 50px; /* 角丸の指定 */
        }

        .heading {
            height: 28px;
            margin: 0px 0px;
            padding: 5px;
            background-color: #9FD6D2;
            font-size: 16px;
            text-align: center;
            color: #FFF;
        }

        .heading3 {
            height: 28px;
            margin: 0px 0px;
            padding: 5px;
            background-color: #EAEAEA;
            font-size: 20px;
            text-align: center;
            color: #333;
            font-weight: 800;
        }

        textarea {
            width: 100%;
            height: 30%;
        }

        .heading2 {
            height: 28px;
            margin: 0px 0px;
            padding: 5px;
            background-color: #9FD6D2;
            font-size: 16px;
            text-align: center;
            color: #FFF;
            border: 1px #9FD6D2 solid; /* 枠線を引く */
            　　border-radius: 50px; /* 角丸の指定 */
            position: relative;
            font-weight: bold;
            vertical-align: middle;
        }

        .heading2:after, .heading2:before {
            content: '';
            height: 18px;
            width: 4px;
            display: block;
            background: #00A8FF;
            position: absolute;
            top: 8px;
            left: 70px;
            border-radius: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
        }

        .heading2:before {
            height: 10px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            -ms-transform: rotate(-45deg);
            top: 16px;
            left: 62px;
        }

        .btn {
            margin: 0 auto;
            background-color: #F69;
            width: 80%;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            color: #FFF;
            display: block;
            padding: 10px 0;
            border-radius: 10px;
            border: 1px solid #DDD;
        }

        .btn2 {

            margin-right: 10px;
            margin: 10px 10px;
            float: right;
            background-color: #F69;
            width: auto;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            color: #FFF;
            display: block;
            padding: 10px 10px;
            border-radius: 10px;
            border: 1px solid #DDD;
        }

        .btn3 {
            margin-left: 50px;
            margin-top: 10px;
            float: left;
            background-color: #F69;
            width: 30%;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            font-size: 13px;
            color: #FFF;
            display: block;
            padding: 10px 0;
            border-radius: 10px;
            border: 1px solid #DDD;
        }

        .coment1 {
            padding: 0.5em 5% 0em;
            font-size: 12px;
            font-weight: bold;
        }

        .coment {
            padding: 0.3em 5% 1em;
            font-size: 12px;
        }

        article {
            margin: 0px 0px;
        }

        section {
            margin: 0px 0px;
            margin-top: 10px;
        }

        section2 {
            margin: 0px 0px;
            margin-top: 10px;
        }

        .section3 {
            margin: auto;
            margin-top: 10px;
            width: 80%;
            height: 500px;
            text-align: center;
        }

        .section4 {
            margin: auto;
            margin-top: 10px;
            width: 90%;

            text-align: center;
        }

        imgs {
            width: 100%;
        }

        #nav {
            background-color: #9FD6D2;
            padding: 20px;
        }

        #nav ul {
            padding: 0px;
            margin: 0px;
            text-align: center;
        }

        #nav ul li {
            display: inline-block;

            margin-left: 0.7em;
        }

        #nav ul li a {
            font-family: "Trebuchet MS", sans-serif;
            text-decoration: none;
            color: #fff;
            border-bottom-color: #fff;
        }

        #nav ul li a:hover {
            border-bottom: dotted 1px #fff;
        }

        /*ページトップボタン*/
        #pageTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        #pageTop a {
            display: block;
            z-index: 999;
            padding: 8px 1 0 8px;
            border-radius: 30px;
            width: 35px;
            height: 35px;
            background-color: #9FD6D2;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
        }

        #pageTop a:hover {
            text-decoration: none;
            opacity: 0.7;
        }

        .ta1, .ta1 th, .ta1 td {
            border: 1px #9FD6D2 solid;
            margin: auto;
            margin-top: 0px;
            padding: 0px 0px 0px 0px;
        }

        /*テーブル*/
        .MyTable {
            display: table;
            width: 95%;
            margin: auto;
            margin-top: 50px;
        }

        .MyTable div.row {
            display: table-row;
            text-align: center;
        }

        .MyTable div.cell {
            display: table-cell;
            border: 1px solid #9FD6D2;

        }

        .MyTable div.cell1 {
            display: table-cell;
            width: 10%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable div.cell2 {
            display: table-cell;
            width: 10%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable div.cell3 {
            display: table-cell;
            width: 20%;
            border: 1px solid #9FD6D2;
            vertical-align: middle;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable div.cell4 {
            display: table-cell;
            width: 20%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable div.cell5 {
            display: table-cell;
            width: 50%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
            padding: 2px 2px;
        }

        .MyTable2 {
            display: table;
            width: 95%;
            margin: auto;
            margin-top: 10px;
        }

        .MyTable2 div.row {
            display: table-row;
            text-align: center;
        }

        .MyTable2 div.cell {
            display: table-cell;
            border: 1px solid #9FD6D2;

        }

        .MyTable2 div.cell1 {
            display: table-cell;
            width: 10%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable2 div.cell2 {
            display: table-cell;
            width: 30%;
            height: 50px;
            padding: 10px;
            border: 1px solid #9FD6D2;
            text-align: left;
            vertical-align: middle;
        }

        .MyTable2 div.cell3 {
            display: table-cell;
            height: 120px;
            padding: 10px;
            border: 1px solid #9FD6D2;
            vertical-align: middle;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable2 div.cell4 {
            display: table-cell;
            width: 90%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
        }

        .MyTable2 div.cell5 {
            display: table-cell;
            width: 50%;
            border: 1px solid #9FD6D2;
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
            padding: 2px 2px;
        }

        .MyTable3 {
            display: table;
            width: 100%;
            margin-left: 1px;
            margin-top: 10px;
        }

        .MyTable3 div.row {
            display: table-row;
            text-align: center;
        }

        .MyTable3 div.cell {
            display: table-cell;
            border: 1px solid #9FD6D2;

        }

        .MyTable3 div.cell1 {
            display: table-cell;
            width: 30%;
            border: 0px solid #9FD6D2;
            text-align: right;
            vertical-align: middle;
        }

        .MyTable3 div.cell2 {
            display: table-cell;
            width: 70%;
            height: 30px;

            border: 0px solid #9FD6D2;
            text-align: left;
            vertical-align: middle;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
</head>
<body>
@foreach($uploads as $upload)
    <section>
        <?php
        $tdFields = ['user_sex', 'number', 'user_photo', 'user_name', 'user_message'];
        $datas = [];
        foreach ($tdFields as $idx => $tdf) {
            if ($tdf == 'user_photo') {
                $user_photo = $upload[$tdf];
                $basename = pathinfo($user_photo, PATHINFO_BASENAME);
                $datas[$tdf] = url("/thumb/$basename");
            } elseif ($tdf == 'user_sex') {
                switch ($upload[$tdf]) {
                    case 'M':
                        $sex = '<img src="/image/men.png" width="32" height="32" alt="men">';
                        break;
                    case 'F':
                        $sex = '<img src="/image/woman.png" width="32" height="32" alt="woman">';
                        break;
                    default:
                        $sex = '';
                }
                $datas[$tdf] = $sex;
            } else {
                $datas[$tdf] = $upload[$tdf];
            }
        }
        ?>
        <table width="95%" height="20" cellpadding="15">
            <tr>
                <td width="15%"><?= $datas['user_sex'] ?></td>
                <td width="20%">番号</td>
                <td width="15%"><?= $datas['number'] ?></td>
                <td width="55%"><?= $datas['user_name'] ?></td>
            </tr>
        </table>
        <img class="img_w" src="<?= $datas['user_photo'] ?>"/>
        <div class="coment1">comment</div>
        <div class="coment">
            <?= $datas['user_message'] ?>
        </div>
    </section>
@endforeach
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
@include('bootstrap.sources')
<script>

    capture();
    function capture() {
        html2canvas(document.body, {
            onrendered: function (canvas) {
                var downloadType = "{{ request('type','jpg') }}";
                switch (downloadType.toUpperCase()) {
                    case 'JPG':
                    case 'JPEG':
                        downloadJPGfromCanvas(canvas);
                        break;
                    case 'PDF':
                        downloadPDFfromCanvas(canvas);
                        break;
                    default:
                        downloadJPGfromCanvas(canvas);
                        break;
                }
            }
        });
    }
    function downloadPDFfromCanvas(canvas, name = "{{ auth()->user()->happy_id }}.pdf") {
        var width = canvas.width;
        var height = canvas.height;
        var millimeters = {};
        millimeters.width = Math.floor(width * 0.264583);
        millimeters.height = Math.floor(height * 0.264583);

        var imgData = canvas.toDataURL('image/png');
        var doc = new jsPDF("p", "mm", "a4");
        doc.deletePage(1);
        doc.addPage(millimeters.width, millimeters.height);
        doc.addImage(imgData, 'PNG', 0, 0);
//        doc.save(name);
        var jpeg_dataurl = doc.output('datauristring');
        if (checkDataURISize(jpeg_dataurl)) {
            $.post('/mobile/upload_jpeg_dataurl', {
                    _token: "{{ csrf_token() }}"
                    , jpeg_dataurl
                },
                function (res) {
                    console.log(res);
                    if (res.saved) {
                        window.location.href = res.download_url;
                    } else {
                        $.notify(res.err_message)
                    }
                }
            ).fail(function (res) {
                notifyFail(res);
            });
        }
    }
    function downloadJPGfromCanvas(canvas, name = "{{ auth()->user()->happy_id }}.jpg") {
        @if(IS_MOBILE)
            $.notify('長押ししたら画像を保存できます。', 'success');
                @endif
        var jpeg_dataurl = canvas.toDataURL("image/jpeg", 1.0);
        if (checkDataURISize(jpeg_dataurl)) {
            $.post('/mobile/upload_jpeg_dataurl', {
                _token: "{{ csrf_token() }}"
                , jpeg_dataurl
            }, function (res) {
                console.log(res);
                if (res.saved) {
                    window.location.href = res.download_url;
                } else {
                    $.notify(res.err_message)
                }
            }).fail(function (res) {
                notifyFail(res);
            });
        }
    }
    function checkDataURISize(dataURI) {
        var dataurisize = getDataURISize(dataURI) * 1.2;
        var post_max_size = parseInt("{{  \App\Http\Controllers\MobileController::post_max_size() }}");
        console.log({post_max_size});
        console.log({dataurisize});
        if (dataurisize > post_max_size) {
            $.notify(`PDFファイルが大きすぎます
                写真ファイルをダウンロードします。`);
            setTimeout(function () {
                location.href = '/mobile/pdf_download?type=jpg';
            }, 3000);
            return false
        }
        return true;
    }
    /**
     * getDataURISize in bytes
     * @param datauri
     * @returns {number}
     */
    function getDataURISize(datauri) {
        return Math.round((datauri.length - 'data:image/png;base64,'.length) * 3 / 4);
    }

</script>
</body>
</html>


