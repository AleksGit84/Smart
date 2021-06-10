<?php
$host = $_POST['host'];
$count = $_POST['count'];
$size = $_POST['size'];
$fdate = date('d.m.Y_H:i');
$file = "ping/$host-$fdate.php";
$time = $_POST['minut'] * 60 + $_POST['hour'] * 3600 + $_POST['day'] * 86400;

/*$string1 = "<?php\ninclude '../ping.head';\n?>\n<HTML>\n<HEAD>\n<META HTTP-EQUIV=Refresh CONTENT='30'; URL=http://stats.in.soho.net.ua/smart/$file'>\n<META http-equiv=Content-Type content='text/html; charset=windows-1251'>\n</HEAD>\n<BODY>\n";*/
$string2 = "<?php\ninclude '../ping.head';\n?><a href=http://stats.in.soho.net.ua/smart/ping.php> <---- ��������� </a> &nbsp;&nbsp;&nbsp;&nbsp;  | &nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:history.go(0)'> �������� </a> &nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <a href='javascript:scrollToBottom()'> ���� </a>\n<PRE>\n";

if ($count == 0) $command = "timeout -s 2 $time /usr/bin/oping $host >> $file &";
else
{
$command = "oping -c $count $host >> $file &";
}

$fp = fopen("$file", "w");
//$test = fwrite($fp, $string1);
$test = fwrite($fp, $string2);
fclose($fp);

echo exec($command);
//echo $command;
header("HTTP/1.1 301 Moved Permanently");
header("Location: http://stats.in.soho.net.ua/smart/$file");
exit();

?>