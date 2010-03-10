
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

require_once 'includes/facebook.php';

$appapikey = 'ee8e855f33bdb1f255dad718eaf65342';
$appsecret = 'b97215368c83caedaeab91922d407f51';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();


// Greet the currently logged-in user!
//echo "<h2>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</h2>";
/*
echo '<!-- include braided-includes/home.fbml -->';
echo '<fb:header>' + 'Hello, <fb:name uid="$user_id" />!</fb:header>';

echo "<p>My uid = $user_id.</p>";
*/
echo "<h1>The Latest From The <fb:name uid=<?=$user;?> linked='true' size='large' useyou='false' firstnameonly='false'/> Community</h1>";

echo "<h2>This is the ugly canvas page. Who needs it!?</h2>";

?>

