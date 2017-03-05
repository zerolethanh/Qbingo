<!doctype html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>クイズ＆ビンゴ</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/css.css" rel="stylesheet" type="text/css">
    @include('bootstrap.jquery')
    <script type="text/javascript" src="/js/top.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
</head>
<body>
<header><a href="/"><img src="/image/rogo195-115.png" width="48" height="32" alt="rogo"></a>
    <h1>PDFダウンロードページ</h1>
</header>
<div id="nav">
    <ul>
        <li><a href="/">説明書</a></li>
        <li><a href="/mobile/rec2">ゲスト登録</a></li>
        <li><a href="/mobile/quiz">クイズ作成</a></li>
        <li><a href="/mobile/start">ビンゴスタート</a></li>
    </ul>
</div>
<article>

    <div class="urlrec3">
        <a class="btn"
           href="/mobile/pdf_download">
            PDFでダウンロードする
        </a>
    </div>
    <div id="pdf_html">
        @foreach($uploads as $upload)
            <section>
                <?php
                $tdFields = ['user_sex', 'number', 'user_photo', 'user_name', 'user_message'];
                $datas = [];
                foreach ($tdFields as $idx => $tdf) {
                    if ($tdf == 'user_photo') {
                        $user_photo = $upload[$tdf];
                        $basename = pathinfo($user_photo, PATHINFO_BASENAME);
//                        $d = "<img src='/getphoto/$user_photo' width='80' class='img-responsive'/>";
//                    $d = "<img src='/photo/$basename' width='120' class='img-responsive'/>";
                        $datas[$tdf] = url("/photo/$basename");
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
    </div>

    <!--コメント終わり--------------------------------------------->
    <div class="urlrec3">
        <a class="btn"
           href="/mobile/pdf_download">
            {{--onclick="pdf_download()">--}}
            PDFでダウンロードする
        </a>
    </div>

    <section>

    </section>
</article>
<p id="pageTop"><a href="#">top</a></p>
<footer>
    <address>Copyright(C)2017 クイズ＆ビンゴAllright Reserved.</address>
</footer>
<script>
    function pdf_download() {
        window.open().location.href = '/mobile/pdf_download';
    }
</script>
</body>
</html>
