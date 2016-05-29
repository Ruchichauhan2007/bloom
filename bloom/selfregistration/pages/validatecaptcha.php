<?php
session_start();

if(($_REQUEST['captcha'] == $_SESSION['cap_code'])){
	echo 1;
}else{
	echo $_SESSION['cap_code'];
}

?>