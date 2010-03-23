<?php
class Author {
    var $display_name;
    var $profile_url;
    var $avatar;
    
    function Author($params) {

       // Allow creationg of empty Author to allow
       // other services to override it.
    /*   if (!$xid) {
          return;
       }

       if (!$author_json) {
          $author_json = pull_json(get_author_api_url($xid));
       }*/
       
       if (array_key_exists('json', $params)) {
          $this->display_name = $params['json']->displayName;
          $this->profile_url = $params['json']->profilePageUrl;
          $this->avatar = get_resized_avatar($params['json'], 35);
       }
       
       // otherwise, use the param keys to insert the author data.
       $keys = array('display_name', 'profile_url', 'avatar');
       foreach ($keys as $key) {
          if (array_key_exists($key, $params)) {
             $this->$key = $params[$key];
          }
       }
    }
}