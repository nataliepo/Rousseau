#!/usr/bin/perl
use strict;

use JSON;
use LWP::UserAgent;
my $ua = new LWP::UserAgent;

my $param = { 'permalinkUrl' => 'http://mtcs-demo.apperceptive.com/testmt/animals/2010/03/sloth.html' };
print "PARAM = $param\n";
my $json = encode_json($param);

print "JSON = $json\n";

my $response = $ua->post('http://api.typepad.com/blogs/6a00e5539faa3b88330120a94362b9970b/discover-external-post-asset.json',
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
