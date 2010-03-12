<?php
require_once 'includes/facebook.php';

$appapikey = 'ee8e855f33bdb1f255dad718eaf65342';
$appsecret = 'b97215368c83caedaeab91922d407f51';
$facebook = new Facebook($appapikey, $appsecret);
$user_id = $facebook->require_login();
?>

<h3>Here's a Live Stream.</h3>
<?php

echo '<fb:live-stream event_app_id="ee8e855f33bdb1f255dad718eaf65342" width="400" height="500" /> ';

?>