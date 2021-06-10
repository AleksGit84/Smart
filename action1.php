<?php
$host = $_POST['host'];
$count = $_POST['count'];
$size = $_POST['size'];
$fdate = date('d.m.Y_H:i');
$file = "ping/$host-$fdate.html";
$time = $_POST['minut'] * 60 + $_POST['hour'] * 3600 + $_POST['day'] * 86400;

$string1 = "<HTML>\n<HEAD>\n<META HTTP-EQUIV=Refresh CONTENT='60'; URL=http://stats.in.soho.net.ua/smart/$file'>\n<META http-equiv=Content-Type content='text/html; charset=windows-1251'>\n</HEAD>\n<BODY>\n";
$string2 = "<a href=http://stats.in.soho.net.ua/smart/ping.php> <---- Вернуться </a> &nbsp;&nbsp;&nbsp;&nbsp;  | &nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:history.go(0)'> Обновить </a> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <a href='javascript:scroll(0,999999999);'> Вниз </a>\n<PRE>\n";

if ($count == 0) $ccount = "";
else
{
$ccount = "-c$count";
$time = 0;
}

$fp = fopen("$file", "w");
$test = fwrite($fp, $string1);
$test = fwrite($fp, $string2);
fclose($fp);

$command = "ping $ccount -s$size -w$time $host >> $file &";
echo exec($command);
//echo $command;
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://stats.in.soho.net.ua/smart/$file");
exit();

?>