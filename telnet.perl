#!/usr/bin/perl
use Net::Telnet ();
$ip = $ARGV[0];
#$cmd1 = $ARGV[1];
$port = $ARGV[2];
if( $port != "" ) {
$cmd1 = "$ARGV[1] interface EPON 0/$ARGV[2]";
} else {
$cmd1 = $ARGV[1];
}
#print $port;
#print $ip;
$username = 'admin';
$passwd = '!rfhfynby!';

$t = new Net::Telnet(
    Timeout => 160,
    Prompt => '/PON-OLT.*$/',
#    input_log => "/var/log/swi_in.log",
    );
$t->open($ip);
$t->login($username, $passwd);
#$t->waitfor('/*PON*$/');
$t->cmd("enable");
#$t->cmd($passwd);
#$t->cmd("onu");
#$t->waitfor('/#/');
#$t->cmd("exit");
#@lines = $t->cmd("onu");
#@lines = $t->cmd("$cmd1 interface EPON 0/$port");
@lines = $t->cmd("$cmd1");
print @lines;
