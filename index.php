<?php
include "header.php";
?>

<b><font color=black>&nbsp;Системные данные: </font></b>
 <TABLE cellSpacing=1 cellPadding=2 width="100%" border=0>
                          <TBODY>
                          <TR>
                            <TD width="50%" bgColor=#ffffff>Логин</TD>
                            <TD width="50%" bgColor=#ffffff>admin</TD></TR>
                          <TR>
                            <TD width="50%" bgColor=#ffffff>IP-адрес</TD>

                            <TD width="50%" bgColor=#ffffff>

<?php
$ip = $_SERVER['REMOTE_ADDR'];
echo "$ip";
?>
</TD></TR>
</TBODY></TABLE>

<?php
include "footer.php";

?>