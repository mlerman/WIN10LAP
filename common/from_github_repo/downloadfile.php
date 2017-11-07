<?php

$before="";
if (isset($_GET["before"])) {
  $before=$_GET["before"];				// before is addhr or not set
}

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

// quelque soit le OS
// si $before=="addhr"
// et $fname=="ui_edit_this.run" ou "edit_this.rn"
// et $targetfile==".head"
// alors rajouter la ligne <hr/> en debut de .head maintenant

if( 
     ($before=="addhr")
   &&($targetfile==".head")
   &&(  ($fname=="ui_edit_this.run")  ||  ($fname=="edit_this.rn")  )
  )
{
//file_put_contents("c:\\UniServer\\www\\mlscript\\debug.txt", $targetdir."\\".$targetfile." addhr : condition remplie\n", FILE_APPEND);

$filehead = $targetdir."\\".$targetfile;
$current = "\n<hr/>\n";
$current .= file_get_contents($filehead);
file_put_contents($filehead, $current);
}


// detect OS on client
include 'oslist.php';
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
$android="";
$mac="";
if($CurrOS=="Android") {
$android="Android";
$CurrOS="Linux";
}
if($CurrOS=="Mac OS X Puma") {
$mac="mac";
$CurrOS="Linux";
}

 
$targetdirxp=$targetdir;
//$drive="C:";
if($CurrOS=='Windows XP') {
// change "C:\UniServer\www\doc\files"  with "y:\files" in $targetdir
$targetdirxp=str_replace("C:\\UniServer\\www\\doc\\files", "y:\\files", $targetdir);
$drive="y:";
}
///////////////////////////////////////////// Linux ///////////////////////////////////
if(($CurrOS=='Linux')||($CurrOS=='Android')) {

  $targetdir = rtrim($targetdir, '\\');

  // OK the client is Linux but how if the link was for Windows
  // let's try fix this
  // if fname==ui_total_commander.run then krusaderHere.rn
  if ($fname=='ui_total_commander.run') {
    $fname='krusaderHere.rn';
	$perma=$perma."Linux";
  }

    // replace "/doc/files/ThisPCLinux/apt-get_update"
    // with "/home/user/files/ThisPCLinux/apt-get_update"
    $url=$urldir;
    $urldir=str_replace("/doc/","/home/user/",$urldir);  // adjust for linux
  

  // copy source destination
  if($CurrOS=='Linux') {
    $text="#!/bin/bash \n";
  } else {	// this must be android
    $text="#!/system/bin/sh \n";
  }
  $text.="# Linux shell file from ".$_SERVER["HTTP_HOST"]." \n";
  $text.="# current detected os: ".$CurrOS."\r\n";
  $text.="# running ".$fname." \n";

  $text.="# Change directory to ".$targetdir." is added by the server script. \n";

  // find the path on linux
  // in windows C:\UniServer\www\doc\files\ThisPC\opensuze_guest\test_run_command
  // becomes /home/user/files/ThisPC/opensuze_guest/test_run_command

  $pos=strpos("UniServer\\www\\doc\\files\\",$targetdir);
  $linTargetdir="/home/user/".substr($targetdir,$pos+21);
  $linTargetdir=str_replace("\\","/",$linTargetdir);
  //$text.="#echo \"Change directory to ".$linTargetdir." is added by the server script.\" \n";

  if (($fname!="mntFiles.sh")&&($fname!="umntFiles.sh")&&($fname!="testFilesMounted.sh")) {
    //$text .="pwd \n";
    //$text.="cd ".$linTargetdir." \n";

    $text.="LINDIRECTORY=\"".$linTargetdir."\"; \n";
    $text.="TARGETDIR=\"".$targetdir."\"; \n";
    $text.="TARGETFILE=\"".$targetfile."\"; \n";
    $text.="IHOST=\"".$_SERVER["HTTP_HOST"]."\"; \n";
    $text.="HOST=\"".$host."\"; \n";
    $text.="URLDIR=\"".$urldir."\"; \n";
    $text.="URL=\"".$url."\"; \n";
    if(isset($_GET["param1"])) {
        $text.="PARAM1=".$param1."\r\n";
      }
    $text.="if [ ! -d \"\$LINDIRECTORY\" ]; then\n"; 
    $text.="  echo \"dir=\$LINDIRECTORY\"\n";
    $text.="  echo \"The directory does not exist, Mounting...\";\n"; 
    $text.="  sudo mkdir -p /home/user/files\n";
    $text.="  echo \"if error wrong fs type etc try run sudo apt install cifs-utils\";\n"; 
    $text.="  sudo mount -t cifs -o username=mlerman,password=2232,uid=mlerman,gid=users //".$_SERVER["HTTP_HOST"]."/files /home/user/files\n"; 
    //$text.="  read -p \"Press [Enter] key to continue... \" \n";
    $text.="else \n";
    //$text.="  echo \"The directory exists\";\n"; 
    $text.="  cd \$LINDIRECTORY\n";
    $text.="fi\n"; 
    // add the function pause so it can be used in linux shell
    $text.="pause(){\n"; 
    $text.="if [ $# -eq 0 ]; then\n";
    $text.='   read -p "Press any key to continue . . ."'; 
    $text.="\n"; 
    $text.="else\n";
    $text.='   read -p "$*";'; 
    $text.="\n"; 
    $text.="fi\n";
    $text.="}\n"; 

    //$text.="[ -d \"".$linTargetdir."\" ] && cd \"".$linTargetdir."\" || echo 'The directory does not exist' \n"; 
    //$text.="test -d \"".$linTargetdir."\" \n";
    //$text.="read -p \"Press [Enter] key to continue... \" \n";
  }


  $text.="# ======= original file below this line ======= \n";

  if(isset($_GET["perma"])) {

    $textbat=file_get_contents($perma."\\".$fname);
  } else {

    $textbat=file_get_contents($targetdir."\\".$fname);
  }

  //$textbat=file_get_contents($targetdir."\\".$fname);
  $text.=$textbat;

  $text.="\n# ======= add auto delete =======\n";
  $text.='rm -- "$0"'."\n";

  //file_put_contents($fname, $text);
  if($CurrOS=='Linux') {
    header('Content-type: "application/octet-stream"');
  } else {	// this must be android
    header('Content-type: "text/x-shellscript"');		// this tells Android with what to open this file
														// to prevent the error message: "can't open file"
  }														// il y a open with maintenant mais ca ne marche pas

  //
  header('Content-Disposition: attachment; filename="'.$fname.'"');
  header("Content-Transfer-Encoding: binary");
  //readfile($fname);
  print($text);

} else {

///////////////////////////////////////////// Windows 7 ///////////////////////////////////

  // OK the client is windows but how if the link was for linux
  // let's try fix this
  // if fname==krusaderHere.rn then ui_total_commander.run
  if ($fname=='krusaderHere.rn') {
    $fname='ui_total_commander.run';
    $perma=substr($perma,0,-5);					// remove "Linux" from the suffix;
	}


  //$admin=false;
  $rest= strtoupper(substr($fname, -4));
  if($rest==".LNK") {
	header('Content-type: "application/octet-stream"');
	header('Content-Disposition: attachment; filename="'.$fname.'.run"');
	header("Content-Transfer-Encoding: binary");
	readfile($targetdir."\\".$fname);
	exit(0);
  }

  // copy source destination

  if (!$isexclam) $text="setlocal enabledelayedexpansion\r\n";
  else $text="";
  $text.="@echo off\r\n";
  if($admin)
    {
    //$admin=true;
    $text.="rem admin mode\r\n";
    }
  //$text.="echo cd =%cd%\r\n";
  $text.="rem current detected os: ".$CurrOS."\r\n";
  $text.="rem Interactive batch file from ".$_SERVER["HTTP_HOST"]."\r\n";
  $text.="rem running ".$fname."\r\n";
  $text.="rem perma is ".$perma."\r\n";
  $text.="rem Change directory to ".$targetdirxp." is added by the server script.\r\n";
  $text.="set HOST=".$host."\r\n";
  $text.="set URLDIR=".$urldir."\r\n";
  $text.="set TARGETDIR=".$targetdirxp."\r\n";
  $text.="set TARGETFILE=".$targetfile."\r\n";

  if(isset($_GET["param1"])) {
    $text.="set PARAM1=".$param1."\r\n";
  }

  if(isset($_GET["perma"])) {
    $textbat=file_get_contents($perma."\\".$fname);
  } else {
    $textbat=file_get_contents($targetdir."\\".$fname);
  }


  // create a file in the download directory
  if($admin) {
    $text.="echo @echo off>.admin.bat\r\n";
    $text.="echo rem admin mode>>.admin.bat\r\n";
  
    $text.="echo set TARGETDIR=".$targetdirxp.">>.admin.bat\r\n";
    $text.="echo set TARGETFILE=".$targetfile.">>.admin.bat\r\n";
    $text.="echo ".$drive.">>.admin.bat\r\n"; 		// change drive because cd does not change drive ex for y:
    $text.="echo cd ".$targetdirxp.">>.admin.bat\r\n";
  
   //$text.="echo @echo on>>.admin.bat\r\n";
   $text.="echo rem ======= original file below this line =======>>.admin.bat\r\n";
 
   foreach(preg_split("/((\r?\n)|(\r\n?))/", $textbat) as $line){
     // do stuff with $line
	 if (!empty($line)) {
      $text.="echo ".$line.">>.admin.bat\r\n";
	  }
    } 
  }

  if ((!$admin)&&($targetdirxp!="")) {
    $text.=$drive."\r\n"; 		// change drive because cd does not change drive ex for y:
    $text.="if not exist ".$targetdirxp." mkdir ".$targetdirxp."\r\n";
    $text.="cd ".$targetdirxp."\r\n";
    $text.="for %%a in (.) do set CURRENTFOLDER=%%~na\r\n";
  }

  // create a file in the target directory
  //if($admin) {
  //  $text.="echo rem >.admin.bat\r\n";
  //}

  //$text.="rem perma=".$perma."\r\n";

  //$text.="call c:\\UniServer\\www\\doc\\files\\Engineering\\ENVIRONMENT\\WINDOWS_BATCH\\AutoRun\\env.cmd\r\n";
  // this should be done with the registry key  "HKLM\software\Microsoft\command processor" and value - Autorun.
  $text.="rem ======= original file below this line ======= & @echo on\r\n";
  $text.="cls\r\n";

  if (!$admin) {
    $text.=$textbat;
    $text.="\r\n"."rem ======= add auto delete =======\r\n";
    //$text.="echo 1 %0 %USERPROFILE%\Downloads\r\n";
	
	//$text.="goto EOF\r\n";		// this to disable auto deletion
	$text.="set curfile=%0\r\n";
    $text.='set curfile2=%curfile:"=%'."\r\n";
    $text.='if "%curfile:~-4%" == ".bat" ( echo is dot bat'."\r\n";
    $text.="set curfile3=%curfile:~0,-4%\r\n";
    $text.="if exist !curfile3! del !curfile3! /Q\r\n";
    $text.=")\r\n";

	
	
    //$text.="if exist %0 del %0 /Q\r\n";
    //$text.="pause\r\n";

    $text.="set curdir=%cd%\r\n";
    $text.='if "%curdir:~-10%" == "\Downloads" ( echo deleting "%~f0"'."\r\n";
    $text.= "\r\n".'start /b "" cmd /c del "%~f0"&exit /b'."\r\n";
    //$text.="echo 4\r\n";
    //$text.="pause\r\n";
    $text.="  )";
  }
  if (!$isexclam) $text.="\r\nendlocal\r\n";

  //file_put_contents($fname, $text);

  header('Content-type: "application/octet-stream"');
  header('Content-Disposition: attachment; filename="'.$fname.'"');
  header("Content-Transfer-Encoding: binary");
  //readfile($fname);

  print($text);
  if ($admin) {
    print('c:\UniServer\www\doc\files\ThisPC\nircmd\nircmdc.exe elevate cmd /K " call %cd%\.admin.bat & exit"');
  }
  
}

?>