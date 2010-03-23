<?php
   require_once('rousseau-includes/rousseau-utilities.php');



class Comment {
   var $author;
   
   var $content;
   var $timestamp;
   var $source;
   
   function Comment ($source, $params) {
      // source must be defined.
      
      $this->source = $source;
      
      if (array_key_exists('json', $params)) {
         $this->content = $params['json']->content;
         $this->xid = $params['json']->urlId;
                  
//         $date =  new DateTime($params['json']->published);
//         $this->timestamp = print_timestamp($date);
         $this->timestamp = new RousseauDate($params['json']->published);
         
         $author_params = array();
         $author_params['json'] = $params['json']->author;
         $this->author = new Author($author_params);
      }
      
      else {
         // otherwise, use the param keys to insert the comment data.
          $keys = array('content', );
          // treat 'timestamp' separately
          foreach ($keys as $key) {
             if (array_key_exists($key, $params)) {
                $this->$key = $params[$key];
             }
          }
          
          if (array_key_exists('timestamp', $params)) {
             $this->timestamp = new RousseauDate($params['timestamp']);
          }
          
          // check if there's an author.
          if (array_key_exists('author', $params)) {
             $this->author = new Author($params['author']);
          }
      }

   }
   
}


class TPCommentListing {
   var $tp_comments;
   
   
   function TPCommentListing($entry_xid) {
      $events = pull_json(get_comments_api_url($entry_xid));

      $i = 0;    
      $param = array();
      
      foreach($events->{'entries'} as $comment) {
         $param['xid'] = $comment->urlId;
         $param['json'] = $comment;
         $this->tp_comments[$i] = new Comment("TypePad", $param);
         $i++;
      }
   }
}

class FBCommentListing {
   var $fb_comments;
   
   function FBCommentListing ($fb_id) {
      $facebook = new Facebook(FACEBOOK_API_KEY, FACEBOOK_API_SECRET);
      $comments = $facebook->api_client->comments_get($fb_id);

      $num_comments = sizeof($comments);

      if (!$num_comments) {
         return;
      }
      
      for ($i = 0; $i < $num_comments; $i++) {
         $user_record = $facebook->api_client->users_getInfo($comments[$i]['fromid'], 
                                    'last_name, first_name, pic_with_logo, profile_url');

         $param = array();
         $param['content'] = $comments[$i]['text'];
//         $param['timestamp'] = get_fb_date($comments[$i]['time']);
         $param['timestamp'] = $comments[$i]['time'];
         
         $author = array();
         $author['display_name'] = $user_record[0]['first_name'] . ' ' . $user_record[0]['last_name'];
         $author['profile_url'] = $user_record[0]['profile_url'];
         $author['avatar'] = $user_record[0]['pic_with_logo'];
         
         $param['author'] = $author;
         
         $this->fb_comments[$i] = new Comment("Facebook", $param);
      }
   }
}

?>

