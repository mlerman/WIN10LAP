function f()
{
this.toto=3;
this.show=function(){alert(this.toto);};	// public
}

obj = new f();
obj.show();