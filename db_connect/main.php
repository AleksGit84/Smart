<?php
// ������ ��� ���������� � �����
$dblocation = "192.168.11.74";
$dbname = "smart";
$dbuser = "smart_user";
$dbpasswd = "6LmEm3qy0W5AA";
// ������ ����� �� ��������
$pnumber = "20";
// ����� ������� ���������� � �����

//  if (!($dbcnx=mysql_connect($dblocation,$dbuser,$dbpasswd))) {
if (!($dbcnx = mysqli_connect($dblocation, $dbuser, $dbpasswd))) {
    printf("������ ��� ���������� � MySQL !\n");
    exit();
}

// if (!mysql_select_db($dbname, $dbcnx)) {
if (!mysqli_select_db($dbname, $dbcnx)) {
    printf("������ ���� ������ !");
    exit();
}


?>
