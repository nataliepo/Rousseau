#!/usr/bin/perl
use strict;

use JSON;
use LWP::UserAgent;

use URI::Escape;
my $ua = new LWP::UserAgent;


my $url = 'http://nataliepo.typepad.com/nataliepo/2010/03/the-questions-on-everyones-minds.html';
#my $param = 'url=http://nataliepo.typepad.com/nataliepo/2010/03/mindy-kaling-and-her-twitter-machine.html';
print "URL = $url\n";
#my $json = encode_json($param);

my $encoded_entry = uri_escape('<h2>The Question on Everyones Minds: is Justin Bieber...</h2>');


#print "JSON = $json\n";

my $response = $ua->post("http://dev3.apperceptive.com/rousseau/comments.php&url=$url&content=$encoded_entry");


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
