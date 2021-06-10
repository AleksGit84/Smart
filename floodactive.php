<HTML>
<HEAD>
<TITLE>SoHo.NET - Flood table</TITLE>
</HEAD>
<BODY>
<center>
<button style="height: 22px; width: 100px; background-color:#b6dcee;" onclick="location.href='javascript: window.close()'">Close</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<button style="height: 22px; width: 100px; background-color:#b6dcee;" onclick="location.href='javascript: window.location.reload()'">Reload</button>
<br>
<br>
<?php
if(isset($_GET['macsearch'])) {

if($_GET['vlan'] != "" ) { $vlan =".".$_GET['vlan']; }
else { $vlan =""; }

if(isset($_GET['time'])){ $time = $_GET['time']; }
else { $time ="10"; }
echo "<table width=\"100%\" border=\"1\"><tr bgcolor=\"#b6dcee\"><td><b>Amount</b></td><td><b>User MAC</b></td></tr>";

   passthru ("sudo /usr/sbin/tcpdump -w /tmp/test12345 -n -i em2".$vlan." -G ".$time." -W 1 2>/dev/null");
//   passthru ("sudo /usr/sbin/tcpdump -r /tmp/test12345 -ne 2>/dev/null | /bin/grep length | /usr/bin/awk '{print $2}' | /usr/bin/sort | /usr/bin/uniq -c | /usr/bin/sort -nr | /usr/bin/head -n 30 | /bin/grep -v 00:02:17:72:98:00 | /usr/bin/awk '{print \"<tr><td>\"$1\"</td><td>\"$2\"</td></tr>\"}'");
   passthru ("sudo /usr/sbin/tcpdump -r /tmp/test12345 -ne 2>/dev/null | /bin/grep length | /usr/bin/awk '{print $2}' | /usr/bin/sort | /usr/bin/uniq -c | /usr/bin/sort -nr | /usr/bin/head -n 30 | /usr/bin/awk '{print \"<tr><td>\"$1\"</td><td>\"$2\"</td></tr>\"}'");
   passthru ("sudo /bin/rm /tmp/test12345");   
echo "</table>";
echo "</center>";
}
?>

<?php
if(isset($_GET['fulldump'])) {

if($_GET['vlan'] != "" ) { $vlan = ".".$_GET['vlan']; }
else { $vlan =""; }

if($_GET['param'] != "" ) { $param = "-".$_GET['param']; }
else { $param =""; }


if($_GET['mac'] != "" ) { $mac ="ether src ".$_GET['mac']; }
else { $vlan =""; }

if(isset($_GET['time'])){ $time = $_GET['time']; }
else { $time ="10"; }
echo "</center>";
echo "<pre>";
   passthru ("sudo /usr/sbin/tcpdump -w /tmp/test54321 -i em2".$vlan." -G ".$time." -W 1  2>/dev/null");
   passthru ("sudo /usr/sbin/tcpdump -r /tmp/test54321 ".$param." ".$mac." 2>/dev/null");
   passthru ("sudo /bin/rm /tmp/test54321");   
echo "</pre>";
}
?>


</BODY></HTML>

