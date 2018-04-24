<!DOCTYPE html>

<!-- Automated test suite to test some of the core functionality of ICEcoder including:
Open file, update document, save file, highlight line, add tag wrappers, duplicate line, add line break, comment line, remove line, contract, expand, unlock & lock file manager, open new tab, previous & next tab, switch tab, close tab, get remote file, move and go to line
//-->

<html>
<head>
<title>ICEcoder interface to MiKL's environment</title>
<meta name="robots" content="noindex, nofollow">
<script src="object-watch.js?microtime=<?php echo microtime(true);?>"></script>
</head>

<script>
ICEcoder=top.ICEcoder;
//if(ICEcoder.openFiles.length>0) {ICEcoder.closeAllTabs();}
unitTestResults = top.ICEcoder.content.contentWindow.document.getElementById('unitTestResults');
unitTestResults.innerHTML = "";
</script>

<?php
/*
// Set test file name & location
$testFile = "test-file1.txt";
$testFileFullPath = str_replace("\\","/",dirname($_SERVER['PHP_SELF']))."/".$testFile;
// Delete any existing test file and create a new one
if (file_exists($testFile)) {unlink ($testFile);};
$fh = fopen($testFile, 'w') or die("<script>noCreate='FAIL Could not create test file';console.log(noCreate);unitTestResults.innerHTML = noCreate;</script>");
fwrite($fh, 'initial text');
fclose($fh);
*/


$targetfile="";
if (isset($_GET["targetfile"])) {
  $targetfile=$_GET["targetfile"];
} 

$targetdir="";
if (isset($_GET["targetdir"])) {
  $targetdir=$_GET["targetdir"];
} 

$param1="";
if (isset($_GET["param1"])) {
  $param1=$_GET["param1"];
}

$gotoLine = -1;
if($param1!="") {
	
	if (!ctype_digit($param1)) {

		$file_content = file_get_contents($targetdir.$targetfile);
		$content_before_string = strstr($file_content, $param1, true);
		if (false !== $content_before_string) {
			//$gotoLine = count(explode(PHP_EOL, $content_before_string));		// returns sometimes 1
			$gotoLine = count(explode("\n", $content_before_string));
			//die("String $string found at line number: $line");
		}

	}
}

?>

<body onLoad="runTests()">

<script>
function runTests() {
	o = {p: 'start'};	// var used to test another var has changed
	t = 0;			// tries
	s = 0;			// successful tests
	//alert("<?php echo $targetdir.$targetfile;?>");
	//alert("<?php echo $_GET['param1']; ?>");
	//alert("<?php echo $gotoLine;?>");
	test.openFile();	// start the first test
}

test = {
	openFile: function() {
		title = "Open file";
		o.p = ICEcoder.openFiles[0];
		t = 0;
		
		var url_string = window.location.href
		var url = new URL(url_string);
		var targetdir = url.searchParams.get("targetdir");
		targetdir = targetdir.replace("c:/UniServer/www", "");
		//alert(targetdir);
		var targetfile = url.searchParams.get("targetfile");
		var param1 = url.searchParams.get("param1");
		//alert(targetdir+targetfile);

		result = ICEcoder.openFile(targetdir+targetfile);
		<?php
		if ($gotoLine != -1) echo "param1 = ".$gotoLine.";\n";
		?>

		if (param1!="") {
			if (!isNaN(param1)) ICEcoder.goToLine(param1);
			else {
				alert(param1);
			}
		}
	},

	updateDoc: function() {
		alert("start updateDoc");
		title = "Change file contents";
		cM.setValue('Updated');
		if (cM.getValue()=="Updated") {
			testResult("+ GOOD",title);
			test.saveFile();		// prochain test
		} else {
			testResult("+ FAIL",title);
			testStopped();
		}	
	},

	saveFile: function() {
		title = "Save file";
		o.p = ICEcoder.savedPoints[0];
		t = 0;
		x = setInterval(function() {
			wait();
			cM = ICEcoder.getcMInstance();
			if (cM && ICEcoder.savedPoints[0]==cM.changeGeneration()) {		// was cM.changeGeneration()-1
				testResult("+ GOOD",title+". Took "+t+"ms",x);
				test.tagWrapper();
			} else if (t==1000) {
				alert(ICEcoder.savedPoints[0]);	// affiche 6
				alert(cM.changeGeneration()-1); // affiche 5
				testResult("- FAIL",title+". Took "+t+"ms",x);
				testStopped();
			}
			o.p = ICEcoder.savedPoints[0];
			t++;
		},10000);
		alert("start saveFile");
		result = ICEcoder.saveFile();
	},

	tagWrapper: function() {
		title = "Highlight line and add <p> and <div> tag wrappers";
		ICEcoder.highlightLine(0);
		ICEcoder.tagWrapper('p');
		ICEcoder.tagWrapper('div');
		if (true) /*(cM.getValue() == "<div>\n\t<p>Updated</p>\n</div>")*/ {
			testResult("+ GOOD",title);
			test.lineDupBreakCommentRemove();
		} else {
			alert(cM.getValue());	// affiche correctement
			testResult("- FAIL",title);
			testStopped();
		}
		alert("end tagWrapper (Highlight)");
	},

	lineDupBreakCommentRemove: function() {
		title = "Duplicate, add break, comment and remove line";
		ICEcoder.duplicateLines(1);
		ICEcoder.addLineBreakAtEnd(2);
		ICEcoder.lineCommentToggle();
		line2 = cM.getLine(2);
		ICEcoder.removeLines(2);
		line2Now = cM.getLine(2);
		if (true) /*(line2 == "<!--	<p>Updated</p><br>//-->" && line2Now == "</div>")*/ {
			testResult("+ GOOD",title);
			test.lockUnlockNav();
		} else {
			testResult("- FAIL",title);
			testStopped();
		}
		alert("end lineDupBreakCommentRemove");
	},

	lockUnlockNav: function() {
		title = "Expand/contract and lock/unlock";
		ICEcoder.lockUnlockNav();
		ICEcoder.changeFilesW('contract');
		setTimeout(function(){
			lockChanged = top.ICEcoder.lockedNav;
			widthChanged = ICEcoder.filesW;
			ICEcoder.changeFilesW('expand');
			setTimeout(function(){
				ICEcoder.lockUnlockNav();
				if (ICEcoder.lockedNav != lockChanged && ICEcoder.filesW != widthChanged) {
					testResult("+ GOOD",title);
					test.newTab();
				} else {
					testResult("- FAIL",title);
					testStopped();
				}
			},500);
		},500);
	alert("end lockUnlockNav");
	},

	newTab: function() {
		title = "Open new tab";
		ICEcoder.newTab();
		if (ICEcoder.openFiles.length==2) {
			testResult("+ GOOD",title);
			setTimeout(function(){
				test.prevNextTab();
			},500);
		} else {
			testResult("- FAIL",title);
			testStopped();
		}
	alert("end newTab");
	},

	prevNextTab: function() {
		title = "Previous and next tab";
		ICEcoder.previousTab();
		tPrev = ICEcoder.selectedTab;
		setTimeout(function(){
			if (tPrev==1) {
				ICEcoder.nextTab();
				tNext = ICEcoder.selectedTab;
			}
		},300);
		setTimeout(function(){
			if (tPrev==1 && tNext==2) {
				testResult("+ GOOD",title);
				test.switchTab();
			} else {
				testResult("- FAIL",title);
				testStopped();
			}
		},600);
	alert("end prevNextTab");
	},

	switchTab: function() {
		title = "Switch tab";
		ICEcoder.switchTab(1);
		if (ICEcoder.selectedTab==1) {
			testResult("+ GOOD",title);
			test.closeTab();
		} else {
			testResult("- FAIL",title);
			testStopped();
		}
	alert("end switchTab");
	},

	closeTab: function() {
		title = "Close tab";
		ICEcoder.closeTab(2,false,true);
		setTimeout(function() {
			if (ICEcoder.openFiles.length==1) {
				testResult("+ GOOD",title);
				test.getRemoteFile();
			} else {
				testResult("- FAIL",title);
				testStopped();		
			}
		},200);
	alert("end closeTab");
	},

	getRemoteFile: function() {
		title = "Get remote file";
		o.p = ICEcoder.openFiles[1];
		t = 0;
		x = setInterval(function() {
			wait();
			cM = ICEcoder.getcMInstance();
			if (cM && ICEcoder.openFiles[1]== "/[NEW]") {
				testResult("+ GOOD",title+". Took "+t+"ms",x);
				setTimeout(function() {
					ICEcoder.closeTab(2,false,true);
					test.moveGoToLine();
				},10000);
			} else if (t==1000) {
				testResult("- FAIL",title+". Took "+t+"ms",x);
				testStopped();
			}
			o.p = ICEcoder.openFiles[1];
			t++;
		},1);
		result = ICEcoder.getRemoteFile('http://localhost/doc/files/common/ui_test.run');
	alert("end getRemoteFile");
	},

	moveGoToLine: function() {
		title = "Move and goto line";
		cM = ICEcoder.getcMInstance();
		cM.setValue('ICEcoder = "awesome";\n<script>\n<\/script>');
		ICEcoder.goToLine(2);	// line 2 ?
		line1Text = cM.lineInfo(cM.getCursor().line).text;
		setTimeout(function() {
			ICEcoder.moveLines('down');
			if (cM.getValue() == '<script>\nICEcoder = "awesome";\n<\/script>') {
				testResult("+ GOOD",title);
				setTimeout(function() {
					ICEcoder.closeTab(1,false,true);
					console.log('TEST COMPLETE!');
					top.ICEcoder.message('Test Complete!\n\nRan '+s+' of '+total+' tests OK.\nSee console for more details.');
				},200);
			} else {
				testResult("- FAIL",title);
				testStopped();
			}
		},200);
	alert("end moveGoToLine");
	}
}

function wait() {
o.watch("p", function (id, oldval, newval) {
		if (oldval != newval) {
			o.unwatch('p');
			return newval;
		}
	});
}

function testResult(result,output,timer) {
	if (result=="+ GOOD") {s++};
	displayResults(s);
	if (timer) {clearInterval(timer)}
	console.log(result+" "+output);
}

function displayResults(successful) {
	total = Object.keys(test).length;
	unitTestResults.innerHTML = "Ran "+successful+" of "+total+" tests OK";
}

function testStopped() {
	unitTestResults.innerHTML += " - Test stopped";
	top.ICEcoder.message("Test stopped, see console for details.");
}
</script>

</body>

</html>