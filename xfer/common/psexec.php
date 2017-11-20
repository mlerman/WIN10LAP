<?php

$fname="";
if (isset($_GET["fname"])) {
  $fname=$_GET["fname"];
}

$admin=false;
if (isset($_GET["admin"])) {
  if($_GET['admin']==1)
	$admin=true;
}

$host="";
if (isset($_GET["host"])) {
  $host=$_GET["host"];
  if($host="localhost") {
  // change to the real host name that is stored in c:\UniServer\www\local\hostname.txt
  $host=file_get_contents("c:\UniServer\www\local\hostname.txt");  
  }
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

echo "<pre>\n";

// run as system in system32 directory
//echo getcwd() . "<br>";
//chdir($targetdir);  // ne marche pas
//echo getcwd() . "<br>";
echo "targetdir is ".$targetdir."<br/>\n";
$strcmd="c:\\UniServer\\www\\doc\\files\\ThisPC\\install_pstools\\PsExec64.exe -i 1 -s -d cmd /K cd ".$targetdir." && ".$targetdir."\\".$targetfile."  2>&1 && exit";
echo "executing command : ".$strcmd."\n";

// ce code marche mais le targetdir en param de proc_open ne fonctionne pas
/**/
$descriptorspec = array (
    0 => array ("pipe","r"),
    1 => array ("pipe","w"),
    2 => array ("pipe","w")
);
$handle = proc_open ($strcmd, $descriptorspec, $pipes, $targetdir, NULL, array("bypass_shell" => 1));
if (! is_resource($handle))
    die ("Process handle creation failed!\n");
$output = stream_get_contents ($pipes[1]);
$error = stream_get_contents ($pipes[2]);
fclose ($pipes[0]);
fclose ($pipes[1]);
fclose ($pipes[2]);
$ret = proc_close ($handle);
/**/

//echo shell_exec($strcmd);
echo "</pre>\n";


?>