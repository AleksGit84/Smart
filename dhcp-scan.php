<?php
require 'db.php';

if (isAuthorized())
{
    require_once("PHPTelnet.php");

    // VLANs no arp inspection
    $rad = [2, 3, 4, 7, 11, 13, 14, 15, 16, 17, 24, 25, 26, 27, 29,
		36, 45, 48, 50, 51, 52, 54, 57, 58, 59, 69, 78, 79,
		88, 99, 111, 125, 150, 155, 160, 161, 162, 163, 164, 165, 166, 
		167, 168, 169, 170, 171, 171, 172, 173, 174, 175, 176, 
		177, 178, 179, 199, 201, 210, 211, 221, 222, 223, 225, 
		240, 241, 242, 243, 244, 245, 246, 249, 315, 410, 420, 430, 440,];
    // legal DHCP MACs
    $macs = [
	'24:44:27:b6:b8:68',
        'e8:04:62:1c:8d:80',
        'a4:4c:11:b8:e9:bc',
        '00:12:DA:27:AE:4A',
        '00:0B:45:6D:6C:0A',
        '00:0A:8B:BC:30:4A',
        '00:11:BC:34:CB:CA',
        '00:0C:86:A1:11:0A',
        '00:0C:CF:40:10:4A',
        '00:26:6C:FC:DA:4C',
	'38:90:A5:EB:AB:A5',
    ];

    $ignore = implode(' -l ', $macs);
    $vlan = $_GET['vlan'];
    $output = [];

    $arpInspection = function($vlan, $on = true) use ($output)
    {
        $Telnet = new PHPTelnet();
        $result = $Telnet->Connect("192.168.11.134", "cron", "!rfhfynby!");

        if ($on) {
            $action = '';
            $output[] = 'arp inspection ON';
        } else {
            $action = 'no ';
            $output[] = 'arp inspection OFF';
        }

        if ($result == 0) {
            $Telnet->DoCommand("configure terminal", $result);
            $Telnet->DoCommand("{$action}ip arp inspection vlan $vlan", $result);
            $Telnet->DoCommand("{$action}ip dhcp snooping vlan $vlan", $result);
            $Telnet->DoCommand("exit", $result);
            $Telnet->DoCommand("exit", $result);
        } else
            $output[] = 'Telnet connection error';

        $Telnet->Disconnect();
    };

    if ($vlan) { // проверяет если передан vlan
        if (!in_array($vlan, $rad)) { // если не присутствует ли переданный vlan в массиве $rad
            $arpInspection($vlan, false); // 'arp inspection OFF'
        }

        exec("sudo dhcdrop -t -i em2.$vlan -l $ignore", $output);

        if (!in_array($vlan, $rad)) { // если не присутствует ли переданный vlan в массиве $rad
            $arpInspection($vlan, true); // 'arp inspection ON'
        }
    }
    // если vlan присутствует в массиве $rad то ничего не делается
	
    header('Content-Type: application/json');
    echo json_encode($output);
}
