<?php

   require_once('rousseau-includes/rousseau-utilities.php');
   
   $right_now = time();
   
   $r_date = new RousseauDate($right_now);
   
   echo "Now is: " . $r_date->print_readable_time();
   echo "SQL-readable now is: " . $r_date->print_sql_time();

?>