function person(n)
{
this.name=n;
this.show=function(){alert(this.name)};
}

person.prototype.changename=function(newname){this.name=newname;}

me=new person("Michael");
me.changename("toto");
me.show();