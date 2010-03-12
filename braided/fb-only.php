<html>
    <head>
        <title>fb test</title>
 
    </head>
    
    <body>
        
         <?php

                require_once 'includes/facebook.php';


                $entry_obj = "";

                // nataliepo blog's xid
                //$blog_xid = '6a00e5539faa3b883300e553bb10b78834';
                // freebie_2 blog's xid
                // $blog_xid = '6a0120a8e7be76970b0120a8e7be80970b';
                $blog_xid = '6a0120a7ee9b66970b0120a7ee9b6d970b';

                //    print_as_table($_GET);
              
                // this is the freebie post with the fail giraffe as the default.
                // http://freebie.typepad.com/blog/2010/03/uh-oh.html
                $post_xid = '6a0120a7ee9b66970b0120a921523b970b';
                
                if ( ($_SERVER['REQUEST_METHOD'] == 'GET') &&
                    ( $_GET['xid'] != '')) {
                        $post_xid = $_GET['xid'];
                }

                $root_api_url = 'http://api.typepad.com/';
                $limit = 'max-results=1';
                
                $post_assets_url = $root_api_url . 'blogs/' .  $blog_xid . '/post-assets.js?' . 
                                $limit . '&callback=display_entry';
                $entry_url = $root_api_url . 'assets/' . $post_xid . '.js?' . 'callback=display_entry';
                $comments_url = $root_api_url . 'assets/' . $post_xid . '/comments.js?' . 
                            'callback=display_comments'; 
                
            ?>
            
        <!--<p>All Posts URL is <?php echo $post_assets_url; ?></p>
        <p>Post URL is <?php echo $entry_url; ?></p>
        <p>Comments URL is <?php echo $comments_url; ?></p> -->


        <h2>Facebook Comments</h2>
<?php
    // required facebook setup.
//    $user = $_POST['fb_sig_profile_user'];
    require_once 'includes/facebook.php';
    $api_key = 'ee8e855f33bdb1f255dad718eaf65342';
    $secret = 'b97215368c83caedaeab91922d407f51';
    $facebook = new Facebook($api_key, $secret);
//    $session_key = md5($facebook->api_client->session_key);
//    session_id($session_key);
//    session_start();
    
    
     
    //     $alpha_post_xid = 'braided_comments-6a00e5539faa3b883301310f284ed8970c';
    $alpha_post_xid = 'braided_comments-' . $post_xid;
     $alpha_comments = $facebook->api_client->comments_get($alpha_post_xid);


//     echo "<ol>"; 
     for ($i = 0; $i < sizeof($alpha_comments); $i++) {
/*         echo "<li>";
         echo " <br /><br />Full Dump: " . var_dump($alpha_comments[$i]) . " <br />";
*/
         $user_record = $facebook->api_client->users_getInfo($alpha_comments[$i]['fromid'], 'last_name, first_name, pic_with_logo, profile_url');

         
         $user_keys = array_keys($user_record[0]);
/*         for ($j = 0; $j < sizeof($user_keys); $j++) {
             echo $user_keys[$j] . " = " . $user_record[0][$user_keys[$j]] . "<br />";
         }
         echo "User record = $user_record <br />";

         echo "Text: " . $alpha_comments[$i]['text'] .  "<br /><br />" ; 
*/                
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
         

//         echo "</li>";
     }
 //    echo "</ol>";
     

?>
       

        
    </body>
</html>