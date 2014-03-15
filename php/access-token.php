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

// Allow the document id to be specified in the URL.
$docId = $_GET['doc'];
if (!$docId) {
    $docId = 'simple-demo';
}

// Just to distinguish users in the demo. Should be the users id ;-)
$randomId = rand();

// JSON Web Token attributes
$accessData = array(
    "iss" => "https://wikidocs.com/v1/apps/" . APP_ID,
    "iat" => time(),
    "exp" => time() + 60*60,
    "sub" => 'user-' + $randomId,
    // propagate custom user attributes available in Wikidocs session object
    "session" => array(
       "randomId" => $randomId
    ),
    // This access token allows users to collaborate on 4 documents
    // and send messages to global messaging channel
    // access priviledges per channel [read|write|full]
    "access" => array(
        "/$docId-text"           => "full", // input=text
        "/$docId-textarea"       => "full", // textarea
        "/$docId-html"           => "full", // plain html element
        "/$docId"                => "full", // wysiwyg editors and content editable
        "/messages"              => "full"  // messaging channel
    ),
);

// JSON web token implementation
// See section "Access Token" at
// https://wikidocs.com/home/docs/getting-started.html
// for a list of ready to use libraries.
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
