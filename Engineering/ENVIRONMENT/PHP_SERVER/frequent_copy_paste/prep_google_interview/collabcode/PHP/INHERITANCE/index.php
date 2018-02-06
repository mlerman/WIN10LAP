<?php #Inheritance.php

   class Person
   {
	public $numberOfLegs = 2;
	
	public function __construct($name = 'unknown', $surname = 'unknown')
	{
		$this->name = $name;
		$this->surname = $surname;
	}//end constructor
	
	public function introduce()
	{
		echo "<p>Hello, my full name is <strong>
                         $this->name $this->surname</strong>.</p>";
		echo "<p>If you are interested, 
                         I can tell you I have $this->numberOfLegs legs.</p>";
	}//end introduce
	
   }//end Person
   
   /* using the keyword EXTENDS to make Student inherit from Person */
   class Student extends Person
   {
	public function __construct($name = 'unknown', 
                                                $surname = 'unknown', 
                                                $id = 0, 
                                                $topic = 'IT')
	{
		//ALWAYS call the parent constructor 
                //from a derived class
		parent::__construct($name, $surname);
		$this->id = $id;
		$this->topic = $topic;
	}//end constructor
		
	public function identify()
	{
		echo "<p>My student id is <strong>$this->id</strong>, 
			and I am studying <strong>$this->topic</strong></p>";
	}//end identify
		
    }//end Student

    //creating a new instance of STUDENT called 'bob'
    $b = new Student('Bob', 'Robertson', 15017, 'PHP');

    //using a Student method
    $b->identify();
	
    //using a method inherited from Person
    $b->introduce();
	

   /* 
   		My student id is 15017, and I am studying PHP
		Hello, my full name is Bob Robertson.
		If you are interested, I can tell you I have 2 legs.
   */
?>