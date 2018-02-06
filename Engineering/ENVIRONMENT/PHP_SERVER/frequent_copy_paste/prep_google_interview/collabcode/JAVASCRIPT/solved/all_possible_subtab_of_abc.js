var tab=['a','b','c'];

for(i=0; i<=7; i++)
{
  for(j=0; j<=2; j++)
  {
    if((1<<j) & i) 
    {
    document.write(tab[j]);
    }
  }
  document.write("<br/>");
}