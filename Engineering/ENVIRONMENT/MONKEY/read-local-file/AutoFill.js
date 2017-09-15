// ==UserScript==
// @name       read-local-file
// @namespace  
// @version    0.1
// @description  Read a local file from client side 
// @match      http://siliconkit.com/fav/table.shtml
// @copyright  2012+, Michael Lerman
// ==/UserScript==

var div = document.createElement('div');
document.body.appendChild(div);
div.style.left = '32px'; 
div.style.top = '745px';
div.style.height = '70px'; 
div.style.width = '180px'; 
div.style.border = '1px solid #ccc'; 
div.style.background = 'gray';
div.style.opacity = '0.6';
div.id = 'page-wrapper';
div.innerHTML = '<div>&nbsp;Script by Michael Lerman<br/><input type=\"file\" id=\"fileInput\"></div><pre id=\"fileDisplayArea\"><pre>';
var mlsnumber="";
window.onload = function() {
		var fileInput = document.getElementById('fileInput');
		var fileDisplayArea = document.getElementById('fileDisplayArea');

		fileInput.addEventListener('change', function(e) {
			var file = fileInput.files[0];
			var textType = /text.*/;

			if (file.type.match(textType)) {
				var reader = new FileReader();
//alert(JSON.stringify(file, null, 4));

				reader.onload = function(e) {
                    mlsnumber=reader.result;
                    fileDisplayArea.innerText = mlsnumber;
                    alert("mls="+mlsnumber);

				}

				reader.readAsText(file);	
			} else {
				fileDisplayArea.innerText = "File not supported!";
			}
		});
    
// make the div draggable
   draggable('page-wrapper');    
} 



var dragObj = null;
function draggable(id)
{
    var obj = document.getElementById(id);
    obj.style.position = "absolute";
    obj.onmousedown = function(){
            dragObj = obj;
    }
}

document.onmouseup = function(e){
    dragObj = null;
};

document.onmousemove = function(e){
    var x = e.pageX;
    var y = e.pageY;

    if(dragObj == null)
        return;

    dragObj.style.left = x +"px";
    dragObj.style.top= y +"px";
};



