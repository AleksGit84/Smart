<?php
require 'db.php';

if (isAuthorized()) {

    $ip = empty($_GET['ip']) ? null : $_GET['ip'];
    $network = empty($_GET['network']) ? toNetwork($ip) : $_GET['network'];

    $source = lastOctet($network, 254);

//    $segment = mysql_fetch_object(mysql_query("SELECT * FROM radius_segment WHERE ip = '$network'"));
    $segment = mysqli_fetch_object(mysqli_query("SELECT * FROM radius_segment WHERE ip = '$network'"));

    if ($ip) {
        $hostName = gethostbyaddr($ip);
        $output[] = "ARP Pinging $ip ($hostName)";

        $exec = "sudo arping -c 5 -I em2.{$segment->vlan_id} {$ip}";
    } else {
        $exec = "sudo dhcdrop -i em2.{$segment->vlan_id} -S {$network}/24 -F {$source}";
    }

//    $output[] = $exec;
    exec($exec, $output);

    //    header('Access-Control-Allow-Origin: http://localhost');
    header('Content-Type: application/json');
    echo json_encode($output);
}
