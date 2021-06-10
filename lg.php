<?php
include "header.php";
?>
<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0 bgcolor="#FFFFFF">
<TBODY>
<TR>
<TD>
<?php
passthru("/usr/bin/perl /media/data/www/stats.in.soho.net.ua/smart/lg.cgi");
?>
</TD>
</TR>
</TBODY>
</TABLE>



<!-- <iframe src="http://stats.in.soho.net.ua/smart/lg" width="750" height="800" align="left">
</iframe> -->
<?php
include "footer.php";
?>
