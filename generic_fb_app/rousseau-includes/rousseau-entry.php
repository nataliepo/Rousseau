<?php
   require_once('rousseau-includes/rousseau-utilities.php');

class Post {
   var $id;
   var $xid;
   var $site_id;
   var $permalink;
   var $blog_xid;
   var $fb_id;

   var $content;
   var $timestamp;
   
   var $comment_listing;
      
   function Post ($params) {
      
      // if an XID and URL are passed, it's a TypePad post.
      if (array_key_exists('xid', $params)) {
         debug ("[Post::Post] INSERT DB QUERY HERE...");
         $this->id = 0;
         $this->xid = $params['xid'];
         $this->permalink = $params['permalink'];
         $this->blog_xid = 0;
         
         $this->content = "<P>Dummy content for XID=" . $params['xid'] . " for now.</p>";
         $this->timestamp = '2010-03-14 14:29:25';
         
         //$entry_json = pull_json(get_entry_api_url($params['xid']));

      }
      
      if (array_key_exists('fb_prefix', $params) &&
         array_key_exists('xid', $params)) {
         $this->fb_id = $params['fb_prefix'] . $params['xid'];   

      }
      if (array_key_exists('fb_id', $params)) {
         $this->fb_id = $params['fb_id'];
      }
      
      if (array_key_exists('blog_xid', $params)) {
         $json = '{"permalinkUrl":"' . $params['permalink'] . '"}';
         
         $post_url = get_tpconnect_external_assets_api_url($params['blog_xid']);
         $events = post_json($post_url, $json);
      //      var_dump($events);
         $this->xid = $events->asset->urlId;
      }
      $this->comment_listing = array();
   }
   
   
   function comments() {
      if (!$this->comment_listing) {
         
         // Pull the TP Comment listing.
         if ($this->xid) {
            $tp_listing = new TPCommentListing($this->xid);
            $tp_comment_listing = $tp_listing->tp_comments;
            $new_listing = array_merge($this->comment_listing, $tp_comment_listing);
            $this->comment_listing = $new_listing;
         }
         
         if ($this->fb_id) {
            $fb_listing = new FBCommentListing($this->fb_id);
            $new_listing = array_merge($this->comment_listing, $fb_listing->fb_comments);
            $this->comment_listing = $new_listing;
         }
      }
      
      $this->sort_comments();
          
      return $this->comment_listing;
   }
   
   function sort_comments () {
      $final_array = array();
      foreach ($this->comment_listing as $comment) {
         $final_array[$comment->timestamp] = $comment;
      }
      
      krsort($final_array);
      
      $this->comment_listing = $final_array;
   }
   
   
      
      /*
      $query = "select * from posts where posts_permalink='" . $permalink . "';";
      $result = mysql_query($query);

      if (!mysql_num_rows($result)) {
//         debug ("Result for url $site_url was null.");
         $this->create_post_row($permalink, $site_url, $content, $timestamp);
        
         $query = "select * from posts where posts_permalink='" . $permalink . "';";
         $result = mysql_query($query);
      }
      else {
         // don't update the row for now.
//         debug ("That URL was located in the posts table.");
      }
      
      $this->id = mysql_result($result, 0, "posts_id");
      $this->site_id = mysql_result($result, 0, "posts_site_id");
      $this->content = mysql_result($result, 0, "posts_content");
      $this->timestamp = mysql_result($result, 0, "posts_timestamp");
      $this->permalink = mysql_result($result, 0, "posts_permalink");
   }
   
   function get_fb_xid () {
      return "rousseau_" . $this->site_id . "_" . $this->id;
   }
   
   function create_post_row($permalink, $site_url, $content, $timestamp) {
      $query = "select * from sites where sites_url='" . $site_url . "';";
      $result = mysql_query($query);
      if (!mysql_result($result, 0, "sites_id")) {
//         debug ("The site $site_url does not exist; dying for now.");
      }
      
      $site_id = mysql_result($result, 0, "sites_id");
      
      $query = "insert into posts values ('',$site_id,'$content','$timestamp','$permalink');";

      $result = mysql_query($query);   
      */
   }


function grab_post($permalink) {
   $query = "select * from posts where posts_permalink='" . $permalink . "' limit 1;";
   $result = mysql_query($query);

   if (!$result) {
      return "";
   }
   else {
      return new Post(mysql_result($result, 0, "posts_permalink"));
   }
}

function grab_most_recent_event($site_id) {
   $query = "select * from posts where posts_site_id=" . $site_id . " limit 1;";
   $result = mysql_query($query);
   
   return new Post (mysql_result($result, 0, "posts_permalink"));
} 

function grab_recent_events($site_id) {
   $query = "select * from posts where posts_site_id=" . $site_id . " order by timestamp desc;";
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

      
      $permalink = mysql_result($result, $i, "posts_permalink");
      $recent_entries[$i] = new Post($permalink);
   }
   
   
   return $recent_entries;
}





 

?>