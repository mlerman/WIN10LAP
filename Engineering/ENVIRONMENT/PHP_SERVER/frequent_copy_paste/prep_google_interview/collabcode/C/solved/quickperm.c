#include <stdio.h>
#define N 4

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
   for(k=0; k<N; k++) 
     printf("%d",a[k]);
   printf("\n");
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
     for(k=0; k<N; k++) // display
       printf("%d",a[k]);
     printf("\n");
     permsample(a);
      i = 1; 
      while (!p[i])
      {
         p[i] = i;
         i++; 
      } // while(!p[i])
   } // while(i < N)
} // quickperm()


void permsample(int tab[])
{

}

void main()
{
  quickperm();
  exit(000);
}
