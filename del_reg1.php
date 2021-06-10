<?php

function go_back ()
{
	print ( "<TABLE cellSpacing=1 cellPadding=2 width=\"100%\" border=0 bgcolor=#ffffff>\n" );
	print ( "<TBODY>\n" );
	print ( "<META http-equiv=\"refresh\" content=\"1;url=manager1.php?switch_segment=".$_GET['switch_segment']."&switch_ip_address=".$_GET['switch_ip_address']."&switch_address_t2=".urlencode( $_GET['switch_address_t2'] )."\">\n" );
	print ( "<tr>\n" );
	print ( "<td width=50% bgColor=#ffffff>\n" );
	print ( "Запрос обработан!\n" );
	print ( "<td width=50% bgColor=#ffffff>\n" );
	print ( "</td>\n" );
	print ( "</td>\n" );
	print ( "</tr>\n" );
	print ( "</TBODY>\n" );
	print ( "</TABLE>\n" );

}

foreach ($_POST['ports'] as $val)
{
	list($switch_id, $port_id, $mac_cur) = explode(";", $val);
  	echo "DELETE FROM portstatus WHERE `switch_id`=".$switch_id." AND `port_id`=".$port_id." AND `mac_cur`='".$mac_cur."'<br/>";

}

$cmd="";
if (isset($_GET['cmd'])) $cmd=$_GET['cmd'];
if ( $cmd == "delete" )
{
    if (isset($_GET['switch_id'])) $switch_id=$_GET['switch_id'];
    if (isset($_GET['port_id'])) $port_id=$_GET['port_id'];
    if (isset($_GET['mac'])) $mac=$_GET['mac'];
    if (isset($_GET['mac_cur'])) $mac_cur=$_GET['mac_cur'];
    if (isset($_GET['qty_cur'])) $qty_cur=$_GET['qty_cur'];

    # DELETE REGISTERED MAC from current switch
    if ( isset($switch_id) AND isset($port_id) AND isset($mac) ) {
	echo "DELETE FROM portstatus WHERE `switch_id`=$switch_id AND `port_id`=$port_id AND `mac`=\"$mac\"";

	//$results_delete_mac = mysql_query($query_delete_mac) or die("Query query_delete_mac failed");
        echo "DELETE OK: Switch id: $switch_id Port id: $port_id MAC: $mac";
//	header("Location: manager.php");
	//go_back();
	exit;
    }

    # DELETE UNREGISTERED MAC from current switch
    if ( isset($switch_id) AND isset($port_id) AND isset($mac_cur) ) {
	$mac_cur = str_replace('"', '\"', $mac_cur);
	echo "DELETE FROM portstatus WHERE `switch_id`=$switch_id AND `port_id`=$port_id AND `mac_cur`=\"$mac_cur\"";
	//$results_delete_mac_cur = mysql_query($query_delete_mac_cur) or die("Query query_delete_mac_cur failed");
	echo "DELETE OK: Switch id: $switch_id Port id: $port_id MAC: $mac_cur";
//	header("Location: manager.php", false );
	//go_back();
	exit;
    }

    # DELETE UNREGISTERED MAC from current switch discovered not more than one time
    if ( isset($qty_cur)) {
	echo "DELETE FROM portstatus WHERE `mac_cur`<>\"\" AND `qty_cur`=$qty_cur";
	//$results_delete_mac_cur = mysql_query($query_delete_mac_cur) or die("Query query_delete_mac_cur failed");
        echo "DELETE OK!";
//	header("Location: manager.php");
	//go_back();
	exit;
    }

    # DELETE ALL MACs from current switch
    if ( isset($switch_id) AND !isset($port_id) AND !isset($mac) AND !isset($mac_cur) ) {
	echo "DELETE FROM portstatus WHERE `switch_id`=$switch_id";
	//$results_delete_all_mac = mysql_query($query_delete_all_mac) or die("Query query_delete_all_mac failed");
        echo "DELETE OK: Switch id: $switch_id";
//	header("Location: manager.php");
	//go_back();
        exit;
    }
}

	if ( $cmd == "register" ) {
    if (isset($_GET['switch_id'])) $switch_id=$_GET['switch_id'];
    if (isset($_GET['port_id'])) $port_id=$_GET['port_id'];
    if (isset($_GET['mac_cur'])) $mac_cur=$_GET['mac_cur'];
    if (isset($_GET['mac_date_cur'])) $mac_date_cur=$_GET['mac_date_cur'];
    if (isset($_GET['ip_cur'])) $ip_cur=$_GET['ip_cur'];
    # REGISTER MAC
    echo "UPDATE portstatus SET `mac` = \"$mac_cur\", `ip` = \"$ip_cur\", `mac_date` = $mac_date_cur, `mac_cur` = \"\", `ip_cur` = \"\", `mac_cur_date` = 0, `qty_cur` = 0 WHERE `switch_id`=$switch_id AND `port_id`=$port_id AND `mac_cur`=\"$mac_cur\"";
    //$results_register_mac_cur = mysql_query($query_register_mac_cur) or die("Query query_register_mac_cur failed");
    echo "Registration OK: Switch id: $switch_id Port id: $port_id MAC: $mac_cur";
//    header("Location: manager.php");
	//go_back();
    exit;
}

if ( $cmd == "port_off" ) {
    if (isset($_GET['switch_id'])) $switch_id=$_GET['switch_id'];
    if (isset($_GET['switch_ip'])) $switch_ip=$_GET['switch_ip'];
    if (isset($_GET['port_id'])) $port_id=$_GET['port_id'];
    $port_off=snmpset($switch_ip, "KUKUMBER", ".1.3.6.1.2.1.17.2.15.1.4.$port_id", "i", "2", "300000");
//    header("Location: manager.php");
	//go_back();
    exit;
}

if ( $cmd == "port_on" ) {
    if (isset($_GET['switch_id'])) $switch_id=$_GET['switch_id'];
    if (isset($_GET['switch_ip'])) $switch_ip=$_GET['switch_ip'];
    if (isset($_GET['port_id'])) $port_id=$_GET['port_id'];
    $port_off=snmpset($switch_ip, "KUKUMBER", ".1.3.6.1.2.1.17.2.15.1.4.$port_id", "i", "1", "300000");
//    header("Location: manager.php");
	//go_back();
    exit;
}

# Check for view all ports to mac for the current switch
if (isset($_GET['switch_view'])) {
    $switch_view=$_GET['switch_view'];
    if (isset($_GET['switch_id'])) {
	$switch_id=$_GET['switch_id'];
	$where_switch_id="`switch_id`=$switch_id";
    } else {
	$where_switch_id="1";
    }
    # UPDATE switch_view in DB
    echo "UPDATE switches SET `switch_view` = $switch_view WHERE $where_switch_id";
    //$results_switch_view_update = mysql_query($query_switch_view_update) or die("Query query_switch_view_update failed");
//    header("Location: manager.php");
//	//go_back();
}
?>