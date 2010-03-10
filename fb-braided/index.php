<h3>using localhost now</h3>
    <style type="text/css">
        h2 { margin: 0px; padding: 10px; font-family: Georgia, "Times New Roman", Times, serif; font-size: 200%; font-weight: normal; color: #FFF; background-color: #CCC; border-bottom: #BBB 2px solid; }
    </style>




<?php
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: Braided
// File: 'index.php' 
//   This is a sample skeleton for your application. 
// 

require_once 'facebook.php';

$appapikey = 'ee8e855f33bdb1f255dad718eaf65342';
$appsecret = 'b97215368c83caedaeab91922d407f51';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();

// Greet the currently logged-in user!
//echo "<h2>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</h2>";
echo "<h2>Hello, <fb:name uid=\"$user_id\" />!</h2>";


// Print out at most 25 of the logged-in user's friends,
// using the friends.get API method
echo "<p>Friends:";
$friends = $facebook->api_client->friends_get();
$friends = array_slice($friends, 0, 25);
foreach ($friends as $friend) {
  echo "<br>$friend";
}
echo "</p>";
?>

