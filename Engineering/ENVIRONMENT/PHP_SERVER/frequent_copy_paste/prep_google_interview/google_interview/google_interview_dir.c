#include<stdio.h>
#include <string.h>

const char *strs[] = {
"dir1",
" dir11",
" dir12",
"  picture.jpeg",
"  dir 121",
"   file1.txt",
"dir2",
" file2.gif"
};


/*
// en java
public static int printSum(String s){
       String[] arr=s.split("\n");
       int sum=0, spaces=0;
       for(int i=arr.length-1;i>=0;i--){
           String line=arr[i];
           if(line.contains(".gif") | line.contains(".jpeg") ){
               spaces=line.length()-line.trim().length();
           }
           if(spaces> line.length()-line.trim().length() ){
               sum+=line.trim().length()+1;
               spaces--;
           }
       }
       return sum;
}

*/

main()
{
	int i;
	int sum=0, spaces=0;
	char line[64];
	
	/*
	for(i=0; i<=7 ; i++)
	{
    printf("%s\n", strs[i]);
	}
	*/
	for(i=7; i>=0 ; i--)
	{
		int len;
		int j;
		strcpy(line,strs[i]);
		len=strlen(line);
		for(j=0; line[j]==' ' ; j++);		// count the spaces
		if((strstr(line, ".gif") != NULL) || (strstr(line, ".jpeg")) )
		{
			spaces=len-j;
		}
		if(spaces>len-j)
		{
			sum+=j+1;
			spaces--;
		}
		
		//printf("%s\n", strs[i]);
	}
	printf("\n sum: %d\n", sum);
	

}