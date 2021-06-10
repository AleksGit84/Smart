#!/usr/bin/perl
use Net::Ping;

$d=1;
$p=Net::Ping->new("icmp", 1) or die bye;
while (1) {
        if ($p->ping($ARGV[0])) {
                printf("packet %d is OK \n", $d);
        } else {
                printf("packet %d is LOST \n", $d);
        }
        sleep(1);
        $d++;
}
$p->close;
