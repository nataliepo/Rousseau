<?php


/* EXAMPLES:
   
      Standard TypePad Blog:
         http://localhost/rousseau/generic_fb_app/typepad_comments.php?xid=6a00e5539faa3b883301310f284ed8970c&permalink=http://nataliepo.typepad.com/hobbitted/2010/02/some-ill-shit-is-overdue-in-the-hobbit-right-about-now.html&fb_prefix=braided_comments-   
      
      MTConnect Blog:
         http://localhost/rousseau/generic_fb_app/comments.php?blog_xid=6a00e5539faa3b88330120a94362b9970b&permalink=http://mtcs-demo.apperceptive.com/testmt/animals/2010/03/sea-otter.php&fb_id=fb-animals-60
   
   
      MTConnectBlog:
         http://dev3.apperceptive.com/rousseau/comments.php?blog_xid=6a00e5539faa3b88330120a94362b9970b&permalink=http://mtcs-demo.apperceptive.com/testmt/animals/2010/03/sea-otter.php&fb_id=fb-animals-60&HTML=1
      
      Standard TypePad Blog:
         http://dev3.apperceptive.com/rousseau/comments.php?xid=6a00e5539faa3b883301310f284ed8970c&permalink=http://nataliepo.typepad.com/hobbitted/2010/02/some-ill-shit-is-overdue-in-the-hobbit-right-about-now.html&fb_prefix=braided_comments-&HTML=1

*/
require_once ('rousseau-includes/rousseau-utilities.php');


start_db_connection();
$post = new Post($_POST);
//$post = new Post($_GET);

$comments = $post->comments();

/*
debug ("<h2>GET table:</h2>");
print_as_table($_GET);
  
debug("<h2>POST table:</h2>");
print_as_table($_POST);
*/




//if ($_GET['HTML']) {
if (array_key_exists('HTML', $_POST) && 
   ($_POST['HTML'])) {
   foreach ($comments as $comment){
   echo
   '   <div class="comment-outer">
         <div class="comment-avatar">
            <a href="' . $comment->author->profile_url . '"><img class="avatar" src="' . $comment->author->avatar. '" /></a>
         </div>
         <div class="comment-contents">
            <a href="' . $comment->author->profile_url . '">' . $comment->author->display_name . '</a>
            wrote <p>' . $comment->content . '</p> on ' . $comment->timestamp->print_readable_time() . '<br />' .
         '</div>
      </div>';
   }
}
else {
   echo 
'{
"comments" : [
';   

   if ($comments) {

      $num_events = sizeof($comments);
      $i = 0;
      foreach ($comments as $comment){

         echo 
'  {
   "content": "' . $comment->content . '",
   "timestamp": "' . $comment->timestamp->print_readable_time() . '",
   "author": {
      "displayName": "' . $comment->author->display_name . '",
      "profilePageUrl": "' . $comment->author->profile_url . '",
      "avatar": "' . $comment->author->avatar . '"
   }
}';
           if ($i != ($num_events -1)) {
              echo ",";
           }
           $i++;
        }
     }

     echo '
        ]
     }';   
}


  
/*   
  
   
   
*/   
clean_up();

  ?>
  
   
