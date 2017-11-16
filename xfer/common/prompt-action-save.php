<?php
$dir=substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/"));
$send_cmd=$_GET['cmd'];
// append the command at the end of the file specific-here.inc
file_put_contents("c:/UniServer/www".$dir.'/specific-here.inc', $send_cmd."\n", FILE_APPEND | LOCK_EX);



header("Location: open-command-prompt-here.html");
die();

?>

