<?php
// FOR MT TESTING

    define ("FACEBOOK_POST_ID_PREFIX", "fb-animals-");
    define ("FACEBOOK_API_KEY", "336fb869587da7159dc0c56337183c3d");
    define ("FACEBOOK_API_SECRET", "d3db6494609e56aec9bf3392f69aff40");

    define ("DEFAULT_DEBUG_MODE", 0);
    
    define ("BLOG_XID", "6a00e5539faa3b88330120a94362b9970b");
    
    define ('CONSUMER_KEY', '63d5fd057d2d6eb7');
    define ('CONSUMER_SECRET', 'hmNdSsy7');
    define ('CALLBACK_URL', 'http://mtcs-demo.apperceptive.com/testmt/recent_news/index.php');
    
    define ('DB_HOST', 'localhost');
    define ('DB_USERNAME', 'rocky');
    define ('DB_PASSWORD', 'four');
    define ('DB_NAME', 'test_mt_client');
    
    
    
    define ('COOKIE_NAME', 'recent-news-session');
    

    include_once('tp-libraries/tp-utilities.php'); 
    include_once ("oauth/oauth-php-98/library/OAuthStore.php");
    include_once ("oauth/oauth-php-98/library/OAuthRequester.php");
?>