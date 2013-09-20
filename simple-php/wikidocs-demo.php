<?php

// Your Wikidocs app id and app secret
// 1) Go to https://wikidocs.com/space/create and create
//    your own space eg. myspace.wikidocs.com
// 2) Goto to https://myspace.wikidocs.com/admin/space
//    generate an API key and insert below.
// 3) You can see the docs you create under
//    https://myspace.wikidocs.com/me/docs/api
define("APP_ID", "demo");
define("APP_SECRET", "demo");

// get the doc id from URL or use simple-demo as id
$doc = $_GET['doc'];
if (!$doc) {
    $doc = 'simple-demo';
}
 
// The payload of the access token.
$accessData = array(
    "iss" => "https://wikidocs.com/v1/apps/" . APP_ID,
    "iat" => time(),
    "exp" => time() + 60*60,
    // just to distinguish clients in the demo. Should be the users id ;-)
    "sub" => $_SERVER['REMOTE_ADDR'], 
    "access" => array(
        "/$doc-title"          => "full",
        "/$doc-teaser"         => "full",
        "/$doc-content"        => "full"
    ),
);

// JSON web token implementation
// See https://wikidocs.com/home/docs/getting-started.html
// section "Access Token" for a list or ready to use libraries
// for different platforms
function createAccessToken($data, $secret) {
     $header = encodeBase64UrlSafe(json_encode(array("typ" => "JWT", "alg" => "HS256")));
     $payload = encodeBase64UrlSafe(json_encode($data));
     $rawSignature = hash_hmac("sha256", "$header.$payload", $secret, $raw = true);
     $signature = encodeBase64UrlSafe($rawSignature);
     return "$header.$payload.$signature";
}
function encodeBase64UrlSafe($data) {
     return strtr(base64_encode($data), "+/", "-_");
}
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
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
