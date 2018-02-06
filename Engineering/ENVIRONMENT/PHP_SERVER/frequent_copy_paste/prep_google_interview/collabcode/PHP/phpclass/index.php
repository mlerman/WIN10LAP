<?php
 
include ("page.php");
$my_page = new page("Title");    /* this calls the constructor and pass name to the class object */
 
$my_page->set_note("What this page does.");
 
echo $my_page->print_info();

?>