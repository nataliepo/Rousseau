<?php 

require_once ('utilities.php');


$facebook = start_fb_session();
//start_db_connection();
include_local_css();
	
?>

<h1>Recent Posts</h1>

<?php 
   $site_id = $_GET['rousseau_id'];
   if (!$site_id) {
      $site_id = $_POST['rousseau_id'];
   }

   
$url = 'http://dev3.apperceptive.com/rousseau/posts.php?rousseau_id=' . $site_id;
$handle = fopen($url, "rb");
$doc = stream_get_contents($handle);
$events = json_decode($doc);
   
foreach ($events->{'entries'} as $entry) {
echo "
   <div class='wallkit_frame clearfix'>
      <div class='wallkit_post'>
         <div class='wallkit_postcontent clearfix'>" . 
            $entry->content . "
            
            <div class='commentable_item'>
               <fb:comments xid='" . $entry->xid .  "' can_post='true' candelete='false'>
               </fb:comments>
            </div>

         </div>
      </div>
   </div>";
}
?>
