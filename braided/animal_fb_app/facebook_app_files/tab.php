<?php 

require_once ('utilities.php');
require_once ('includes/facebook.php');

$user = $_POST['fb_sig_profile_user'];
$api_key = 'ee8e855f33bdb1f255dad718eaf65342';
$secret = 'b97215368c83caedaeab91922d407f51';
$facebook = new Facebook($api_key, $secret);
$session_key = md5($facebook->api_client->session_key);
session_id($session_key);
session_start();	
?>


<style>
.wallkit_post {
/*
   border-bottom:1px solid #D8DFEA;
   margin:10px 10px 5px 0;
   padding-bottom:5px;
*/
}

.gray_box {
/*
   border: 1px solid #FF99CC !important;
*/
   background-color: #FFFFFF !important;
   margin-top: -3px !important;
   margin-bottom: -3px !important;   
/*   
   height: 25px !important;

*/
   /* 
      background-color:#F7F7F7;
      border:1px solid #CCCCCC;
   */
}

.wallkit_post h4{
    font-size:13px;
}

.wallkit_post .wallkit_profilepic img {

   /* 
   display:block;
   float:left;
   margin:0 10px 10px 0;
   width:50px;
   height:50px;
   */
}

.wallkit_post .wallkit_postcontent div {
   padding:0 0 0 0 !important;
}

.wallkit_post div.wallkit_actionset {
/*
   font-size:11px;
   padding-bottom:3px;
   color:#777;
*/
}

.wallkit_post div.wallkit_actionset .date{
   color:#777;
}



/* Hiding the string below the last comment for now. 
 * May also be hiding pagination, but ignoring for now...
 */
.wallkit_subtitle {
   display: none;
}


.braided_thumbnail_outer {
   float: left;
   padding: 2px 2px;
   width: 150px;
}
.braided_thumbnail {
   max-height: 146px;
   max-width: 146px;
   border: 0pt;
}

.braided_entry {
/*
   overflow: auto;
   width: 450px;
*/
/*
   border:1px dotted #ccc;
*/
   padding: 2px 2px;
}
.braided_entry_outer { 
/*
   border: 2px solid #aaa;
*/
   width: 600px;
}
.commentable_item {
/*
   margin-left: 50px; 
   padding-left: 10px;
   border: 2px solid #660033;

*/
   width: 600px;
   height: 50px;
}

img.connected {
   display: none !important;
}

</style>

<h1>Recently on <a href="http://nataliepo.typepad.com/hobbitted>Hobbited</a>...</h1>

<?php 

$freebie_url = 'http://api.typepad.com/blogs/6a00e5539faa3b88330120a7aa0fdb970b/post-assets.json?max-results=5';
$handle = fopen($freebie_url, "rb");
$doc = stream_get_contents($handle);
/*$doc = str_replace('callback(','',$doc);
$doc = substr($doc,0,-1);*/

$events = json_decode($doc);


foreach($events->{'entries'} as $entry) {
    echo 
"<div class='wallkit_frame clearfix'>
    <div class='wallkit_post'>
        <div class='wallkit_profilepic'>
            <img src='" . get_resized_avatar($entry->author, 35) . "' />
        </div>
        
        <div class='wallkit_postcontent clearfix'>
        
            <h4><span><a href='" . $entry->author->profilePageUrl . "'>" . $entry->author->displayName . "</a></span></h4>
            <div class='braided_entry_outer'>";
        
        $thumbnail = get_first_thumbnail($entry->embeddedImageLinks);
        echo "
               <div class='braided_thumbnail_outer'>
            ";
        if ($thumbnail) {
           echo "
                  <img class='braided_thumbnail' src='" . get_first_thumbnail($entry->embeddedImageLinks) . "' />
               ";
        }
//        $date =  new DateTime($entry->published);        
//        $timestamp = print_timestamp($date);
        
        echo "
               </div>
        
               <div class='braided_entry'>
                  <a href='" . $entry->permalinkUrl . "'>" . get_title($entry) . "</a>
                  <p>" . chop_str($entry->content, 200) . "</p>
               </div>
            </div>
            
            <div class='commentable_item'>
               <fb:comments xid='braided_comments-" . $entry->urlId . "' can_post='true' candelete='false'>" .
                    /* <fb:title>" . 
                        get_title($entry) .  
                    "</fb:title> */
"              </fb:comments>
            </div>
         </div>
    </div>
</div>";
 }

?>
