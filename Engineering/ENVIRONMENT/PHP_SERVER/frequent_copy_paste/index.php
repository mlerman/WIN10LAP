<html>
<body>

<?php 

echo "<!-- "; 

echo " test zone ";

echo "-->"; 


?>
    
    
<script>
var arr_blank = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['', ''], 
    ['', ''], 
    ['', ''] 
    ];
var arr_batch = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['for %%a in (*.*) do ( echo %%a )', 'for %%a in (*.*) do ( echo %%a )'],
    ['if exist toto del toto /Q', 'if exist toto del toto /Q'],
    ['if "%1" == "" ( echo no param&#10;goto end&#10;)&#10;', 'if "%1" == "" (...'] 


    ];
var arr_shell = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['#!/bin/sh', '#!/bin/sh'], 
	['if [ ! -f /tmp/foo.txt ]; then&#10;    echo "File not found!"&#10;fi&#10;','if [ ! -f /tmp/foo.txt ]; ... (if file not exist)'],
    ['du -sh .', 'du -sh . (disk utilization)'], 
    ['df .', 'df . (disk free)'], 
    ['find . -name "*.err"', 'find . -name "*.err"'], 
    ['grep --include=\\*.{c,h} -rnw "." -e "pattern"', 'grep --include=\\*.{c,h} -rnw "." -e "pattern"'], 
    ['ps -Adef | grep mikhaell', 'ps -Adef | grep mikhaell'], 
    ['rm -rf removeMeAllWithMySbdirs', 'rm -rf removeMeAllWithMySbdirs'], 
    ['mkdir -p createMeIfNotExist', 'mkdir -p createMeIfNotExist'], 
    ['read -p "Press [Enter] key to continue..." reply', 'read -p "Press [Enter] key to continue..." reply'], 
    //['http_proxy=http://proxy.micron.com:8080; export http_proxy', 'http_proxy=http://proxy.micron.com:8080; export http_proxy']
    ['#!/bin/sh&#10;i=1;&#10;&#10;while [[ i -le 100 ]] ;&#10;do&#10;  echo $i;&#10;  i=$((i+1));&#10;done;', 'while loop <mark>full</mark>'] 
    ];
var arr_html = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['<html>&#10;&nbsp;&nbsp;<head>&#10;&nbsp;&nbsp;</head>&#10;&nbsp;&nbsp;<body>&#10;&nbsp;&nbsp;</body>&#10;</html>', '&lt;html&gt;&lt;head&gt;&lt;/head&gt;&lt;body&gt;&lt;/body&gt;&lt;/html&gt;'], 
    ['<scr'+'ipt>&#10;</scr'+'ipt>', '&lt;script&gt;&lt;/script&gt;'], 
    ['<a href="http://someURL">link</a>', '&lt;a href=:"http://someURL"&gt;link&lt;/a&gt;'],
    ['<mark></mark>', '&lt;mark&gt;&lt;/mark&gt;'] ,
    ['&param1=1234', '&amp;param1=1234 - add a line in frequent edit'] 
    ];
var arr_c_cpp = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['printf("hello");&#10;', 'printf("hello");'], 
    ['printf("%s\\n", str);&#10;', 'printf("%s\\n", str);'], 
    ['printf("\\n i: %d", i);&#10;', 'printf("\\n i: %d", i);'], 
    //['printf("ml: %s http://mlerman-lap/s/X\\n", __func__);&#10;', 'printf("ml: http://mlerman-lap/s/");'], 
    ['#include <stdio.h>&#10;#include <string.h>&#10;&#10;int main()&#10;{&#10;  int i=0;&#10;&#10;  printf("\\n i: %d", i);&#10;  return 0;&#10;}&#10;', 'main() | <mark>full</mark>'], 
    ['if(tab[im]>max)&#10;{&#10;  max=tab[im];&#10;  sovim=im;&#10;}&#10;', 'max clause in a loop context'], 
    ['max=-INT_MAX;&#10;for(im=0; im<SIZE ; im++)&#10;{&#10;  if(tab[im]>max)&#10;  {&#10;    max=tab[im];&#10;    sovim=im;&#10;  }&#10;}', 'max loop complete'], 
    ['if(tab[im]<min)&#10;{&#10;  min=tab[im];&#10;  sovim=im;&#10;}&#10;', 'min clause in a loop context'], 
    ['min=INT_MAX;&#10;for(im=0; im<SIZE ; im++)&#10;{&#10;  if(tab[im]<min)&#10;  {&#10;    min=tab[im];&#10;    sovim=im;&#10;  }&#10;}', 'min loop complet'],
    ['temp = a;&#10;a = b;&#10;b = temp;&#10;', 'swap a b'],
    ['for(i=0; i<strlen(str); i++)&#10;{&#10;  &#10;}', 'scan str'],
    ['for(i=strlen(str)-1; i>=0; i--)&#10;{&#10;  &#10;}', 'reverse scan str'],
    ['l=strlen(str);&#10;for(i=0; i<l; i++)&#10;{&#10;  revstr[i]=str[l-i-1]; &#10;}', 'reverse str'],
    ['    int i;&#10;    int len = strlen(str) - 1;&#10;    int mid = (len % 2) ? (len / 2) : ((len + 1) / 2);&#10;    for(i = 0; i <= mid; ++i)&#10;    {&#10;        char buf = str[i];&#10;        str[i] = str[len - i];&#10;        str[len - i] = buf;&#10;    }&#10;', 'reverse str in place | OK'],
    ['    #include <stdio.h>&#10;    #include <string.h>&#10;    main()&#10;    {&#10;        char str_subject[] = "Hello World";&#10;        char str_search[] = "Wor";&#10;        char str_replace[] = "co";&#10;        char *pos;&#10;        int clen_search = strlen(str_search), clen_replace = strlen(str_replace);&#10;        while(pos = strstr(str_subject, str_search))&#10;        {&#10;            memmove(pos + clen_replace, pos + clen_search, strlen(pos) - clen_search + 1);&#10;            memcpy(pos, str_replace, clen_replace);&#10;        }&#10;        printf("%s", str_subject);&#10;    }', 'replace in str_subject str_search with str_replace with str_replace smaller that str_search'],
    ['    char* newstring = NULL;&#10;    size_t needed = snprintf(NULL, 0, "%s%s", str_subject, str_append);&#10;    newstring = malloc(needed);&#10;    sprintf(newstring, "%s%s", str_subject, str_append);', 'append str_append to str_subject'],
    ['switch(k) &#10;{&#10;  case 0:&#10;      break;&#10;  case 1:&#10;      break;&#10;  default :&#10;      break;&#10;}', 'switch(k)'],
    ['while()&#10;{&#10;  &#10;}&#10;', 'while()'],
    ['do&#10;{&#10;  &#10;} while();', 'do {} while()'],
    ['(1 << i)', '1 shifted left by i : (1 << i)'],
    ['char str[] = "Hello World";&#10;', 'char str[] = "Hello World";'],
    ['const char *strs[] = {&#10;    "one",&#10;    "two",&#10;    "three"&#10;};', 'const char *strs[] = {"one","two","three"};'],
    ['static int ret[] = {&#10;    1,&#10;    2,&#10;    3&#10;};', 'static int ret[] = {1,2,3};'],
    ['for(i=0; i< ; i++)&#10;{&#10;&#10;}&#10;', 'for(i=0; i< ; i++) { }'],
    ['for(j=0; j< ; j++)&#10;{&#10;&#10;}&#10;', 'for(j=0; j< ; j++) { }'],
    ['FILE *f;&#10;int val;&#10;f=fopen("fname","r");&#10;if(f)&#10;{&#10;  while(!feof(f))&#10;  {&#10;    fscanf(f,"%d\\n", &val);&#10;  }&#10;  fclose(f);&#10;}&#10;else&#10;{&#10;  printf("error, open fname\\n");&#10;}&#10;', 'read file'],
    ['FILE *f;&#10;int val;&#10;f=fopen("fname","wt");&#10;if(f)&#10;{&#10;  while( )&#10;  {&#10;    fprintf(f,"%d\\n", val);&#10;  }&#10;  fclose(f);&#10;}&#10;else&#10;{&#10;  printf("error, create fname\\n");&#10;}&#10;', 'write file'],
    ['for(i=0; i<SIZE; i++)&#10;{&#10;  for(j=i+1; j<SIZE ; j++)&#10;  {&#10;    if(tab[i] ?? tab[j])&#10;	{&#10;	  &#10;	}&#10;  }  &#10;}', 'find 2 numbers in tab'],
    ['for(i=0; i<SIZE; i++)&#10;{&#10;  for(j=i+1; j<SIZE; j++)&#10;  {&#10;	for(k=j+1; k<SIZE; k++)&#10;	{&#10;      if(tab[i] ?? tab[j] ?? tab[k])&#10;	  {&#10;	    &#10;	  }&#10;	}  &#10;  }  &#10;}', 'find 3 numbers in tab'],
    ['int isprime(int n)&#10;{&#10;    int i, flag = 0;&#10;&#10;    if (n<2) return 0;&#10;    for(i=2; i<=n/2; ++i)&#10;    {&#10;        // condition for nonprime number&#10;        if(n%i==0)&#10;        {&#10;            flag=1;&#10;            break;&#10;        }&#10;    }&#10;&#10;    return !flag;&#10;}', 'function isprim(int n)'],
    //['printk("%s:%s:%d ml: %s http://mlerman-lap/s/K \\n",__FILE__,__func__,__LINE__, "something");&#10;', 'printk("%s:%s:%d ml: %s http://mlerman-lap/s/K \\n",__FILE__,__func__,__LINE__, "something");'] ,
    ['#include <stdio.h>&#10;#include <string.h>&#10;&#10;int recurse(unsigned int i) &#10;{&#10;&#10;   if(i <= 1) &#10;   {&#10;      return 1;&#10;   }&#10;   return i * recurse(i - 1);&#10;}&#10;&#10;int main()&#10;{&#10;  int i;&#10;  &#10;  i=recurse(4);&#10;  printf("\\n i: %d", i);&#10;  return 0;&#10;}&#10;', 'skeleton for recurse, factoriel | <mark>full</mark> | OK'],
    ['#include<stdio.h>&#10; &#10;int Fibonacci(int n)&#10;{&#10;   if ( n == 0 ) return 0;&#10;   else if ( n == 1 ) return 1;&#10;   else return ( Fibonacci(n-1) + Fibonacci(n-2) );&#10;} &#10;&#10;int main()&#10;{&#10;   int n=5, i = 0, c;&#10;   printf("\\n");&#10; &#10;   for ( c = 1 ; c <= n ; c++ )&#10;   {&#10;      printf("%d\\n", Fibonacci(i));&#10;      i++; &#10;   }&#10; &#10;   return 0;&#10;}&#10;', 'recurse, fibonacci serie | <mark>full</mark> | OK'],
    ['#include<stdio.h>&#10; &#10;int main()&#10;{&#10;   int n=5, first = 0, second = 1, next, c;&#10; &#10;   printf("\\n");&#10;   for ( c = 0 ; c < n ; c++ )&#10;   {&#10;      if ( c <= 1 )&#10;         next = c;&#10;      else&#10;      {&#10;         next = first + second;&#10;         first = second;&#10;         second = next;&#10;      }&#10;      printf("%d\\n",next);&#10;   }&#10; &#10;   return 0;&#10;}', 'normal, fibonacci serie | <mark>full</mark> | OK'],
    ['#include <stdio.h>&#10;#include <stdlib.h>&#10;&#10;int main()&#10;{&#10;  struct node {&#10;   int data;&#10;   struct node *next;&#10;  }*start, *elem1, *elem2, *elem3;&#10;&#10;  struct node *temp, *last ;&#10;&#10;  elem1 = (struct node*) malloc(sizeof(struct node));&#10;  elem1->data = 1;&#10;&#10;  start = elem1;&#10;&#10;  elem2 = (struct node*) malloc(sizeof(struct node));&#10;  elem2->data = 2;&#10;  elem1->next=elem2;&#10;&#10;  elem3 = (struct node*) malloc(sizeof(struct node));&#10;  elem3->data = 3;&#10;  elem2->next=elem3;&#10;&#10;  elem3->next=NULL;&#10;  &#10;  temp = start;&#10;&#10;  do {&#10;      printf("data : %d next : %p\\n", temp->data, temp->next); &#10;      last = temp;&#10;      temp = temp->next;&#10;  } while(last->next);&#10; &#10;  return 0;&#10;}&#10;', 'linked list with scan | <mark>full</mark> | OK'],
    ['#include <stdio.h>&#10;#include <ctype.h>&#10;#include <stdlib.h>&#10;#include <math.h>&#10; &#10;long int Sum_of_Digits(long int Number)&#10;{&#10;    static long int sum=0;&#10;    if (Number==0) return(sum);&#10;    else sum=sum+Number%10+Sum_of_Digits(Number/10);&#10;    return(sum);&#10;}&#10; &#10;int main()&#10;{&#10;    long int Sum_dig=Sum_of_Digits(12345);&#10;    printf("%ld", Sum_dig);&#10;    return(0);&#10;} ', 'sum_of_digits of a long number | <mark>full</mark> | OK'],
    ['#include <stdio.h>&#10;typedef struct TreeNode &#10;{&#10;  int element;&#10;  struct TreeNode *left, *right;&#10;} TreeNode;&#10;TreeNode *displayTree(TreeNode *node)&#10;{&#10;  //display the full tree&#10;  if(node==NULL)&#10;  {&#10;    return node;&#10;  }&#10;  displayTree(node->left);&#10;  printf("| %d ", node->element); &#10;  displayTree(node->right);&#10;  return node;&#10;}&#10;&#10;int main()&#10;{&#10;  TreeNode myTreeRoot, myTreeLeft, myTreeRight, myTreeRightChild;&#10;  &#10;  myTreeRoot.element=1;&#10;  myTreeRoot.left=&myTreeLeft;&#10;  myTreeRoot.right=&myTreeRight;&#10;  &#10;  myTreeLeft.element=2;&#10;  myTreeLeft.left=NULL;&#10;  myTreeLeft.right=NULL;&#10;  &#10;  myTreeRight.element=3;&#10;  myTreeRight.left=&myTreeRightChild;&#10;  myTreeRight.right=NULL;&#10;&#10;  myTreeRightChild.element=4;&#10;  myTreeRightChild.left=NULL;&#10;  myTreeRightChild.right=NULL;&#10;&#10;  displayTree(&myTreeRoot);&#10;  return 0;&#10;}&#10;', 'binary tree node with init | <mark>full</mark> | OK']
    ];

var arr_js = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['var elem=document.getElementById("someID");&#10;', 'var elem=document.getElementById("someID");'], 
    ['arr.forEach(function(arritem, arrindex) {&#10;&nbsp;&nbsp;console.log(arritem);&#10;});', 'arr.forEach(function(arritem, arrindex) {console.log(arritem);});'], 
    ['pos=fpath.lastIndexOf("/");', 'pos=fpath.lastIndexOf("/");'], 
    ['str.substring(indexA, indexB)', 'str.substring(indexA, indexB)'], 
    ['if(str.indexOf("somesubstring") !== -1) {}', 'if(str.indexOf("somesubstring") !== -1) {}'], 
    ['var arr = ["str0", "str1", "str2"];', 'var arr = ["str0", "str1", "str2"];'], 
    ['var arr = &#10;    [ &#10;    ["str00", "str01"], &#10;    ["str10", "str11"], &#10;    ["str20", "str21"] &#10;    ];', 'var arr = [ ["str00", "str01"], ["str10", "str11"], ["str20", "str21"] ];'],
    ['function toto()&#10;{&#10;}&#10;', 'function toto(){}'], 
    ['function getFileFromServer(url, doneCallback) {&#10;    var xhr;&#10;    xhr = new XMLHttpRequest();&#10;    xhr.onreadystatechange = handleStateChange;&#10;    xhr.open("GET", url, true);&#10;    xhr.send();&#10;    function handleStateChange() {&#10;        if (xhr.readyState === 4) {&#10;            doneCallback(xhr.status == 200 ? xhr.responseText : null);&#10;        }&#10;    }&#10;}&#10;', 'function getFileFromServer(url, doneCallback) {... (AJAX)'] 
    ];
var arr_php = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['if(file_exists("somefile")) {}', 'if(file_exists("somefile")) {}'], 
    ['$fcontent=file_get_contents("somefile");', '$fcontent=file_get_contents("somefile");'], 
    ['file_put_contents("debug.txt","somestring"."\\n", FILE_APPEND);', 'file_put_contents("debug.txt","somestring"."\n", FILE_APPEND);'],
    ['file_put_contents("debug.txt","all post data : ".print_r($_POST, true)."\\n", FILE_APPEND);', 'file_put_contents("debug.txt","all post data : ".print_r($_POST, true)."\n", FILE_APPEND);'],
    ['file_put_contents("debug.txt","all get data : ".print_r($_GET, true)."\\n", FILE_APPEND);', 'file_put_contents("debug.txt","all get data : ".print_r($_GET, true)."\n", FILE_APPEND);'],
    ['foreach($texts as $text) { &#10;&nbsp;&nbsp;echo $text; &#10;}', 'foreach($texts as $text) { echo $text; }'],
    ['echo substr("somestring",$start,$length);', 'echo substr("somestring",$start,$length);']
    ];
var arr_admin = // each line: ['string value to be copied with newlines', 'string to be shown'],
    [ 
    ['95125', '5) 95125'], 
    ['Indeed', 'Indeed'], 
    ['Mikhael', '1) Mikhael'], 
    ['Lerman', '2) Lerman'], 
    ['San Jose', '4) San Jose'], 
    ['Mikhael Lerman', 'Mikhael Lerman'], 
    ['michael_lerman@yahoo.com', 'michael_lerman@yahoo.com'],
    ['celine_lerman@yahoo.com', 'celine_lerman@yahoo.com'],
    ['mikhaell@xilinx.com', 'mikhaell@xilinx.com'],
    ['408-978-2232', '408-978-2232'], 
    ['408-564-9578', '6) 408-564-9578'], 
    ['2462 Booksin Ave &#10;San Jose CA 95125', '2462 Booksin Ave San Jose CA 95125'], 
    ['2462 Booksin Ave', '3) 2462 Booksin Ave'], 
    ['<?php echo file_get_contents('../../../../../../local/C7911B96-4115-406f-8BAE-551E4112AC2E.txt'); ?>', 'stupid blancs'],
    ['<?php echo file_get_contents('../../../../../../local/32D00D3E-92DA-4d69-872C-4D06C232F91A.txt'); ?>', 'stupid'],
    //['Mikhael Lerman &#10;570 Alder Drive &#10;Milpitas CA 95035 &#10;408-822-0180', 'Mikhael Lerman 570 Alder Drive Milpitas CA 95035 408-822-0180'],
    //['1140537', '1140537 (Micron Employee number)'],
    //['127650', '127650 (Micron cost center)'],
    //['zszubbocsev@micron.com', 'zszubbocsev@micron.com'],
    ['STMicroelectronics', 'STMicroelectronics'],
    ['http://checkthisresume.com', 'http://checkthisresume.com'],
    ['https://www.linkedin.com/in/getme/', 'https://www.linkedin.com/in/getme/'],
    ['https://twitter.com/manestate', 'https://twitter.com/manestate'],
    ['https://github.com/mlerman', 'https://github.com/mlerman'],
    ['http://ntmio.com/showcase', 'http://ntmio.com/showcase'],
    ['Please consider my application for this position and give me the opportunity to talk about my experience. http://checkthisresume.com', 'Please consider... Cover letter']
    ];
	
var arr_of_arr = 
	[
	arr_batch,		// arr_batch
	arr_shell,		// arr_shell
	arr_html,		// arr_html
	arr_c_cpp,		// arr_c_cpp
	arr_js,			// arr_js
	arr_php,		// arr_php
	arr_admin		// arr_admin
	];
var clicked_id;


function bindme(id, section) {
    //alert('bindme'+' id is '+id +" section is "+section);
    
    found=-1;
    for (ii=0; ii<rearrange_order.length ; ii++) {
    	//console.log(rearrange_order[ii]);
    	if(rearrange_order[ii]==section) found=ii;
    }
    //console.log("found = "+found);
    let temp = rearrange_order[found];
    
    for (ii=found; ii>=1 ; ii--) {
    	rearrange_order[ii]=rearrange_order[ii-1];
    }
    rearrange_order[0]=temp;
    
    
    //for (ii=0; ii<rearrange_order.length ; ii++) {
    // 	console.log(rearrange_order[ii]);
    //}
    
    localStorage.setItem("rearrange_order", JSON.stringify(rearrange_order));
    
    //alert("found is " + found + " order is " + rearrange_order);
	
	var clipboard_data = document.getElementById(id).getAttribute('data-clipboard-text');
	//alert(clipboard_data);
	var parent_div_prevclip=window.opener.document.getElementById('prevclip');
	parent_div_prevclip.innerHTML=clipboard_data;

    var clipboard = new ClipboardJS('#'+id, { text: function() { return clipboard_data  } });

}
	
document.write("<table width='100%'><tr><td><a href='#batch'>Batch</a></td><td><a href='#shell'>Shell</a></td><td><a href='#html'>HTML</a></td><td><a href='#c_cpp'>C/C++</a></td><td><a href='#js'>Javascript</a></td><td><a href='#php'>PHP</a></td><td><a href='#admin'>Admin</a></td></tr></table>");
//<![CDATA[
var strid="";


var rearrange_order = [];	//ok
//var rearrange_order = [1, 2, 3, 4, 5, 6, 0];	// OK
//var rearrange_order = [2, 4, 6, 0, 5, 1, 3];	// OK

rearrange_order = JSON.parse(localStorage.getItem("rearrange_order"));
if(rearrange_order==null) rearrange_order = [0, 1, 2, 3, 4, 5, 6];

//alert(rearrange_order);


var strid_tab = ["batch", "shell", "html", "c_cpp", "js", "php", "admin"];
for(arr_of_arr_index=0; arr_of_arr_index<arr_of_arr.length; arr_of_arr_index++ )
{
  strid="";
  switch(rearrange_order[arr_of_arr_index])
  {
  case 0: document.write("<h3><a name='batch'></a>Batch</h3>");
			break;
  case 1: document.write("<h3><a name='shell'>Shell</h3></a>");
			break;
  case 2: document.write("<h3><a name='html'></a>HTML</h3>");
			break;
  case 3: document.write("<h3><a name='c_cpp'></a>C/C++</h3>");
			break;
  case 4: document.write("<h3><a name='js'></a>Javascript</h3>");
			break;
  case 5: document.write("<h3><a name='php'></a>PHP</h3>");
			break;
  case 6: document.write("<h3><a name='admin'></a>Admin</h3>");
			break;
  }
  strid=strid_tab[rearrange_order[arr_of_arr_index]];
  section=rearrange_order[arr_of_arr_index];
  for(ii=0; ii<arr_of_arr[rearrange_order[arr_of_arr_index]].length; ii++)
  {
  // this display the links in the body
  document.write("<br/>&nbsp;<span class='btn' id='copy_button_"+strid+"_"+ii+"' data-clipboard-text='"+arr_of_arr[rearrange_order[arr_of_arr_index]][ii][0]+"' title='copy to clipboard' style='cursor:pointer' onmouseover='this.style.backgroundColor=\'white\';' clicked_id=this.id; onclick='bindme(this.id,"+section+"); window.close();'><img src=\"/doc/images/copyclip.png\"/>&nbsp;<img src='copy_button_"+strid+"_"+ii+".gif'>&nbsp;"+arr_of_arr[rearrange_order[arr_of_arr_index]][ii][1]+"</span>");
  }
  document.write("<br/><hr/>");
}

//]]>

</script>


<script src="./dist/clipboard.min.js"></script>
 <br/>
<div align="center" style="border:1px solid red">
 <small>to edit this file go to <a href="/doc/files/Engineering/ENVIRONMENT/PHP_SERVER/frequent_copy_paste/open-command-prompt-here.html">frequent_copy_paste</a></small>
</div>

 
</body>

</html>