<html>
    <head>
        <title>braided</title>
        
        <?php
            include_once('tp-libraries/tp-comment.php');
        ?>
        
    </head>
        
        
    <body>
        <h2>TypePad Demo!</h2>
        
        
        <?php
        
            $post_xid = '6a0120a7ee9b66970b0120a921523b970b';
                
            if ( ($_SERVER['REQUEST_METHOD'] == 'GET') &&
                ( $_GET['xid'] != '')) {
                    $post_xid = $_GET['xid'];
            }
            
            
            $comment_listing = new CommentListing($post_xid);
            $comments = $comment_listing->comments();
            
            for ($i = 0; $i < sizeof($comments); $i++) {
                echo 
'<div class="comment-outer">
    <div class="comment-avatar">
        <img src="' . $comments[$i]->author_avatar. '" />
    </div>
    <div class="comment-contents">
        <p>
            <a href="' . $comments[$i]->author_profile_page_url . '">' . $comments[$i]->author_display_name . '</a>
            said ' . $comments[$i]->content . '
        </p>
    </div>
</div>';
            }
        ?>
    
    </body>
</html>