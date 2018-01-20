<?php
function http_response($url){
    $resURL = curl_init(); 
    curl_setopt($resURL, CURLOPT_URL, $url); 
    curl_setopt($resURL, CURLOPT_BINARYTRANSFER, 1); 
    curl_setopt($resURL, CURLOPT_HEADERFUNCTION, 'curlHeaderCallback'); 
    curl_setopt($resURL, CURLOPT_FAILONERROR, 1); 
    curl_exec ($resURL); 
    $intReturnCode = curl_getinfo($resURL, CURLINFO_HTTP_CODE); 
    curl_close ($resURL); 
    if ($intReturnCode != 200 && $intReturnCode != 302 && $intReturnCode != 304) { return false; } else return true;
}

//echo "urldir : ".$_GET['urldir']."<br/>";

$urldir=$_GET['urldir'];
$othersites = file('c:/UniServer/www/local/allsites.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//file_put_contents("debug.txt","all get data : ".print_r($othersites, true)."\n", FILE_APPEND);
//print_r ($othersites); echo "<br/>";


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link type="text/css" rel="stylesheet" href="fav.contextmenu.css" />
	<script type="text/javascript" src="fav.contextmenu.js"></script>
	<script type="text/javascript">
		SimpleContextMenu.setup({'preventDefault':true, 'preventForms':false});
		SimpleContextMenu.attach('container1', 'CM1');
		SimpleContextMenu.attach('container2', 'CM2');
		SimpleContextMenu.attach('container3', 'CM3');
		SimpleContextMenu.attach('container4', 'CM4');
		SimpleContextMenu.attach('container5', 'CM5');
		SimpleContextMenu.attach('container6', 'CM6');
		SimpleContextMenu.attach('container7', 'CM7');
	</script>

</head>
<body>

 
          
<?php
$i=0;
foreach ($othersites as $value) {
	$url_othersite=$value.$urldir."elfinder.html";
//echo $value.$urldir.'favicon.ico'."<br/>";
	$host=substr($value,7);
//echo $host;
	if(http_response($value.$urldir.'favicon.ico')) {
		$i++;
		
		echo '<ul id="CM'.$i.'" class="SimpleContextMenu">'."\n";
		echo '<li><a href="'.$value.'/doc/files/common/downloadfile.php?fname=ui_tightvnc_remote.run&host='.$host.'&perma=C:\UniServer\www\common\perma"><img src="/doc/images/tightvncs.png"/></a></li>'."\n";
		echo '<li><a href="'.$value.'/doc/files/ThisPC/install_uniserver/prompt-action.php?cmd=update_from_anywhere.bat&rawdisplay=1" target="_blank"><img src="/doc/images/update-gear.png" title="Update from here"/></a></li>'."\n";
		echo '</ul>'."\n";



		$tag_othersite='<img src="'.$value.$urldir.'favicon.ico" title="'.$value.'" height="16" width="16"/>';
		echo '&nbsp;<span class="container'.$i.'"><a href="'.$url_othersite.'" target="_parent">'.$tag_othersite.'</a></span><br/>';
		
	}
}
?>
          
        

</body>
</html>