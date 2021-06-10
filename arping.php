<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>SoHo.NET :: ARP Ping Script</title>
</head>
<body>
<?php
// данные для соединения с базой
$dblocation = "192.168.11.74";
$dbname = "net_scan";
$dbuser = "net_scan_user";
$dbpasswd = "OAsj/v85oukSQ";
// Всякой херни на страницу

//  if (!($dbcnx=mysql_connect($dblocation,$dbuser,$dbpasswd))) {
if (!($dbcnx=mysqli_connect($dblocation,$dbuser,$dbpasswd))) {
	printf("Ошибка при соединении с MySQL !\n");
	exit();
	}

//  if (!mysql_select_db($dbname, $dbcnx)) {
if (!mysqli_select_db($dbname, $dbcnx)) {
	printf("Ошибка базы данных !");
	exit();
	}

?>
<div>
<?php

if ($_GET['arp_ip'])
$value_ip = explode(" ", $_GET['arp_ip']);
foreach($value_ip AS $host_ip) {
//	$host_ip = $value_ip[0];
	// ($_GET['network'])
	$value = explode(".", $host_ip);
	$network = $value[0].".".$value[1].".".$value[2].".0/24";
	$host_name = gethostbyaddr($host_ip);
	echo "<center><b>ARP Pinging ".$host_ip." (".$host_name.")</b></center>";
	$test = $value[0].".".$value[1];
//	echo "<br>";
	if ($test!="192.168") {echo "<b>ARP ping абонентов с Real IP не доступен</b>"; }
//		{
//		$o = mysql_fetch_array(mysql_query("select * from arp_scan WHERE network='".$network."'"));
    $o = mysqli_fetch_array(mysqli_query("select * from arp_scan WHERE network='".$network."'"));
		echo '<pre>';	
		//system("sudo dhcdrop -i ".$o['iface'].".".$o['vlanid']." -S ".$o['network']." -F ".$o['src_ip']."");	
//echo "sudo arping -c 5 -i ".$o['iface'].".".$o['vlanid']." -S ".$o['src_ip']." ".$host_ip."\n";	
		system("sudo /usr/sbin/arping -c 5 -i ".$o['iface'].".".$o['vlanid']." -S ".$o['src_ip']." ".$host_ip);	
	echo '</pre>';	
	$network = "";
	$o = "";
//	}
}
?>
</div>
<center><a href="javascript: window.close()"><b>Закрыть</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: window.location.reload()"><b>Повторить</b></a></center> 
</body></html>