<?php 

include('utilities.php');

$user = $_POST['fb_sig_profile_user'];
require_once 'includes/facebook.php';
$appapikey = 'ee8e855f33bdb1f255dad718eaf65342';
$appsecret = 'b97215368c83caedaeab91922d407f51';
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

<h1>The Latest From The <fb:name uid=<?=$user;?> linked='true' size='large' useyou='false' firstnameonly='false'/> Community</h1>

<?php 

$freebie_url = 'http://api.typepad.com/blogs/6a00e5539faa3b88330120a7aa0fdb970b/post-assets.json?max-results=5';
$handle = fopen($freebie_url, "rb");
$doc = stream_get_contents($handle);
/*$doc = str_replace('callback(','',$doc);
$doc = substr($doc,0,-1);*/

$events = json_decode($doc);


/*
<fb:comments xid="titans_comments" canpost="true" candelete="false" returnurl="http://apps.facebook.com/myapp/titans/"> 
    <fb:title>Talk about the Titans</fb:title> 
</fb:comments>
*/

echo "<hr />";
foreach($events->{'entries'} as $entry) {
    echo "<div class='wallkit_frame clearfix'><div class='wallkit_post'>";
    echo "<div class='wallkit_profilepic'><img src='" . get_resized_avatar($entry->author, 35) . "' /></div>";
    echo "<div class='wallkit_postcontent clearfix'><h4><span><a href='" . $entry->author->profilePageUrl . "'>" . $entry->author->displayName . "</a></span></h4>";
    echo "<fb:comments xid='braided_comments-" .  $entry->urlId . "' can_post='true' candelete='false' returnurl='http://apps.facebook.com/myapp/braided/comments.php'>" .      
         "<fb:title>" . $entry->title . "</fb:title></fb:comments></fb:like>";
/*    echo "<div class='wallkit_actionset'><a span class='date' href='" . $entry->permalinkUrl  . "'>" . 
        $entry->published . "</a>  · <a href='" . $entry->permalinkUrl . "'>Comments (" . 
        $entry->commentCount . ")</a>  · <a href='" . $entry->permalinkUrl .   "'>Favorites (" . 
        $entry->favoriteCount  . ")</a></div><fb:share-button class='meta' />";
*/
    echo "</div></div></div>";
 }

?>
