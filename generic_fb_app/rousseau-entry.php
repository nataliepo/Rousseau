<?php
   require_once('utilities.php');
   
   
   
class Post {
   var $id;
   var $site_id;
   var $content;
   var $timestamp;
   var $permalink;
   
   function Post ($permalink, $site_url='', $content='', $timestamp='') {
      
      $query = "select * from posts where permalink='" . $permalink . "';";
      
      $result = mysql_query($query);

      if (!mysql_num_rows($result)) {
         debug ("Result for url $site_url was null.");
         $this->create_post_row($permalink, $site_url, $content, $timestamp);
        
         $query = "select * from posts where permalink='" . $permalink . "';";
         $result = mysql_query($query);
      }
      else {
         // don't update the row for now.
      }
      
      $this->id = mysql_result($result, 0, "id");
      $this->site_id = mysql_result($result, 0, "site_id");
      $this->content = mysql_result($result, 0, "content");
      $this->timestamp = mysql_result($result, 0, "timestamp");
      $this->permalink = mysql_result($result, 0, "permalink");
   }
   
   function get_fb_xid () {
      return "rousseau-" . $this->site_id . "-" . $this->id;
   }
   
   function create_post_row($permalink, $site_url, $content, $timestamp) {
      $query = "select * from sites where content_url='" . $site_url . "';";
      $result = mysql_query($query);
      if (!mysql_result($result, 0, "id")) {
         debug ("The site $site_url does not exist; dying for now.");
      }
      
      $site_id = mysql_result($result, 0, "id");
      
      $query = "insert into posts values ('',$site_id,'$content','$timestamp','$permalink');";

      $result = mysql_query($query);   
   }
}

function grab_post($permalink) {
   $query = "select * from posts where permalink='" . $permalink . "' limit 1;";
   $result = mysql_query($query);

   if (!$result) {
      return "";
   }
   else {
      return new Post(mysql_result($result, 0, "permalink"));
   }
}

function grab_most_recent_event($site_id) {
   $query = "select * from posts where posts.site_id=" . $site_id . " limit 1;";
   $result = mysql_query($query);
   
   return new Post (mysql_result($result, 0, "permalink"));
} 

function grab_recent_events($site_id) {
   $query = "select * from posts where site_id=" . $site_id . " order by timestamp desc;";
   $result = mysql_query($query);
   
/*
   while ($row = mysql_fetch_object($result)) {
      echo "row ID = " . $row->id;
      echo "row site_id = " . $row->site_id;
      echo "row permalink = " . $row->permalink;
      
   }
*/

   $recent_entries = array();


   for ($i = 0; $i < mysql_num_rows($result); $i++) {

      
      $permalink = mysql_result($result, $i, "permalink");
      $recent_entries[$i] = new Post($permalink);
   }
   
   
   return $recent_entries;
}
?>