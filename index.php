<html>
    <head>
        <title>braided</title>
        
        <?php
        
            $entry_obj = "";

            // nataliepo blog's xid
            $xid = '6a00e5539faa3b883300e553bb10b78834';

            // freebie_2 blog's xid
            // $xid = '6a0120a8e7be76970b0120a8e7be80970b';
            
            $root_api_url = 'http://api.typepad.com/blogs/';
            $limit = '?max-results=10';
            $post_assets_url = $root_api_url . $xid . '/post-assets.json' . $limit;
        
        
            function show_entries ($entry_array) {
                echo '<ol>';
                for ($i = 0; $i < $entry_array.count(); $i++) {
                    echo '<li>' . $entry_array.title . '</li>';
                }
                echo '</ol>';
    
            }
        ?>
    </head>
    
    <body>
        <p>
            <?php
            
                echo "Hey, this is a <a href=\"http://www.mmmeow.com\"> " . 
                    "link to mmmeow.com</a>!";
            
            ?>
        </p>
        
        <h2>json dump below</h2>
        <?php
//            $json = file_get_contents($post_assets_url);

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
            
        ?>
        
        
    </body>
</html>