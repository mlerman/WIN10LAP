<?php
echo "closePageNext.php"."<br/>\n";
echo "parent=".$_GET['parent']."<br/>\n";
echo "link with=".$_GET['linkwith']."<br/>\n";
echo "composing links:<br/>\n";

$parent_dir = "/UniServer/www/doc/files".$_GET['parent'];
$parent_dir_url = "/doc/files".$_GET['parent'];
echo $parent_dir."<br/>\n";
$parent_name=substr($_GET['parent'],0,-1);
$pos=strrpos($parent_name,"/");
$parent_name=substr($parent_name,$pos+1);
//echo "parent_name=".$parent_name."<br/>\n";


// Match user agent string with operating systems
include '../oslist.php';
// Loop through the array of user agents and matching operating systems
foreach($OSList as $CurrOS=>$Match)
	{
		// Find a match
		if (preg_match("/".$Match."/i", $_SERVER['HTTP_USER_AGENT']))
			{
			// We found the correct match
			break;
			}
	}
// You are using
//echo "You are using ".$CurrOS."<br/>";

$linuxstr="";
$commanderstr="ui_total_commander.run";
$commanderpng="totalcommander16.png";
if($CurrOS=='Linux') {
	$linuxstr="Linux";
	$commanderstr="krusaderHere.rn";
	$commanderpng="krusader16.png";
	}





// create the line for the project we are linking with

$icon_with="";
$with_name=substr($_GET['linkwith'],0,-30);
$link_next_dir="/UniServer/www/doc/files".$with_name;
$link_next_dir_url="/doc/files".$with_name;
echo "link_next_dir : ".$link_next_dir."<br/>\n";
$link_next_run = $with_name."/ui_run.run";
echo "link_with_run=".$link_next_run."<br/>\n";
if(file_exists("c:/UniServer/www/doc/files".$link_next_run)){
	echo "exists !<br/>\n"; 
	$icon_with="<a href='/doc/files/common/download".$linuxstr."file.php?fname=ui_run.run&targetdir=".$link_next_dir."&admin=0'><img src='/doc/images/Play-1-Hot-icon.png'/></a>";
}

$pos=strrpos($with_name,"/");
$with_name=substr($with_name,$pos+1);
echo "with_name=".$with_name."<br/>\n";

// highlight " . " pour mieux voir
$link_next="<a href='/doc/files/common/download" . $linuxstr . "file.php?fname=" . $commanderstr . "&targetdir=C:" . $parent_dir . "&urldir=" . $link_next_dir_url . "&perma=C:/UniServer/www/doc/files/common/perma" . $linuxstr . "'><img src='/doc/images/" . $commanderpng . "' /></a>&nbsp;" . '<a href="/doc/files' . $_GET['linkwith'] . '" target="' . $with_name . '" class="inline" id="idnext"  onmouseover="getFileFromServer(\'' . $link_next_dir_url . '/.brief\', function(text){ Tipped.create(\'#\'+\'idnext\', \'<pre>\'+text+\'</pre>\'); });">' . $with_name . '</a>' . $icon_with . "<br/>\n";
echo "link_with=".$link_next;


$file_parent='c:/UniServer/www/doc/files'.$_GET['parent'].'.next';

if( strpos(file_get_contents($file_parent),$link_next) === false) {
  echo file_put_contents($file_parent, $link_next/*." next_parent"*/);
  echo "added in ".$file_parent."<br/>\n";
}

// Now put the reverse link

$icon_back="";
if(file_exists($parent_dir."ui_run.run")){
	echo "exists !<br/>\n"; 
	$icon_back="<a href='/doc/files/common/download".$linuxstr."file.php?fname=ui_run.run&targetdir=".$parent_dir."&admin=0'><img src='/doc/images/Play-1-Hot-icon.png'/></a>";
}
$link_parent="<a href='/doc/files/common/download".$linuxstr."file.php?fname=".$commanderstr."&targetdir=C:".$link_next_dir."&urldir=".$parent_dir_url."&perma=C:/UniServer/www/doc/files/common/perma".$linuxstr."'><img src='/doc/images/".$commanderpng."' /></a>&nbsp;".'<a href="/doc/files'.$_GET['parent'].'open-command-prompt-here.html" target="'.$parent_name.'">'.$parent_name.'</a>'.$icon_back."<br/>\n";
echo "link_parent=".$link_parent;


$file_with='c:/UniServer/www/doc/files'.substr($_GET['linkwith'],0,-29).'.previous';

//echo $file_with;

if( strpos(file_get_contents($file_with),$link_parent) === false) {
  echo file_put_contents($file_with, $link_parent/*." next_with_append"*/, FILE_APPEND);
  echo "added in ".$file_with."<br/>\n";
}


?>


<script>
// refresh parent 
// enleve ces 2 ligne pour debugger
opener.location.reload();
window.close();
</script>
