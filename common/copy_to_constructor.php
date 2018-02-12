<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$fname=$_GET['fname'];
$targetdir=$_GET['targetdir'];
//$urldir=$_GET['urldir'];
//$urlslashdoc=$urldir;
//$host=$_GET['host'];

//$srcdir = $urldir;

echo "fname : ". $fname."<br/>\n";
echo "targetdir : ". $targetdir."<br/>\n";
//echo "urldir : ". $urldir."<br/>\n";
//echo "srcdir : ". $srcdir."<br/>\n";
//echo "host : ". $host."<br/>\n";

$source=$targetdir."/".$fname;
echo "source : ". $source."<br/>\n";

$destination=$targetdir;
$pos = strrpos($destination, "/");
$destination=substr($destination, 0, $pos+1);
//$pos = strrpos($destination, "/");
//$destination=substr($destination, 0, $pos+1);


$file=file_get_contents($source);
echo $file;

$destination=$destination."_constructor/copy_over_those_files/".$fname;
echo "destination : ". $destination."<br/>\n";
if (copy($source, $destination)) {
  echo "<br/>the file has been copied<br/>\n";
} else {
  echo "<br/>*** ERROR : the file has NOT been copied<br/>\n";
}


//$host = str_replace("http://", "//", $host);
//$urldir = str_replace("/doc", $host, $urldir);

//echo "mkdir destination ".$urldir."<br/>\n";
//if (!file_exists($urldir)) {
    //mkdir($urldir, 0755, true);
//}

//echo "host : ". $host."<br/>\n";
//echo "urldir : ". $urldir."<br/>\n";

// c:\UniServer\www\doc\files\Engineering\ENVIRONMENT\NODE\fill_sd_ajax\
//$u=substr($urldir, 0, -1);
//echo "mkdir ".$u."<br/>\n";
//if (!file_exists($u)) {
   // mkdir( $u, 0755, true);
//}


function cpy($source, $dest){
    if(is_dir($source)) {
        $dir_handle=opendir($source);
        while($file=readdir($dir_handle)){
            if($file!="." && $file!=".."){
                if(is_dir($source."/".$file)){
                    if(!is_dir($dest."/".$file)){
                        mkdir($dest."/".$file);
                    }
                    cpy($source."/".$file, $dest."/".$file);
                } else {
                    copy($source."/".$file, $dest."/".$file);
                }
            }
        }
        closedir($dir_handle);
    } else {
        copy($source, $dest);
    }
}

//cpy("/UniServer/www".$srcdir,$urldir);
//header("Location: http://".$urldir); /* Redirect browser */
//exit();

// this was when I just copy 3 files
/*
$file = "/UniServer/www".$srcdir."favicon.ico";
$newfile = $urldir."favicon.ico";
if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}

$file = "/UniServer/www".$srcdir.".htaccess";
$newfile = $urldir.".htaccess";
if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}

// open-command-prompt-here.html
$file = "/UniServer/www".$srcdir."open-command-prompt-here.html";
$newfile = $urldir."open-command-prompt-here.html";
if (!copy($file, $newfile)) {
    echo "failed to copy $file...\n";
}
*/

//file_put_contents("debug.txt",$urldir." ".$host);
//echo "redirect to http:".$host. $urlslashdoc."open-command-prompt-here.html<br/>";
?>

<script>
//window.location="http:<?php echo $host.$urlslashdoc; ?>open-command-prompt-here.html";
</script>



