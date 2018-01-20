<?php

$fname="";
if (isset($_GET["fname"])) {
  $fname=$_GET["fname"];
}

$host="";
if (isset($_GET["host"])) {
  $host=$_GET["host"];
}

$urldir="";
if (isset($_GET["urldir"])) {
  $urldir=$_GET["urldir"];
}

$targetdir="";
if (isset($_GET["targetdir"])) {
  $targetdir=$_GET["targetdir"];
}

$targetfile="";
if (isset($_GET["targetfile"])) {
  $targetfile=$_GET["targetfile"];
} 

$perma="";
if (isset($_GET["perma"])) {
  $perma=$_GET["perma"];
}

$param1="";
if (isset($_GET["param1"])) {
  $param1=$_GET["param1"];
}

$drive="C:";
if (isset($_GET["drive"])) {
  $drive=$_GET["drive"];
}

// detect OS on client
include 'oslist.php';
/* 
$OSList = array
(
// Match user agent string with operating systems
'Windows 3.11' => 'Win16',
'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
'Windows 98' => '(Windows 98)|(Win98)',
'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
'Windows Server 2003' => '(Windows NT 5.2)',
'Windows Vista' => '(Windows NT 6.0)',
'Windows 7' => '(Windows NT 7.0)|(Windows NT 6.1)',
'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
'Windows ME' => 'Windows ME',
'Open BSD' => 'OpenBSD',
'Sun OS' => 'SunOS',
'Linux' => '(Linux)|(X11)',
'Mac OS' => '(Mac_PowerPC)|(Macintosh)',
'QNX' => 'QNX',
'BeOS' => 'BeOS',
'OS/2' => 'OS/2',
'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves/Teoma)|(ia_archiver)'
);
 */
// Loop through the array of user agents and matching operating systems
foreach($OSList as $CurrOS=>$Match)
{
// Find a match
if (preg_match('/'.$Match.'/', $_SERVER['HTTP_USER_AGENT']))
{
// We found the correct match
break;
}
}
// You are using ...
//echo "You are using ".$CurrOS."<br/>";

$targetdirxp=$targetdir;
//$drive="C:";
if($CurrOS=='Windows XP') {

// change "C:\UniServer\www\doc\files"  with "y:\files" in $targetdir

$targetdirxp=str_replace("C:\\UniServer\\www\\doc\\files", "y:\\files", $targetdir);
$drive="y:";

}





//exit();
if ($fname!="") {

	// create here the zip file
	$zipfname=$fname.".zip";
	exec('cmd.exe /c C:\\UniServer\\www\\doc\\files\\common\\zipfolder.bat '." ".$zipfname." ".$targetdirxp);

	header('Content-type: "application/octet-stream"');
	header('Content-Disposition: attachment; filename="'.$zipfname.'"');
	header("Content-Transfer-Encoding: binary");
	readfile($zipfname);
	unlink($zipfname);
} else {
// TODO check why this error ???
	exec('cmd.exe /c C:\\UniServer\\www\\doc\\files\\common\\zipfolderErr.bat '." ".$zipfname." ".$targetdirxp);
}

?>