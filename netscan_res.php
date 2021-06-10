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
<input type="text" name="srch" id="srch"> <input type="button" onclick="repl()" value="Найти">
<br><br>
<a href="netscan.php">Вернуться</a>
<br><br>
<div id="div4ik">
<?php

if ($_GET['network'])
{
//$o = mysql_fetch_array(mysql_query("select * from arp_scan WHERE network='".$_GET['network']."'"));
    $o = mysqli_fetch_array(mysql_query("select * from arp_scan WHERE network='".$_GET['network']."'"));
echo '<pre>';	
system("sudo dhcdrop -i ".$o['iface'].".".$o['vlanid']." -S ".$o['network']." -F ".$o['src_ip']."");	
echo '</pre>';	
}

?>
</div>
<br><br>
<a href="netscan.php">Вернуться</a>
</TD></TR></table>

<script type="text/javascript" >
stxt = document.getElementById('div4ik').innerHTML;
function repl()
{
	var sh = document.getElementById('srch').value;
	var re = '<font color=green style="background:yellow"><b>'+document.getElementById('srch').value+'</b></font>';

	var txt = stxt.split(sh).join(re);	
	document.getElementById('div4ik').innerHTML = txt;

}


</script>

<?php
include "footer.php";
                 
?>
