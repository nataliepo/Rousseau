#!/usr/bin/perl
use strict;

use JSON;
use LWP::UserAgent;
my $ua = new LWP::UserAgent;

#my $param = { 'url' => #'http://nataliepo.typepad.com/nataliepo/2010/03/mindy-kaling-and-her-twitter-machine.html#' };
my $param = 'url=http://nataliepo.typepad.com/nataliepo/2010/03/mindy-kaling-and-her-twitter-machine.html';
print "PARAM = $param\n";
#my $json = encode_json($param);

#print "JSON = $json\n";

my $response = $ua->post('http://dev3.apperceptive.com/rousseau/comments.php',
   [
      'url' =>  'http://nataliepo.typepad.com/nataliepo/2010/03/the-questions-on-everyones-minds.html',
      'site_url' => 'http://api.typepad.com/blogs/6a00e5539faa3b883300e553bb10b78834/post-assets.json?max-results=5',
      'content' => '<h2>The Question on Everyones Minds: is Justin Bieber...</h2>',
      'timestamp' => '2010-03-22 18:20:25'
   ]);


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
