<html> 
<head> 
<script type="text/javascript" src="instantedithead.js"></script> 
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

#cityName, #cityName_field{ 
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

#head { 
    width: 100%; 
	display: block;

} 

</style> 
</head> 
<body> 
<script type="text/javascript"> 
setVarsForm("pageID=profileEdit&userID=11&sessionID=28ydk3478Hefwedkbj73bdIB8H"); 
</script> 

<fieldset>
<legend>&nbsp;<a href="/mlscript/download<?php if($CurrOS=='Linux') echo 'Linux';?>file.php?fname=<?php if($CurrOS!='Linux') echo 'ui_';?>edit_this.<?php if($CurrOS!='Linux') echo 'run'; else echo 'sh'?>&targetdir=<?php echo realpath($dir); ?>&targetfile=.head&perma=<?php if($CurrOS!='Linux') echo realpath('perma'); else echo realpath('permalinux'); ?>"><img src="/doc/images/notepad-plus-plus.gif"/></a> 
              <small>(.head)</small> Notes: 
</legend>
<pre>
<span id="head" class="editText"><?php readfile(".head"); ?> </span> 
</pre>
</fieldset>


</body> 
</html>