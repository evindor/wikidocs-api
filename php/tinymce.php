<?php require_once('access-token.php'); ?>
<!DOCTYPE html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta charset="utf-8">
	<title>Wikidocs &amp; TinyMCE Demo</title>
	<link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />
</head>
<body>
	<h1>
		Wikidocs &amp; TinyMCE demo on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?>
	</h1>

	<p>
	    <div>Wikidocs connection: <span id="connection-status"><span style="color: red">disconnected</span></span></div>
        <div>You: <span id="you"></span></div>        
        <div>Other online users: <span id="users"></span></div>
		<div id="doc-id">Doc: <a href="?doc=<?php echo $docId; ?>"><?php echo $docId; ?></a></div>
	</p>

	<textarea id="content">Your content here.</textarea>

	<small>powered by <a href="http://www.tinymce.com/" target="_blank">TinyMCE</a> and <a href="https://wikidocs.com">Wikidocs</a>.</small>

	<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	<script src="//cdn.wikidocs.com/lib/sockjs.min.js"></script>
	<script src="//cdn.wikidocs.com/lib/wikidocs.min.js"></script>
	<script src="../lib/wikidocs-lib.js"></script>

	<script>
		// Use the access token that was created in common.php
		var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

		// Use the doc ID the access token was created with.
		var docId = '<?php echo $docId; ?>';

		var app = WD.App(accessToken);
		var doc = app.Document('/' + docId);

		tinymce.init({
			selector:'textarea',
			content_css : "//wikidocs-sandbox.com/lib/wikidocs.min.css",
			init_instance_callback : function(editor) {
				doc.bind(editor.contentDocument.body, {
				    type: 'ckeditor'
				});
		    }
		});

        // wikidocs helper functions from wikidocs-lib.js
        wdTrackConnectionStatus(app, document.getElementById('connection-status'));
        var youContainer = document.getElementById('you');
        var usersContainer = document.getElementById('users');
        app.on('connected', function(session) {
            wdShowOnlineUsers(session.sid, doc, youContainer, usersContainer);
        });
	</script>
</body>
</html>