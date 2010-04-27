#!/usr/bin/perl
use strict;

use JSON;
use LWP::UserAgent;

use URI::Escape;
my $ua = new LWP::UserAgent;


my $permalink = 'http://mtcs-demo.apperceptive.com/testmt/recent_news/2010/03/performance-artist-mimics-performance-artist-at-moma.php';
#my $param = { 'permalinkUrl' => $permalink };
my $param = {'permalinkUrl' => $permalink,
             'blog_xid' => '6a00e5539faa3b88330120a94362b9970b',
             'fb_id' => 'fb-animals-67',
             'HTML' => 1};
my $json = encode_json($param);


my $blog_xid = '6a00e5539faa3b883301';


#my $response = $ua->post("http://api.typepad.com/blogs/6a00e5539faa3b88330120a94362b9970b/discover-external-post-asset.json",
my $response = $ua->post('http://dev3.apperceptive.com/rousseau/comments.php', 
   Content => $json,
   "Content-Type" => "application/json");



my $content = $response->content;
if ($response->is_success) {
   print "Response = \"$content\"\n";
}
else {
   print "Response = \"$content\"\n";
   die $response->status_line;
}

print STDERR "*** SCRIPT COMPLETE ***\n";


# Comments are here: http://api.typepad.com/assets/6a00e5539faa3b883301310faa730f970c/comments.js
