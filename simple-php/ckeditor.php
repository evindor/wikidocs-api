<?php require_once('common.php'); ?>
<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta charset="utf-8">

<title>Wikidocs & CKEditor Demo</title>

<link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />

<h1>Wikidocs & CKEditor demo on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?></h1>

<div id="editable" contentEditable="true">
</div>

<small>powered by <a href="https://github.com/xing/CKEditor" target="_blank">CKEditor</a> and <a href="https://wikidocs.com">Wikidocs</a>.</small>

<script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.3.2/ckeditor.js"></script>
<script src="//cdn.wikidocs.com/lib/sockjs.min.js"></script>
<script src="//cdn.wikidocs.com/lib/wikidocs.min.js"></script>
<script>
// Use the access token that was created in common.php
var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

// Use the doc ID the access token was created with.
var docId = '<?php echo $doc; ?>';

var app = WD.App(accessToken);
var doc = app.Document('/' + docId);
CKEDITOR.on('instanceReady', function () {
    doc.bind(document.getElementById('editable'));
});
</script>
