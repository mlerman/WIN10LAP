var tab=[1,5,10,3,2];

var swapped=true;
while(swapped)
{
  swapped=false;
  for(i=0; i<tab.length-1 ; i++)
  {
    if(tab[i+1]<tab[i])
    {
    temp=tab[i];
    tab[i]=tab[i+1];
    tab[i+1]=temp;
    swapped=true;
    }
  }
}

tab.forEach(function(x){document.write(x+" ")});