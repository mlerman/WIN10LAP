<?php
        class person {
                var $name;					// with var it's public
                public $height;         
                protected $social_insurance;
                private $pinn_number;
				// optional constructor
                function __construct($persons_name) {           
                        $this->name = $persons_name;            
                }  
				// setter and getter
                function set_name($new_name) {
                    $this->name = $new_name;
                }
                function get_name() {
                    return $this->name;
                }
        }
?>