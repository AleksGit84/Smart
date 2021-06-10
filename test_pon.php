<?php
include "header.php";
?>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
<TBODY>
<TR>
<TD>
<CENTER><B>PON ONU information</B></CENTER><BR>
<a href="pon.php?ip=10.111.13.2">OLT Черноморская дорога 119</a><br>
<a href="pon.php?ip=10.111.192.2">OLT Маршала Говорова 10в</a></br>
<a href="pon.php?ip=10.111.176.2">OLT-1 ж/м Радужный</a><br>
<PRE>
<?php

//if(isset($_GET['ip'])) {} else { exit; }

//$ip = $_GET['ip'];

require_once ("PHPTelnet.php");

$Telnet = new PHPTelnet();

$result = $Telnet->Connect("10.111.176.2", "admin", "!rfhfynby!");
//$result = $Telnet->Connect("$ip", "admin", "!rfhfynby!");

switch ($result) {
case 0:

$Telnet->DoCommand("enable", $trash);
$Telnet->DoCommand("terminal width 256", $trash);
$Telnet->DoCommand("terminal length 512", $trash);
$Telnet->DoCommand("show epon onu-information", $info );
$info=substr($info,27);
print_r ($info);
$Telnet->DoCommand("exit", $trash);
$Telnet->DoCommand("exit", $trash);

break;
}
$Telnet->Disconnect();
//echo $info;

?>

</PRE>
</TD></TR></table>
<?php
include "footer.php";
?>
