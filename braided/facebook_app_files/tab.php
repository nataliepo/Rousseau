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
border-bottom:1px solid #D8DFEA;
margin:10px 10px 5px 0;
padding-bottom:5px;
}

.wallkit_post h4{
    font-size:13px;
}

.wallkit_post .wallkit_profilepic img {
display:block;
float:left;
margin:0 10px 10px 0;
width:50px;
height:50px;
}

.wallkit_post .wallkit_postcontent div {
padding:3px 0;
}

.wallkit_post div.wallkit_actionset {
font-size:11px;
padding-bottom:3px;
color:#777;
}

.wallkit_post div.wallkit_actionset .date{color:#777;}

.wallkit_post .wallkit_postcontent div {
padding:3px 0;
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

echo "<hr />";

foreach($events->{'entries'} as $entry) {
    echo 
"<div class='wallkit_frame clearfix'>
    <div class='wallkit_post'>
        <div class='wallkit_profilepic'>
            <img src='" . get_resized_avatar($entry->author, 35) . "' />
        </div>
        <div class='wallkit_postcontent clearfix'>
            <h4><span><a href='" . $entry->author->profilePageUrl . "'>" . $entry->author->displayName . "</a></span></h4>
            <div class='commentable_item' style='margin-left: 50px; padding-left: 10px'>
                <fb:comments xid='braided_comments-" . $entry->urlId . "' can_post='true' candelete='false'>      
                    <fb:title>" . 
                        get_title($entry) .  
                    "</fb:title> 
                </fb:comments>
            </div>
        </div>
    </div>
</div>";
 }

?>
