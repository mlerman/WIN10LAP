<?php
$targetdir="";
  if (isset($_GET['targetdir'])) {
	  $targetdir=$_GET['targetdir'];
	  $targetdir = str_replace('\\', '/', $targetdir);
  }
  
  //file_put_contents("debug.txt","targetdir ".$targetdir."\n", FILE_APPEND);
  //exit(0);

  if (isset($_POST['submit'])) {
    if(isset($_POST['envVar']) && !empty($_POST['envVar'])) {
      $envVar = $_POST['envVar'];
	  $txt = "<a href=\"".$_SERVER["PHP_SELF"]."?targetdir=".$targetdir."&disaction=1&name=".$envVar."\"><img src=\"/doc/images/on.png\"></a>&nbsp;<a href=\"".$_SERVER["PHP_SELF"]."?targetdir=".$targetdir."&delaction=1&name=".$envVar."\"><img src=\"/doc/images/delete.png\"></a>&nbsp;<label>".$envVar."</label>  <span id=\"".$targetdir.'/'.$envVar."\" class=\"editText\"></span><hr/>";
      file_put_contents($targetdir.'/entries.html', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
      file_put_contents($targetdir.'/'.$envVar.'.sh.bat', "set ".$envVar."=new" , FILE_APPEND | LOCK_EX);
    }
  }

  if (isset($_GET['delaction'])) {
    $file = $targetdir.'/entries.html'; 
    $fh = fopen($file, 'r') or die('Could not open file: '.$file); 
    $i = 0; 
    $content="";
    while (!feof($fh)) { 
       $buffer = fgets($fh); 
   
       if (strpos($buffer, "<label>".$_GET["name"]."</label>") !== false) {
         //echo $buffer." skiped<br/>\n";
       }  else {
         //echo $buffer."<br/>\n";
        $content.=$buffer;
      }   
      $i++;   
    } 
    fclose($fh); 

    file_put_contents($file, $content);

    unlink($targetdir.'/'.$_GET["name"].".sh.bat");
  }

  if (isset($_GET['disaction'])) {
    $file = $targetdir.'/entries.html'; 
    $fh = fopen($file, 'r') or die('Could not open file: '.$file); 
    $i = 0; 
    $content="";
    while (!feof($fh)) { 
       $buffer = fgets($fh); 
   
       if (strpos($buffer, "<label>".$_GET["name"]."</label>") !== false) {
         // TODO
		$buffer=str_replace("disaction","enaction",$buffer);
		$buffer=str_replace("on.png","off.png",$buffer);
        $content.=$buffer;
       }  else {
         //echo $buffer."<br/>\n";
        $content.=$buffer;
      }   
      $i++;   
    } 
    fclose($fh); 

    file_put_contents($file, $content);

	copy($targetdir.'/'.$_GET["name"].".sh.bat", $targetdir.'/'.$_GET["name"].".sh.bat.0");
    unlink($targetdir.'/'.$_GET["name"].".sh.bat");
  }
  

  if (isset($_GET['enaction'])) {
    $file = $targetdir.'/entries.html'; 
    $fh = fopen($file, 'r') or die('Could not open file: '.$file); 
    $i = 0; 
    $content="";
    while (!feof($fh)) { 
       $buffer = fgets($fh); 
   
       if (strpos($buffer, "<label>".$_GET["name"]."</label>") !== false) {
         // TODO
		$buffer=str_replace("enaction","disaction",$buffer);
		$buffer=str_replace("off.png","on.png",$buffer);
        $content.=$buffer;
       }  else {
         //echo $buffer."<br/>\n";
        $content.=$buffer;
      }   
      $i++;   
    } 
    fclose($fh); 

    file_put_contents($file, $content);

	copy($targetdir.'/'.$_GET["name"].".sh.bat.0", $targetdir.'/'.$_GET["name"].".sh.bat");
    unlink($targetdir.'/'.$_GET["name"].".sh.bat.0");
  }
  
?>


<html>
<head>
<title>Manage environment variables</title>
<script type="text/javascript" src="./instanteditenv.js"></script>
<style type='text/css'>
body{
	font-family: verdana;
	font-size: .9em;

}

input, textarea, pre{
	font-family: verdana;
	font-size: inherit;
	font-family: inherit;
}

label{
	width: 110px;
}


#userName, #userName_field{
	font-size: 14px;
}

.editText {
	font-size: 14px;
	background-color: #333;
	color: #fff;
}


#blogTitle, #blogTitle_field{

	font-size: 24px;


}

#blogText, #blogText_field{

	width: 240px;


}

#lorumText, #lorumText_field{
	width: 500px;

}

</style>
</head>
<body>
<script type="text/javascript">
setVarsForm("pageID=profileEdit&userID=11&sessionID=28ydk3478Hefwedkbj73bdIB8H");
</script>

<form action="" method="post">
New environment variable name: <input type="text" name="envVar" placeholder="Variable name" />&nbsp;
<input type="submit" name="submit" value="Add new" />
</form>


<hr />
<?php 
  //echo "env var posted : ".$envVar."<br/>\n";

  $strHTML=file_get_contents($targetdir."/entries.html"); 
  //echo $strHTML;
  $doc = new DOMDocument();
  $doc->loadHTML($strHTML);
  
  //OK
  $item_num=0;
  $spans = $doc->getElementsByTagName('span');
  $labels = $doc->getElementsByTagName('label');
  foreach ($spans as $span) {
	  $elem_label = $doc->getElementsByTagName('label')->item($item_num);
	  $var_name=$elem_label->nodeValue;
      //echo "item ".$item_num." ".$span->nodeValue." ".$var_name."<br/>\n";
	  $elem = $doc->getElementsByTagName('span')->item($item_num);
	  if (file_exists($targetdir.'/'.$var_name.".sh.bat")) {
		$strVal=file_get_contents($targetdir.'/'.$var_name.".sh.bat");
	  }	else {
		$strVal=file_get_contents($targetdir.'/'.$var_name.".sh.bat.0");
	  }
	  $elem->nodeValue=$strVal;
	  $item_num++;
  }  
  
  echo $doc->saveHTML();
?>
<br/>
<!--
<label>Your city:</label>  <span id="cityName" class="editText"><?php if ( 0 == filesize( "cityName.sh.bat" ) ) echo "..."; else echo file_get_contents("cityName.sh.bat"); ?></span>
<hr />
-->
</body>
</html>