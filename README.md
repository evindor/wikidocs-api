Wikidocs examples
=================

Clone the repository and have a look at the source of the examples.
They do have well documented source, which guides you through 
the code.

Supported synchronisation features
==================================

## Input field

* type=text
* no telepointer
* no undo/redo

## Textarea

* no telepointer
* no undo/redo

## Contenteditable=true

#### Full support

* telepointer

#### Limited support

* basic cmdExecute commands (no styles)
* undo/redo (but not as intended)

## Aloha Editor

#### Full support

* telepointer
* copy/paste
* bold, italic, underlined, strikethrough, subscript, superscript, remove-format
* insert/remove/indent/outdent numbered/bulleted list
* block quote
* images
* tables
* set language
* links/unlinking
* block formats (h1,h2,...) 
* show blocks
* aloha blocks

#### Limited support

* undo/redo (works but not as intended)

## CKEditor

#### full support

* telepointer
* new page (just clears the editable)
* copy/paste
* find/replace/select-all
* font name/size, foreground/background color
* bold, italic, underlined, strikethrough, subscript, superscript, remove-format
* insert/remove/indent/outdent numbered/bulleted list
* block quote
* create div container
* align left/center/right/justify
* text-direction left/right, set language
* URL (http, https, news, ftp)/email links/unlinking
* horizontal rule
* block formats (h1,h2,...) 
* show blocks
* 'insert paragraph' feature
* images except the target attribute (not whitelisted)
* links except links to anchors and the following attributes: accesskey,
  charset, rel (relationship), type (content-type), tabindex, style,
  target attributes (not whitelisted)
* tables

#### limited support

* form elements; input/select/textarea etc. all are whitelisted, but the state or their text content is not an attribute but a property,  and properties are not synced; only if you bind a text input or a textarea are they synced (should support that for checkboxes etc. as well).
* undo (works, but not as intended)

#### not supported

* anchors and links to anchors
* templates (should re-init the editable)
* spellchecker
* form (security implications)
* flash
* page break (contentEditable attribute not whitelisted)
* iframe (not whitelisted)

## wysiHtml5

* todo: feature description and testing
