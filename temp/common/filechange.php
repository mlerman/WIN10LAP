<?php
$target=$_GET['target'];
$ret=1;
if (file_exists($target)) $ret=filemtime($target);
echo $ret;
//file_put_contents("debug.txt",$target);
//file_put_contents("debug.txt",$ret . " - " . $target);

?>