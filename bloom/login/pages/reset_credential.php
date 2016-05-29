<?php
$pagename=$_GET['page'];

if($_COOKIE['status'])
{
	$status = $_COOKIE['status'];	
		setcookie("status","AV",0,'/', '', false, false);
		header("Location:".$pagename);
}
else 
{
		header("Location:login_userName.php");
} 
?>
