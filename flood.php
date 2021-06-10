<?php
include "header.php";
include 'db.php';
?>

<script type="text/javascript">
    <!--
    function _submit1() {
        window.open('', 'new_win1', 'width=300,height=600,location=no,toolbar=no,menubar=no,status=no,scrollbars=yes,resizable=yes');
    }
    function _submit2() {
        window.open('', 'new_win2', 'width=1200,height=800,location=no,toolbar=no,menubar=no,status=no,scrollbars=yes,resizable=yes');
    }
    //-->
</script>

<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
    <TBODY>
    <TR>
        <TD>
            <CENTER><B><a href="flood.php">Flooder finder</a></B></CENTER>
            <BR>
            <B>TOP 30 flooreds mac in vlan</B><br>
            <form onsubmit="_submit1()" target="new_win1" action="floodactive.php" method="get">
                <p>
                    <b>Vlan ID:</b><select name="vlan" size="1">
                        <option selected="selected" value="">all</option>
                        <?php
                        $sql = "SELECT * FROM vlan ORDER BY id ASC";
//                        $result = mysql_query($sql);
                        $result = mysqli_query($sql);
                        $options = '';
//                        while ($row = mysql_fetch_assoc($result)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $vlanid = $row['id'];
                            $options .= "<option value=\"{$vlanid}\">{$vlanid}</option>" . PHP_EOL;
                        }
                        echo $options;
                        ?>
                    </select>
                    <b>Time out sec.</b><input type="text" name="time" size="2" maxlength="2" value="10">
                    <input type="submit" style="height: 22px; width: 200px; background-color:#b6dcee;" name="macsearch"
                           value="Scan"/></p>
            </form>
            <br>

            <B>Full tcpdump in vlan</B><br>
            <form onsubmit="_submit2()" target="new_win2" action="floodactive.php" method="get">
                <p>
                    <b>Vlan ID:</b><select name="vlan" size="1">
                        <option selected="selected" value="">all</option>
                        <?= $options ?>
                    </select>
                    <b>MAC address</b><input type="text" name="mac" size="17" maxlength="17" value="">
                    <b>Time out sec.</b><input type="text" name="time" size="2" maxlength="2" value="5">
                    <b>Tcpdump paramerts</b><input type="text" name="param" size="3" maxlength="6" value="ne">
                    <input type="submit" style="height: 22px; width: 200px; background-color:#b6dcee;" name="fulldump"
                           value="Scan"/></p>
            </form>
            <br>

            <B>Search MAC address in DHCP config and Soho Core</B><br>
            <form action="flood.php" method="get">
                <p>
                    <b>MAC address</b><input type="text" name="mac" size="17" maxlength="17" value="">
                    <input type="submit" style="height: 22px; width: 200px; background-color:#b6dcee;" name="macsearch"
                           value="Search MAC"/></p>
            </form>


            <?php
            if (isset($_GET['macsearch'])) {
                $mac1 = preg_replace('#[^0-9a-f]+#', '', strtolower($_GET['mac']));

#echo "<b>Search MAC address ".$_GET['mac']."</b><br>";    

                $sql = "SELECT * FROM device WHERE mac LIKE '%{$mac1}%'";
//                $result = mysql_query($sql);
                $result = mysqli_query($sql);
////$row = mysql_fetch_assoc($result);
//                while ($row = mysql_fetch_assoc($result)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $ip = $row['ip'];
                    $host_name = $row['host'];
                    $mac2 = $row['mac'];
                    echo "Login: <b>" . $host_name . "</b> IP: <b>" . $ip . "</b> MAC: <b>" . $mac1 . "</b><br>";
                }


                require_once("PHPTelnet.php");

                $mac_tmp = explode(':', $_GET['mac']);
                $mac = $mac_tmp[0] . $mac_tmp[1] . "." . $mac_tmp[2] . $mac_tmp[3] . "." . $mac_tmp[4] . $mac_tmp[5];


                $Telnet = new PHPTelnet();
                $result = $Telnet->Connect("192.168.11.134", "cron", "!rfhfynby!");
                switch ($result) {
                    case 0:
                        $Telnet->DoCommand("show mac-address-table address $mac", $result);
                        $Telnet->DoCommand("exit");
                        break;
                }
                $Telnet->Disconnect();
                echo "<pre>";
//echo $result;
                $string = explode("\r", $result);
                echo $string[5];
                echo $string[6];
                echo "<b>";
                echo $string[8];
                echo "</b></pre>";


            }
            ?>
            *mac address must looks like xx:xx:xx:xx:xx:xx<br>
            **mac address e8:04:62:1c:8d:80 is Soho_Core address<br>
            ***don't use time more then 60 sec.
    </TBODY>
</TABLE>

<?php
include "footer.php";
?>
