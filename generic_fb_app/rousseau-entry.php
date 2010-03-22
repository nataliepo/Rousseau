<?php
   require_once('utilities.php');
   
   
   
class Post {
   var $id;
   var $site_id;
   var $content;
   var $timestamp;
   
   function Post ($post_id) {
      
      $query = "select * from posts where id=" . $post_id . ";";
      $result = mysql_query($query);

      if (!mysql_result($result, 0, "id")) {
         debug ("Result for id request $post_id was null.");
      }
      
      $this->id = $post_id;
      $this->site_id = mysql_result($result, 0, "site_id");
      $this->content = mysql_result($result, 0, "content");
      $this->timestamp = mysql_result($result, 0, "timestamp");
   }
}


function grab_most_recent_event($site_id) {
   $query = "select * from posts where site_id=" . $site_id . " limit 1;";
   $result = mysql_query($query);
   
   return new Post (mysql_result($result, 0, "id"));
} 

function grab_recent_events($site_id) {
   $query = "select * from posts where site_id=" . $site_id . " order by timestamp desc;";
   
   $result = mysql_query($query);

   $recent_entries = array();

   for ($i = 0; $i < mysql_num_rows($result); $i++) {
      $recent_entries[$i] = new Post(mysql_result($result, $i, "id"));
   }
   
   return $recent_entries;
}
?>