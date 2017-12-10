<?php
$targetdir="";
  if (isset($_GET['targetdir'])) {
	  $targetdir=$_GET['targetdir'].'\\';
  }

  if (isset($_POST['submit'])) {
    $envVar = $_POST['envVar'];
	$txt = "<a href=\"index.php?delaction=1&name=".$envVar."\"><img src=\"/doc/images/delete.png\"></a>&nbsp;<label>".$envVar."</label>  <span id=\"".$envVar."\" class=\"editText\"></span><hr/>";
    file_put_contents($targetdir.'entries.html', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
    file_put_contents($targetdir.$envVar.'.sh.bat', "set ".$envVar."=new" , FILE_APPEND | LOCK_EX);
  }

  if (isset($_GET['delaction'])) {
    $file = $targetdir.'entries.html'; 
    $fh = fopen($file, 'r') or die('Could not open file: '.$file); 
    $i = 0; 
    $content="";
    while (!feof($fh)) { 
       $buffer = fgets($fh); 
   
       if (strpos($buffer, $_GET["name"]) !== false) {
         //echo $buffer." skiped<br/>\n";
       }  else {
         //echo $buffer."<br/>\n";
        $content.=$buffer;
      }   
      $i++;   
    } 
    // close file 
    fclose($fh); 

    file_put_contents($targetdir.$file, $content);

    unlink($_GET["name"].".sh.bat");
  }
?>


<html>
<head>
<title>Example page: instant edit AJAX-style</title>
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
New environment variable name: <input type="text" name="envVar" value="toto" />&nbsp;
<input type="submit" name="submit" value="Add new" />
</form>

<?php
if(isset($_POST['envVar']) && !empty($_POST['envVar'])) {
    //echo 'Welcome, ' . $_POST['envVar']; 
}
?>

<hr />
<?php 
  //echo "env var posted : ".$envVar."<br/>\n";

  $strHTML=file_get_contents($targetdir."entries.html"); 
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
	  $strVal=file_get_contents($targetdir.$var_name.".sh.bat");
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