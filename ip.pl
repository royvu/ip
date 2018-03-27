#!/usr/bin/env perl
## ArchLinux install package via pacman: perl-net-cidr-lite
use strict;
use warnings;
use Net::CIDR::Lite;
my $cidr = Net::CIDR::Lite->new;
while (my $line=<>) {
    $cidr->add($line);
}
$cidr->add("0.0.0.0/8");
$cidr->add("10.0.0.0/8");
$cidr->add("100.64.0.0/10");
$cidr->add("127.0.0.0/8");
$cidr->add("169.254.0.0/16");
$cidr->add("172.16.0.0/12");
$cidr->add("192.0.0.0/29");
$cidr->add("192.88.99.0/24");
$cidr->add("192.168.0.0/16");
$cidr->add("198.18.0.0/15");
$cidr->add("198.51.100.0/24");
$cidr->add("203.0.113.0/24");
$cidr->add("224.0.0.0/3");

foreach my $line( @{$cidr->list} ) {
    print "$line\n";
}
