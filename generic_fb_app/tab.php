<?php 

require_once ('utilities.php');


start_fb_session();
include_local_css();
	
?>

<h1>Recent Posts</h1>

<?php 



   $site_id = $_GET['rousseau_id'];
   if (!$site_id) {
      $site_id = $_POST['rousseau_id'];
   }

$events = grab_recent_events($site_id);


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


clean_up();
?>
