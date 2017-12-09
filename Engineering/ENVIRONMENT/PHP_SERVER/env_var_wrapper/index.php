<html>
<head>
<title>Example page: instant edit AJAX-style</title>
<script type="text/javascript" src="http://www.yvoschaap.com/instantedit/instantedit.js"></script>
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

#lorumText, #lorumText_field{
	width: 500px;

}

</style>
</head>
<body>
<script type="text/javascript">
setVarsForm("pageID=profileEdit&userID=11&sessionID=28ydk3478Hefwedkbj73bdIB8H");
</script>
<label>Your name:</label> <span id="userName" class="editText">John Doe</span><br />
<label>Your city:</label>  <span id="cityName" class="editText">Rotterdam, NL</span>

<hr />
<h1><span id="blogTitle" class="editText">AJAX instant edit script - clean HTML</span></h1>
<span id="blogText" class="editText">Welcome to my blog. Today i created this instant update script. Click here to try! If you like it you can download and view the source at: yvoschaap.com. Have fun and success.</span>
<p>Message of the day:<strong><span id="messageDay" class="editText">Time Spend Wishing, Is Time Wasted</span></strong></p>
<hr>
<span id="lorumText" class="editText">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut faucibus commodo lacus. Donec egestas magna et risus.<br />
<br />
Etiam velit tellus, sagittis eget, pretium eu, sagittis ut, sem. Aliquam est. Nam condimentum. In massa ligula, varius in, aliquet vehicula, facilisis id, ante. Sed purus. Vestibulum tempus facilisis lectus. Phasellus convallis, lorem in bibendum convallis, nunc nisl fringilla sem, ut nonummy turpis nunc sed risus. Aliquam bibendum semper ipsum. <br />
<br />
In hac habitasse platea dictumst. Maecenas vulputate, nisl nec tempus rutrum, tortor ligula interdum urna, eget porttitor risus sem eu odio. <br />
<br />
Nullam vel leo sed enim sodales euismod. Phasellus volutpat purus sit amet erat. Nulla ut enim. Nullam tempus enim eget lacus. Nulla a nibh eu enim bibendum bibendum. Nunc justo. Vivamus sagittis sollicitudin lacus. Duis lacinia nisi et lectus. Etiam ac felis et est sagittis aliquam. Duis vitae nulla. Nam sed nibh. Mauris fermentum sodales nulla. Nam fringilla. In hac habitasse platea dictumst. Aliquam erat volutpat. Fusce consectetuer. <br />
</span>
<p></p>
<hr>
<em>note: editted text fields in this example do not save!</em><br />
<em><a href="http://www.yvoschaap.com/index.php/weblog/ajax_inline_instant_update_text_20">Back to article</a></em>
</body>
</html>