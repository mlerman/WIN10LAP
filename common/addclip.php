<?php
echo "running addclip.php copied from addedit.php<br/>";
$path=$_GET['path'];
echo "path=".$path."<br/>";
$parent=$_GET['parent'];
echo "parent=".$parent."<br/>\n";

$parent_dir = "/doc/files".$_GET['parent'];

$pos=strrpos($path, "\\");
$targetfile=substr($path,$pos+1);
echo "targetfile=".$targetfile."<br/>\n";

$targetdir=substr($path,0,$pos+1);
echo "targetdir=".$targetdir."<br/>\n";

$pos=strpos($targetdir, "\\doc");
$targetdirdoc=substr($targetdir,$pos);
$targetdirdoc = str_replace('\\', '/', $targetdirdoc);


//echo realpath("..")."<br/>\n";;
//$recentedit=realpath("..")."/doc/files".$parent.".recentedit";
$recentedit="c:/UniServer/www/doc/files".$parent.".recentedit";
echo ".recentedit path=".$recentedit."<br/>\n";

$fname="ui_edit_this.run";
echo "fname=".$fname."<br/>\n";

$drive=$path[0];

//$link="http://".$_SERVER["HTTP_HOST"]."/doc/files/common/downloadfile.php?fname=".$fname."&targetdir=".$targetdir."&targetfile=".$targetfile."&perma=C:\UniServer\www\doc\files\common\perma&drive=".$drive.":";
$link="/doc/files/common/downloadfile.php?fname=".$fname."&targetdir=".$targetdir."&targetfile=".$targetfile.'&perma=C:\UniServer\www\doc\files\common\perma&drive='.$drive.":";

$str= "<a href='".$link."'>".$path."</a>&nbsp;<a href=\"\" onclick='openOnce(\"/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder/\", \"editor\", \"".$targetdirdoc.$targetfile."\"); return false;'><img src=\"/doc/images/text.png\"/></a>&nbsp;<a href='/viewfile/view.php?fname=".$targetfile."&targetdir=".$targetdir."'><img src='/doc/images/view.jpg'/></a>&nbsp;<a href='/doc/files/common/downloadfile.php?fname=ui_total_commander.run&urldir=".$parent_dir."&targetdir=".$targetdir.$targetfile."&perma=C:\UniServer\www\doc\'.'files\common\perma' ><img src='/doc/images/totalcommander16.png' /></a><br/>\n";
echo "str=".$str."<br/>\n";


//file_put_contents($recentedit, $str, FILE_APPEND);

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
