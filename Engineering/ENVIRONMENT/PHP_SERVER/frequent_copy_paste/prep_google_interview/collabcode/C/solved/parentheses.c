#include <stdio.h>
#define N 6

// ()()()
// (()())
// ()(())
// (())()
// ((()))

int tab[]={ 1, -1, 1, -1, 1, -1 };

void quickperm(void)
{
   unsigned int a[N], p[N+1];      
   register unsigned int i, j, k, tmp; 

   for(i = 0; i < N; i++)  
   {
      a[i] = i; 
      p[i] = i;
   }
   p[N] = N; 
   permsample(a);
   i = 1;   // setup first swap points to be 1 and 0 respectively (i & j)
   while(i < N)
   {
      p[i]--;
      j = 0;
      do
      {
         tmp = a[j];
         a[j] = a[i];
         a[i] = tmp;
         j++;
         i--;
      } while (j < i);
     permsample(a);
      i = 1; 
      while (!p[i])
      {
         p[i] = i;
         i++; 
      } // while(!p[i])
   } // while(i < N)
} // quickperm()


void permsample(int a[])
{
  int i, ok=1, sum=0;

  for(i=0; i<N; i++)
  {
  sum+=tab[a[i]];
  if(sum<0)
    {
    ok=0;
    break;
    }
  }
  if(ok)
    {
    for(i=0; i<N; i++)
    {
      if(tab[a[i]]==1)
        printf("(");
      else
        printf(")");
    }
    printf("\n");
    }

}

void main()
{
  int i;
  quickperm();
  exit(000);
}
