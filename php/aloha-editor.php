<?php require_once('access-token.php'); ?>
<html>
<head>
    <title>Wikidocs &amp; Aloha Editor</title>
    <link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />
    <link href="http://cdn.aloha-editor.org/latest/css/aloha.css" rel="stylesheet" type="text/css" />
</head>
<body>

    <h1>
        Wikidocs &amp; Aloha Editor on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?>
    </h1>

    <p>
        <div>Wikidocs connection: <span id="connection-status"><span style="color: red">disconnected</span></span></div>
        <div>Online users: <span id="users"></span></div>
        <div id="doc-id">Doc: <a href="?doc=<?php echo $docId; ?>"><?php echo $docId; ?></a></div>
    </p>

    <div id="aloha-editable">Aloha Editor initial content.</div>

    <small>powered by <a href="http://aloha-editor.org" target="_blank">Aloha Editor</a> and <a href="https://wikidocs.com">Wikidocs</a>.</small>

    <script type="text/javascript" src="http://cdn.aloha-editor.org/latest/lib/require.js"></script>
    <script type="text/javascript" src="http://cdn.aloha-editor.org/latest/lib/vendor/jquery-1.7.2.js"></script>
    <script src="http://cdn.aloha-editor.org/latest/lib/aloha.js"
                       data-aloha-plugins="common/ui,
                                            common/format,
                                            common/list,
                                            common/link,
                                            common/highlighteditables">
    </script>
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
         
        // Aloha Editor binding
        Aloha.ready(function() {
            $('#aloha-editable').aloha()
            var editable = document.getElementById('aloha-editable');
                doc.bind(editable, {
                type: 'aloha'
            });
        });

        // wikidocs helper functions from wikidocs-lib.js
        trackConnectionStatus(app, document.getElementById('connection-status'));
        showOnlineUsers(doc, document.getElementById('users'));
    </script>
</body>
</html>
