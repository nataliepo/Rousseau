<?php

require_once ('fb-includes/facebook.php');
require_once ('config.php');
require_once ('local_css.php');
require_once ('rousseau-entry.php');
require_once ('rousseau-comments.php');
require_once ('rousseau-authors.php');
require_once ('rousseau-date.php');


function get_contents ($entry) {
   return "<h3>Same contents for everybody!</h3>";
}

function start_fb_session ($api_key, $api_secret) {
   
   if (array_key_exists('fb_sig_profile_user', $_POST)) {
      $user = $_POST['fb_sig_profile_user'];
   }
   
   //global $facebook, $session_key, $api_key, $call_id, $format, $v;
   $facebook = new Facebook($api_key, $api_secret);
   $session_key = md5($facebook->api_client->session_key);
   session_id($session_key);
   session_start(); 

   /*
   $api_key = FACEBOOK_API_KEY;
   $call_id = microtime(true);
   $format = "JSON";
   $v = "1.0";
   */
      
   return $facebook;
}

function start_db_connection() {
   
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


/*
function grab_recent_events ($site_id){
   

   $json_url = grab_sites_url ($site_id);
   
   $handle = fopen($json_url, "rb");

   $doc = stream_get_contents($handle);

   return json_decode($doc);
   
}
*/


/*****
 * utility features mostly borrowed from Tydget's typepad_parsing.js
 *****/
function get_resized_avatar ($user, $size) {
    // use the lilypad as a default in case all else fails
    $default_avatar = 'http://up3.typepad.com/6a00d83451c82369e20120a4e574c1970b-50si';
    
    /*
     *  The links arrays were deprecated in R51 (04/2010)
    $links_array = $user->links;
    foreach ($links_array as $link) {
        if ($link->rel == "avatar") {
            if ($link->width < 125) {
                return $link->href;
            } 
        }
    }
    */
    if ($user->avatarLink) {
       return $user->avatarLink->url;
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



function debug ($msg) {
   if (DEFAULT_DEBUG_MODE) {
      echo '<p class="debug">' . $msg . '</p>';
   }
}

function post_json ($url, $params) {
   debug("<p class='request'>[POST_JSON], URL = <a href='$url'>$url</a>, params=$params</p>");


   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json;"));

   $result = curl_exec($ch);
   
   return json_decode($result);
}


function get_comments_wrapper($facebook, $xid) {   
  
   /*
   debug ("  api_key = $api_key");   
   debug ("  call_id = $call_id");
//   debug ("  sig = $sig");
   debug ("  v = $v");
   debug ("  session_key = $session_key");
   debug ("xid = $xid");
   debug ("object_id = $object_id");
   debug ("  format = $format");
   debug (" callback = $callback");
   */

   $result = $facebook->api_client->comments_get($xid);
   var_dump($result);
   debug ("comments_get() result = ^^");
   return $result;
   
}


/** 
 *   input: 
 *    $URL -- a full string to scrape the json data from
 *  output: 
 *    a json-decoded php object.
**/
function pull_json ($url) { 
   
   if (DEFAULT_DEBUG_MODE) {
      echo "<p class='request'>[PULL_JSON], URL = <a href='$url'>$url</a></p>";
   }
   $handle = fopen($url, "rb");
   $doc = stream_get_contents($handle);
   return json_decode($doc);
}

function get_entry_api_url ($xid) {
   return ROOT_TYPEPAD_API_URL . '/assets/' . $xid . '.json';
}


function get_comments_api_url ($xid) {
     return ROOT_TYPEPAD_API_URL . '/assets/' . $xid . '/comments.json';
}

function get_tpconnect_external_assets_api_url($xid) {
   return ROOT_TYPEPAD_API_URL . '/blogs/' . $xid . '/discover-external-post-asset.json';
}

function print_timestamp ($datetime) {
   return $datetime->format('F d, Y g:ia');
}

function get_fb_date($timestamp) {
   return date("F d, Y g:ia", $timestamp);        

/*
   return date("Y", $timestring);
       $this->month  =  date("m", $timestring);
       $this->day    =  date("d", $timestring);
       $this->hour   =  date("H", $timestring);
       $this->min    =  date("i", $timestring);
       $this->sec    =  date("s", $timestring);*/
}


function print_as_table($array) {
   print "<table border='1'><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
   foreach(array_keys($array) as $key) {
      print "<tr><td>$key</td><td>$array[$key]</td></tr>";
   }
   print "</tbody></table>";
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