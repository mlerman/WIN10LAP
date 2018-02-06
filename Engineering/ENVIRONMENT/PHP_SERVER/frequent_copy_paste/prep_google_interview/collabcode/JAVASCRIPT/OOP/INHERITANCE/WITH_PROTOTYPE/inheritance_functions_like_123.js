function cls1(){ this.a1=1; };
function cls2(){ this.a2=2; };

cls2.prototype=new cls1(); // dynamic inheritnace
cls3=new cls2();

alert(cls3.a1 + " " +cls3.a2);
