<?php
$link =  "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//   //mlerman-lap/doc/files/Engineering/ENVIRONMENT/NODE/fill_sd_ajax/open-command-prompt-here.html
$escaped_link = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');
$pos=strrpos($escaped_link,"/doc/files");
//   //mlerman-lap/doc/files/Engineering/ENVIRONMENT/NODE/fill_sd_ajax/open-command-prompt-here.html
//                ^ = 13                                              ^ = -30


//   //mlerman-lap/common/othersites.php?urldir=/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/open-command-prompt-here/
                                          //    ^ 43                                                                   
$dir_loc=substr($escaped_link, $pos, -1);
file_put_contents("debug.txt",$dir_loc."\n", FILE_APPEND);

$clienthost = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$clienthost = str_replace(".micron.com", "", $clienthost);
$clienthost = str_replace(".xlnx.xilinx.com", "", $clienthost);
$clienthost = strtolower($clienthost);

?>

&nbsp;<a href="http://<?php echo $clienthost.$dir_loc; ?>/open-command-prompt-here.html" id="homelink" target="_parent"><img src="/doc/images/home.png" title="Go to <?php echo $clienthost; ?>" id="hometitle"/></a>

<?php

//Go to your php.ini file and remove the ; mark from the beginning of the following line:
//;extension=php_curl.dll

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
$othersites = file('./allsites.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

//print_r ($othersites);

foreach ($othersites as $value) {
	$url_othersite=$value.$urldir."open-command-prompt-here.html";
	if(http_response($value.$urldir.'favicon.ico')) {
		$tag_othersite='<img src="'.$value.$urldir.'favicon.ico" title="go to '.$value.'" height="16" width="16"/>';
		echo '&nbsp;<a href="'.$url_othersite.'" target="_parent">'.$tag_othersite.'</a>';
	} else {
		if(http_response($value.'/doc/favicon.ico')) {
			$tag_othersite='<img src="'.$value.'/doc/favicon.ico" title="create project container in '.$value.'" height="16" width="16"/>';
			echo '&nbsp;<a href="/common/create_project_container.php?host='.$value.'&urldir='.$urldir.'" target="_parent">'.$tag_othersite.'</a>';
		}
	}
}

?>