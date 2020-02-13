<?php
$document_root = $_SERVER['DOCUMENT_ROOT'];
for ($i=1; $i <= strlen($document_root) ; $i++) {
  $document_root = str_replace("/", "\\", $document_root);
}
$root = $document_root;
$document_root = str_replace($document_root, '', getcwd() . DIRECTORY_SEPARATOR);
define('STATE', $document_root);
$document_root = explode("\\", $document_root);
define('FOLDER_ROOT', DIRECTORY_SEPARATOR . $document_root[1] . DIRECTORY_SEPARATOR);
define('ROOT', $root . FOLDER_ROOT);
?>
