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
    ['&#10;', ''], 
    ['&#10;', ''], 
    ['&#10;', ''] 
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
    ['read -p "Press Enter key to continue..." reply', 'read -p "Press [Enter] key to continue..." reply'], 
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
    ['int i, j, k;&#10;', 'int i, j, k; | <span style="background-color:lightgreen">declaration</span>'], 
    ['unsigned long ul;&#10;', 'unsigned long ul; | <span style="background-color:lightgreen">declaration</span>'], 
    ['int a, b, temp;&#10;', 'int a, b, temp; | <span style="background-color:lightgreen">declaration</span>'], 
    ['unsigned char uc = &apos;a&apos;;&#10;', 'unsigned char uc = &apos;a&apos;; | <span style="background-color:lightgreen">declaration</span>'], 
    ['char str[] = "Hello World";&#10;', 'char str[] = "Hello World"; | <span style="background-color:lightgreen">declaration</span>'],
    ['const char *strs[] = {&#10;    "one",&#10;    "two",&#10;    "three"&#10;};', 'const char *strs[] = {"one","two","three"}; | <span style="background-color:lightgreen">declaration</span>'],
    ['static int tab[] = { 1, 2, 3 };', 'static int tab[] = {1,2,3}; | <span style="background-color:lightgreen">declaration</span>'],
    ['printf("hello");&#10;', 'printf("hello");'], 
    ['printf("%s\\n", str);&#10;', 'printf("%s\\n", str);'], 
    ['printf("\\n i: %d", i);&#10;', 'printf("\\n i: %d", i);'], 
    ['printf("\\n %08lx", ul);&#10;', 'printf("\\n %08lx", ul);'], 
    ['printf("\\n c: %c", uc);&#10;', 'printf("\\n c: %c", uc);'], 
    ['#include <stdio.h>&#10;#include <string.h>&#10;#include <limits.h>&#10;#include <stdlib.h>&#10;&#10;int main()&#10;{&#10;int i, j, k;&#10;unsigned long ul;&#10;int a, b, temp;&#10;unsigned char uc = &apos;a&apos;;&#10;char str[] = "Hello World";&#10;static int tab[] = { 1, 2, 3 };  &#10;  &#10;  return 0;&#10;}&#10;', 'main() with all <span style="background-color:lightgreen">declaration</span> | <mark>full</mark>'], 
    ['#include <stdio.h>&#10;#include <string.h>&#10;#include <limits.h>&#10;#include <stdlib.h>&#10;&#10;int main()&#10;{&#10;  &#10;  &#10;  return 0;&#10;}&#10;', 'main() | <mark>full</mark>'], 
    ['int max=-INT_MAX;&#10;int sovim=-1;&#10;for(int im=0; im<(sizeof(tab) / sizeof(tab[0])) ; im++)&#10;{&#10;  if(tab[im]>max)&#10;  {&#10;    max=tab[im];&#10;    sovim=im;&#10;  }&#10;}&#10;printf("\\n max at index i: %d", sovim);&#10;', 'max loop complete | <span style="background-color:orange">snippet (tab)</span> '], 
    ['int min=INT_MAX;&#10;int sovim=-1;&#10;for(int im=0; im<(sizeof(tab) / sizeof(tab[0])) ; im++)&#10;{&#10;  if(tab[im]<min)&#10;  {&#10;    min=tab[im];&#10;    sovim=im;&#10;  }&#10;}&#10;printf("\\n min at index i: %d", sovim);&#10;', 'min loop complet | <span style="background-color:orange">snippet (tab)</span>'],
    ['temp = a;&#10;a = b;&#10;b = temp;&#10;', 'swap a b | <span style="background-color:orange">snippet (a,b,temp)</span>'],
    ['a ^= b;&#10;b ^= a;&#10;a ^= b;&#10;', 'swap a b with xor| <span style="background-color:orange">snippet (a,b)</span>'],
    ['for(i=0; i<strlen(str); i++)&#10;{&#10;printf("\\n i: %d c: %c", i, str[i]);&#10;  &#10;}', 'scan str | <span style="background-color:orange">snippet (str,i)</span>'],
    ['for(i=strlen(str)-1; i>=0; i--)&#10;{&#10;printf("\\n i: %d c: %c", i, str[i]);  &#10;}', 'reverse scan str | <span style="background-color:orange">snippet (str,i)</span>'],
    ['for(i=0; i<(sizeof(tab) / sizeof(tab[0])); i++)&#10;{&#10;printf("\\n i: %d tab[i]: %d", i, tab[i]);  &#10;}', 'scan tab | <span style="background-color:orange">snippet (tab,i)</span>'],
    ['for(i=(sizeof(tab) / sizeof(tab[0]))-1; i>=0; i--)&#10;{&#10;printf("\\n i: %d tab[i]: %d", i, tab[i]);   &#10;}', 'reverse scan tab | <span style="background-color:orange">snippet (tab,i)</span>'],
    ['int swapped=1;&#10;while(swapped)&#10;{&#10;  swapped=0;&#10;  int len = sizeof(tab) / sizeof(tab[0]);&#10;  for(i=0; i<len-1 ; i++)&#10;  {&#10;    if(tab[i]>tab[i+1])&#10;    {&#10;      temp = tab[i];&#10;      tab[i] = tab[i+1];&#10;      tab[i+1] = temp;&#10;      swapped=1;&#10;    }&#10;  }&#10;}&#10;', 'sort ascending tab | <span style="background-color:orange">snippet (tab,i,temp)</span>'], 
    ['int swapped=1;&#10;while(swapped)&#10;{&#10;  swapped=0;&#10;  int len = sizeof(tab) / sizeof(tab[0]);&#10;  for(i=0; i<len-1 ; i++)&#10;  {&#10;    if(tab[i]<tab[i+1])&#10;    {&#10;      temp = tab[i];&#10;      tab[i] = tab[i+1];&#10;      tab[i+1] = temp;&#10;      swapped=1;&#10;    }&#10;  }&#10;}&#10;', 'sort descending tab | <span style="background-color:orange">snippet (tab,i,temp)</span>'], 
	
    ['int l=strlen(str);&#10;char rstr[128];&#10;for(i=0; i<l; i++)&#10;{&#10;  rstr[i]=str[l-i-1]; &#10;}&#10;rstr[l]=0;&#10;printf("%s\\n", rstr);&#10;', 'reverse str | <span style="background-color:orange">snippet (str,i)</span>'],
    ['    int len = strlen(str) - 1;&#10;    int mid = (len % 2) ? (len / 2) : ((len + 1) / 2);&#10;    for(i = 0; i <= mid; ++i)&#10;    {&#10;        char buf = str[i];&#10;        str[i] = str[len - i];&#10;        str[len - i] = buf;&#10;    }&#10;    printf("%s\\n", str);&#10;', 'reverse str in place | <span style="background-color:orange">snippet (str,i)</span>'],
    ['    #include <stdio.h>&#10;    #include <string.h>&#10;    int main()&#10;    {&#10;        char str_subject[] = "Mikhael is not a good candidate";&#10;        char str_search[] = "good";&#10;        char str_replace[] = "bad";&#10;        char *pos;&#10;        int clen_search = strlen(str_search), clen_replace = strlen(str_replace);&#10;        while(pos = strstr(str_subject, str_search))&#10;        {&#10;            memmove(pos + clen_replace, pos + clen_search, strlen(pos) - clen_search + 1);&#10;            memcpy(pos, str_replace, clen_replace);&#10;        }&#10;        printf("%s", str_subject);&#10;    }', 'replace in str_subject str_search with str_replace with str_replace smaller that str_search | <mark>full</mark>'],
    ['    char* newstring = NULL;&#10;    char str_subject[] = "Mikhael ";&#10;    char str_append[] = "Lerman";&#10;    size_t needed = snprintf(NULL, 0, "%s%s", str_subject, str_append);&#10;    newstring = malloc(needed);&#10;    sprintf(newstring, "%s%s", str_subject, str_append);&#10;    printf("%s\\n", newstring);&#10;', 'append str_append to str_subject | <span style="background-color:orange">snippet</span>'],
    ['int k=0;&#10;switch(k) &#10;{&#10;  case 0:&#10;      break;&#10;  case 1:&#10;      break;&#10;  default :&#10;      break;&#10;}', 'switch(k) | <span style="background-color:orange">snippet</span>'],
    ['while(1)&#10;{&#10;  &#10;}&#10;', 'while(1) | <span style="background-color:orange">snippet</span>'],
    ['do&#10;{&#10;  &#10;} while(1);', 'do {} while(1) | <span style="background-color:orange">snippet</span>'],
    ['unsigned long mask = (1 << i);&#10;printf("%08lx\\n", mask);&#10;', '1 shifted left by i : unsigned long mask = (1 << i); | <span style="background-color:orange">snippet(i)</span>'],
    ['for(i=0; i<10 ; i++)&#10;{&#10;&#10;}&#10;', 'for(i=0; i<10 ; i++) { } | <span style="background-color:orange">snippet(i)</span>'],
    ['for(j=0; j<10 ; j++)&#10;{&#10;&#10;}&#10;', 'for(j=0; j<10 ; j++) { } | <span style="background-color:orange">snippet(j)</span>'],
    ['FILE *f;&#10;int val;&#10;f=fopen("fname","r");&#10;if(f)&#10;{&#10;  while(!feof(f))&#10;  {&#10;    fscanf(f,"%d\\n", &val);&#10;  }&#10;  fclose(f);&#10;}&#10;else&#10;{&#10;  printf("error, open fname\\n");&#10;}&#10;', 'read file | <span style="background-color:orange">snippet</span>'],
    ['FILE *f;&#10;int val=10;&#10;f=fopen("fname","wt");&#10;if(f)&#10;{&#10;  while(val)&#10;  {&#10;    fprintf(f,"%d\\n", val);&#10;    val--;&#10;  }&#10;  fclose(f);&#10;}&#10;else&#10;{&#10;  printf("error, create fname\\n");&#10;}&#10;', 'write file | <span style="background-color:orange">snippet</span>'],
    ['for(i=0; i<(sizeof(tab) / sizeof(tab[0])); i++)&#10;{&#10;  for(j=i+1; j<(sizeof(tab) / sizeof(tab[0])) ; j++)&#10;  {&#10;    if(tab[i] == tab[j])&#10;	{&#10;	  printf("found %d %d \\n", i, j);&#10;	}&#10;  }  &#10;}&#10;', 'find 2 identical numbers in tab | <span style="background-color:orange">snippet (tab,i,j)</span>'],
    ['for(i=0; i<(sizeof(tab) / sizeof(tab[0])); i++)&#10;{&#10;  for(j=i+1; j<(sizeof(tab) / sizeof(tab[0])); j++)&#10;  {&#10;	for(k=j+1; k<(sizeof(tab) / sizeof(tab[0])); k++)&#10;	{&#10;      if((tab[i] == tab[j])&&(tab[j] == tab[k])&&(tab[i] == tab[k]))&#10;	  {&#10;	  printf("found %d %d %d\\n", i, j, k);	    &#10;	  }&#10;	}  &#10;  }  &#10;}&#10;', 'find 3 identical numbers in tab | <span style="background-color:orange">snippet (tab,i,j,k)</span>'],
    ['int *ptr = (int *)malloc(sizeof(int)); &#10;*ptr = 10;&#10;printf("%d", *ptr); &#10;free(ptr);  &#10;', 'malloc ptr int | <span style="background-color:orange">snippet</span>'], 
    ['int x=1 ? printf("true") : printf("false"); &#10;int y=0 ? printf("true") : printf("false"); &#10;printf("\\nValue of x:%d y:%d\\n", x, y);&#10;', 'ternary | <span style="background-color:orange">snippet</span>'], 

    ['unsigned long get_field(unsigned long val, int start, int end)&#10;{&#10;   unsigned long ret = 0;&#10;   for (int i=start; i<=end; i++)&#10;       ret |= 1 << i;&#10;&#10;   ret = (val & ret) >> start;&#10;   return ret;&#10;}&#10;', 'get_field(val, start, end) | <span style="background-color:cyan">function</span>'], 
    ['int isprime(int n)&#10;{&#10;    int i, flag = 0;&#10;&#10;    if (n<2) return 0;&#10;    for(i=2; i<=n/2; ++i)&#10;    {&#10;        // condition for nonprime number&#10;        if(n%i==0)&#10;        {&#10;            flag=1;&#10;            break;&#10;        }&#10;    }&#10;&#10;    return !flag;&#10;}', 'isprim(int n) | <span style="background-color:cyan">function</span>'],
    //['printk("%s:%s:%d ml: %s http://mlerman-lap/s/K \\n",__FILE__,__func__,__LINE__, "something");&#10;', 'printk("%s:%s:%d ml: %s http://mlerman-lap/s/K \\n",__FILE__,__func__,__LINE__, "something");'] ,
    ['#include <stdio.h>&#10;#include <string.h>&#10;&#10;int recurse(unsigned int i) &#10;{&#10;&#10;   if(i <= 1) &#10;   {&#10;      return 1;&#10;   }&#10;   return i * recurse(i - 1);&#10;}&#10;&#10;int main()&#10;{&#10;  int i;&#10;  &#10;  i=recurse(4);&#10;  printf("\\n i: %d", i);&#10;  return 0;&#10;}&#10;', 'recurse, factoriel | <mark>full</mark>'],
    ['#include<stdio.h>&#10; &#10;int Fibonacci(int n)&#10;{&#10;   if ( n == 0 ) return 0;&#10;   else if ( n == 1 ) return 1;&#10;   else return ( Fibonacci(n-1) + Fibonacci(n-2) );&#10;} &#10;&#10;int main()&#10;{&#10;   int n=5, i = 0, c;&#10;   printf("\\n");&#10; &#10;   for ( c = 1 ; c <= n ; c++ )&#10;   {&#10;      printf("%d\\n", Fibonacci(i));&#10;      i++; &#10;   }&#10; &#10;   return 0;&#10;}&#10;', 'recurse, fibonacci serie | <mark>full</mark>'],
    ['#include<stdio.h>&#10; &#10;int main()&#10;{&#10;   int n=5, first = 0, second = 1, next, c;&#10; &#10;   printf("\\n");&#10;   for ( c = 0 ; c < n ; c++ )&#10;   {&#10;      if ( c <= 1 )&#10;         next = c;&#10;      else&#10;      {&#10;         next = first + second;&#10;         first = second;&#10;         second = next;&#10;      }&#10;      printf("%d\\n",next);&#10;   }&#10; &#10;   return 0;&#10;}', 'normal, fibonacci serie | <mark>full</mark>'],
    ['#include <stdio.h>&#10;#include <stdlib.h>&#10;&#10;int main()&#10;{&#10;  struct node {&#10;   int data;&#10;   struct node *next;&#10;  }*start, *elem1, *elem2, *elem3;&#10;&#10;  struct node *temp, *last ;&#10;&#10;  elem1 = (struct node*) malloc(sizeof(struct node));&#10;  elem1->data = 1;&#10;&#10;  start = elem1;&#10;&#10;  elem2 = (struct node*) malloc(sizeof(struct node));&#10;  elem2->data = 2;&#10;  elem1->next=elem2;&#10;&#10;  elem3 = (struct node*) malloc(sizeof(struct node));&#10;  elem3->data = 3;&#10;  elem2->next=elem3;&#10;&#10;  elem3->next=NULL;&#10;  &#10;  temp = start;&#10;&#10;  do {&#10;      printf("data : %d next : %p\\n", temp->data, temp->next); &#10;      last = temp;&#10;      temp = temp->next;&#10;  } while(last->next);&#10; &#10;  return 0;&#10;}&#10;', 'linked list with scan | <mark>full</mark>'],
    ['#include <stdio.h>&#10;#include <ctype.h>&#10;#include <stdlib.h>&#10;#include <math.h>&#10; &#10;long int Sum_of_Digits(long int Number)&#10;{&#10;    static long int sum=0;&#10;    if (Number==0) return(sum);&#10;    else sum=sum+Number%10+Sum_of_Digits(Number/10);&#10;    return(sum);&#10;}&#10; &#10;int main()&#10;{&#10;    long int Sum_dig=Sum_of_Digits(12345);&#10;    printf("%ld", Sum_dig);&#10;    return(0);&#10;} ', 'sum_of_digits of a long number | <mark>full</mark>'],
    ['#include <stdio.h>&#10;typedef struct TreeNode &#10;{&#10;  int element;&#10;  struct TreeNode *left, *right;&#10;} TreeNode;&#10;TreeNode *displayTree(TreeNode *node)&#10;{&#10;  //display the full tree&#10;  if(node==NULL)&#10;  {&#10;    return node;&#10;  }&#10;  displayTree(node->left);&#10;  printf("| %d ", node->element); &#10;  displayTree(node->right);&#10;  return node;&#10;}&#10;&#10;int main()&#10;{&#10;  TreeNode myTreeRoot, myTreeLeft, myTreeRight, myTreeRightChild;&#10;  &#10;  myTreeRoot.element=1;&#10;  myTreeRoot.left=&myTreeLeft;&#10;  myTreeRoot.right=&myTreeRight;&#10;  &#10;  myTreeLeft.element=2;&#10;  myTreeLeft.left=NULL;&#10;  myTreeLeft.right=NULL;&#10;  &#10;  myTreeRight.element=3;&#10;  myTreeRight.left=&myTreeRightChild;&#10;  myTreeRight.right=NULL;&#10;&#10;  myTreeRightChild.element=4;&#10;  myTreeRightChild.left=NULL;&#10;  myTreeRightChild.right=NULL;&#10;&#10;  displayTree(&myTreeRoot);&#10;  return 0;&#10;}&#10;', 'binary tree node with init | <mark>full</mark>'],
    ['#include <stdio.h>&#10;&#10;int printIntersection(int arr1[], int arr2[], int m, int n)&#10;{&#10;  int i = 0, j = 0;&#10;  while (i < m && j < n)&#10;  {&#10;    if (arr1[i] < arr2[j])&#10;      i++;&#10;    else if (arr2[j] < arr1[i])&#10;      j++;&#10;    else /* if arr1[i] == arr2[j] */&#10;    {&#10;      printf(" %d ", arr2[j++]);&#10;      i++;&#10;    }&#10;  }&#10;}&#10; &#10;/* Driver program to test above function */&#10;int main()&#10;{&#10;  int arr1[] = {1, 2, 4, 5, 6};&#10;  int arr2[] = {2, 3, 5, 7};&#10;  int m = sizeof(arr1)/sizeof(arr1[0]);&#10;  int n = sizeof(arr2)/sizeof(arr2[0]);&#10;  printIntersection(arr1, arr2, m, n);&#10;  return 0;&#10;}&#10;', 'intersection of 2 arrays of integer | <mark>full</mark>'], 
    ['#include<stdio.h>&#10;#include<string.h>&#10;&#10;void findIntersection(char str1[], char str2[]) {&#10;&#10;    int i, j, k = 0;&#10;    char str3[100];&#10;&#10;    int len1 = strlen(str1);&#10;    int len2 = strlen(str2);&#10;&#10;    for (i = 0; i < len1; i++) {&#10;        for (j = 0; j < len2; j++) {&#10;            if (str1[i] == str2[j]) {&#10;                str3[k] = str1[i];&#10;                k++;&#10;            }&#10;        }&#10;    }&#10;    str3[k] = 0;&#10;    printf("\\nIntersection of Two String :%s", str3);&#10;}&#10;&#10;int main() {&#10;&#10;    char str1[] = "mikhael";&#10;    char str2[] = "lerman";&#10;&#10;    findIntersection(str1, str2);&#10;&#10;    return 0;&#10;}&#10;', 'intersection of 2 strings | <mark>full</mark>'], 
    ['#include <stdio.h>&#10;#include <string.h>&#10;#include <limits.h>&#10;&#10;int main()&#10;{&#10;    &#10;unsigned long ul;&#10;&#10;static union { &#10;    unsigned char bytes[4]; &#10;    unsigned long val; &#10;} order;   &#10;&#10;order.bytes[0]=0x0a;&#10;order.bytes[1]=0x0b;&#10;order.bytes[2]=0x0c;&#10;order.bytes[3]=0x0d;&#10;&#10;printf("\\n %08lx", order.val);&#10;if(order.val==0x0d0c0b0aL) printf(" big indian - most popular");&#10;if(order.val==0x0a0b0c0dL) printf(" little indian");&#10;&#10;  return 0;&#10;}&#10;', 'little or big indian | <mark>full</mark>'], 
    ['#include <stdio.h> &#10;void fun(int a) &#10;{ &#10;    printf("Value of a is %d\\n", a); &#10;} &#10;  &#10;int main() &#10;{ &#10;    void (*fun_ptr)(int) = &fun; &#10;  &#10;    (*fun_ptr)(10); &#10;  &#10;    return 0; &#10;}&#10;', 'function pointer | <mark>full</mark>'], 
    ['#include <stdio.h>&#10;&#10;void swap(char *a, char *b)&#10;{&#10;char temp = *a;&#10;*a = *b;&#10;*b = temp;&#10;}&#10;&#10;void permute(char a[], int first, int last)&#10;{&#10;   int i;&#10;   if (first == last)&#10;     printf("%s\\n",a);&#10;   else&#10;   {&#10;       for (i = first; i <= last; i++)&#10;       {&#10;          swap(&a[first], &a[i]);          &#10;          permute(a, first+1, last);&#10;          swap(&a[first], &a[i]);&#10;       }&#10;   }&#10;} &#10;&#10;int main()&#10;{&#10;   char a[] = "ABCD";&#10;   permute(a, 0, 3);&#10;   return 0;&#10;}&#10;', 'all permutation of "ABCD" | <mark>full</mark>'], 
    ['#include <iostream>&#10;using namespace std;&#10;&#10;class Rectangle {&#10;    int width, height;&#10;  public:&#10;    void set_values (int,int);&#10;    int area() {return width*height;}&#10;};&#10;&#10;void Rectangle::set_values (int x, int y) {&#10;  width = x;&#10;  height = y;&#10;}&#10;&#10;int main () {&#10;  Rectangle rect;&#10;  rect.set_values (3,4);&#10;  cout << "area: " << rect.area();&#10;  return 0;&#10;}&#10;', 'C++ Rectangle | <mark>full</mark>'],
    ['#include <iostream>&#10;#include <vector>&#10;&#10;int main ()&#10;{&#10;  std::vector<int> first;                                // empty vector of ints&#10;  std::vector<int> second (4,100);                       // four ints with value 100&#10;  std::vector<int> third (second.begin(),second.end());  // iterating through second&#10;  std::vector<int> fourth (third);                       // a copy of third&#10;&#10;  &#10;  int myints[] = {16,2,77,29};   // construct from array&#10;  std::vector<int> fifth (myints, myints + sizeof(myints) / sizeof(int) );&#10;&#10;  std::cout << "The contents of fifth are:";&#10;  for (std::vector<int>::iterator it = fifth.begin(); it != fifth.end(); ++it)&#10;    std::cout << &apos; &apos; << *it;&#10;  std::cout << &apos;\\n&apos;;&#10;&#10;  return 0;&#10;}&#10;', 'C++ vectors | <mark>full</mark>'] 
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