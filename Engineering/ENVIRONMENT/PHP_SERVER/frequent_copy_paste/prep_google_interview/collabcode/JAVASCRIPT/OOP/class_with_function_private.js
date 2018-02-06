function f()
{
this.toto=3;
function show(){alert(toto);};	// private
}

obj = new f();
obj.show();	// cannot call, it's private