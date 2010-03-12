<html>
    <head>
        <title>fb test</title>
 
    </head>
    
    <body>

    <h2>Facebook Comments</h2>
        
<?php

    require_once 'facebook_app_files/includes/facebook.php';

    // this is the Hobbited post that has comments on facebook to pull from
    $post_xid = '6a00e5539faa3b883301310f284ed8970c';
    
    if ( ($_SERVER['REQUEST_METHOD'] == 'GET') &&
        ( $_GET['xid'] != '')) {
            $post_xid = $_GET['xid'];
    }
    

    $api_key = 'ee8e855f33bdb1f255dad718eaf65342';
    $secret = 'b97215368c83caedaeab91922d407f51';
    $facebook = new Facebook($api_key, $secret);

    $alpha_post_xid = 'braided_comments-' . $post_xid;
    $alpha_comments = $facebook->api_client->comments_get($alpha_post_xid);

     for ($i = 0; $i < sizeof($alpha_comments); $i++) {
         $user_record = $facebook->api_client->users_getInfo($alpha_comments[$i]['fromid'], 'last_name, first_name, pic_with_logo, profile_url');
     
        echo 
'<div class="comment-outer">
    <div class="comment-avatar">
        <img src="' . $user_record[0]['pic_with_logo'] . '" />
    </div>
    <div class="comment-contents">
        <p>
        <a href="' . $user_record[0]['profile_url'] . '">' . $user_record[0]['first_name'] . ' ' . $user_record[0]['last_name'] . '</a>
        said ' . $alpha_comments[$i]['text'] . '</p>
    </div>
</div>';
     }?>  
    </body>
</html>