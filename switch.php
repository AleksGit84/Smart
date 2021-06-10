<?php
include "header.php";
// главный контент
if (isset($_GET['cmd'])) $cmd = $_GET['cmd'];
if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_POST['switch_type_id'])) $switch_type_id = $_POST['switch_type_id'];
if (isset($_POST['switch_ip'])) $switch_ip = $_POST['switch_ip'];
if (isset($_POST['switch_address'])) $switch_address = $_POST['switch_address'];
if (isset($_POST['switch_noports'])) $switch_noports = $_POST['switch_noports'];
if (isset($_POST['switch_comments'])) $switch_comments = $_POST['switch_comments'];

if (!isset($cmd)) {

    $cmd = "default";

    if (isset($_GET['page'])) $page = ($_GET['page'] - 1); else $page = 0;
    $start = abs($page * $pnumber);

    ?>

    <TABLE cellSpacing=1 cellPadding=2 width="100%"
           border=0 bgcolor=#ffffff>
        <TBODY>

        <tr>
            <td width=50% bgColor=#ffffff>

            <td width=50% bgColor=#ffffff></td>
            </td></tr>


        </TBODY>
    </TABLE>

    <TABLE cellSpacing=1 cellPadding=2 width="100%"
           border=0>
        <TBODY>

        <tr>
            <td border=0 bgcolor=#ffffff width=30% align=center><b>Добавить свитч</b></td>
            <td bgcolor=#ffffff width=70%></td>
        </tr>

        <TR>
            <TD width="30%" bgColor=#ffffff>
                <form action=switch.php?cmd=add method=POST>Модель свитча
            </TD>
            <TD width="70%" bgColor=#ffffff>
                <select name=switch_type_id>
                    <?php

                    //$ql = mysql_query("select * from switch_type order by switch_type_model");
                    //while($qlrow = mysql_fetch_array($ql)) {
                    $ql = mysqli_query("select * from switch_type order by switch_type_model");
                    while ($qlrow = mysqli_fetch_array($ql)) {
                        print"<option value=" . $qlrow["switch_type_id"] . ">" . $qlrow["switch_type_model"] . "\n";

                    }

                    ?>
                </select>
            </TD>
        </TR>


        <TR>
            <TD width="30%" bgColor=#ffffff>IP-адрес свитча</TD>
            <TD width="70%" bgColor=#ffffff><input type=text name=switch_ip></TD>
        </TR>

        <TR>
            <TD width="30%" bgColor=#ffffff>Адрес свитча</TD>
            <TD width="70%" bgColor=#ffffff><input type=text name=switch_address></TD>
        </TR>

        <TR>
            <TD width="30%" bgColor=#ffffff>Switch noports</TD>
            <TD width="70%" bgColor=#ffffff><input type=text name=switch_noports></TD>
        </TR>

        <TR>
            <TD width="30%" bgColor=#ffffff>Комментарий</TD>
            <TD width="70%" bgColor=#ffffff><textarea rows=10 cols=50 name=switch_comments></textarea></TD>
        </TR>


        <TR>


            <TD width="1%" bgColor=#ffffff><i><small><font color=red></small></font></i></TD>
            <TD width="70%" bgColor=#ffffff><input type=submit value="Добавить"></form></TD>
        </TR>


        </TBODY>
    </TABLE>


    <?php

    print <<<HERE

 <TABLE cellSpacing=1 cellPadding=2 width="100%" 
border=0 bgcolor=#ffffff>
                          <TBODY>
    
<tr><td width=50% bgColor=#ffffff>

<b><br><a href=#>Все свитчи по $pnumber на страницу</a>: <br></b><br>
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>

<TABLE cellSpacing=1 cellPadding=3 width="100%" 
border=0><TBODY>
<tr>
<td width=5% bgColor=#ffffff>
<b>id</b>
</td>

<td width=10% bgColor=#ffffff>
<b>Тип свитча</b>
</td>

<td width=10% bgColor=#ffffff>
<b>IP</b>
</td>

<td width=20% bgColor=#ffffff>
<b>Адрес </b>
</td>

<td width=15% bgColor=#ffffff>
<b>№ портов </b>
</td>


<td width=20% bgColor=#ffffff>
<b>Комментарий</b>
</td>

<td width=40% bgColor=#ffffff>
<b>Ред\Удал</b>
</td>
</tr>

HERE;
//$que = mysql_query("select * from switches order by switch_ip ASC LIMIT $start,$pnumber");
//while($srow = mysql_fetch_array($que)) {
    $que = mysqli_query("select * from switches order by switch_ip ASC LIMIT $start,$pnumber");
    while ($srow = mysqli_fetch_array($que)) {
        $ip = long2ip("$srow[switch_ip]");
        $id = "$srow[switch_id]";
        $address = "$srow[switch_address]";
        $noports = "$srow[switch_noports]";
        $comments = "$srow[switch_comments]";
        $switch_type_id = "$srow[switch_type_id]";

        print <<<HERE
<tr>
<td width=5% bgColor=#ffffff>
$id
</td>

<td width=10% bgColor=#ffffff>
HERE;

//$sql = mysql_query("select * from switch_type where switch_type_id = '$switch_type_id'");
//$arr = mysql_fetch_array($sql);
        $sql = mysqli_query("select * from switch_type where switch_type_id = '$switch_type_id'");
        $arr = mysqli_fetch_array($sql);
        print "" . $arr["switch_type_model"] . "\n";

        print <<<HERE


</td>

<td width=10% bgColor=#ffffff>
$ip
</td>

<td width=20% bgColor=#ffffff>
$address
</td>

<td width=15% bgColor=#ffffff>
$noports
</td>

<td width=20% bgColor=#ffffff>
$comments
</td>

<td width=40% bgColor=#ffffff>
<a href=switch.php?cmd=edit&id=$id>Редактировать</a>&nbsp&nbsp/&nbsp&nbsp
<a href=switch.php?cmd=del&id=$id>Удалить</a>
</td>
</tr>
HERE;


    }
    echo "</TBODY></TABLE>";


// страницы
    $q = "SELECT count(*) FROM switches";
//    $res = mysql_query($q);
//    $row = mysql_fetch_row($res);
    $res = mysqli_query($q);
    $row = mysqli_fetch_row($res);
    $total_rows = $row[0];

    print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
HERE;

    print "Страницы :&nbsp;";
    $num_pages = ceil($total_rows / $pnumber);

    for ($i = 1; $i <= $num_pages; $i++) {
        if ($i - 1 == $page) {
            echo "[<b><a class=page>&nbsp;$i&nbsp;</a>&nbsp;</b>]";
        } else {
            echo '<a class=adds href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . '">[&nbsp;' . $i . "&nbsp;]</a>&nbsp;";
        }
    }
    print <<<HERE
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
// end страницы
}


// добавление свитча
if ($cmd == "add") {
    if (!empty($switch_ip)) {
        $switch_ip_long = ip2long($switch_ip);
        $query_check_ip = "select * from switches where switch_ip = $switch_ip_long";
//        $query_check_ip_result = mysql_query($query_check_ip) or die("ERROR! Query {$query_check_ip} failed!!!");
//
//        if (mysql_num_rows($query_check_ip_result) > 0) {
        $query_check_ip_result = mysqli_query($query_check_ip) or die("ERROR! Query {$query_check_ip} failed!!!");

        if (mysqli_num_rows($query_check_ip_result) > 0) {
            print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<font color="red"><b>
Свитч с таким IP-адресом уже существует!
</font></b>
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
##<META http-equiv="refresh" content="1;url=switch.php">

        } else {
            $switch_ip_long = ip2long($switch_ip);
            $query_add_switch = "INSERT INTO switches VALUES (0, '$switch_type_id', $switch_ip_long, '$switch_address', '$switch_noports', '$switch_comments', 0, 0)";
            $query_add_switch_result = mysql_query($query_add_switch) or die("ERROR! Query {$query_add_switch} failed!!!");
            print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>
<META http-equiv="refresh" content="1;url=switch.php">
<tr><td width=50% bgColor=#ffffff>
Ваша запись успешно добавленна!
<td width=50% bgColor=#ffffff></td>
</td></tr>



</TBODY></TABLE>
HERE;

        }


    } else {

        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%" 
border=0 bgcolor=#ffffff>
                          <TBODY>
    
<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Вы ничего не ввели!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;

    }
}


// end добавление
// end главный контент

// редактирование
if ($cmd == "edit") {


    if (isset($id) && !empty($id)) {
//        $quer = mysql_query("select * from switches where switch_id = '$id'");
//        while ($srowr = mysql_fetch_array($quer)) {
        $quer = mysqli_query("select * from switches where switch_id = '$id'");
        while ($srowr = mysqli_fetch_array($quer)) {
            $ip = long2ip("$srowr[switch_ip]");
            $id = "$srowr[switch_id]";
            $s_type = "$srowr[switch_id]";
            $address = "$srowr[switch_address]";
            $noports = "$srowr[switch_noports]";
            $comments = "$srowr[switch_comments]";
            $switch_type_id = "$srowr[switch_type_id]";
            print <<<HERE


  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0>
                          <TBODY>

<tr>
<td border=0 bgcolor=#ffffff width=30% align=center><b>Редактирование</b></td>
<td bgcolor=#ffffff width=70%></td>
</tr>

<TR>
                            <TD width="30%" bgColor=#ffffff><form action=switch.php?cmd=update&id=$id method=POST>Модель свитча</TD>
                          <TD width="70%" bgColor=#ffffff>
                            <select name=switch_type_id>
HERE;

//            $sql = mysql_query("select * from switch_type where switch_type_id = '$switch_type_id'");
//            $arr = mysql_fetch_array($sql);
            $sql = mysqli_query("select * from switch_type where switch_type_id = '$switch_type_id'");
            $arr = mysqli_fetch_array($sql);
            print"<option value=" . $arr["switch_type_id"] . ">Выбрано - " . $arr["switch_type_model"] . "\n";


//            $ql = mysql_query("select * from switch_type order by switch_type_model");
//            while ($qlrow = mysql_fetch_array($ql)) {
            $ql = mysqli_query("select * from switch_type order by switch_type_model");
            while ($qlrow = mysqli_fetch_array($ql)) {
                print"<option value=" . $qlrow["switch_type_id"] . ">" . $qlrow["switch_type_model"] . "\n";

            }


            print <<<HERE
                            </select>
                            </TD></TR>


                            <TR>
                            <TD width="30%" bgColor=#ffffff>IP-адрес свитча</TD>
                            <TD width="70%" bgColor=#ffffff><input type=text name=switch_ip value=$ip></TD></TR>

                            <TR>
                            <TD width="30%" bgColor=#ffffff>Адрес свитча</TD>
                            <TD width="70%" bgColor=#ffffff><input type=text name=switch_address value="$address"></TD></TR>

                            <TR>
                            <TD width="30%" bgColor=#ffffff>Switch noports</TD>
                            <TD width="70%" bgColor=#ffffff><input type=text name=switch_noports value="$noports"></TD></TR>

   <TR>
                            <TD width="30%" bgColor=#ffffff>Комментарий</TD>
                            <TD width="70%" bgColor=#ffffff><textarea rows=10 cols=50 name=switch_comments>$comments</textarea></TD></TR>




                            
<TR>
                            <TD width="1%" bgColor=#ffffff>&nbsp;</TD>
                            <TD width="70%" bgColor=#ffffff><input type=submit value="Отправить"><input name=id type=hidden value=$id></form></TD></TR>



</TBODY></TABLE>
HERE;
        }
    } else {

        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Вы не выбрали ID!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    }
// end редактирование
}

// Обновление

if ($cmd == "update") {
    if (!empty($switch_type_id)) {
//        $upd = mysql_query("UPDATE `switches` SET `switch_type_id` = '$switch_type_id', `switch_ip` = inet_aton('$switch_ip'), `switch_address` = '$switch_address', `switch_noports` = '$switch_noports',  `switch_comments` = '$switch_comments' WHERE `switch_id` = '$id'");
        $upd = mysqli_query("UPDATE `switches` SET `switch_type_id` = '$switch_type_id', `switch_ip` = inet_aton('$switch_ip'), `switch_address` = '$switch_address', `switch_noports` = '$switch_noports',  `switch_comments` = '$switch_comments' WHERE `switch_id` = '$id'");
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Ваша запись успешно обновлена!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    } else {
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Вы не выбрали ID или название пустое!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    }

}


// end Обновление


// подтверждение удаления

if ($cmd == "del") {
    if (!empty($id)) {
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
Вы действительно хотите удалить эту запись?
<td width=50% bgColor=#ffffff><form action=switch.php?cmd=del_confim&id=$id method=post>&nbsp;&nbsp;&nbsp;&nbsp;<a href=switch.php><b>НЕТ</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value=ДА><input type=hidden name=id value=$id></form>

</td>
</td></tr>


</TBODY></TABLE>
HERE;
    } else {
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Вы не выбрали ID или название пустое!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    }

}

// end подтверждение удаления


// удаление

if ($cmd == "del_confim") {
    if (!empty($id)) {
//        $upd = mysql_query("DELETE FROM switches where switch_id = '$id'");
        $upd = mysqli_query("DELETE FROM switches where switch_id = '$id'");
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Ваша запись успешно удалена!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    } else {
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=switch.php">
Вы не выбрали ID или название пустое!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    }

}

// end удаление


include "footer.php";

?>
