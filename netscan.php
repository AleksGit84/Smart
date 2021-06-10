<?php
exit;
include "header.php";
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
<CENTER><B><a href="netscan.php">ARP сканирование</a></B></CENTER><BR>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
<TBODY>
<TR>
<TD>
<?php
$r = 0;
//$ql = mysql_query("select * from arp_scan order by network ASC");
//while($qlrow = mysql_fetch_array($ql)) {
$ql = mysqli_query("select * from arp_scan order by network ASC");
while($qlrow = mysqli_fetch_array($ql)) {
$a = explode('.',$qlrow['network']);
$skynet[$a[2]] = $qlrow['network'];
}
ksort($skynet);
foreach ($skynet as $term) {
$r++;
if ($r==19) { $r=1; echo '</td><td>'; }
?>
<a href="#" onclick="sbm('<? echo $term; ?>')"><? echo $term; ?></a><br/>
<?php
}

?>
</TD></TR></table>
<script type="text/javascript" >
function sbm(val)
{
	if (confirm("Сканировать?")) {
  		window.location.replace('netscan_res.php?network='+val);
	} else {
  		
	}
}
</script>
<?php
include "footer.php";
                 
?>