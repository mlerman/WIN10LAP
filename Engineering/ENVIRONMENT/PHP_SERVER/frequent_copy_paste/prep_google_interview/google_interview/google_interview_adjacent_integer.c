#include <stdio.h>
#include <stdlib.h>
#include <limits.h>
#define SIZE 6

main()
{
    char str[8] = "";
	const char *strs[] = { "2", "3", "3", "6", "1", "4" };
	int i, j, k, val, min;
	
	min=INT_MAX;
	for(i=1; i<SIZE ; i++)
	{
		printf("\n i: %d :", i);
		printf(" %s%s : %d%d largest : %d", strs[i-1], strs[i], atoi(strs[i-1]), atoi(strs[i]), atoi(strs[i-1])>atoi(strs[i])?atoi(strs[i-1]):atoi(strs[i]));
		// recompose
		for(j=0; j<SIZE ; j++)
		{
			if(j==i) 
			{
			str[j-1]= (atoi(strs[i-1])>atoi(strs[i])?strs[i-1][0]:strs[i][0]);
			str[j]='X';
			} else
			str[j]=strs[j][0];
		}
		str[SIZE]=0;
		printf(" %s", str);
		for(j=0; j<SIZE ; j++)
		{
			if(str[j]=='X') 
			{
				str[j]=str[j+1];
				str[j+1]='X';
			}
		}
		printf(" %s", str);
		
		val=atoi(str);
		if(val<min)
		{
			min=val;
		}

	}
	printf("\n result : %d \n", min);

}