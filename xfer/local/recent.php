<?php


header("Content-type: text/plain; charset=utf-8");
$page = file_get_contents('recent.txt');
echo $page;

?>