<?php
/**
 * User: ZE
 * Date: 2016/12/14
 * Time: 21:39
 */
?>
        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Hello World</title>
    <script src="https://unpkg.com/react@latest/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@latest/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
</head>
<body>
<div id="root"></div>
<div id="upload-form"></div>

<script type="text/babel" src="/views/upload/components/UploadForm.js"></script>

<script type="text/babel">
    ReactDOM.render(
            <UploadForm/>, document.getElementById('upload-form')
    )
</script>
</body>
</html>
