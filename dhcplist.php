<?php
include "header.php";
include 'db.php';
//$con = mysql_connect('192.168.11.74','dhcp_master','nasd38rudsasucn');
?>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
    <TBODY>
    <TR>
        <TD>
            <CENTER><B><a href="dhcplist.php">DHCP servers finder</a></B></CENTER>
            <BR>

            <form action="dhcplist.php" method="get">
                <p>
                    <!--  <b>Vlan ID:</b><input type="text" name="vlan" size="4" maxlength="4" value=""> -->
                    <b>Vlan ID:</b><select name="vlan" size="1">
                        <!-- <option selected="selected" value="">all</option> -->
                        <?php
                        //$sql = "SELECT vlan_table.vlan_num, vlan_table.blade_num FROM vlan_table GROUP BY vlan_table.vlan_num ORDER BY vlan_table.vlan_num ASC";
                        $sql = "SELECT * FROM vlan ORDER BY id ASC";
//                        $result = mysql_query($sql);
//                        while ($row = mysql_fetch_object($result)) {
                        $result = mysqli_query($sql);
                        while ($row = mysqli_fetch_object($result)) {
//$vlanid = $row['vlan_num'];
                            echo "<option value=\"{$row->id}\">{$row->id}</option>\n";
                        }
                        ?>
                    </select>

                    <input type="submit" style="height: 22px; width: 200px; background-color:#b6dcee;" name="search"
                           value="DHCP search"/></p>
            </form>

            <?php
            if (isset($_GET['search'])) {
                require_once("PHPTelnet.php");

# Spisok Vlan ID BEZ arp inspection !!! #
                $rad = array("11", "211", "88", "160", "155", "161", "162", "163", "164", "165", "166", "167", "168", "169", "170", "171", "171", "172", "173", "174", "175", "176", "177", "178", "179", "240", "241", "242", "243", "244", "245", "246", "247", "248", "249");

                $vlan = $_GET['vlan'];

//                $con = mysql_connect('192.168.11.74', 'dhcp_master', 'nasd38rudsasucn');
//                echo "<PRE>\n";
//                if (!$con) {
//                    die('MySQL connection error: ' . mysql_error());
//                }
//                mysql_select_db('dhcp', $con);

//                $sql = "SELECT vlan_table.vlan_num FROM vlan_table WHERE vlan_table.vlan_num = " . $vlan;
//                $result = mysql_query($sql);

//                if (mysql_num_rows($result) != 0) {
                if ($vlan) {
                    echo "<b>test VLAN ID $vlan</b><br>";

                    if (!in_array($vlan, $rad)) {
                        $Telnet = new PHPTelnet();
                        $result = $Telnet->Connect("192.168.11.134", "cron", "!rfhfynby!");
                        switch ($result) {
                            case 0:
                                $Telnet->DoCommand("configure terminal");
                                $Telnet->DoCommand("no ip arp inspection vlan $vlan");
                                $Telnet->DoCommand("no ip dhcp snooping vlan $vlan");
                                $Telnet->DoCommand("exit");
                                $Telnet->DoCommand("exit");
                                break;
                        }
                        $Telnet->Disconnect();
                        echo "<b>arp inspection OFF</b><br>\n";
                    }
                    echo "<b>DHCP servers in vlan $vlan</b><br>\n"; //      N9K                  cisco 6500            Radujniy             Radujniy cisco          Radujniy cisco      Radujniy cisco      Radujniy cisco      Radujniy cisco       Radujniy cisco         DHCP-Server
                    passthru("sudo /usr/sbin/dhcdrop -t -i em2.$vlan -l 38:90:a5:eb:ab:a5 -l e8:04:62:1c:8d:80 -l a4:4c:11:b8:e9:bc -l 00:12:DA:27:AE:4A -l 00:0B:45:6D:6C:0A -l 00:0A:8B:BC:30:4A -l 00:11:BC:34:CB:CA -l 00:0C:86:A1:11:0A -l 00:0C:CF:40:10:4A -l 00:26:6C:FC:DA:4C");

                    if (!in_array($vlan, $rad)) {
                        $Telnet = new PHPTelnet();
                        $result = $Telnet->Connect("192.168.11.134", "cron", "!rfhfynby!");
                        switch ($result) {
                            case 0:
                                $Telnet->DoCommand("configure terminal");
                                $Telnet->DoCommand("ip arp inspection vlan $vlan");
                                $Telnet->DoCommand("ip dhcp snooping vlan $vlan");
                                $Telnet->DoCommand("exit");
                                $Telnet->DoCommand("exit");
                                break;
                        }
                        $Telnet->Disconnect();
                        echo "<b>arp inspection ON</b><br>\n";
                    }

                } else {
                    echo "<b>Wrong vlan ID</b><br>\n";
                }
                echo "</PRE>\n";
            }
            ?>

            <?php
            if (!isset($_GET['search'])) {
                echo "<table cellSpacing=0 bordercolor=#3399cc width=\"100%\" border=1>\n";
                echo "<tr bgcolor=#b6dcee><td><b>Date</b></td><td><b>Quantity</b></td><td><b>Cisco Core Port</b></td><td><b>MAC</b></td><td><b>VLAN</b></td><td><b>IP</b></td></tr>\n";
//$loggi = "cat /media/data/syslog/all/192.168.11.134.log | grep \"drop message on untrusted port\" | awk '{print $22}' | sort -u | awk '{print \"cat /media/data/syslog/all/192.168.11.134.log | grep \" $1 \" | tail -n 1\" }' | sh | awk '{ print \"<tr><td>\"$1\" \"$2\" \"$3\"</td><td>\"$16\"</td><td>\"$22\"</td><td>\"$24\"</td><td>\"$27\"</td></tr>\"}' | sort -n | tr -d ,";
//passthru ("$loggi");
                passthru("/media/data/smart/dhcp_parser | sort -n");
                echo "</table>\n";
//                echo "<br>\n";
//                echo "<table cellSpacing=0 bordercolor=#3399cc width=\"100%\" border=1>\n";
//                echo "<tr bgcolor=#b6dcee><td><b>VLAN ID</b></td><td><b>Users IP</b></td><td><b>Blade num</b></td></tr>\n";
////                $con = mysql_connect('192.168.11.74', 'dhcp_master', 'nasd38rudsasucn');
////                if (!$con) {
////                    die('MySQL connection error: ' . mysql_error());
////                }
////                mysql_select_db('dhcp', $con);
//
//                $sql = "SELECT * FROM vlan ORDER BY id ASC";
//                $result = mysql_query($sql);
////$row = mysql_fetch_assoc($result);
//                while ($row = mysql_fetch_assoc($result)) {
//                    $vlanid = $row['id'];
//                    echo "<tr><td>{$vlanid}</td><td>";
//
//                    $sql1 = "SELECT * FROM segment WHERE vlan_id = $vlanid ORDER BY ip ASC";
//                    $result1 = mysql_query($sql1);
//                    while ($row1 = mysql_fetch_assoc($result1)) {
//                        echo $row1['ip'] . "; ";
//                    }
//                    echo "</td><td>" . $row['blade_id'] . "</td><tr>\n";
//                }
//                echo "</table>";
            }
            ?>
    </TBODY>
</TABLE>

<?php
include "footer.php";
?>
