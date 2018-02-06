// bags of 6, 9, 17
tab = new Array();

function f(x)
{
  if(!x) {document.write(tab+' ok<br/>'); return true;}
  if(x<6) { document.write(x+' nope<br/>'); tab.pop(); return false;}

  tab.push('6'); f(x-6); 
  tab.push('9'); f(x-9); 
  tab.push('17');f(x-17); 

}

f(15);

// marche a moitie
//3 nope
//6,9 ok
//-8 nope
//6,9,9,6 ok
//-3 nope
//-11 nope
//-2 nope