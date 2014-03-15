<?php require_once('access-token.php'); ?>
<!DOCTYPE html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta charset="utf-8">
  <title>Wikidocs & wysihtml5 Textarea</title>
  <link rel="stylesheet" type="text/css" href="../vendor/wysihtml5/wysihtml5.css" />
</head>
<body>
  <h1>Wikidocs & wysihtml5 demo on <?php echo $_SERVER['SERVER_ADDR']; ?>:<?php echo $_SERVER['SERVER_PORT']; ?> <span id="connection-status"></span></h1>

  <form>
    <div id="toolbar" style="display: none;">
      <a data-wysihtml5-command="bold" title="CTRL+B">bold</a> |
      <a data-wysihtml5-command="italic" title="CTRL+I">italic</a> |
      <a data-wysihtml5-command="createLink">insert link</a> |
      <a data-wysihtml5-command="insertImage">insert image</a> |
      <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">h1</a> |
      <a data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">h2</a> |
      <a data-wysihtml5-command="insertUnorderedList">insertUnorderedList</a> |
      <a data-wysihtml5-command="insertOrderedList">insertOrderedList</a> |
      <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="red">red</a> |
      <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="green">green</a> |
      <a data-wysihtml5-command="foreColor" data-wysihtml5-command-value="blue">blue</a> |
      <a data-wysihtml5-command="undo">undo</a> |
      <a data-wysihtml5-command="redo">redo</a> |
      <a data-wysihtml5-command="insertSpeech">speech</a>
      <a data-wysihtml5-action="change_view">switch to html view</a>
      
      <div data-wysihtml5-dialog="createLink" style="display: none;">
        <label>
          Link:
          <input data-wysihtml5-dialog-field="href" value="http://">
        </label>
        <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
      </div>
      
      <div data-wysihtml5-dialog="insertImage" style="display: none;">
        <label>
          Image:
          <input data-wysihtml5-dialog-field="src" value="http://">
        </label>
        <label>
          Align:
          <select data-wysihtml5-dialog-field="className">
            <option value="">default</option>
            <option value="wysiwyg-float-left">left</option>
            <option value="wysiwyg-float-right">right</option>
          </select>
        </label>
        <a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
      </div>
      
    </div>
    <p id="doc-id">Doc: <a href="?doc=<?php echo $docId; ?>"><?php echo $docId; ?></a></p>
    <textarea id="textarea" placeholder="Enter text ..."></textarea>
    <br><input type="reset" value="Reset form!">
  </form>

  <small>powered by <a href="https://github.com/xing/wysihtml5" target="_blank">wysihtml5</a> and <a href="https://wikidocs.com">Wikidocs</a>.</small>

  <script src="../vendor/wysihtml5/wysihtml5-rules-advanced.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js"></script>

  <script src="//cdn.wikidocs.com/lib/sockjs.min.js"></script>
  <script src="//cdn.wikidocs.com/lib/wikidocs.min.js"></script>
  <script src="../lib/connection-status.js"></script>
  <script>
  // Use the access token that was created in common.php
  var accessToken = '<?php echo createAccessToken($accessData, APP_SECRET); ?>';

  // Use the doc ID the access token was created with.
  var docId = '<?php echo $docId; ?>';
   
  var app = WD.App(accessToken);
  var doc = app.Document('/' + docId);

  var editor = new wysihtml5.Editor("textarea", {
    toolbar:        "toolbar",
    parserRules:    wysihtml5ParserRules,
    stylesheets:    "//wikidocs-sandbox.com/lib/wikidocs.min.css"    
  });

  editor.on("load", function(){
    doc.bind(editor.composer.element, {
        type: 'wysihtml5'
    });
  });

  trackConnectionStatus(app, document.getElementById('connection-status'));
  </script>
</body>
</html>