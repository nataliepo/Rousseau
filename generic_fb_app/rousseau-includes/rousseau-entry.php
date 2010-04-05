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
      $keys = array('xid', 'blog_xid', 'fb_id', 'permalink', 'content', 'site_id');
      foreach ($keys as $key) {
         if (array_key_exists($key, $params)) {
            $this->$key = $params[$key];
         }
         else {
            $this->$key = 0;
         }
      }
      
         if ($this->blog_xid and $this->permalink) {
            $json = '{"permalinkUrl":"' . $this->permalink . '"}';
            
         $post_url = get_tpconnect_external_assets_api_url($this->blog_xid);
         $events = post_json($post_url, $json);
         $this->xid = $events->asset->urlId;
         debug ("[Post::Post] this XID = " . $this->xid);
      }
      
      $this->comment_listing = array();      
      
      if ($this->content) {
         $this->content = urldecode($this->content);
      }

      if (!array_key_exists('READ_ONLY', $params)) {
         if (array_key_exists('fb_prefix', $params) &&
            array_key_exists('xid', $params)) {
            $this->fb_id = $params['fb_prefix'] . $params['xid'];   
         }

         $this->update_post_content();
         
         // IF we have a parent site, we should start a FB session.
         if ($this->site_id) {
            $this->facebook = start_fb_session(get_fb_api_key($this->site_id), get_fb_api_secret($this->site_id));
         }
      }
   }
   
   
   function update_post_content() {
      $query = "SELECT * FROM posts WHERE posts_permalink='" . $this->permalink . "' LIMIT 1;";
      
      $result = mysql_query($query); 

      // This URL doesn't exist, so we'll make a new row.
      if (!mysql_num_rows($result)) {
         debug("[update_post_content] Could not find this row in the posts table.");
         $escaped_content = str_replace("'", "\'", $this->content);
         $this->site_id = find_parent_site($this->permalink);
         $r_time = new RousseauDate(time());
         $this->timestamp = $r_time->print_sql_time();
         $create_query = "INSERT INTO posts (posts_content,posts_site_id," . 
                                             "posts_timestamp,posts_permalink,posts_xid," . 
                                             "posts_blog_xid, posts_fb_id) " . 
                     "VALUES (" . 
                        "'" . $escaped_content . "'," . 
                        $this->site_id . "," . 
                        "'" . $this->timestamp. "'," . 
                        "'" . $this->permalink . "'," . 
                        "'" . $this->xid . "'," . 
                        "'" . $this->blog_xid . "'," . 
                        "'" . $this->fb_id . "'" .
                     ");";
                     
         debug("[update_post_content] Insert query is $create_query");
         $result = mysql_query($create_query);
         
      } 
      else {

         $this->id = mysql_result($result, 0, "posts_id");
         $this->site_id = mysql_result($result, 0, "posts_site_id");
         $this->fb_id = mysql_result($result, 0, "posts_fb_id");
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
            $new_listing = array_merge($this->comment_listing, $tp_listing->comments());
            $this->comment_listing = $new_listing;
         }
         
         if ($this->fb_id) {
            $fb_listing = new FBCommentListing($this->fb_id, $this->facebook);
            $new_listing = array_merge($this->comment_listing, $fb_listing->comments());
            $this->comment_listing = $new_listing;
         }
      }
      
      $this->sort_comments();
          
      return $this->comment_listing;
   }
   
   function sort_comments () {
      $final_array = array();      
      $timestamps_array = array();
      
      foreach ($this->comment_listing as $comment) {
         $final_array[$comment->timestamp->print_sortable_time()] = $comment;
         $timestamps_array[] = $comment->timestamp->print_sortable_time();
         
      }    
//      krsort($final_array);
//      asort($final_array);
   
      sort($timestamps_array);

      $this->comment_listing = array();

      
      for ($i = 0; $i < sizeof($timestamps_array); $i++) {
         $this->comment_listing[] = $final_array[$timestamps_array[$i]];
      }
   }
}


function grab_recent_events($site_id) {
   $query = "select * from posts where posts_site_id=" . $site_id . " order by posts_timestamp desc;";
   $result = mysql_query($query);
   
   $recent_entries = array();

   for ($i = 0; $i < mysql_num_rows($result); $i++) {
      
      $params = array();
      $params['id'] = mysql_result($result, $i, "posts_id");
      $params['site_id'] = mysql_result($result, $i, "posts_site_id");
      $params['permalink'] = mysql_result($result, $i, "posts_permalink");
      $params['fb_id'] = mysql_result ($result, $i, "posts_fb_id");
      $params['content'] = mysql_result($result, $i, "posts_content");
      $params['xid'] = mysql_result($result, $i, "posts_xid");
      
      // Don't overwrite the existing contents.
      $params['READ_ONLY'] = 1;
      
      $recent_entries[$i] = new Post($params);
   }
   
   
   return $recent_entries;
}



 

?>