<?php
#	include "db_connect/main.php";
include 'header.php';
include 'del_reg1.php';

print ( "<a href=manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&switch_view=1><b>Show</b></a>\n" );
print ( "<a href=manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&switch_view=0><b>Hide</b></a>\n" );
print ( "<a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=delete&qty_cur=1#switch1' onClick=\"return confirm('Are you sure you want to DELETE all UNREGISTERED MACs discovered not more than one time?');\"><img src='images/trash.gif' border=0 alt='DELETE all UNREGISTERED MACs discovered not more than one time'></a>\n" );
//print ( "<table cellSpacing=1 cellPadding=2 width=\"100%\" border=0 bgcolor=#ffffff>\n" );
//print ( "<tbody>\n" );
//print ( "<tr>\n" );
//print ( "<td width=50% bgColor=#ffffff>\n" );
//print ( "<td width=50% bgColor=#ffffff>\n" );
//print ( "</td>\n" );
//print ( "</td>\n" );
//print ( "</tr>\n" );
//print ( "</tbody>\n" );
//print ( "</table>\n" );
echo "<form name=frm1 method=post>";
print ( "<table cellSpacing=1 cellPadding=3 width=\"100%\" border=0>\n" );
print ( "<tbody>\n" );
print ( "<tr align=\"center\">\n" );
print ( "<td width=5% bgColor=#ffffff><b>Port</b></td>\n" );
print ( "<td width=15% bgColor=#ffffff><b>Registered<br>MACs</b></td>\n" );
print ( "<td width=15% bgColor=#ffffff><b>IP-address</b></td>\n" );
print ( "<td width=8% bgColor=#ffffff><b>Last<br>DATE</b></td>\n" );
print ( "<td width=15% bgColor=#ffffff><b>UNREGISTERED<br>MACs</b></td>\n" );
print ( "<td width=15% bgColor=#ffffff><b>IP-address</b></td>\n" );
print ( "<td width=8% bgColor=#ffffff><b>Last<br>DATE</b></td>\n" );
print ( "<td width=5% bgColor=#ffffff><b>QTY</b></td>\n" );
print ( "<td width=15% bgColor=#ffffff><b>Comments</b></td>\n" );
print ( "<td width=15% bgColor=#ffffff><b>Commands</b></td>\n" );
print ( "</tr>\n" );
print ( "</tbody>\n" );

$switch_num=0;

#������ � ���� ������ ���������� �� �����, ������� ����� ������������. ��� ������� ���������� � ������ �����
#����������� �������������� �����.

if ( $_GET['mac_registered'] )
{
$query_switches_select = "
					SELECT
						switches.switch_id,
						switches.switch_type_id,
						switches.switch_ip,
						switches.switch_address,
						switches.switch_comments,
						switches.switch_view,
						switches.switch_last_access,
						portstatus.mac";
#					portstatus.mac_cur";
$query_switches_from = "
					FROM
						switches AS switches,
						portstatus AS portstatus";
$query_switches_where = "
##					WHERE portstatus.mac='".$_GET['mac_registered']."' OR portstatus.mac_cur='".$_GET['mac_registered']."'
					WHERE portstatus.mac='".$_GET['mac_registered']."'
					AND portstatus.switch_id=switches.switch_id ";
$query_switches_order_by = "
					ORDER BY ";

#������ �� ���������
$query_switches .= $query_switches_select.$query_switches_from.$query_switches_where;
}
else
{
$query_switches_select = "
					SELECT
						switch_id,
						switch_type_id,
						switch_ip,
						switch_address,
						switch_comments,
						switch_view,
						switch_last_access";
$query_switches_from = "
					FROM
						switches";
$query_switches_where = "
					WHERE ";
$query_switches_order_by = "
					ORDER BY ";

#������ �� ���������
$query_switches .= $query_switches_select.$query_switches_from;
}

#���������� ������ ������� � ������ ��� ������� �������� � ����������
if ( $_GET['switch_segment'] >= 0 )
{
	$query_switches_where_if .= " ((switch_ip&65280)/256)='".$_GET['switch_segment']."' AND ";
	$query_switches_order_by_if .= "switch_ip, ";
}

if ( $_GET['switch_address_t2'] )
{
	$query_switches_where_if .= " switch_address='".urldecode( $_GET['switch_address_t2'] )."' AND ";
}

if ( $_GET['switch_ip_address'] )
{
	$query_switches_where_if .= " switch_ip='".$_GET['switch_ip_address']."' AND ";
}

#�������������� ������ �������, �������� ������ ����� � ����� �������
if ( $query_switches_where_if )
{
	$query_switches_where_if = substr( $query_switches_where_if, 0, strlen( $query_switches_where_if )-4 );
	$query_switches .= $query_switches_where.$query_switches_where_if;
}

if ( $query_switches_order_by_if )
{
	$query_switches_order_by_if = substr( $query_switches_order_by_if, 0, strlen( $query_switches_order_by_if )-2 );
	$query_switches .= $query_switches_order_by.$query_switches_order_by_if;
}


#������� ��������� ������� � ���������� ��� ����� ��������� � ��������� �������
//$results_switches = mysql_query($query_switches) or die("Query swicthes failed");
$results_switches = mysqli_query($query_switches) or die("Query swicthes failed");

$switch_info_error = 0;
//while ($row_switches = mysql_fetch_array( $results_switches, MYSQL_NUM )) {
while ($row_switches = mysqli_fetch_array( $results_switches, MYSQL_NUM )) {
	if ( $_GET['mac_registered'] )
	{
	$switch_num++;
    $switch_id=$row_switches[0];
    $switch_type_id=$row_switches[1];
    $switch_ip=long2ip($row_switches[2]);
    $switch_address=$row_switches[3];
    $switch_comments=$row_switches[4];
    $switch_view=$row_switches[5];
    $switch_last_access=$row_switches[6];
    $mac_reg=$row_switches[7];
	}
	else
	{
	$switch_num++;
    $switch_id=$row_switches[0];
    $switch_type_id=$row_switches[1];
    $switch_ip=long2ip($row_switches[2]);
    $switch_address=$row_switches[3];
    $switch_comments=$row_switches[4];
    $switch_view=$row_switches[5];
    $switch_last_access=$row_switches[6];
	}


    # Get switch type from DB
    $query_switches_type = "SELECT switch_type_model FROM switch_type WHERE `switch_type_id` = $switch_type_id";
//    $results_switches_type = mysql_query($query_switches_type) or die("Query swicthes failed");
//    $row_switch_type = mysql_fetch_array($results_switches_type);
	$results_switches_type = mysqli_query($query_switches_type) or die("Query swicthes failed");
	$row_switch_type = mysqli_fetch_array($results_switches_type);
    $switch_type_model = $row_switch_type[0];

    # Get MAC to ports correspondings from DB
    if ( $_GET['mac_registered'] )
    {
    	$query_ports = "SELECT port_id, mac, ip, mac_date, mac_cur, ip_cur, mac_cur_date, qty_cur, comments FROM portstatus WHERE mac='$mac_reg' AND `switch_id`=$switch_id ORDER BY `port_id` ASC";
    }
    else
    {
    	$query_ports = "SELECT port_id, mac, ip, mac_date, mac_cur, ip_cur, mac_cur_date, qty_cur, comments FROM portstatus WHERE `switch_id`=$switch_id ORDER BY `port_id` ASC";
    }
//    $results_ports = mysql_query($query_ports) or die("Query ports failed");
//    $results_ports2 = mysql_query($query_ports) or die("Query ports failed");
//    $mac_count = mysql_num_rows($results_ports);
	$results_ports = mysqli_query($query_ports) or die("Query ports failed");
	$results_ports2 = mysqli_query($query_ports) or die("Query ports failed");
	$mac_count = mysqli_num_rows($results_ports);
    $port_id_old = 0;
    $port_id_count = 0;
//    while ($row_ports = mysql_fetch_array($results_ports2, MYSQL_NUM)) {
	while ($row_ports = mysqli_fetch_array($results_ports2, MYSQL_NUM)) {
	$port_id = $row_ports[0];
	if ( $port_id != $port_id_old ) $port_id_count = $port_id_count + 1;
	$port_id_old = $port_id;
    }
//    mysql_free_result($results_ports2);
	mysqli_free_result($results_ports2);

    # Check&show last access time for switch
    $current_date=date("U");
    if ( ($current_date-$switch_last_access) > 3600 ) {
	$switch_last_access=date("d.m.Y H:i", $switch_last_access);
    	$switch_last_access="<font color='red' style='font-weight:bold;'>$switch_last_access <img src='images/help.gif' border='0' alt='Can NOT get MACs list from the switch more than 1 hour!'></font>";
    } else {
    	$switch_last_access=date("d.m.Y H:i", $switch_last_access);
    }

    # Print switch info
    echo "
    	<tr>
    		<td width=10% bgColor=#ffffff colspan=10>
    		<table width=100%>
    	<tr>
    		<td>";
#������ � ����� $switch_num) �� ������
    echo "
    	<b>
    	<a name='switch$switch_num'>
    	</a> $switch_num)
    	<a href=\"switch.php?cmd=edit&id=$switch_id\" title=\"Edit switch settings\"s>$switch_ip</a>
    	&nbsp&nbsp&nbsp
    	<a href=\"http://$switch_ip\" target=\"_blank\">
    	<img src=\"images/www.gif\" alt=\"Open WWW session to switch\" border=\"0\"></a>
    	&nbsp&nbsp&nbsp
    	<a href=\"telnet://$switch_ip\">
    	<img src=\"images/telnet.gif\" alt=\"Open telnet session to switch\" border=\"0\"></a>
    	&nbsp&nbsp&nbsp
    	<a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=delete&switch_id=$switch_id#switch$switch_num' onClick=\"return confirm('Are you sure you want to DELETE all MACs?');\">
    	<img src='images/trash.gif' border=0 alt='Delete ALL MACs from the switch'></a>
    	<br>$switch_address # $switch_type_model #</b>
    	<b>MACs:</b> $mac_count <b># Ports:</b> $port_id_count <b># Last access:</b> $switch_last_access";

    if ( $switch_view <> 0 ) {
        $switch_info=@snmpget($switch_ip, "MYpublic2K", ".1.3.6.1.2.1.1.3.0", "300000");
	if ( $switch_info != "" ) {
	    $switch_info_array=explode(" ", $switch_info);
    	    echo "<br>uptime: $switch_info_array[2] $switch_info_array[3] $switch_info_array[4]";
	    $switch_info_error=0;
	} else {
    	    echo "<br>uptime: <b><font color='red'>ERROR in getting uptime via SNMP request!</font></b>";
	    $switch_info_error=1;
	}
    }

    echo "</td><td align=\"center\" width=8%>";

    if ( $switch_view == 0 ) {
		echo "<a href=manager1.php?mac_registered=".$_GET['mac_registered']."&switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&switch_view=1&switch_id=$switch_id#switch$switch_num>
        <img src='images/closed.gif' border=0 alt='show'></a>";
    } else {
        echo "<a href=manager1.php?mac_registered=".$_GET['mac_registered']."&switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&switch_view=0&switch_id=$switch_id#switch$switch_num>
        <img src='images/opened.gif' border=0 alt='hide'></a>";

    }

    echo "</td></tr></table></td></tr>\n";

    # Read and analyse MACs
//    while ( $row_ports = mysql_fetch_array($results_ports, MYSQL_NUM )) {
	while ( $row_ports = mysqli_fetch_array($results_ports, MYSQL_NUM )) {
	$port_id=$row_ports[0];
	$mac=$row_ports[1];
	$ip=$row_ports[2];
	$mac_date_orig=$row_ports[3];
	if ($mac_date_orig == 0) {
    	    $mac_date="";
	} else {
	    $mac_date=str_replace(" ", "<BR>", date("H:i d.m.Y", $mac_date_orig));
	}

	$mac_cur=$row_ports[4];
	$ip_cur=$row_ports[5];
	$mac_cur_date_orig=$row_ports[6];
	if ($mac_cur_date_orig == 0) {
	    $mac_cur_date="";
	} else {
	    $mac_cur_date=str_replace(" ", "<BR>", date("H:i d.m.Y", $mac_cur_date_orig));
	}
	$qty_cur=$row_ports[7];
	if ($qty_cur == 0) $qty_cur = "";

	$comments=$row_ports[8];


	# Set alarm color
	$alarm_font = "<font color=''>";

	if ( $mac != "" ) {
	    # Set commands list for correct MACs
//	    Delete command
	    $commands="<a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=delete&switch_id=$switch_id&port_id=$port_id&mac=$mac#switch$switch_num' onClick=\"return confirm('Are you sure you want to DELETE this registered MAC?');\"><img src='images/trash.gif' border=0 alt='DELETE registered MAC from the switch'></a>";
	} else {
	    # Set commands for uncorrect MACs
//		Register command
		$zzz++;
	    $command1="<a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=register&switch_id=$switch_id&port_id=$port_id&mac_cur=$mac_cur&ip_cur=$ip_cur&mac_date_cur=$mac_cur_date_orig#switch$switch_num' onClick=\"return confirm('Are you sure you want to REGISTER this MAC?');\"><img src='images/register.gif' border=0 alt='REGISTER MAC'></a>";
//		Delete command
	    $command2="<a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=delete&switch_id=$switch_id&port_id=$port_id&mac_cur=$mac_cur#switch$switch_num' onClick=\"return confirm('Are you sure you want to DELETE this unregistered MAC?');\"><img src='images/trash.gif' border=0 alt='DELETE unregistered MAC from the switch'></a>
	    <input type='checkbox' name=ports[".$zzz."] value='".$switch_id.";".$port_id.";".$mac_cur."'";
	    $commands="$command1 &nbsp;$command2";
	}

	if ( $switch_view == 1 OR $mac_cur != "" OR $ip == "UNKNOWN" ) {
	    # Looking in DNS for hostname
	    $hostname = @gethostbyaddr($ip);
	    $hostname_cur = @gethostbyaddr($ip_cur);
	    if ( strstr($hostname, ".SoHo.NET.ua") ) {
	        $hostname = str_replace(".SoHo.NET.ua", "", $hostname);
	    } else {
	        $hostname = "";
	    }
	    if ( strstr($hostname_cur, ".SoHo.NET.ua") ) {
	        $hostname_cur = str_replace(".SoHo.NET.ua", "", $hostname_cur);
	    } else {
	        $hostname_cur = "";
	    }
	    # Get snmp port status
	    if ( $switch_info_error == 0 AND $switch_view == 1 ) {
		$port_status=@snmpget($switch_ip, "MYpublic2K", ".1.3.6.1.2.1.2.2.1.8.$port_id", "300000");
##		$port_admin_status=@snmpget($switch_ip, "MYpublic2K", ".1.3.6.1.2.1.2.2.1.7.$port_id", "300000");
		$port_admin_status=@snmpget($switch_ip, "MYpublic2K", ".1.3.6.1.2.1.17.2.15.1.4.$port_id", "300000");
		if (strstr($port_status, "up")) {
		    $port_status="<br><strong>up</strong>";
		    $alarm_font = "<font color='' style='font-weight:bold;'>";
		}
		if (strstr($port_status, "down")) $port_status="<br>down";
		if (strstr($port_admin_status, " 1")) $port_admin_status="<br><a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=port_off&switch_id=$switch_id&switch_ip=$switch_ip&port_id=$port_id#switch$switch_num' title='OFF port'><font color='green'><strong>on</strong></font></a>";
		if (strstr($port_admin_status, " 2")) {
		    $port_admin_status="<br><a href='manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."&cmd=port_on&switch_id=$switch_id&switch_ip=$switch_ip&port_id=$port_id#switch$switch_num' title='ON port'><font color='red'><strong>off</strong></font></a>";
		    $alarm_font = "<font color='' style='font-weight:bold;'>";
		}
	    } else {
		$port_status="";
		$port_admin_status="";
	    }

	if ($ip == "UNKNOWN") $alarm_font = "<font color='#2C42E5' style='font-weight:bold;'>";
	if ($mac_cur <> "") $alarm_font = "<font color='#FF3333' style='font-weight:bold;'>";

print <<<HERE
<tr align="center">

<td width=5% bgColor=#ffffff>
$alarm_font
$port_id
$port_status
$port_admin_status
</font>
</td>

<td width=15% bgColor=#ffffff>
$alarm_font
$mac
</font>
</td>

<td width=15% bgColor=#ffffff>
$alarm_font
$ip<br>
$hostname
</font>
</td>

<td width=8% bgColor=#ffffff>
$alarm_font
$mac_date
</font>
</td>


<td width=15% bgColor=#ffffff>
$alarm_font
$mac_cur
</font>
</td>

<td width=15% bgColor=#ffffff>
$alarm_font
$ip_cur<br>
$hostname_cur
</font>
</td>

<td width=8% bgColor=#ffffff>
$alarm_font
$mac_cur_date
</font>
</td>

<td width=5% bgColor=#ffffff>
$alarm_font
$qty_cur
</font>
</td>

<td width=15% bgColor=#ffffff>
$comments
</font>
</td>

<td width=15% bgColor=#ffffff>
$commands
</td>
</tr>

HERE;
    }
    }
//    mysql_free_result($results_ports);
//}
//mysql_free_result($results_switches);
	mysqli_free_result($results_ports);
}
mysqli_free_result($results_switches);

echo "</TBODY></TABLE>";
echo '<div align=right><input type=submit value=�������></div></form>';
include "footer.php";

?>
