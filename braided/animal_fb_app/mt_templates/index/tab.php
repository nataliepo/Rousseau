<?php 
   require_once ('config.php');
?>

<mt:include module="fb_css">

<h1>Recently on <a href="<mt:blogurl>"><mt:blogname></a>...</h1>
<br />

<mt:entries>

<div class='wallkit_frame clearfix'>
    <div class='wallkit_post'>
         <mt:ignore>
        <div class='wallkit_profilepic'>
            <img src="<mt:var name="mt_url"><mt:authoruserpicurl>" />
        </div>
        </mt:ignore>

        <div class='wallkit_postcontent clearfix'>

              <h4><mt:authorname> posted <a href="<mt:entrypermalink>"><mt:entrytitle></a></h4>
              <mt:ignore>
              <div class='braided_entry_outer'>
                  <mt:entryassets limit="1">
                  <img src="<mt:asseturl>" />
                  </mt:entryassets>
              </div>
              </mt:ignore>
              
               <div class='braided_entry'>
                    <p><mt:entrybody></p>
               </div>
               
               
               <div class='commentable_item'>
                  <fb:comments xid='fb-animals-<mt:entryid>' can_post='true' candelete='false'>
                  </fb:comments>
               </div>
   </div>
</div>
                  
                  

</mt:entries>
