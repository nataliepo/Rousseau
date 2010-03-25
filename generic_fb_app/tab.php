<?php 

require_once('rousseau-includes/rousseau-utilities.php');
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


//start_fb_session(get_fb_api_key($events->{'api_key'}), get_fb_api_secret($events->{'api_secret'}));
// Natalie, keying off of api keys passed from the json is not working right now.
start_fb_session('feb21f78c79d85b2d0c715dd1e12f947', '5b5a2bf5c965e757557e8e797c89c933');

   
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
