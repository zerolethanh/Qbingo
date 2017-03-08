<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>クイズ＆ビンゴ</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/css.css" rel="stylesheet" type="text/css">
    @include('bootstrap.jquery')
    <script type="text/javascript" src="/js/top.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<header><a href="/"><img src="/image/rogo195-115.png" width="48" height="32" alt="rogo"></a>
    <h1>ゲスト登録</h1>
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
    <div class="urlrec">写真、コメント登録用ぺーじURL
        <textarea>{{ $url??'' }}</textarea>
        <div class="coment">ラインで連絡する場合は上記のURLをコピーして<br>ゲストに送って下さい。</div>
    </div>
    <div class="urlrec3"><a class="btn" href="{{ $url ?? '' }}">こちらから自分で登録する場合はコチラ</a>
    </div>
    <div class="heading2">登録済みゲスト一覧</div>
    <a class="btn2" href="/mobile/pdf">PDFダウンロード</a><a class="btn2" href="/mobile/rec">表示切替</a>
    <section>
        <!--登録一覧表始まり--------------------------------------------->
        <div class="MyTable">
            <div class="row">
                <div class="cell1">性別</div>
                <div class="cell2">番号</div>
                <div class="cell3">写真</div>
                <div class="cell4">名前</div>
                <div class="cell5">コメント</div>
            </div>
            @foreach($uploads as $upload)
                <div class="row">
                    <?php
                    $tdFields = ['user_sex', 'number', 'user_photo', 'user_name', 'user_message'];
                    $tdClass = ['<div class="cell1">', '<div class="cell2">', '<div class="cell3">', '<div class="cell4">', '<div class="cell5">'];
                    $divEnd = '</div>';
                    $datas = [];
                    foreach ($tdFields as $idx => $tdf) {
                        if ($tdf == 'user_photo') {
                            $user_photo = $upload[$tdf];
                            $basename = pathinfo($user_photo, PATHINFO_BASENAME);
//                        $d = "<img src='/getphoto/$user_photo' width='80' class='img-responsive'/>";
                            $d = "<img src='/photo/$basename' width='120' class='img-responsive'/>";
                            $datas[$tdf] = $tdClass[$idx] . $d . $divEnd;
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
                            $datas[$tdf] = $tdClass[$idx] . $sex . $divEnd;
                        } else {
                            $datas[$tdf] = $tdClass[$idx] . $upload[$tdf] . $divEnd;
                        }
                    }
                    ?>
                    @foreach($datas as $tdf => $val)

                        <?php echo $val ?>

                    @endforeach
                </div>
            @endforeach
        </div>
    </section>
    <!--コメント終わり--------------------------------------------->
    <section>

    </section>
</article>
<p id="pageTop"><a href="#">top</a></p>
<footer>
    <address>Copyright(C)2017 クイズ＆ビンゴAllright Reserved.</address>
</footer>

</body>
</html>
