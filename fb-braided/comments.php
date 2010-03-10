<?php

include('utilities.php');

$user = $_POST['fb_sig_profile_user'];
require_once 'includes/facebook.php';
$appapikey = 'ee8e855f33bdb1f255dad718eaf65342';
$appsecret = 'b97215368c83caedaeab91922d407f51';
$facebook = new Facebook($api_key, $secret);
$session_key = md5($facebook->api_client->session_key);
session_id($session_key);
session_start();

function print_as_table($array) {
      print "<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
      foreach(array_keys($array) as $key) {
          print "<tr><td>$key</td><td>$array[$key]</td></tr>";
      }
      print "</tbody></table>";
  }
  
  print "<h2>GET table:</h2>";
  print_as_table($_GET);
  
  
  echo "<h3>Here are the comments for each entry:</h3>";
  
  <?php 

  $freebie_url = 'http://api.typepad.com/blogs/6a00e5539faa3b88330120a7aa0fdb970b/post-assets.json?max-results=5';
  $handle = fopen($freebie_url, "rb");
  $doc = stream_get_contents($handle);
  /*$doc = str_replace('callback(','',$doc);
  $doc = substr($doc,0,-1);*/

  $events = json_decode($doc);

  // NATALIE, LEFT OFF ATTEMPTING TO GET THE XID FOR POSTED COMMENTS
  
  foreach($events->{'entries'} as $entry) {
      $xid='braided_comments-' .  $entry->urlId;
      $comments = $facebook->api_client->comments_get('pete_comments');
      echo "<p>Post: " . $entry->title . ", comments = $comments</p>";
   }
   
   

  ?>
  
  
