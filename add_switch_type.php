<?php
include "header.php";
// главный контент
if (isset($_GET['cmd'])) $cmd = $_GET['cmd'];
if (isset($_GET['id'])) $id = $_GET['id'];
if (isset($_POST['switch_type_model'])) $switch_type_model = $_POST['switch_type_model'];
if (isset($_POST['switch_type_comments'])) $switch_type_comments = $_POST['switch_type_comments'];

if (!isset($cmd)) {
    $cmd = "default";
    if (isset($_GET['page'])) $page = ($_GET['page'] - 1); else $page = 0;
    $start = abs($page * $pnumber);

    ?>

    <TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor=#ffffff>
        <TBODY>

        <tr>
            <td width=50% bgColor=#ffffff>

                <a href=add_switch_type.php?cmd=search><b>Искать тип свитча</b></a><br><br><br>
            <td width=50% bgColor=#ffffff></td>
            </td></tr>


        </TBODY>
    </TABLE>

    <TABLE cellSpacing=1 cellPadding=2 width="100%"
           border=0>
        <TBODY>

        <tr>
            <td border=0 bgcolor=#ffffff width=30% align=center><b>Добавить тип свитча</b></td>
            <td bgcolor=#ffffff width=70%></td>
        </tr>

        <TR>
            <TD width="30%" bgColor=#ffffff>
                <form action=add_switch_type.php?cmd=add method=POST>Модель свитча
            </TD>
            <TD width="70%" bgColor=#ffffff><input type=text name=switch_type_model></TD>
        </TR>

        <TR>
            <TD width="30%" bgColor=#ffffff>Комментарий</TD>
            <TD width="70%" bgColor=#ffffff><textarea rows=10 cols=50 name=switch_type_comments></textarea></TD>
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

<b><br><a href=#>Все типы свитчей по $pnumber на страницу</a>: <br></b><br>
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>

<TABLE cellSpacing=1 cellPadding=3 width="100%" 
border=0><TBODY>
<tr>
<td width=5% bgColor=#ffffff>
<b>id</b>
</td>



<td width=25% bgColor=#ffffff>
<b>Модель свитча </b>
</td>

<td width=40% bgColor=#ffffff>
<b>Комментарий</b>
</td>

<td width=40% bgColor=#ffffff>
<b>Ред\Удал</b>
</td>
</tr>

HERE;
//$que = mysql_query("select * from switch_type order by switch_type_id ASC LIMIT $start,$pnumber");
//while($srow = mysql_fetch_array($que)) {
    $que = mysqli_query("select * from switch_type order by switch_type_id ASC LIMIT $start,$pnumber");
    while ($srow = mysqli_fetch_array($que)) {
        $model = "$srow[switch_type_model]";
        $id = "$srow[switch_type_id]";
        $comment = "$srow[switch_type_comments]";

        print <<<HERE
<tr>
<td width=5% bgColor=#ffffff>
$id
</td>



<td width=25% bgColor=#ffffff>
$model
</td>

<td width=40% bgColor=#ffffff>
$comment
</td>

<td width=30% bgColor=#ffffff>
<a href=add_switch_type.php?cmd=edit&id=$id>Редактировать</a>&nbsp&nbsp/&nbsp&nbsp
<a href=add_switch_type.php?cmd=del&id=$id>Удалить</a>
</td>
</tr>
HERE;


    }
    echo "</TBODY></TABLE>";


// страницы
    $q = "SELECT count(*) FROM switch_type";
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


// добавление типа свитча
if ($cmd == "add") {
    if (!empty($switch_type_model)) {
//        $que = mysql_query("select * from switch_type where switch_type_model like '$switch_type_model'");
        $que = mysqli_query("select * from switch_type where switch_type_model like '$switch_type_model'");
// $query = mysql_query("INSERT INTO tarif VALUES (0, '$opis')");
//        if (mysql_num_rows($que) > 0) {
        if (mysqli_num_rows($que) > 0) {
            print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=add_switch_type.php">
Такая запись уже существует!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
        } else {
//            $query = mysql_query("INSERT INTO switch_type VALUES (0, '$switch_type_model', '$switch_type_comments')");
            $query = mysqli_query("INSERT INTO switch_type VALUES (0, '$switch_type_model', '$switch_type_comments')");
            print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
//        $quer = mysql_query("select * from switch_type where switch_type_id = '$id'");
//        while ($srowr = mysql_fetch_array($quer)) {
        $quer = mysqli_query("select * from switch_type where switch_type_id = '$id'");
        while ($srowr = mysqli_fetch_array($quer)) {
            $model = "$srowr[switch_type_model]";
            $comment = "$srowr[switch_type_comments]";
            print <<<HERE


  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0>
                          <TBODY>

<tr>
<td border=0 bgcolor=#ffffff width=30% align=center><b>Редактирование</b></td>
<td bgcolor=#ffffff width=70%></td>
</tr>

<TR>
                            <TD width="30%" bgColor=#ffffff><form action=add_switch_type.php?cmd=update&id=$id method=POST>Модель свитча</TD>
                            <TD width="70%" bgColor=#ffffff><input type=text name=switch_type_model value="$model"></TD></TR>
                            
                            <TR>
                            <TD width="30%" bgColor=#ffffff>Название улицы</TD>
                            <TD width="70%" bgColor=#ffffff> <textarea rows=10 cols=50 name=switch_type_comments>$comment</textarea></TD></TR>

                            
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
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
    if (!empty($switch_type_model)) {
//        $upd = mysql_query("UPDATE `switch_type` SET `switch_type_model` = '$switch_type_model', `switch_type_comments` = '$switch_type_comments' WHERE `switch_type_id` = '$id'");
        $upd = mysqli_query("UPDATE `switch_type` SET `switch_type_model` = '$switch_type_model', `switch_type_comments` = '$switch_type_comments' WHERE `switch_type_id` = '$id'");
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
<td width=50% bgColor=#ffffff><form action=add_switch_type.php?cmd=del_confim&id=$id method=post>&nbsp;&nbsp;&nbsp;&nbsp;<a href=add_switch_type.php><b>НЕТ</b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value=ДА><input type=hidden name=id value=$id></form>

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
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
//        $upd = mysql_query("DELETE FROM switch_type where switch_type_id = '$id'");
        $upd = mysqli_query("DELETE FROM switch_type where switch_type_id = '$id'");
        print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=add_switch_type.php">
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
<META http-equiv="refresh" content="1;url=add_switch_type.php">
Вы не выбрали ID или название пустое!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    }

}

// end удаление


// форма поиска

if ($cmd == "search") {
    print <<<HERE


  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0>
                          <TBODY>

<tr>
<td border=0 bgcolor=#ffffff width=30% align=center><b>Форма поиска</b></td>
<td bgcolor=#ffffff width=70%></td>
</tr>

<TR>
                            <TD width="30%" bgColor=#ffffff><form action=add_switch_type.php?cmd=search_result method=POST>Модель свитча</TD>
                            <TD width="70%" bgColor=#ffffff><input type=text name=switch_type_model value=""></TD></TR>


<TR>
                            <TD width="30%" bgColor=#ffffff><form action=add_switch_type.php?cmd=search_result method=POST>Комментарий</TD>
                            <TD width="70%" bgColor=#ffffff><textarea rows=10 cols=50 name=switch_type_comments></textarea></TD></TR>
<TR>

                            <TD width="1%" bgColor=#ffffff>&nbsp;</TD>
                            <TD width="70%" bgColor=#ffffff><input type=submit value="Искать!"></form></TD></TR>



</TBODY></TABLE>
HERE;


}

// end форма поиска


// Результат поиска

if ($cmd == "search_result") {
    if (!empty($switch_type_model)) {
        print <<<HERE

 <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>

<b><br><a href=add_switch_type.php?cmd=search>Поиск</a> \ <a href=#>Результаты поиска</a>: <br></b><br>
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>

<TABLE cellSpacing=1 cellPadding=3 width="100%"
border=0><TBODY>
<tr>
<td width=5% bgColor=#ffffff>
<b>id</b>
</td>



<td width=20% bgColor=#ffffff>
<b>Тип свичта</b>
</td>

<td width=40% bgColor=#ffffff>
<b>Комментарий</b>
</td>

<td width=40% bgColor=#ffffff>
<b>Ред\Удал</b>
</td>
</tr>

HERE;
//        $que = mysql_query("select * from switch_type where switch_type_model like '$switch_type_model%' AND switch_type_comments LIKE '%$switch_type_comments%'");
//        if (mysql_num_rows($que) > 0) {
//            while ($srow = mysql_fetch_array($que)) {
        $que = mysqli_query("select * from switch_type where switch_type_model like '$switch_type_model%' AND switch_type_comments LIKE '%$switch_type_comments%'");
        if (mysqli_num_rows($que) > 0) {
            while ($srow = mysqli_fetch_array($que)) {
                $model = "$srow[switch_type_model]";
                $id = "$srow[switch_type_id]";
                $comment = "$srow[switch_type_comments]";

                print <<<HERE
<tr>
<td width=5% bgColor=#ffffff>
$id
</td>



<td width=20% bgColor=#ffffff>
$model
</td>


<td width=40% bgColor=#ffffff>
$comment
</td>

<td width=40% bgColor=#ffffff>
<a href=add_switch_type.php?cmd=edit&id=$id>Редактировать</a>&nbsp&nbsp/&nbsp&nbsp
<a href=add_switch_type.php?cmd=del&id=$id>Удалить</a>
</td>
</tr>
HERE;


            }
            echo "</TBODY></TABLE>";
        } else {

            print <<<HERE
  <TABLE cellSpacing=1 cellPadding=2 width="100%"
border=0 bgcolor=#ffffff>
                          <TBODY>

<tr><td width=50% bgColor=#ffffff>
<META http-equiv="refresh" content="1;url=add_switch_type.php"><br><br><b><font color=red>
По Вашему запросу ничего не найденно!</b></font>
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
<META http-equiv="refresh" content="1;url=add_switch_type.php">
Название пустое!
<td width=50% bgColor=#ffffff></td>
</td></tr>


</TBODY></TABLE>
HERE;
    }


}

// end Результат поиска


include "footer.php";

?>
