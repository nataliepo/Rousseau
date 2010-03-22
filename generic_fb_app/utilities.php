<?php

require_once ('includes/facebook.php');
require_once ('config.php');
require_once ('local_css.php');

function get_contents ($entry) {
   return "<h3>Same contents for everybody!</h3>";
}

function start_fb_session () {

   $user = $_POST['fb_sig_profile_user'];
   $facebook = new Facebook(FACEBOOK_API_KEY, FACEBOOK_SECRET);
   $session_key = md5($facebook->api_client->session_key);
   session_id($session_key);
   session_start();
   
   
   // also connect to the local db.
   mysql_connect(DB_HOST,DB_USER,DB_PWD);
   @mysql_select_db(DB_NAME) or die( "Unable to select database '" . DB_NAME . "'.");
   
}

function clean_up () {
   mysql_close();
}

// required to use DateTime objects in php
date_default_timezone_set('America/New_York');

function grab_sites_url ($site_id) {
   
   $query = "select * from sites where id=" . $site_id . ";";
   
   $result = mysql_query($query);
   
   
   $url = mysql_result($result, 0, "content_url");
   return $url;
}


function grab_most_recent_event($site_id) {
   $query = "select * from posts where site_id=" . $site_id . " limit 1;";
   $result = mysql_query($query);
   
   return mysql_result($result, 0, "content");
}

function grab_recent_events ($site_id){
   

   $json_url = grab_sites_url ($site_id);
   
   $handle = fopen($json_url, "rb");

   $doc = stream_get_contents($handle);

   return json_decode($doc);
   
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


function get_title ($entry) {
    if ($entry->title) {
        return $entry->title;
    }
    
    return "[Untitled Entry]";
}

/** may want to provide a default thumbnail here...something in tp-config, perhaps. **/
function get_first_thumbnail ($embedded_array) {
    if (!$embedded_array) {
        return "";
    }
    
    return $embedded_array[0]->url;
}

function chop_str ($str, $size) {
    
    // Cut out the HTML/PHP from the entry body.
    
   $str = strip_tags($str);
   if (strlen($str) <= $size) {
      return $str;
   }
   
   $str_parts = array();
   $str_parts = explode(" ", $str);
   
   // now we have an array of words.
   $i = 0;

   $curr = "";
   $next = $str_parts[$i];
   while (strlen($next) < $size) {
      $curr .= $str_parts[$i] . ' ';
      $i++;
      $next .= $str_parts[$i] . ' ';
   }
  
   // chop the last space
   $curr = substr($curr, 0, (strlen($curr) - 1));
   return $curr . "...";
}

function print_timestamp ($datetime) {
   return $datetime->format('F d, Y g:ia');
}

function debug ($msg) {
   if (DEFAULT_DEBUG_MODE) {
      echo '<p class="debug">' . $msg . '</p>';
   }
}

?>
