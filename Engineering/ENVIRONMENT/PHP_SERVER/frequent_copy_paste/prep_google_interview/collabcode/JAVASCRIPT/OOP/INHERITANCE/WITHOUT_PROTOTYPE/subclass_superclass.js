function superf(){ return " super";}
function subf() { return " sub";}

function superClass()	// construct supper
{
this.sp=superf;	// attach superf()
}

function subClass()		// construct sub
{
this.heriteDe=superClass;
this.heriteDe();
this.sb=subf;	// attach subf()
}
//===========
var subClass = new subClass();
alert(subClass.sb() + subClass.sp() );