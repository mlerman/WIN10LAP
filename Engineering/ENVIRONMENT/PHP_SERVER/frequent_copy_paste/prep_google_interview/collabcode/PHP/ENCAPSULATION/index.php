<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html;
        charset=iso-8859-1" />
        <title>OOP in PHP</title>
        <?php include("class_lib.php"); ?>
</head>
<body>
        <?php
                $stefan = new person();
				$jimmy = new person;
                $stefan->set_name("Stefan Mischook");
                $jimmy->set_name("Nick Waddles");
                echo "Stefan's full name: " . $stefan->get_name()."<br/>";
                echo "Nick's full name: " . $jimmy->get_name()."<br/>"; 
                // directly accessing properties in a class is a no-no.
                echo "Stefan's full name: ".$stefan->name."<br/>";
				$ml = new person("Michael Lerman");	// initialize with the constructor
                echo "ml's full name: ".$ml->get_name()."<br/>";

                /*  
                Since $pinn_number was declared private, this line of code 
                will generate an error. Try it out!   
                */  
                echo "Tell me private stuff: ".$stefan->pinn_number."<br/>";
				echo "Now is it hang? <br/>"


        ?>
</body>
</html>