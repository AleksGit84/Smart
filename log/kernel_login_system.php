<?

        $username=$_POST[user];
	$password=$_POST[passw];
	error_reporting(0);
	include("kernel.php");

	session_start();
	session_register("SESSION");

	if (! isset($SESSION)) {
	$SESSION = array();
	}
	
	if($event=='exit') {
	unset ($SESSION["password"]);
	unset ($SESSION["username"]);
	}

	if($enter) { 
	
	$SESSION["username"] = $user;
	$SESSION["password"] = md5($passw);
	
	} 

	$username = $SESSION["username"];
	$password = $SESSION["password"];

$dd = array_search($password, $Users);
?>



<? if (empty($password) or $dd !== $username) { ?>
<center>
<form action="<?=$PHP_SELF?>" method="post">
<input type="text" name="user" size="22"><br>
<input type="password" name="passw" size="22"><br>
<input type="submit" value="войти" name="enter">
</form>
<? 
	die(); 
	} 
?>
