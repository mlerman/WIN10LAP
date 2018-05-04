<?php
echo "running addclip.php copied from addedit.php<br/>";
$path=$_GET['path'];
echo "path=".$path."<br/>";
$parent=$_GET['parent'];
echo "parent=".$parent."<br/>\n";

$parent_dir = "/doc/files".$_GET['parent'];

$cliptab="c:/UniServer/www/doc/files".$parent.".cliptab";
echo ".cliptab path=".$cliptab."<br/>\n";

?>

<script>
//this does not refresh but come back to the same vertical scroll position
//sessionStorage.setItem("forcerefresh", "yes");
//window.history.back();
</script>
