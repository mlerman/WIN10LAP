<html>
<head>
<title>Choose which project to go to next...</title>
</head>
<body>
<img src="http://".$_SERVER["HTTP_HOST"]."/doc/images/Arrownext48.png"/><br/>
Possible next step(s) or <a href="javascript:window.close();">close [X]</a>:
<ul>

<?php

$step1="";
if (isset($_GET["step1"])) {
  $step1=$_GET["step1"];
  $target1=$_GET["target1"];
echo "<li><a href='".$step1."' target='".$target1."' onclick='window.open(\"\", \"_self\", \"\"); window.close();' >".$target1."</a></li>\n";
}

$step2="";
if (isset($_GET["step2"])) {
  $step2=$_GET["step2"];
  $target2=$_GET["target2"];
echo "<li><a href='".$step2."' target='".$target2."' onclick='window.open(\"\", \"_self\", \"\"); window.close();' >".$target2."</a></li>\n";
}

$step3="";
if (isset($_GET["step3"])) {
  $step3=$_GET["step3"];
  $target3=$_GET["target3"];
echo "<li><a href='".$step3."' target='".$target3."' onclick='window.open(\"\", \"_self\", \"\"); window.close();' >".$target3."</a></li>\n";
}


?>

</ul>

<script>
// automatically close after delay
setTimeout(function(){
    self.close();
},20000);
</script>
</body>
</html>