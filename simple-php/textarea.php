<?php require_once('common.php'); ?>
<html>
<head>
    <title>Wikidocs Demo</title>
    <link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />
    <script src="//cdn.wikidocs.com/lib/sockjs.min.js"></script>
	<script src="//cdn.wikidocs.com/lib/wikidocs.min.js"></script>
	<script src="connection-status.js"></script>
</head>
<body>

<h1>Wikidocs demo on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?> <span id="connection-status"></span></h1>

<div class="app">
    <p id="doc-id">Doc: <a href="?doc=<?php echo $docId; ?>"><?php echo $docId; ?></a></p>
    <div class="input">
        <input type="text" id="my-title">
        <textarea id="my-teaser"></textarea>
        <div contenteditable="true" id="editable"></div>
    </div>
</div>

<script>
// Use the access token that was created in common.php
var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

// Use the doc ID the access token was created with.
var docId = '<?php echo $docId; ?>';
 
var app = WD.App(accessToken);
 
// As we have 3 differnt content areas in this example
// we prefix all of them with the doc id.
var textbox = document.getElementById('my-title');
app.Document('/' + docId + '-title').bind(textbox);

// You can also synchronize textareas
var textarea = document.getElementById('my-teaser');
app.Document('/' + docId + '-teaser').bind(textarea);

// Or any other DOM element
var editable = document.getElementById('editable');
app.Document('/' + docId).bind(editable);

// Aloha Editor binding is pretty simple
// Aloha.ready(function() {
//     $('#aloha-editable').aloha()
//     var editable = Aloha.getEditableById('aloha-editable');
//     app.Document('/' + docId + '-aloha-doc').bind(editable, {
//         type: 'aloha'
//     });
// }

trackConnectionStatus(app, document.getElementById('connection-status'));
</script>
</body>
</html>
