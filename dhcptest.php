<?php
include "header.php";
?>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
    <TBODY>
    <TR>
        <TD>
            <CENTER><B><a href="dhcptest.php">!TEST! DHCP servers finder</a></B></CENTER>
            <BR>

            <form action="dhcptest.php" method="get">
                <p>
                    Vlan ID:<input type="text" name="vlan" size="4" maxlength="4" value="">
                    <input type="submit" name="search" value="DHCP search"/></p>
            </form>

            <PRE>
<?php
if (isset($_GET['search'])) {
    require_once("PHPTelnet.php");

# Spisok Vlan ID BEZ arp inspection !!! #
    $rad = array("11", "211", "88", "160", "161", "162", "163", "164", "165", "166", "167", "168", "169", "170", "171", "171", "172", "173", "174", "175", "176", "177", "178", "179");

    $vlan = $_GET['vlan'];

//$con = mysql_connect('192.168.11.74','dhcp_master','nasd38rudsasucn');
    $con = mysqli_connect('192.168.11.74', 'dhcp_master', 'nasd38rudsasucn');
    if (!$con) {
//    die('MySQL connection error: ' . mysql_error());
        die('MySQL connection error: ' . mysqli_error());
    }
//mysql_select_db('dhcp', $con);
    mysqli_select_db('dhcp', $con);

    $sql = "SELECT vlan_table.vlan_num FROM vlan_table WHERE vlan_table.vlan_num = " . $vlan;
//$result = mysql_query($sql);
    $result = mysqli_query($sql);

// if(mysql_num_rows($result) !=0) {
    if (mysqli_num_rows($result) != 0) {
        echo "<b>test VLAN ID $vlan</b><br>";

        if (!in_array("$vlan", $rad)) {
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
            echo "<b>arp inspection OFF</b><br>";
        }
        echo "<b>DHCP servers in vlan $vlan</b><br>";
        passthru("sudo /usr/local/sbin/dhcdrop -t -i eth1.$vlan -l e8:04:62:1c:8d:80 -l 00:12:DA:27:AE:4A -l 00:0B:45:6D:6C:0A -l 00:0A:8B:BC:30:4A -l 00:11:BC:34:CB:CA -l 00:0C:86:A1:11:0A -l 00:0C:CF:40:10:4A -l 00:14:69:12:B6:42 -l 00:14:69:12:B6:43 -l 00:14:69:12:B6:44 -l 00:14:69:12:B6:45");

        if (!in_array("$vlan", $rad)) {
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
            echo "<b>arp inspection ON</b><br>";
        }

    } else {
        echo "<b>Wrong vlan ID</b><br>";
    }

}

?>
</PRE>

            <?php
            if (!isset($_GET['search'])) {
                echo "<table width=\"100%\" border=\"1\"><tr bgcolor=\"#b6dcee\"><td><b>VLAN ID</b></td><td><b>Users IP</b></td><td><b>Blade num</b></td></tr>";
//$con = mysql_connect('192.168.11.74','dhcp_master','nasd38rudsasucn');
                $con = mysqli_connect('192.168.11.74', 'dhcp_master', 'nasd38rudsasucn');
                if (!$con) {
//    die('MySQL connection error: ' . mysql_error());
//    }
//mysql_select_db('dhcp', $con);
                    die('MySQL connection error: ' . mysqli_error());
                }
                mysqli_select_db('dhcp', $con);

                $sql = "SELECT vlan_table.vlan_num, vlan_table.blade_num FROM vlan_table GROUP BY vlan_table.vlan_num ORDER BY vlan_table.vlan_num ASC";
//                $result = mysql_query($sql);
//                $row = mysql_fetch_assoc($result);
//
//                while ($row = mysql_fetch_assoc($result)) {

                $result = mysqli_query($sql);
                $row = mysqli_fetch_assoc($result);

                while ($row = mysqli_fetch_assoc($result)) {
                    $vlanid = $row['vlan_num'];
                    echo "<tr><td>" . $row['vlan_num'] . "</td><td>";

                    $sql1 = "SELECT vlan_table.vlan_num, vlan_table.ip FROM vlan_table WHERE vlan_table.vlan_num = " . $vlanid . " ORDER BY vlan_table.ip ASC";
//                    $result1 = mysql_query($sql1);
//                    while ($row1 = mysql_fetch_assoc($result1)) {
                    $result1 = mysqli_query($sql1);
                    while ($row1 = mysqli_fetch_assoc($result1)) {
                        echo $row1['ip'] . "*&nbsp ; &nbsp&nbsp&nbsp ";
                    }
                    echo "</td><td>" . $row['blade_num'] . "</td><tr>\n";
                }
            }
            ?>
</table>

</TBODY></TABLE>

<?php
include "footer.php";
?>
