<?php
$host = $_POST['host'];
$count = $_POST['count'];
$size = $_POST['size'];
$fdate = date('d.m.Y_H:i');
$file = "ping/$host-$fdate.php";
$time = $_POST['minut'] * 60 + $_POST['hour'] * 3600 + $_POST['day'] * 86400;

$string1 = "<?php\ninclude '../header.php';\n?><a href=http://stats.in.soho.net.ua/smart/ping.php> <---- Вернуться </a> &nbsp;&nbsp;&nbsp;&nbsp;  | &nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:document.location.reload(true)'> Обновить </a> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <a href='javascript:scrollToBottom()'> Вниз </a>\n<PRE>\n";

if ($count == 0) $command = "timeout -s 2 $time /usr/bin/oping $host >> $file &";
else
{
$command = "oping -c $count $host >> $file &";
}

$fp = fopen("$file", "w");
$test = fwrite($fp, $string1);
fclose($fp);

echo exec($command);
//echo $command;
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://stats.in.soho.net.ua/smart/$file");
exit();

?>