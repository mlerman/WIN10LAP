<?php
echo "closePageRecentEdit.php"."<br/>\n";
echo "drive=".$_GET['drive']."<br/>\n";
echo "parent=".$_GET['parent']."<br/>\n";
$parent=$_GET['parent'];
echo "linkwith=".$_GET['linkwith']."<br/>\n";
echo "composing fname targetdir and targetfile<br/>\n";
$fullfname=$_GET['linkwith'];
$pos=strrpos($fullfname, "/");
$targetfile=substr($fullfname,$pos+1);
echo "targetfile=".$targetfile."<br/>\n";
$targetdir=substr($fullfname,0,$pos+1);
echo "targetdir=".$targetdir."<br/>\n";
$pos=strpos($targetdir, "/doc");
$targetdirdoc=substr($targetdir,$pos);


//echo realpath("..")."<br/>\n";;
//$recentedit=realpath("..")."/doc/files".$parent.".recentedit";
$recentedit="/doc/files".$parent.".recentedit";
echo ".recentedit path=".$recentedit."<br/>\n";

$fname="ui_edit_this.run";
echo "fname=".$fname."<br/>\n";
$link="http://".$_SERVER["HTTP_HOST"]."/doc/files/common/downloadfile.php?fname=".$fname."&targetdir=".$targetdir."&targetfile=".$targetfile."&perma=C:\UniServer\www\common\perma&drive=".$_GET['drive'].":";
$str= "<a href='".$link."'>".$fullfname."</a>&nbsp;<a href=\"\" onclick='openOnce(\"/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/ICEcoder/\", \"editor\", \"".$targetdirdoc.$targetfile."\"); return false;'><img src=\"/doc/images/text.png\"/></a>&nbsp;<a href='/viewfile/view.php?fname=".$targetfile."&targetdir=".$targetdir."'><img src='/doc/images/view.jpg'/></a><br/>\n";
//echo "<a href='".$link."'>".$fullfname."</a>";

file_put_contents("c:/UniServer/www".$recentedit, $str, FILE_APPEND);


header("Location: ".$link);


?>