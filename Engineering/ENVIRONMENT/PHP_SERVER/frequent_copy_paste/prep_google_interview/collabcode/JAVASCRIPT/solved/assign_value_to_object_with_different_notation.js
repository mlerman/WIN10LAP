function f()
{
this.toto=33;
}

f1= new f();
alert(f1.toto);
f1.toto=7;
alert(f1.toto);
f1["toto"]=6
alert(f1.toto);

f2={titi:5};
alert(f2.titi);

