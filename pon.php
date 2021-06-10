<?php
include "header.php";
?>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
<TBODY>
<TR>
<TD>
<CENTER><B>PON ONU information</B></CENTER><BR>
<table style="width: 100%; border-collapse: collapse; border: 1px solid #000;";>
<?php
$file = fopen('olt.list', "r");
if ($file) {
while (!feof($file)) {
$string = fgets($file);
$value = explode(":", $string);
$port = 1;
echo "<tr style=\"border:1px solid black;\"><td>$value[1]</td>\n";
echo "<td>$value[0]</td>\n";
echo "<td>Зарегистрированные ONU <a href=\"pon.php?ip=$value[0]\">all</a></td>\n";
echo "<td>Port: ";
   while (($port <= $value[2]) && ($port <= 16)) {	
	echo "<a href=\"pon.php?ip=$value[0]&&port=$port\"> $port</a>,\n";
	$port = $port+1;
   }
echo "</td>\n";
echo "<td><a href=\"pon.php?signal=$value[0]\">Уровни сигнала ONU</a></td>\n";
echo "<td><a href=\"pon.php?log=$value[0]\">Syslog OLT</a></td></tr>\n";
}
}
else echo "Ошибка при открытии списка PON OLT";
fclose($file);
?>
</table>
<br>
<input type="text" name="srch" id="srch"> <input type="button" onclick="repl()" value="Найти">
<div id="div4ik">
<PRE>
<?php

if(isset($_GET['log'])) {
$ip = $_GET['log'];
print "<b>System log for PON OLT IP: $ip</b><br><br>";
//passthru ("/usr/bin/tail -n 100 /media/data/syslog/all/$ip.log 2>&1");
system("/usr/bin/tail -n 100 /media/data/syslog/all/$ip.log 2>&1");
}

if(isset($_GET['ip'])) {
$ip = $_GET['ip'];
$port = $_GET['port'];
print "<b>Зарегистрированные ONU на PON OLT IP: $ip порт $port</b><br><br>";
passthru ("./telnet.perl $ip onu $port");
}

if(isset($_GET['signal'])) {
$ip = $_GET['signal'];
print "<b>Уровни сигнала ONU на PON OLT IP: $ip</b><br><br>";
passthru ("./telnet.perl $ip signal");
}
// else { exit; }
?>

</PRE>
</div>
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
