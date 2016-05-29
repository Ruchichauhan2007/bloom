<?php
if(isset($_GET["user"]) && !empty($_GET["user"]) && isset($_GET["type"]) && !empty($_GET["type"]) && isset($_GET["id"]) && !empty($_GET["id"])   && isset($_GET["userName"]) && !empty($_GET["userName"]))
{
	$userStatus = "AV";	
	$user = $_GET["user"];
	$authType = "PASSWORD";
//	echo $_GET["password"];
	setcookie('user',$user,0,'/', '', false, false);
	setcookie("status",$userStatus,0,'/', '', false, false);
	setcookie("type",$_GET["type"],0,'/', '', false, false);
//	setcookie("password",$_GET["password"],0,'/', '', false, false);
	setcookie("id", $_GET["id"],0,'/', '', false, false);
	setcookie("userName", $_GET["userName"],0,'/', '', false, false);
	setcookie("authType",$authType,0,'/', '', false, false);
	header("Location:portal_dashboard.php");
						
	
}
else 
{
		header("Location:login_userName.php");
} 
?>
