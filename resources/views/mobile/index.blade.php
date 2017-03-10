<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>クイズ＆ビンゴ</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/css.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/top.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
        .error {
            color: #F00;
        }
    </style>
</head>
<body>
<header>

</header>

<article>
    <div class="section3">
        <div class="coment1"><img class="img_w" src="/image/rogo975-575.png"></div>
        <br>
        @if (count($errors) > 0)
            <div class="error">IDまたはパスワードが間違っています。</div>
        @endif
        <form action="/" method="post">
            {{ csrf_field() }}
            ID<br><input type="text" name="happy_id" size="45"><br>
            パスワード<br><input type="password" name="password" size="45"><br><br>
            <button class="btn" type="submit">ログイン</button>
        </form>
    </div>
</article>
<p id="pageTop"><a href="#">top</a></p>
<footer>
    <address>Copyright(C)2017 クイズ＆ビンゴAllright Reserved.</address>
</footer>

</body>
</html>
