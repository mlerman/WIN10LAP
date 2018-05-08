<?php
echo "running addclip.php copied from addedit.php<br/>";
$path=$_GET['path'];
echo "path=".$path."<br/>";
$parent=$_GET['parent'];
echo "parent=".$parent."<br/>\n";
$label=$_GET['label'];
echo "label=".$label."<br/>\n";

$parent_dir = "/doc/files".$_GET['parent'];

$cliptab="c:/UniServer/www/doc/files".$parent.".cliptab";
echo ".cliptab path=".$cliptab."<br/>\n";


if(!file_exists($cliptab)) {
  file_put_contents($cliptab, "    [ \n    ['', ''] \n    ]\n");
}


$strfile = file_get_contents( $cliptab ); // get the contents, and echo it out.
//echo $strfile;


/*
detect this:
] 
    ]
    
    
in 

    [ 
    ['toto', 'toto'] ,
    ['titi', 'titi'] ,
    ['tutu', 'tutu'] ,
    ['tata', 'tata'] ,
    ['coucou', 'coucou'] 
    ]

*/

$path=addslashes($path);	// escape the backslashes
if ($label=="") $label=$path;
if(strstr($strfile, "] \n    ]")) {

  //echo "<br/>found ! <br/>";
  $strfile=str_replace("] \n    ]", "] ,\n    ['".$path."', '".$label."'] \n    ]", $strfile);
  //echo $strfile;
  file_put_contents($cliptab, $strfile);
}

?>

<script>
//this does not refresh but come back to the same vertical scroll position
sessionStorage.setItem("forcerefresh", "yes");
window.history.back();
</script>
