<?php
  $vmcService = new VMCServiceInfo();
  $admin=new AdminPortalWrapper();
  $msg="";

  	if(isset($_POST['submit']))
  	{ 
		$page_error="Password";

  		try
  		{
			$vmcService->setUserName($_COOKIE['user']);
			$institutionName = explode(":", $_SERVER['HTTP_HOST']);
			$vmcService->setInstitutionName($institutionName[0]);
			
			$pinone=$_POST['firstpin'];
			$pintwo=$_POST['secondpin'];
			$pinthree=$_POST['thirdpin'];
			$pinfour=$_POST['fourthpin'];
			$imageName=$_POST['imageNamepin'];
			$Password = $pinone.$pintwo.$pinthree.$pinfour;

			$vmcService->setPassword($Password);
			$vmcService->setImageName($_POST['imageName']);
			$vmcService->setAuthType($_COOKIE['authType']);
			
			$entityUtil = new EntityUtil();
			$loginResp = $entityUtil->login($vmcService);

			if($loginResp != VMCPortalConstants::$PHP_EMPTY)
			{
				$entityInfo = $loginResp->{entityInfo};
				setcookie("status",$entityInfo->{status},0,'/', '', false, true);
				setcookie("password",$vmcService->{password},0,'/', '', false, true);
				setcookie("imageLoginName",$vmcService->{imageName},0,'/', '', false, true);
				setcookie("type",$entityInfo->{entityType},0,'/', '', false, true);
				setcookie("id", $entityInfo->{entityId},0,'/', '', false, true);
				setcookie("userName", $entityInfo->{firstName}." ".$entityInfo->{lastName},0,'/', '',false, true);
				header("Location:portal_dashboard.php");
			}
			else 
			{
			 
			}
		}
		
	  catch(Exception $e)
	  {
	  
	    $msg = $e->getMessage();
		
		if($msg == "USER_NOT_AUTHENTICATED")
		{
			$msg = VMCPortalConstants::$USER_NOT_AUTHENTICATED_IMAGE_AND_PIN;
		}
		
  	 } 
 }

?>
