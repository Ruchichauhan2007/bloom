<?php
  $vmcService = getVMCServiceInfo();
  $credential = new CredentialInfo();
  $admin=new AdminPortalWrapper();
  $msg="";
  
  if(isset($_POST['submit_form']))
  { 
 	   $page_error="New password";
	   try
  		{				
			$vmcService->setUserName($_COOKIE['user']);
			$vmcService->setPassword($_COOKIE['password']);
			$institutionName = explode(":", $_SERVER['HTTP_HOST']);
			$vmcService->setInstitutionName($institutionName[0]);
			$pinone=$_POST['firstpin'];
			$pintwo=$_POST['secondpin'];
			$pinthree=$_POST['thirdpin'];
			$pinfour=$_POST['fourthpin'];
			$imageName=$_POST['imageNamepin'];

			$newPassword = $pinone.$pintwo.$pinthree.$pinfour;

			if(!$newPassword)
			{
				throw new Exception("Please set pin");
			}
			else
			{
				$credential->setUserLoginMethodDesc(VMCPortalConstants::$AUTHENTICATION_METHOD_IMAGEANDPIN);
				$credential->setUserName($_COOKIE['user']);
				$credential->setPassword($newPassword);
				$credential->setAuthImagename($imageName);
				$credential->setPasswordChangeReqd("");
				
				$loginResp =  $admin->changeCredential($vmcService, $credential);
				$entityInfo = $loginResp->{entityInfo};

				if($loginResp != VMCPortalConstants::$PHP_EMPTY AND $loginResp->isSuccess() == VMCPortalConstants::$PHP_TRUE )
				{
					setcookie("password",$newPassword,0,'/', '', false, false);
					setcookie("imageLoginName",$imageName,0,'/', '', false, false);
					setcookie("type",$entityInfo->{entityType},0,'/', '', false, false);
					setcookie("id", $entityInfo->{entityId},0,'/', '', false, false);
					setcookie("userName", $entityInfo->{firstName}." ".$entityInfo->{lastName},0,'/', '', false, false);
					header("Location:portal_dashboard.php");
				}
				else if ( $loginResp->isSuccess() == VMCPortalConstants::$PHP_EMPTY AND $loginResp->getErrorMessage() != VMCPortalConstants::$PHP_EMPTY)
				{
					throw new Exception($loginResp->getErrorMessage());
				}
			}
		}
		 catch(Exception $e)
	  {
		$msg = $e->getMessage();
  	  } 
  }
  ?>
