<?php

require_once ('utilities.php');


$facebook = start_fb_session();
start_db_connection();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//   debug ("this is a GET request.");
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   debug ("this is a POST request.");
   //$xid = $_GET['xid'];
   $url = $_POST['url'];

   debug ("url = $url");
   if (array_key_exists('content', $_POST)) {
      $content = $_POST['content'];
      $site_url = $_POST['site_url'];
      
      $post = new Post($url, $_POST['site_url'], $_POST['content'], $_POST['timestamp']);
   }
   else {
      $post = new Post ($url);
   }
   
   
   if ($post) {
      $xid = $post->get_fb_xid();
      debug ("Facebook XID = $xid");
      $alpha_comments = $facebook->api_client->comments_get($post->get_fb_xid());

        // printing the JSON-formatted comments now.
        echo 
'{
   "entries" : [
';   

        if ($alpha_comments) {

           $num_events = sizeof($alpha_comments);
           //foreach ($events as $event) {
           for ($i = 0; $i < $num_events; $i++) {
           echo 
'  {
      "content": "' . $alpha_comments[$i]['text'] . '",
      "timestamp": "' . $alpha_comments[$i]['time'] . '"
   }';
              if ($i != ($num_events -1)) {
                 echo ",";
              }
           }
        }

        echo '
           ]
        }';   
      
   }
   

}

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
  
  
