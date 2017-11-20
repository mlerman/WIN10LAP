<?php
//echo "line=".$_GET["line"]." current dir=".getcwd();
//file_put_contents("debug.txt", "delete_line_in_recent_php line=".$_GET["line"]);
// set file to read 
$file = 'c:/UniServer/www/local/recent.txt'; 
// open file 
$fh = fopen($file, 'r') or die('Could not open file: '.$file); 

// Loop through each line 
$i = 0; 
$content="";
while (!feof($fh)) { 
   $buffer = fgets($fh); 
   
   if (strpos($buffer, $_GET["line"]) !== false) {
     //echo $buffer." skiped<br/>\n";
   }  else {
     //echo $buffer."<br/>\n";
    $content.=$buffer;
  }   
  $i++;   
} 
// close file 
fclose($fh); 

file_put_contents($file, $content);

?>

<script>
  window.history.back();
</script>