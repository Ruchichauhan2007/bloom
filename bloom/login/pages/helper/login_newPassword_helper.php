<?php
    
  $msg="";
  
  if(isset($_POST['submit']))
  { 
		 $page_error="New password";
	   try
  		{				
			
			$newPassword=$_POST['newPassword'];
			$confirmPassword=$_POST['confirmPassword'];
			
			if($newPassword!=$confirmPassword)
			{
				throw new Exception("PASSWORD_MATCH_FAIL");
			}
			else
			{
				$credential = new stdClass ; 
				$credential->userLoginMethodDesc = VMCPortalConstants::$AUTHENTICATION_METHOD_PASSWORD;
				$credential->userName = $_COOKIE['user'];
				$credential->password = $newPassword;
				$credential->passwordChangeReqd = "";
				
				
				$loginResp = changeCredential($credential);
				if($loginResp != VMCPortalConstants::$PHP_EMPTY AND $loginResp->{success} == VMCPortalConstants::$PHP_TRUE )
				{
					$entityInfo = $loginResp->{entityInfo};
					setcookie("password",$newPassword,0,'/', '', false, false);
					setcookie("status",$entityInfo->{status},0,'/', '', false, false);
					setcookie("type",$entityInfo->{entityType},0,'/', '', false, false);
					//setcookie("password",$newPassword,0,'/', '', false, false);
					setcookie("id", $entityInfo->{entityId},0,'/', '', false, false);
					setcookie("user",$_COOKIE['user'],0,'/', '', false, true);
					$authType = $authInfo->{authType};
					setcookie("authType",$authType,0,'/', '', false, true);
					
					if(!empty($_SERVER['HTTPS']))
					{
						header("Location:".VMCPortalConstants::$HTTPS.$_SERVER['HTTP_HOST']."/gladstone/portal/bloom/login/pages/portal_dashboard.php");
						
					}
					else
					{
						header("Location:".VMCPortalConstants::$HTTP.$_SERVER['HTTP_HOST']."/gladstone/portal/bloom/login/pages/portal_dashboard.php");
					}
				}
				else if ( $loginResp->{success} == VMCPortalConstants::$PHP_EMPTY AND $loginResp->{success} == VMCPortalConstants::$PHP_EMPTY)
				{
					
					throw new Exception($loginResp->{errorMessage});
					//header("Location:new-password.php");
				}
					
			}
		}
		 catch(Exception $e)
	  {
		$msg =$e->getMessage();
  	  } 
  }
  ?>
