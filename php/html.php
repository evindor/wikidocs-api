<?php require_once('access-token.php'); ?>
<html>
<head>
    <title>Wikidocs &amp; HTML</title>
    <link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />
    <script src="//cdn.wikidocs.com/lib/sockjs.min.js"></script>
	<script src="//cdn.wikidocs.com/lib/wikidocs.min.js"></script>
	<script src="../lib/connection-status.js"></script>
</head>
<body>

    <h1>Wikidocs demo on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?> <span id="connection-status"></span></h1>

    <p id="doc-id">Doc: <a href="?doc=<?php echo $docId; ?>"><?php echo $docId; ?></a></p>
    <h2>Sychronised input=text</h2>
    <input type="text" id="my-title">
    <h2>Sychronised textarea</h2>
    <textarea id="my-teaser"></textarea>
    <h2>Sychronised html editable</h2>
    <div contenteditable="true" id="editable"></div>
    <h2>Non editable sychronised plain html element</h2>
    <button id="insert">Insert elements</button>
    <button id="reset">Reset</button>
    <div id="html">
        <p>Everything within this div container will be synchronised.</p>
        <div id="container"><p>Click the insert or reset button to change the content.</p></div>
    </div>
    <script>

    function create(htmlStr) {
        var frag = document.createDocumentFragment(),
            temp = document.createElement('div');
        temp.innerHTML = htmlStr;
        while (temp.firstChild) {
            frag.appendChild(temp.firstChild);
        }
        return frag;
    }
    
    var insert = document.getElementById('insert');
    var reset = document.getElementById('reset');

    insert.addEventListener('click', function() {
        var container = document.getElementById('container');
        var fragment = create('<h3>Hello!</h3><p>This was inserted by a script.</p>');
        container.insertBefore(fragment, container.childNodes[0]);
    }, false);

    reset.addEventListener('click', function() {
        var container = document.getElementById('container');
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
        var fragment = create('<p>Click the insert or reset button to change the content.</p>');
        container.insertBefore(fragment, container.childNodes[0]);
    }, false);

    // Use the access token that was created in common.php
    var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

    // Use the doc ID the access token was created with.
    var docId = '<?php echo $docId; ?>';
     
    var app = WD.App(accessToken);
     
    // Synchronise the textarea
    var textbox = document.getElementById('my-title');
    app.Document('/' + docId + '-text').bind(textbox);

    // You can also synchronize textareas
    var textarea = document.getElementById('my-teaser');
    app.Document('/' + docId + '-textarea').bind(textarea);

    // Or any contenteditable element
    var editable = document.getElementById('editable');
    app.Document('/' + docId).bind(editable);

    // And any plain html element
    var html = document.getElementById('html');
    app.Document('/' + docId + '-html').bind(html);

    trackConnectionStatus(app, document.getElementById('connection-status'));
    </script>
</body>
</html>
