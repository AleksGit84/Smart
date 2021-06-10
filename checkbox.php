<form name=sasadw method=post>
<input type=checkbox name=kkk[1] value="12;34;00:11:d8:49:aa:68"><br/>
<input type=checkbox name=kkk[2] value="52;38;00:11:d8:43:aa:33"><br/>
<input type=submit>
</form>

<?php
foreach ($_POST['kkk'] as $val)
{
	list($switch_id, $port_id, $mac_cur) = explode(";", $val);
  	echo "DELETE FROM portstatus WHERE `switch_id`=".$switch_id." AND `port_id`=".$port_id." AND `mac_cur`='".$mac_cur."'<br/>";

}
?>