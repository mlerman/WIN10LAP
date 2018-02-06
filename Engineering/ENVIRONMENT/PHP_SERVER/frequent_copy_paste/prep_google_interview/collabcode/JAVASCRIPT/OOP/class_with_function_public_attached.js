function showf(){alert(this.toto);};

function f()		// constructor and name of the class 
{
this.toto=3;
this.show=showf;	// public
}

obj = new f();
obj.show();