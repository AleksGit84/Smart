<?php
require 'db.php';

if (isAuthorized())
{
    $file = '/tmp/temp-dump';
    $vlan = empty($_GET['vlan']) ? '' : '.' . $_GET['vlan'];
    $output = [];

    exec("sudo tcpdump -w $file -n -i em2{$vlan} -G 10 -W 1");
    exec("sudo tcpdump -r $file -ne | grep length | awk '{print $2}' | sort | uniq -c | sort -nr | head -n 10", $output);
    exec("sudo rm $file");

//    exec("sudo tcpdump -ne -c 1000 -i em2.15 | grep length | awk '{print $2}' | sort | uniq -c | sort -nr | head -n 10", $output);

    foreach ($output as &$item) {
        $item = preg_split('#\s+#', $item, null, PREG_SPLIT_NO_EMPTY);
    }

    header('Content-Type: application/json');
    echo json_encode($output);
}
