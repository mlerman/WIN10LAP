<?php
header('Content-type: application/x-javascript');
//echo $_GET['callback']."([".json_encode($_GET)."])";
echo $_GET['callback']."([".json_encode(file_get_contents("c:\UniServer\www\local\hostname.txt"))."])";
?>