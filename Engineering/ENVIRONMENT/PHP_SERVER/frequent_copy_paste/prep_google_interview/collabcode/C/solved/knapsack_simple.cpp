#include <iostream>
#include <array>

using namespace std;


int n[4]={1,4,2,3};

int knapsack(int currentSum, int target, int index, int tab[]) 
 {
 cout <<"\n";
 for ( int i = index; i < 4 ; i ++) 
   {
   if (currentSum + tab[i] == target) 
     {
     cout<<"("<<tab[i]<<") ";
     return 0;
     // Success, we can stop searching
     }
   else if (currentSum + tab[i] < target) 
     {
       cout<<"("<<tab[i]<<") ";
      return knapsack(currentSum + tab[i] , target, index+1, tab);
     }
   }
 return currentSum;
 }
 

int main()
{
   if(knapsack(0, 10, 0, n)==0)
     {
     cout << ":) " << endl; 
     }
   else
     {
     cout << ":(" << endl; 
     }
   
   return 0;
}
