<?php require_once('access-token.php'); ?>
<html>
<head>
    <title>Wikidocs &amp; Aloha Editor</title>
    <link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />
    <link href="http://cdn.aloha-editor.org/latest/css/aloha.css" rel="stylesheet" type="text/css" />
</head>
<body>

    <h1>Wikidocs &amp; Aloha Editor on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?> <span id="connection-status"></span></h1>

    <div id="aloha-editable">Go here</div>

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
    <script src="../lib/connection-status.js"></script>
     
    <script>
    // Use the access token that was created in common.php
    var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

    // Use the doc ID the access token was created with.
    var docId = '<?php echo $docId; ?>';
     
    var app = WD.App(accessToken);
     
    // Aloha Editor binding
    Aloha.ready(function() {
        $('#aloha-editable').aloha()
        var editable = document.getElementById('aloha-editable');
        app.Document('/' + docId).bind(editable, {
            type: 'aloha'
        });
    });

    trackConnectionStatus(app, document.getElementById('connection-status'));
    </script>
</body>
</html>
