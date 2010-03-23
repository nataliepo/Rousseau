<?php

require_once ('rousseau-includes/rousseau-utilities.php');


$facebook = start_fb_session();
//start_db_connection();


//$post = new Post($_POST);
$post = new Post($_GET);
$comments = $post->comments();


   echo 
'{
"comments" : [
';   

   if ($comments) {

      $num_events = sizeof($comments);
      $i = 0;
      foreach ($comments as $comment){

         echo 
'  {
   "content": "' . $comment->content . '",
   "timestamp": "' . $comment->timestamp . '",
   "author": {
      "displayName": "' . $comment->author->display_name . '",
      "profilePageUrl": "' . $comment->author->profile_url . '",
      "avatar": "' . $comment->author->avatar . '"
   }
}';
           if ($i != ($num_events -1)) {
              echo ",";
           }
           $i++;
        }
     }

     echo '
        ]
     }';   

/*
function print_as_table($array) {
      print "<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
      foreach(array_keys($array) as $key) {
          print "<tr><td>$key</td><td>$array[$key]</td></tr>";
      }
      print "</tbody></table>";
  }
  */
  
//  debug ("GET table:</h2>");
//  print_as_table($_GET);
  
//  debug("<h2>POST table:</h2>");
//  print_as_table($_POST);
  
/*   
  
   
   
*/   
//clean_up();

  ?>
  
   
