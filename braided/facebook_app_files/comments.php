<h3>hello world -- comments </h3>

<?php

include('utilities.php');

$user = $_POST['fb_sig_profile_user'];
require_once 'includes/facebook.php';
$api_key = 'ee8e855f33bdb1f255dad718eaf65342';
$secret = 'b97215368c83caedaeab91922d407f51';
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
  
  print "<h2>POST table:</h2>";
  print_as_table($_POST);
  
  print "<br /><br /><Br /><br />";

  // NATALIE, LEFT OFF ATTEMPTING TO GET THE XID FOR POSTED COMMENTS
  /*
  foreach($events->{'entries'} as $entry) {
      $xid='braided_comments-' .  $entry->urlId;
      $comments = $facebook->api_client->comments_get('pete_comments');
      echo "<p>Post: " . $entry->title . ", comments = $comments</p>";
   }
   */
   
   echo "<br /><Br /><br />";
   echo "<p>Getting alpha_comment listing...</p>";
   $alpha_post_xid = 'braided_comments-6a00e5539faa3b883301310f284ed8970c';
   $alpha_comments = $facebook->api_client->comments_get($alpha_post_xid);
   
   
   echo "<p>Beginning alpha comment listing...</p>";
   
   echo "<p>hello nat-po!  $alpha_comments.count() \n</p>";

   echo "<ol>";
   //for ($i = 0; $i < $alpha_comments.count(); $i++) {
   for ($i = 0; $i < 5; $i++) {
       echo "<li>" . $alpha_comments[$i] . "</li>";
   }
   echo "</ol>";
   
   echo "<p>Ending alpha comment listing.</p>";
   
   // attempting to insert a row into th eDB.
   
   
   /*
   include('http://dev3.apperceptive.com/fb-braided/includes/db-config.php');


   // This is an example opendb.php
   $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      
       ('Error connecting to mysql');
   mysql_select_db($dbname);


   $result = MYSQL_QUERY("INSERT INTO comments (id, fb_comment_id) VALUES ('NULL', 1234)");

   echo "<p>Insert result = $result</p>";

   mysql_close($conn);
   */
   
   
   
   
   
   
   
/*   
   echo "<h2>Getting the comment information... </h2>";
   
   if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        
        $alpha_post_xid = $_GET['alpha_xid'];
        if (!$alpha_post_xid) {
            echo "<h3>[GET] Error!  An xid is required for comment retrieval.</h3>";
        }
        else {
            echo "<p>You requested xid=$alpha_post_xid and that comment value=</p>";
            $alpha_comments = $facebook->api_client->comments_get('braided_comments-' . $alpha_post_xid);
            echo "<p>Here are the comments: $alpha_comments</p>";
        }
    }
        
        
    else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

           $alpha_post_xid = $_GET['alpha_xid'];
           if (!$alpha_post_xid) {
               echo "<h3>[POST] Error!  An xid is required for comment retrieval.</h3>";
           }
           else {
               echo "<p>You requested xid=$alpha_post_xid and that comment value=</p>";
               $alpha_comments = $facebook->api_client->comments_get($alpha_post_xid);
               
               if ($alpha_comments ) {
                   echo "<p>The alpha_comments are good and here are the comments: $alpha_comments</p>";
               }
               else {
                   echo "<p>The alpha_comments were empty. :( </p>";
               }
            
           }
       }    
    echo "<h2>Finished getting the comment information. </h2>";
*/
    

  ?>
  
  
