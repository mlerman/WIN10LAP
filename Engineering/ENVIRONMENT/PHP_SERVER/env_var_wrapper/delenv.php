<?php
echo $_GET['name'];

$file = 'entries.html'; 
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

file_put_contents($file, $content);

unlink($_GET["name"].".txt");

?>

<script>
  //window.history.back();
</script>

