char str[] = "Hello World";
char str2[] = "";

for(i=strlen(str)-1; i>=0; i--)
{
  if(str[i]==' ')
  {
    strcat(str2,str+i+1);
    strcat(str2," ");
    str[i]=0;        // cut
  }
}
strcat(str2,str);
printf("\n str: %s", str2);