<html>
    <head>
        <title>braided</title>
        
    </head>
    
    <body>
        
        <?php 
        /* 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $post_assets_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);
            curl_close($ch);
                  
            if ($json) {
                var_dump(json_decode($json));
            }
            else {
                echo "<p>there was a problem with that json feed.</p>";
            }
            
            
            echo "<p>json->{'entries'} is " . get_class($json["object"]) . "</p>";
            
            show_entries($json->{'entries'});
        */
        ?>
        
         <?php

                $entry_obj = "";

                // nataliepo blog's xid
                //$blog_xid = '6a00e5539faa3b883300e553bb10b78834';
                // freebie_2 blog's xid
                // $blog_xid = '6a0120a8e7be76970b0120a8e7be80970b';
                $blog_xid = '6a0120a7ee9b66970b0120a7ee9b6d970b';

              
                // this is the freebie post with TP comments:
                // http://freebie.typepad.com/blog/2010/03/bobama.html
                $post_xid = '6a0120a7ee9b66970b0120a920a705970b';

                $root_api_url = 'http://api.typepad.com/';
                $limit = 'max-results=1';
                
                $post_assets_url = $root_api_url . 'blogs/' .  $blog_xid . '/post-assets.js?' . 
                                $limit . '&callback=display_entry';
                $comments_url = $root_api_url . 'assets/' . $post_xid . '/comments.js?' . 
                            'callback=display_comments'; 
                
            ?>
        
        <!--<p>full URL is <?php echo $post_assets_url; ?></p>-->
        
        <script type="text/javascript" src="http://localhost/braided/braided_parser.js"></script>
        
       <div id="braided-entry"></div>
       <script type="text/javascript" src="<?php echo $post_assets_url; ?>"></script> 
       
       <div id="braided-comments"></div>
       <script type="text/javascript" src="<?php echo $comments_url; ?>"></script> 
       
        
    </body>
</html>