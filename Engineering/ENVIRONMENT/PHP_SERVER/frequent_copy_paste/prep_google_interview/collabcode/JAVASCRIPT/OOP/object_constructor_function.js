function person(n)
{
this.name=n;
this.show=function(){alert(this.name)};
}

me=new person("Michael");
me.show();