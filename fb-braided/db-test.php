<?php

include('includes/db-config.php');


// This is an example opendb.php
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      
    ('Error connecting to mysql');
mysql_select_db($dbname);


$result = MYSQL_QUERY("INSERT INTO comments (id, fb_comment_id) VALUES ('NULL', 1234)");


mysql_close($conn);

?>