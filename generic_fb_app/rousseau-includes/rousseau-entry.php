<?php
   require_once('rousseau-includes/rousseau-utilities.php');

class Post {
   var $id;
   var $xid;
   var $site_id;
   var $permalink;
   var $blog_xid;
   var $fb_id;
   
   var $facebook;
   
   var $comment_listing;
      
   function Post ($params) {
      
      debug ("[POST::POST]");
      
      // otherwise, use the param keys to insert the author data.
      $keys = array('xid', 'blog_xid', 'fb_id', 'permalink');
      foreach ($keys as $key) {
         if (array_key_exists($key, $params)) {
            $this->$key = $params[$key];
         }
         else {
            $this->$key = 0;
         }
      }
      
      
      
      // if an XID and URL are passed, it's a TypePad post.
//      if (array_key_exists('xid', $params)) {
        if ($this->xid && $this->permalink) {
           debug ("[Post::Post] INSERT DB QUERY HERE...");
/*           $this->id = 0;
           $this->xid = $params['xid'];
         $this->permalink = $params['permalink'];
         $this->blog_xid = 0;
         //$entry_json = pull_json(get_entry_api_url($params['xid']));
*/
      }
      
      if (array_key_exists('fb_prefix', $params) &&
         array_key_exists('xid', $params)) {
         $this->fb_id = $params['fb_prefix'] . $params['xid'];   
      }
      
//      if (array_key_exists('blog_xid', $params) &&
//          array_key_exists('permalink', $params)) {
         if ($this->blog_xid and $this->permalink) {
//         $json = '{"permalinkUrl":"' . $params['permalink'] . '"}';
            $json = '{"permalinkUrl":"' . $this->permalink . '"}';
   
         
         $post_url = get_tpconnect_external_assets_api_url($this->blog_xid);
         $events = post_json($post_url, $json);
      //      var_dump($events);
         $this->xid = $events->asset->urlId;
      }
      
      
      $this->comment_listing = array();
      
      if ($this->permalink) {
         // check if this is a FB post.
         debug ("[Post::Post] permalink = $this->permalink");
         $this->site_id = lookup_fb_site($this->permalink);
      }
      
      // IF we have a parent site, we should start a FB session.
      if ($this->site_id) {
         $this->facebook = start_fb_session(get_fb_api_key($this->site_id), get_fb_api_secret($this->site_id));
      }
      
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
            $fb_listing = new FBCommentListing($this->fb_id, $this->facebook);
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
         $final_array[$comment->timestamp->print_sortable_time()] = $comment;
      }
      
      krsort($final_array);
      
      $this->comment_listing = $final_array;
   }
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



function get_fb_api_key($site_id) {
   $query = "select * from sites where sites_id=" . $site_id . " limit 1;";
   $result = mysql_query($query); 
   
   if (!mysql_num_rows($result)) {
      return 0;
   } 
   
   // otherwise, there was a result.
   return mysql_result($result, 0, "sites_fb_api_key");
}

function get_fb_api_secret($site_id) {
   $query = "select * from sites where sites_id=" . $site_id . " limit 1;";
   $result = mysql_query($query); 
   
   if (!mysql_num_rows($result)) {
      return 0;
   } 
   
   // otherwise, there was a result.
   return mysql_result($result, 0, "sites_fb_secret");
}
 
 
function lookup_fb_site($permalink) {
   $query = "select * from posts where posts_permalink='" . $permalink . "' limit 1;";
   $result = mysql_query($query); 

   if (!mysql_num_rows($result)) {
      debug ("NATALIE, INSERT THIS PERMALINK INTO THE POSTS TABLE.");
      return 0;
   } 

   // otherwise, there was a result.
   return mysql_result($result, 0, "posts_site_id");   
}

?>