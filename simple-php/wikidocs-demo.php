<?php require_once('common.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
    <title>Wikidocs demo</title>

    <!-- Inlice style, just to make demo it look nice ;-). 
         You know how to do this better. -->
    <style>
@import url(http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700);
body {
    margin: 0 30px;
}
h1 {
    margin: 20px auto;
    display: block;
    text-align: center;
}
body, input, textarea {
    font-family: 'Open Sans', sans-serif;
    font-weight: 100;
    font-size: 17px;
    margin: 10px auto 10px;
}
.app {
    width: 600px;
    margin: 0 auto;
}
.app > div > * {
    display: block;
    width: 600px;
}
.input {
    float:left;
}
#my-title, #my-teaser, #my-content {
    border: 1px solid #aaa;
    outline: none;
}
#my-title:focus, #my-teaser:focus, #my-content:focus {
    background-color: #EDD780;
}
    </style>

    <!-- Here we go Wikidocs -->
    <link rel="stylesheet" type="text/css" href="//cdn.wikidocs.com/lib/wikidocs.min.css" />
    <script src="//cdn.wikidocs.com/lib/sockjs.min.js"></script>
    <script src="//cdn.wikidocs.com/lib/wikidocs.min.js"></script>

</head>
<body>

<h1>Wikidocs demo on <?=$_SERVER['SERVER_ADDR']?>:<?=$_SERVER['SERVER_PORT']?></h1>

<div class="app">
    <p id="doc-id">Doc: <a href="?doc=<?=$doc?>"><?=$doc?></a></p>
    <div class="input">
        <input type="text" id="my-title">
        <textarea id="my-teaser"></textarea>
        <div contenteditable="true" id="my-content"></div>
    </div>
</div>

<script>
// We make the server side generated access token available 
// to the client via a Javascript global variable.
var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

// provide doc id in Javascript to make use of it on the client site
var doc = '<?=$doc?>';
 
// We create an app instance with permissions from
// the server side generated access token.
var app = WD.App(accessToken);
 
// You can synchronize the texbox now.
// As we have 3 differnt content areas in this example
// we prefix all of them with the doc id.
var textbox = document.getElementById('my-title');
app.Document('/'+doc+'-title').bind(textbox);

// You can also synchronize textareas
var textarea = document.getElementById('my-teaser');
app.Document('/'+doc+'-teaser').bind(textarea);

// Plain editables work too if you don't need the advanced features
// that WYSIWYG editor like Aloha Editor or wysiHTML5 provide.
var editable = document.getElementById('my-content');
app.Document('/'+doc+'-content').bind(editable);

// Aloha Editor binding is pretty simple
// Aloha.ready(function() {
//     $('#aloha-editable').aloha()
//     var alohaDoc = Aloha.getEditableById('aloha-editable');
//     app.Document('/'+doc+'-aloha-doc').bind(alohaDoc);
// }

// wysiHTML5 binding could be (take care wysiHTML5 is loaded and initialised)
// var iframe = document.querySelector('iframe.wysihtml5-sandbox');
// var wysihtml5Doc = iframe && iframe.contentDocument && iframe.contentDocument.body;
// app.Document('/'+doc+'-wysihtml5-doc').bind(wysihtml5Doc);

</script>
</body>
</html>
