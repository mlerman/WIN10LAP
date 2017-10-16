<?php
echo "running addlink.php<br/>";
$url=$_GET['url'];
echo "url=".$url."<br/>";
$parent=$_GET['parent'];
echo "parent=".$parent."<br/>\n";
$linkfile=realpath("..")."/doc/files".$parent.".links";
echo "linkfile=".$linkfile."<br/>\n";

// check if it does not start with http:// or https://
if ((substr($url, 0, 7)!="http://") && (substr($url, 0, 8)!="https://")) {
  $url="http://".$url;
}

$str="<a href='".$url."' onclick=\"javascript:void window.open('".$url."','URL links','width=1200,height=600,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=100,top=50'); return false;\"><img src='/doc/images/subwin.png'></a>&nbsp;<a href='".$url."'>".$url."</a><br/>\n";
//echo "str=".$str."<br/>\n";
file_put_contents($linkfile, $str, FILE_APPEND);

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