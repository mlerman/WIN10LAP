function f1(){ this.a1=11;}
function f2(){ this.a2=22;}

f1.prototype.polyf=function(){return this.a1;};
f2.prototype.polyf=function(){return this.a2;};

f31=new f1();
f32=new f2();

alert(f31.polyf() +f32.polyf());