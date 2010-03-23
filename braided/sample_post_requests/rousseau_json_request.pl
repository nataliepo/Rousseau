#!/usr/bin/perl
use strict;

use JSON;
use LWP::UserAgent;
my $ua = new LWP::UserAgent;

my $param = { 'permalink' => 'http://nataliepo.typepad.com/nataliepo/2010/03/mindy-kaling-and-her-twitter-machine.html' };
print "PARAM = $param\n";
my $json = encode_json($param);

print "JSON = $json\n";

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
