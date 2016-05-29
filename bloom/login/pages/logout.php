<?php
include 'controller/base_controller.php';
   try 
   {
   
		$paramArray = "";
		//var_dump($paramArray);
		
		$portalResp = logout("logout",VMCPortalConstants::$API_ADMIN,$paramArray);
		
		if($portalResp != "")
		{
			$userStatus = "UN";
			unset($_COOKIE["status"]);
			unset($_COOKIE["timezoneOffset"]);
			setcookie("status", $userStatus,0,'/');
			unset($_COOKIE["user"]);
			unset($_COOKIE["password"]);
			unset($_COOKIE["imageLoginName"]);
			setcookie('user', null, -1, '/');
            setcookie('password', null, -1, '/');
			setcookie('imageLoginName', null, -1, '/');
			setcookie('type', null, -1, '/');
			setcookie("id", null,0,'/');
			setcookie("userName", null, 0, '/');
			setcookie('timezoneOffset', '', time()-300);
			header("Location:portal_dashboard.php");
		}
		else 
		{
			throw new Exception($portalResp->{errorMessage});
		}
		
	}
	catch(Exception $e) 
	{
		
		$msg = $e->getMessage();
		header("Location:login_userName.php");
	}

?>
