<?php
   require_once('rousseau-includes/rousseau-utilities.php');



class Comment {
   var $author;
   
   var $content;
   var $timestamp;
   var $source;
   
   function Comment ($source, $params) {
      // source must be defined.
      if ($source == "TypePad") {
//         if (array_key_exists('xid', $params))
      }
      
      if (array_key_exists('json', $params)) {

         $this->content = $params['json']->content;
         $this->xid = $params['json']->urlId;
         
         $author_params = array();
         $author_params['json'] = $params['json']->author;
         $this->author = new Author($author_params);
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

?>

