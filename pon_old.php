<?php
include "header.php";
?>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
<TBODY>
<TR>
<TD>
<CENTER><B>PON ONU information</B></CENTER><BR>
<a href="pon.php?ip=10.111.13.2">OLT Черноморская дорога 119</a><a href="pon.php?log=10.111.13.2">  -  Log</a><br>
<a href="pon.php?ip=10.111.192.2">OLT Маршала Говорова 10в</a><a href="pon.php?log=10.111.192.2">  -  Log</a></br>
<a href="pon.php?ip=10.111.78.2">OLT Красные зори</a><a href="pon.php?log=10.111.78.2">  -  Log</a></br>
<a href="pon.php?ip=10.111.227.2">OLT Львовская 15б</a><a href="pon.php?log=10.111.227.2">  -  Log</a></br>
<a href="pon.php?ip=10.111.97.2">OLT Царское село 2</a><a href="pon.php?log=10.111.97.2">  -  Log</a></br>
<a href="pon.php?ip=10.111.95.2">OLT Червоный хутор</a><a href="pon.php?log=10.111.95.2">  -  Log</a></br>
<a href="pon.php?ip=10.111.176.2">OLT-1 ж/м Радужный</a> <a href="pon.php?log=10.111.176.2">  -  Log</a><br> 
<a href="pon.php?ip=10.111.172.2">OLT-2 ж/м Радужный</a> <a href="pon.php?log=10.111.172.2">  -  Log</a><br> <br>
<PRE>

<?php

if(isset($_GET['log'])) {
$ip = $_GET['log'];
print "<b>System log for PON OLT IP $ip</b><br><br>";
passthru ("/usr/bin/tail -n 100 /media/data/syslog/all/$ip.log");
}

if(isset($_GET['ip'])) {
$ip = $_GET['ip'];
passthru ("./telnet.perl $ip");
} else { exit; }

?>

</PRE>
</TD></TR></table>
<?php
include "footer.php";
?>
