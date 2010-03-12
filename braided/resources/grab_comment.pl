#!/usr/bin/perl

use strict;

use WWW::Facebook::API;
use Data::Dumper;

my $xid='braided_comments-6a00e5539faa3b883301310f284ed8970c';
my $appapikey = 'ee8e855f33bdb1f255dad718eaf65342';
my $appsecret = 'b97215368c83caedaeab91922d407f51';

my $client = WWW::Facebook::API->new(
    desktop => 0,
    api_key => $appapikey,
    secret => $appsecret,
);

my $response = $client->comments->get(
    xid => $xid,
);

print Dumper($response);