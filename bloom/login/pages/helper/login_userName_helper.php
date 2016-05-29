<?php
  $msg="";
  if(isset($_POST['next']))
  { 
  	$page_error="No Match";

   try 
   {
    	$userName = trim($_POST['userName']);

		//$args = [];
		//$args = array() ; 
		$responseInfo = loginServices("getAuthInfo",VMCPortalConstants::$API_ADMIN,$userName);

		if(!is_null($responseInfo)) 
		{
			if($responseInfo->{success} != VMCPortalConstants::$PHP_TRUE)
			{
				throw new Exception($responseInfo->getErrorMessage());
			}
			$message = $responseInfo->getMessage() ;
			
			$authInfo =  json_decode($message);
			
			
		}
		else
		{
			throw new Exception("Response NULL.");
		}
		
		$authType = $authInfo->{authType};
		$pendingRegistration = $authInfo->{registration};		
		$institutionURL = $authInfo->{institutionURL};
		
		setcookie("user",$userName,0,'/', '', false, true);
		setcookie("authType",$authType,0,'/', '', false, true);
		$userStatus = "AV";
		unset($_COOKIE["status"]);
		setcookie("status", $userStatus,0,'/');
		
		$requestScheme = "http://";
		if(!empty($_SERVER['HTTPS']))
		{
			$requestScheme = "https://";
		}
		header("location:".$requestScheme.$institutionURL."/gladstone/portal/bloom/login/pages/setlogin_password.php?authType=".$authType."&user=".$userName);
	}
	catch(Exception $e) 
	{
		$msg = $e->getMessage();

	}
 }
?>
