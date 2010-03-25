<?php


   $permalink = 'http://mtcs-demo.apperceptive.com/testmt/animals/2010/03/sloth.php';
   preg_match('|(http://[^/]+)|', $permalink, $matches);
   
   var_dump($matches);

?>