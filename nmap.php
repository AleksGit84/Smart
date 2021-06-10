<?php
include "header.php";
?>

<?php
//
// Copyright (c) 2008 Morgan Collins <morgan -at- morcant.com>
//
// PHP-NMAP v0.2 - A PHP web frontend to the command line utility NMAP
// http://www.morcant.net/projects/php-nmap
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
//


$cfg = new stdClass;

// Path to NMAP Executable
$cfg->nmapcmd = '/usr/bin/sudo /usr/bin/nmap';

// Default Scan Type
// To get SYN, you need to chmod +s nmap
$cfg->default_scan_option = 'connect';

// Enable verbose output
$cfg->default_verbose = false;

// Default Ping Type
$cfg->default_ping_type = 'tcp_icmp';

// Detect OS Type
$cfg->default_os_detect = false;

// Default host should be that of the client
$cfg->default_remote_addr = true;

// Host Flags
$cfg->host_flags = '';

// Table Background Color
$cfg->tablebgcolor = '#e1e1e1';

// Host Section Background Color
$cfg->hostsectioncolor = '#913a47';

// Scan Section Background Color
$cfg->scansectioncolor = '#3c7996';

// General Section Background Color
$cfg->generalsectioncolor = '#3a914b';

?>

<?php
	if ($_POST['submit'] && $_POST['host']) {
		$args = '';

		switch ($_POST['scan_type']) {
			case 'connect':
				$args .= '-sT ';
				break;
			case 'syn':
				$args .= '-sS ';
				break;
			case 'null':
				$args .= '-sN ';
				break;
			case 'fin';
				$args .= '-sF ';
				break;
			case 'xmas':
				$args .= '-sX ';
				break;
			case 'ack':
				$args .= '-sA ';
				break;
			case 'window':
				$args .= '-sW ';
				break;
			case 'ping';
				$args .= '-sP ';
				break;
			default:
				$args .= '-sT ';
				break;
		}
		
		switch ($_POST['ping_type']) {
			case 'tcp':
				$args .= '-PT ';
				break;
			case 'tcp_icmp':
				$args .= '-PB ';
				break;
			case 'icmp':
				$args .= '-PI ';
				break;
			case 'none':
				$args .= '-P0 ';
				break;
			default:
				$args .= '-PB ';
				break;
		}

		if ($_POST['os_detect'])
			$args .= '-O ';
			
		if ($_POST['ident_info'])
			$args .= '-I ';
			
		if ($_POST['fragmentation'])
			$args .= '-f ';
		
		if ($_POST['verbose'])
			$args .= '-v ';
		
		if ($_POST['use_port'])
			$args .= '-p ' .  escapeshellarg($_POST['port_range']);

		if ($_POST['fast_scan'])
			$args .= '-F ';

		if ($_POST['use_decoy'])
			$args .= '-D ' .  escapeshellarg($_POST['decoy_name']);

		if ($_POST['use_device'])
			$args .= '-e ' .  escapeshellarg($_POST['device_name']);

		if ($_POST['dont_resolve'])
			$args .= '-n ';

		if ($_POST['udp_scan'])
			$args .= '-sU ';

		if ($_POST['rpc_scan'])
			$args .= '-sV ';
		
		$args .= $cfg->host_flags . ' ' . escapeshellarg($_POST['host']);

		?>
		<pre>
		<?php
		system($cfg->nmapcmd . ' ' . $args . ' 2>&1'); 
		?>
		</pre>
		<?php
	} else {
?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
<div class="header-banner" align="center">
	<font size="+3">SOHO-WEB-NMAP</font><br>
	<br>
</div>
<table bgcolor="<?php echo $cfg->tablebgcolor; ?>" border="0" cols="4" width="550" cellpadding="5" cellspacing="0" align="center">
	<tr bgcolor="<?php echo $cfg->hostsectioncolor; ?>">
		<td width="100"><b>Host(s) to scan</b>:</td>
		<td width="200" colspan="2"><input type="text" name="host" size="20" value="<?php if ($cfg->default_remote_addr) echo $_SERVER['REMOTE_ADDR']; ?>"></td>
		<td width="100" align="right"><input type="submit" name="submit" value="Scan">&nbsp;<input type="reset" value="Clear"></td>
	</tr>
	
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><b>Scan Options</b>:</td>
		<td width="100" bgcolor="<?php echo $cfg->generalsectioncolor; ?>">&nbsp;</td>
		<td width="100" bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><b>General Options</b>:</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>">&nbsp;</td>
	</tr>
	
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="connect" <?php if ($cfg->default_scan_option == 'connect') echo 'CHECKED'; ?>> connect()</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="dont_resolve"> Don't Resolve</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="radio" name="ping_type" value="tcp" <?php if ($cfg->default_ping_type == 'tcp') echo 'CHECKED'; ?>> TCP Ping</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="fragmentation"> Fragmentation</td>
	</tr>
	
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="syn" <?php if ($cfg->default_scan_option == 'syn') echo 'CHECKED'; ?>> SYN Stealth</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="fast_scan"> Fast Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="radio" name="ping_type" value="tcp_icmp" <?php if ($cfg->default_ping_type == 'tcp_icmp') echo 'CHECKED'; ?>> TCP&ICMP Ping</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="ident_info"> Get Ident Info</td>
	</tr>
	
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="null" <?php if ($cfg->default_scan_option == 'null') echo 'CHECKED'; ?>> NULL Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="verbose" <?php if ($cfg->default_verbose) echo 'CHECKED'; ?>> Verbose</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="radio" name="ping_type" value="icmp" <?php if ($cfg->default_ping_type == 'icmp') echo 'CHECKED'; ?>> ICMP Ping</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="resolve_all"> Resolve All</td>
	</tr>
	
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="fin" <?php if ($cfg->default_scan_option == 'fin') echo 'CHECKED'; ?>> FIN Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="udp_scan"> UDP Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="radio" name="ping_type" value="none" <?php if ($cfg->default_ping_type == 'none') echo 'CHECKED'; ?>> Don't Ping</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="os_detect" <?php if ($cfg->default_os_detect) echo 'CHECKED'; ?>> OS Detection</td>
	</tr>
		
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="xmas" <?php if ($cfg->default_scan_option == 'xmas') echo 'CHECKED'; ?>> XMAS Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="rpc_scan"> RPC Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>">&nbsp;</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>">&nbsp;</td>
	</tr>
	
	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="ack" <?php if ($cfg->default_scan_option == 'ack') echo 'CHECKED'; ?>> ACK Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="use_port"> Port Range:</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="use_decoy"> Use Decoy(s):</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="checkbox" name="use_device"> Use Device:</td>
	</tr>

	<tr>
		<td bgcolor="<?php echo $cfg->scansectioncolor; ?>"><input type="radio" name="scan_type" value="window" <?php if ($cfg->default_scan_option == 'window') echo 'CHECKED'; ?>> Window Scan</td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="text" name="port_range" size="10"></td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="text" name="decoy_name" size="10"></td>
		<td bgcolor="<?php echo $cfg->generalsectioncolor; ?>"><input type="text" name="device_name" size="10"></td>
	</tr>
	
</table>
</form>

<?php
	} // if ($submit)
?>

<?php
include "footer.php";
?>
