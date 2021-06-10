<?php
include "header.php";
?>

<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
<TBODY>
<TR>
<TD>
</CENTER>
<font color="black"><b>Advanced Ping page</b></font>

<form action="action.php" method="post">
    <p>IP / Hostname <input type="text" name="host" /></p>
    <p>count packets   <input type="text" name="count" value="0" size="4" maxlength="4" />
<!--    size<input type="text" name="size" value="56" size="4" maxlength="4" /> --> </p>
    <p>minut<input type="text" name="minut" value="5" size="2" maxlength="2" />
    hour<input type="text" name="hour" value="0" size="2" maxlength="2" />
    day<input type="text" name="day" value="0" size="1" maxlength="1" /></p>
    <p><input type="submit" style="height: 25px; width: 200px; background-color:#b6dcee;" value="Ping" /></p>
</form>
</CENTER>
</TD>
<TR>
<TD>

<?php
$dir = "ping/";
    if(is_dir($dir)) {
    $files = scandir($dir);
//    array_shift($files);
    array_shift($files);
    array_shift($files);
    for($i=0; $i<sizeof($files); $i++){
    $filename = substr($files[$i],0,strrpos($files[$i],'.'));
    $filename = str_replace("_"," ",$filename);
    echo '<b>Результат проверки для:<a href="'.$dir.$files[$i].'" title='.str_replace("-"," - ",$filename).'>'.str_replace("-"," - ",$filename).'</a></b> - <a href=.del.php?1='.$files[$i].' title="delete">Удалить</a> <br>';
    }
    }
?>
</TD>
</TD></TR></table>

<?php
include "footer.php";
?>
