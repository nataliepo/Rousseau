<?php

require_once ('rousseau-includes/rousseau-utilities.php');


$facebook = start_fb_session();
start_db_connection();
$url = "";
$post = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   if (array_key_exists('url', $_GET)) {
      $url = $_GET['url'];
   }
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   //$xid = $_GET['xid'];
   $url = $_POST['url'];
}

if (array_key_exists('tp_xid', $_POST)) {
//   $post = new TPPost($_POST['tp_xid']);
   alert("THIS IS A TYPEPAD POST.");
}


if (array_key_exists('content', $_POST)) {
   $content = $_POST['content'];
   $site_url = $_POST['site_url'];
   
   $post = new Post($url, $_POST['site_url'], $_POST['content'], $_POST['timestamp']);
}
else if ($url) {
   $post = new Post ($url);
}


if ($post) {
   $xid = $post->get_fb_xid();
}
else {
   if (array_key_exists('xid', $_GET)) {
      $xid = $_GET['xid'];
   }
}
   
   
   $alpha_comments = $facebook->api_client->comments_get($xid);
 

   // printing the JSON-formatted comments now.
   echo 
'{
"xid" : "' . $xid . '",
"comments" : [
';   

   if ($alpha_comments) {

      $num_events = sizeof($alpha_comments);
      
      for ($i = 0; $i < $num_events; $i++) {
         $user_record = $facebook->api_client->users_getInfo($alpha_comments[$i]['fromid'], 'last_name, first_name, pic_with_logo, profile_url');

         echo 
'  {
   "content": "' . $alpha_comments[$i]['text'] . '",
   "timestamp": "' . $alpha_comments[$i]['time'] . '",
   "author": {
      "displayName": "' . $user_record[0]['first_name'] . ' ' . $user_record[0]['last_name'] . '",
      "profilePageUrl": "' . $user_record[0]['profile_url'] . '",
      "avatar": "' . $user_record[0]['pic_with_logo'] . '"
   }
}';
           if ($i != ($num_events -1)) {
              echo ",";
           }
        }
     }

     echo '
        ]
     }';   
     





function print_as_table($array) {
      print "<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
      foreach(array_keys($array) as $key) {
          print "<tr><td>$key</td><td>$array[$key]</td></tr>";
      }
      print "</tbody></table>";
  }
  
//  debug ("GET table:</h2>");
//  print_as_table($_GET);
  
//  debug("<h2>POST table:</h2>");
//  print_as_table($_POST);
  
/*   
  
   
   
*/   
clean_up();

  ?>
  
   
