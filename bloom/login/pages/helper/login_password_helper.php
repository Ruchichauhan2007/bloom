<?php
  //$entityUtil = new EntityUtil();
  $msg="";

  	if(isset($_POST['submit']))
  	{ 
		$page_error="Incorrect Email or Password";

  		try
  		{
			$password = $_POST['password'];
			
			$args = array();

			if(isset($_COOKIE['registration']) AND $_COOKIE['registration'] == VMCPortalConstants::$PHP_TRUE)
			{
				unset($_COOKIE["registration"]);

				$retVal = authenticateRegisteredUser("authenticateRegisteredUser", $args,  VMCPortalConstants::$API_ADMIN,$password);
				
				if($retVal == VMCPortalConstants::$PHP_TRUE)
				{
					header("Location:pendingRegMessage.php");
					die(); 
				}
			}
			
			$loginResp = login($password);
			$entityInfo = $loginResp->{entityInfo};
			
			if($loginResp != "" AND $loginResp->{success} == VMCPortalConstants::$PHP_EMPTY AND $loginResp->{errorMessage} ==  VMCPortalConstants::$PASSWORD_CHANGE_REQUIRED)
			{
				setcookie("status","AV",0,'/', '', false, false);
				setcookie("password",$password,0,'/', '', false, false);
				setcookie("type",$entityInfo->{entityType},0,'/', '', false, true);
				
				if(count($loginResp->{authenticationInfos}) == 1)
				{ 
					
					if($loginResp->authenticationInfos[0]->authType == "PASSWORD")
					{ 
						
						header("Location:login_newPassword.php");
					}
					else if ($loginResp->authenticationInfos[0]->authType == "IMAGEANDPIN")
					{ 
						header("Location:set_imageAndPin.php");
					}
					else
					{
						throw new Exception($loginResp->{errorMessage});
					}
					
				}
				else
				{				
					header("Location:login_chooseAuthentication_method.php");
				}
				
				
				
				die(); 
			}
			else if($loginResp != VMCPortalConstants::$PHP_EMPTY AND $loginResp->{success} == VMCPortalConstants::$PHP_TRUE AND $loginResp->{errorMessage} == VMCPortalConstants::$PHP_EMPTY)
			{
				setcookie("status",$entityInfo->{status},0,'/', '', false, false);
				setcookie("type",$entityInfo->{entityType},0,'/', '', false, false);
				setcookie("password",$password,0,'/', '', false, false);
				setcookie("id", $entityInfo->{entityId},0,'/', '', false, false);
				setcookie("userName", $entityInfo->{firstName}." ".$entityInfo->{lastName},0,'/', '', false, false);
				header("Location:portal_dashboard.php");
				die(); 
			}
			else
			{
				unset($_COOKIE["password"]);
				throw new Exception($loginResp->{errorMessage});
			}
		}
		
	  catch(Exception $e)
	  {
		//logError("Portal Exception occured..".$e->getMessage());
		$msg = $e->getMessage();
  	  } 
 }

?>
