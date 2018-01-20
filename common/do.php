<?php
$isexclam=false;
$targetdir="";
if (isset($_GET["targetdir"])) {
  $targetdir=$_GET["targetdir"];
  $pos = strpos($targetdir, "!");
  if ($pos) {
    $isexclam=true;
  } 
  //$targetdir=str_replace("!", "!", $targetdir);		//escape the exclamation mark
}

$targetfile="";
if (isset($_GET["targetfile"])) {
  $targetfile=$_GET["targetfile"];
} 
if (!file_exists($targetdir."\\".$targetfile)) {
	$bool=copy("c:\\UniServer\\www\\doc\\files\\common\\open_command_files\\empty.txt", $targetdir."\\".$targetfile);
}

?>

<script>
//this does not refresh but come back to the same vertical scroll position
sessionStorage.setItem("forcerefresh", "yes");
window.history.back();
</script>