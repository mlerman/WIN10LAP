#define SIZE 3
int tab[SIZE];
int swapped=1;
while(swapped)
{
  swapped=0;
  for(i=0; i<SIZE-1 ; i++)
  {
    if(tab[i]>tab[i+1])
    {
      temp = tab[i];
      tab[i] = tab[i+1];
      tab[i+1] = temp;
      swapped=1;
    }
  }
}