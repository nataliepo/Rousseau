<?php
   require_once('rousseau-includes/rousseau-utilities.php');

class Post {
   var $id;
   var $xid;
   var $site_id;
   var $permalink;
   var $blog_xid;
   var $fb_id;
   var $timestamp;
   
   var $facebook;
   
   var $comment_listing;
   
   var $content;
      
   function Post ($params) {      
      // otherwise, use the param keys to insert the author data.
      $keys = array('xid', 'blog_xid', 'fb_id', 'permalink', 'content');
      foreach ($keys as $key) {
         if (array_key_exists($key, $params)) {
            $this->$key = $params[$key];
         }
         else {
            $this->$key = 0;
         }
      }
      
      if (array_key_exists('fb_prefix', $params) &&
         array_key_exists('xid', $params)) {
         $this->fb_id = $params['fb_prefix'] . $params['xid'];   
      }
      
         if ($this->blog_xid and $this->permalink) {
            $json = '{"permalinkUrl":"' . $this->permalink . '"}';
            
         $post_url = get_tpconnect_external_assets_api_url($this->blog_xid);
         $events = post_json($post_url, $json);
         $this->xid = $events->asset->urlId;
      }
      
      $this->comment_listing = array();
      
//         $this->site_id = lookup_fb_site($this->permalink);
      
      
      if ($this->content) {
         $this->content = urldecode($this->content);
      }

      
      $this->update_post_content();

      
      // IF we have a parent site, we should start a FB session.
      if ($this->site_id) {
         $this->facebook = start_fb_session(get_fb_api_key($this->site_id), get_fb_api_secret($this->site_id));
      }
   }
   
   
   function update_post_content() {
      $query = "SELECT * FROM posts WHERE posts_permalink='" . $this->permalink . "' LIMIT 1;";
      
      $result = mysql_query($query); 

      // This URL doesn't exist, so we'll make a new row.
      if (!mysql_num_rows($result)) {
         $escaped_content = str_replace("'", "\'", $this->content);
         $site_id = find_parent_site($this->permalink);
         $r_time = new RousseauDate($time());
         $create_query = "INSERT INTO posts (posts_content,posts_site_id,posts_timestamp,posts_permalink,posts_xid, posts_blog_xid) " . 
                     "VALUES (" . 
                        "'" . $escaped_content . "'," . 
                        $site_id . "," . 
                        "'" . $r_time->print_sql_time() . "'," . 
                        "'" . $this->permalink . "'," . 
                        "'" . $this->xid . "'," . 
                        "'" . $this->blog_xid . "'" . 
                     ");";
         $result = mysql_query($create_query);
         
      } 
      else {

         $this->id = mysql_result($result, 0, "posts_id");
         $this->site_id = mysql_result($result, 0, "posts_site_id");
         
         $content = mysql_result($result, 0, "posts_content");

         // if the text has changed, update the db.
         if (strlen($content) != strlen($this->content)) {
            $escaped_content = str_replace("'", "\'", $this->content);
            $query = "UPDATE posts SET posts_content ='" . $escaped_content . "' WHERE posts_id=" . $this->id . ";";
            $result = mysql_query($query); 
         }
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

function find_parent_site($permalink) {
   preg_match('|(http://[^/]+)|', $permalink, $matches);
   $base_url = $matches[0];

   $query = "SELECT * FROM sites WHERE sites_url like '" . $base_url . "%' LIMIT 1;";

   $result = mysql_query($query);
   
   if (!mysql_num_rows($result)) {
      return 0;
   }

   return mysql_result($result, 0, "sites_id");

}
?>