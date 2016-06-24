<?php
$dt = time();
$page = $_SERVER['REQUEST_URI'];
$ref = $_SERVER['PHP_REFERER'];
$path = "$dt|$page|$ref\n";
file_put_contents(PATH_LOG, $path, FILE_APPEND);
?>
