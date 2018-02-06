#include <stdio.h>

int keyval[] = { 1000, 900, 500, 400, 100,90, 50, 40, 10, 9, 5, 4, 1 };
char keystr[13][3] = { "M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I" };
char str[] = "XXIV";

void decode()
{
  char *ptr=str;
  int i, l;
  int val=0;
  for(i=0; i<13 ; i++)
  {
    l=strlen(keystr[i]);
    while(!strncmp(ptr,keystr[i],l))
    {
      val+=keyval[i];
      ptr+=l;
    }
  }
  printf("\n val: %d", val);
}

void main()
{
  decode();
  exit(000);
}
