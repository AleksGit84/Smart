<?php
#Включение файла с параметрами подкдючения к базе данных
#	include "db_connect/main.php";
	include ( "header.php" );
?>
<html>
<body>
<form action="manager.php">
    	<p><b>Номер сегмента:</b>
		<select name=switch_segment>
			<option value="-1">
			<?php
				$query_seg="		SELECT
										(ROUND((switch_ip&65280)/256)) AS switch_segment
									FROM
										switches
									GROUP BY
										switch_segment;";
//				$query_segment=mysql_query($query_seg);
//				while($query_row_segment = mysql_fetch_array($query_segment))
            $query_segment=mysqli_query($query_seg);
            while($query_row_segment = mysqli_fetch_array($query_segment))
				print"<option value=".$query_row_segment["switch_segment"].">".$query_row_segment["switch_segment"]."\n";
			?> 
		</select></p>
		<p><b>Адрес свитча:</b>
		<select name=switch_address_t2>
			<option value="">
			<?php
//				$query_address=mysql_query("SELECT
//												switch_address
//											FROM
//												switches
//											GROUP BY
//												switch_address
//											ORDER BY
//												switch_address ");
//				while($query_row_address = mysql_fetch_array($query_address))
            $query_address=mysqli_query("SELECT
												switch_address
											FROM
												switches
											GROUP BY
												switch_address
											ORDER BY
												switch_address ");
            while($query_row_address = mysqli_fetch_array($query_address))
				{
					print"<option value=".urlencode($query_row_address["switch_address"]).">".$query_row_address["switch_address"]."\n";
				}
			?>
		</select></p>
    	<p><b>IP-адрес свитча:</b>
		<select name=switch_ip_address>
			<option value="">
			<?php
//				$query_ip_address=mysql_query("SELECT
//													switch_ip
//												FROM
//													switches
//												ORDER BY
//													switch_ip");
//				while($query_row_ip_address = mysql_fetch_array($query_ip_address))
            $query_ip_address=mysqli_query("SELECT
													switch_ip
												FROM
													switches
												ORDER BY
													switch_ip");
            while($query_row_ip_address = mysqli_fetch_array($query_ip_address))
				{
					print"<option value=".$query_row_ip_address["switch_ip"].">".long2ip($query_row_ip_address["switch_ip"])."\n";
				}
			?>
		</select></p>
		<p><b>Зарегестрированный MAC-адрес:</b>
		<input type=text name=mac_registered>
		</p>
		<input type=submit value="GO!">		
</form>
</body>
</html>
