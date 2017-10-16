<?php
echo "running addlink.php<br/>";
$path=$_GET['path'];
echo "path=".$path."<br/>";
$parent=$_GET['parent'];
echo "parent=".$parent."<br/>\n";

$pos=strrpos($path, "\\");
$targetfile=substr($path,$pos+1);
echo "targetfile=".$targetfile."<br/>\n";

$targetdir=substr($path,0,$pos+1);
echo "targetdir=".$targetdir."<br/>\n";

//echo realpath("..")."<br/>\n";;
$sound=realpath("..")."/doc/files".$parent.".sound";
echo ".sound path=".$sound."<br/>\n";

$fname="ui_edit_this.run";
echo "fname=".$fname."<br/>\n";

$drive=$path[0];


file_put_contents($sound, $path);

// si on fait just back le referer n'apparait pas.
// je veux savoir d'ou on vient pour forcer un refresh
// this refresh but need to scroll back down
//header("Location: /doc/files".$parent."open-command-prompt-here.html");
?>

<script>
//this does not refresh but come back to the same vertical scroll position
sessionStorage.setItem("forcerefresh", "yes");
window.history.back();
</script>