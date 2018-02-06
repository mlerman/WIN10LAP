<?php
class page
{
  /* declare some class properties as variables */
  var $name;
  var $note;
 
  /* Constructor is simply a function with same name as the class */
  public function page($name)
  {
	$this->name = $name;
  }
 
  /* To assign a value to the class variable - use $this-> */
  /* NOTE: the variablename when use in $this->, does NOT use the $ in front of variable name */
 
  public function set_note($note)
  {
	$this->note = $note;
  }
 
  /* function print out the contact detail information by appending the value of class variables */
  public function print_info()
  {
	$output = "Title: ".  $this->name ."<br/>".  "Note: ".$this->note."<br/>";
	return $output;
  }
} //end of class

?>