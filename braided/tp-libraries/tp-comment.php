<?php
    define ("ROOT_TYPEPAD_API_URL", "http://api.typepad.com/");

    

    class CommentListing {
        var $post_xid;
        var $comment_array;

          
         function get_comments_api_url () {
            return ROOT_TYPEPAD_API_URL . 'assets/' . $this->post_xid . '/comments.json';
        }
        
        function build_comment_listing () {
            $comments_url = $this->get_comments_api_url();

            $handle = fopen($comments_url, "rb");
            $doc = stream_get_contents($handle);
            $events = json_decode($doc);
            
            $i = 0;    
            foreach($events->{'entries'} as $comment) {
                $this->comment_array[$i] = new Comment($comment);
                $i++;
            }
        }

        // contructor
        function CommentListing($post_xid = "") {
            $this->post_xid = $post_xid;
            $this->comment_listing = array();
            $this->build_comment_listing();
        }
        
        function get_post_xid() {
            return $this->post_xid;
        }
        
        function comment($index) {
            if ($this->comment_array[$index]) {
                return $this->comment_array[$index];
            }
            echo "<p>[CommentListing::comment] index[$index] is not available.</p>";
            return "";
        }
        
        function comments() {
            return $this->comment_array;
        }
    }
    
    /*****
     * utility features mostly borrowed from Tydget's typepad_parsing.js
     *****/
    function get_resized_avatar ($user, $size) {
        // use the lilypad as a default in case all else fails
        $default_avatar = 'http://up3.typepad.com/6a00d83451c82369e20120a4e574c1970b-50si';

        $links_array = $user->links;
        foreach ($links_array as $link) {
            if ($link->rel == "avatar") {
                if ($link->width < 125) {
                    return $link->href;
                } 
            }
        }

       return $default_avatar;
    }



class Comment {
    var $author_avatar;
    var $author_display_name;
    var $author_profile_page_url;
    var $content;
    
    // contructor
    function Comment($comment_json) {
    //    echo "<p>[Comment constructor] Creating new comment...";
        $this->author_avatar = get_resized_avatar($comment_json->author, 35);
        $this->author_display_name = $comment_json->author->displayName;
        $this->author_profile_page_url = $comment_json->author->profilePageUrl;
        $this->content = $comment_json->content;
   //     echo "...display_name = " . $this->author_display_name . ", content = " . $this->content . "</p>";
      }
      
    function get_content () {
        return $this->content;
    }
      
      
  }
    
?>


 