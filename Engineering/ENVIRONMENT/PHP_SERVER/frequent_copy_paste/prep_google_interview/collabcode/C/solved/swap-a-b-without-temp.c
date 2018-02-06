#include <stdio.h>

void main()
{
  int temp, a=123, b=456;

  printf("a=%d, b=%d\n",a,b);
  temp = a;
  a = b;
  b = temp;

  printf("a=%d, b=%d\n",a,b);

  a ^= b;
  b ^= a;
  a ^= b;
  printf("a=%d, b=%d\n",a,b);

  exit(0);
}


