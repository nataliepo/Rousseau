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

$freebie_url = 'http://api.typepad.com/blogs/6a00e5539faa3b88330120a7aa0fdb970b/post-assets.json';
$handle = fopen($freebie_url, "rb");
$doc = stream_get_contents($handle);
/*$doc = str_replace('callback(','',$doc);
$doc = substr($doc,0,-1);*/

$events = json_decode($doc);


foreach($events->{'entries'} as $entry) {
    echo "<div class='wallkit_frame clearfix'><div class='wallkit_post'>";
    echo "<div class='wallkit_profilepic'><img src='" . get_resized_avatar($entry->author, 35) . "' /></div>";
    echo "<div class='wallkit_postcontent clearfix'><h4><span><a href='" . $entry->author->profilePageUrl . "'>" . $entry->author->displayName . "</a></span></h4>";
    echo "<div>" . $entry->renderedContent . "</div>";
    echo "<div class='wallkit_actionset'><a span class='date' href='" . $entry->permalinkUrl  . "'>" . 
        $entry->published . "</a>  · <a href='" . $entry->permalinkUrl . "'>Comments (" . 
        $entry->commentCount . ")</a>  · <a href='" . $entry->permalinkUrl .   "'>Favorites (" . 
        $entry->favoriteCount  . ")</a></div><fb:share-button class='meta' />";
    echo "</div></div></div>";
 }


/*
$message = 'Check out this cute pic.'; 
$attachment = array( 'name' => 'i\'m bursting with joy', 
                    'href' => 'http://icanhascheezburger.com/2009/04/22/funny-pictures-bursting-with-joy/', 
                    'caption' => '{*actor*} rated the lolcat 5 stars', 
                    'description' => 'a funny looking cat', 
                    'properties' => 
                        array('category' => array( 
                            'text' => 'humor', 
                            'href' => 'http://www.icanhascheezburger.com/category/humor'
                            ), 
                        'ratings' => '5 stars'
                    ), 
                    'media' => array(
                        array('type' => 'image', 
                              'src' => 'http://icanhascheezburger.files.wordpress.com/2009/03/funny-pictures-your-cat-is-bursting-with-joy1.jpg',
                               'href' => 'http://icanhascheezburger.com/2009/04/22/funny-pictures-bursting-with-joy/'
                              )
                    ),
                    'latitude' => '41.4', 
                    //Let's add some custom metadata in the form of key/value pairs 
                    'longitude' => '2.19'
                ); 
$action_links = array( 
    array('text' => 'Recaption this', 
          'href' => 'http://mine.icanhascheezburger.com/default.aspx?tiid=1192742&recap=1#step2')); 
$attachment = json_encode($attachment); 
$action_links = json_encode($action_links); 
$facebook->api_client->stream_publish($message, $attachment, $action_links);


$message = 'in ur tubez'; 
$facebook->api_client->stream_publish($message);
*/
?>
