<?php
  
  	if(isset($_POST['submit']))
  	{       
		$page_error="Authentication Method";

		try
 		{					
			$authType = $_POST['authType'];
			
			if($authType == VMCPortalConstants::$AUTHENTICATION_METHOD_PASSWORD)
			{
				header("Location:login_newPassword.php");
			}
			else if($authType == VMCPortalConstants::$AUTHENTICATION_METHOD_IMAGEANDPIN)
			{
				header("Location:set_imageAndPin.php");
			}
			else
			{
				$msg="Please choose password method";
			}
		}
		catch(Exception $e)
		{
			$msg= 'Caught exception: ';
		}
	}
	else
	{
		$msg="";
	}
?>
