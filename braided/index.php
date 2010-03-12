<html>
    <head>
        <title>braided</title>
        
        <?php
        
        
        
        function print_as_table($array) {
            print "<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
            foreach(array_keys($array) as $key) {
                print "<tr><td>$key</td><td>$array[$key]</td></tr>";
            }
            print "</tbody></table>";
        }
        
        ?>
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
            
        <p>All Posts URL is <?php echo $post_assets_url; ?></p>
        <p>Post URL is <?php echo $entry_url; ?></p>
        <p>Comments URL is <?php echo $comments_url; ?></p>
        
        
        <script type="text/javascript" src="http://localhost/braided/braided_parser.js"></script>
        
       <div id="braided-entry"></div>
       <script type="text/javascript" src="<?php echo $entry_url; ?>"></script> 
       
       <div id="braided-comments"></div>
       <script type="text/javascript" src="<?php echo $comments_url; ?>"></script> 
       
        
    </body>
</html>