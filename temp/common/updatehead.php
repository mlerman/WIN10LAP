<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0

//file_put_contents("debug.txt","all post data : ".print_r($_POST, true)."\n", FILE_APPEND);
//file_put_contents("debug.txt","fieldname : ".$_GET['fieldname']."\n", FILE_APPEND);
//file_put_contents("debug.txt","content : ".$_GET['content']."\n", FILE_APPEND);

//we get 2 vars: fieldname and content. so you get: $fieldname=$content;
//and we get the vars set in the function setVarsForm(vars). These could be used 
//to identify a user with sending userID=1 
//you also can use $_COOKIE['someID'] in the file.


//THIS UPDATES A DATABASE
//create DB connection

//update from table set $fieldname = $content where userID = $_COOKIE['userID']


//OR

//THIS STARTS A FUNCTION
//if($_GET['fieldname'] == "userName")
//  setUserName($_GET['content']);
//if($_GET['fieldname'] == "userCity")
//  setUserCity($_GET['content']);
//
//

//OR


//THIS WRITES CONTENT TO A TEXT FILE

$file_sha1 = sha1_file($_GET['fieldname']);
//file_put_contents("debug.txt","file_sha1 : ".$file_sha1."\n", FILE_APPEND);
$content_sha1 = sha1($_GET['content']);
//file_put_contents("debug.txt","content_sha1 : ".$content_sha1."\n", FILE_APPEND);


if (($_GET['content'] != "...") 	// do not save if file does not exist yet
	&& ($file_sha1 != $content_sha1) // do not save if the content is already identical, dont' change the date time of the file
   )
	{
    $handle = fopen($_GET['fieldname'], "w+");
    fwrite($handle, stripslashes($_GET['content']));
    fclose($handle);
	}

$fieldname = $_GET['fieldname'];
echo stripslashes(strip_tags($_GET['content'],"<br><p><img><a><br><strong><em><hr>"));
?>