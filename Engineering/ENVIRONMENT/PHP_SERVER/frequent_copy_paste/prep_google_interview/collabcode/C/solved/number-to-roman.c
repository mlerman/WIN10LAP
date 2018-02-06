int keyval[13] = { 1000, 900, 500, 400, 100,90, 50, 40, 10, 9, 5, 4, 1 };
char keystr[13][3] = { "M", "CM", "D", "CD", "C", "XC", "L", "XL", "X", "IX", "V", "IV", "I" };

char str[256] = "";
int val=47;

void encode()
{
  int i;
  for(i=0; i<13 ; i++)
  {
    while(val>=keyval[i])
    {
      val-= keyval[i];
      strcat(str,keystr[i]);
    }

  }
  printf("\n str: %s", str);
}

void main()
{
  encode();
  exit(000);
}
