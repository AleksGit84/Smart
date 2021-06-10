<?php
include "db_connect/main.php";
##include "log/kernel_login_system.php";
?>

<HTML><HEAD><TITLE>SoHo.NET - network tools</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="css.css">
<style>
    a {display: inline-block; padding: 5px;}
</style>

</HEAD>
<BODY text=#000000 vLink=#551a8b link=#0000ee bgColor=#ffffff topMargin=10
marginwidth="10" marginheight="10">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD bgColor=#3399cc>
      <TABLE cellSpacing=1 cellPadding=0 width="100%" border=0>
        <TBODY>
        <TR>
          <TD bgColor=#b6dcee colSpan=2>
            <TABLE cellSpacing=5 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD vAlign=center align=left>
                  <TABLE cellSpacing=0 cellPadding=0 border=0>
                    <TBODY>
                    <TR>
                      <TD align=left><FONT face=Tahoma,Arial,Helvetica
                        size=5><B>SoHo.NET</B></FONT></TD></TR>
                    <TR>
                      <TD align=middle><FONT face=Tahoma,Arial,Helvetica
                        size=2><B>network tools</B></FONT></TD></TR></TBODY></TABLE></TD>
                <TD vAlign=bottom align=right></TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD vAlign=top width="12%" bgColor=#ffffff>
            <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
              <TR>
                <TD vAlign=top align=left>
                  <TABLE cellSpacing=5 cellPadding=0 width="100%" border=0 bgColor=#ffffff>
                    <TBODY>
                    <TR>
                      <TD>
                        <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0 bgColor=#ffffff>
                          <TBODY>
                          <TR>
                            <TD>
                      
<a href=index.php><b>На главную</b></a><br>
<a href=add_switch_type.php><b>Добавить тип свитча</b></a><br>

<a href=switch.php><b>Список свитчей</b></a><br>

<a href=t2.php><b>Список MACs</b></a><br>

<!--<a href=netscan.php><b>ARP сканирование</b></a><br>-->

<a href=ping.php><b>Advanced Ping</b></a><br>

<a href=pon.php><b>PON ONU information</b></a><br>

<a href=dhcplist.php><b>DHCP servers finder</b></a><br>

<a href=flood.php><b>Flooder finder</b></a><br>

<a href=nmap.php><b>Web NMAP</b></a><br>

<a href=lg.php><b>Looking Glass</b></a><br>

</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
                  <TABLE cellSpacing=5 cellPadding=0 width="100%" bgColor=#b6dcee border=0>
                    <TBODY>
                    <TR>
                      <TD><A href="index.php?event=exit" target=_top><B>Выход</B></A></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
          <TD vAlign=top width="80%" bgColor=#ffffff>
            <TABLE cellSpacing=5 cellPadding=0 width="100%" border=0 bgcolor=#ffffff>
              <TBODY>
              <TR>
                <TD vAlign=top align=left>
                  <TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor=#ffffff>
                    <TBODY>
                    <TR>
			<TD>
<!--                      <TD bgColor=#3399cc> -->