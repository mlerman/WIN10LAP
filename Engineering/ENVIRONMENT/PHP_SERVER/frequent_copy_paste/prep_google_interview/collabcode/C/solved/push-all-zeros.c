#define SIZE 7
int tab[SIZE]={ 1,0,2,0,0,3,4};

void f(void)
{
  int swapped, i, j, temp;
  swapped=1;
  i=0;
  j=0;
  while(swapped)
  {
    swapped=0;
    while((i<SIZE)&&(j<SIZE))
    {
      while((tab[i]==0)&&(i<SIZE))
        i++;
      while((tab[j]!=0)&&(j<SIZE))
        j++;
      if((i<SIZE)&&(j<SIZE))
      {
        temp = tab[i];
        tab[i] = tab[j];
        tab[j] = temp;
        swapped=1;
      }
    }  
  }
}

void main()
{
  int i;
  f();
  for(i=0; i<SIZE ; i++)
  {
    printf("\n %d: %d", i, tab[i]);
  }
  exit(000);
}