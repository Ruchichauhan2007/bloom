<?php
  
  $msg="";
  $information="";
  $page="";
  
  if(isset($_POST['forgotSubmit']))
  { 
	   $page_error="Reset Credentials";
	   
	   try
  		{	
			
			$args[0] = new stdClass;
			$email=$_POST['email'];
					
			if($email)
			{
				$args[0]->emailAddress = $email;								
				$args[0]->resetPassword = true;
				
				$entityUtil = new EntityUtil();
				$paramArray = array();
				$paramArray[0] = json_encode($args[0]);
				$portalRes = $entityUtil->getObjectFromServer($paramArray, "resetCredentials", VMCPortalConstants::$API_ADMIN);
				//setcookie("status","UN",0,'/', '', false, false);
				
				if($portalRes != "" AND $portalRes->{errorMessage} == "")
				{
					//echo "<script> alert('Reset Credentials');</script>";
					$msg="Your request for your username and/ or password has been sent. Please check the email associated with this account for a message with your information. Thank you.";
					
				}	
				
				if($portalRes->{errorMessage} != "")
				{
					throw new Exception("The entered information does not match to our records. Please confirm you have entered the information correctly and resubmit.");
				}
			}
			else
			{
				throw new Exception("Invaild Email Address.");
			}
		}
		 catch(Exception $e)
	  {
		$msg = $e->getMessage();
  	  } 
  }
   
if(isset($_POST['submit_recovery']))
  { 
	   $page_error="Reset Credentials";
	  // echo "<script> alert('Reset Credentials');</script>";
	   try
  		{	
			
			$args[0] = new stdClass;
			$first_name=$_POST['first_name'];
			$last_name=$_POST['last_name'];			
			$dob=$_POST['dob'];
			
			if($first_name != VMCPortalConstants::$PHP_EMPTY and $last_name!= VMCPortalConstants::$PHP_EMPTY and $dob!= VMCPortalConstants::$PHP_EMPTY)
			{
				$pos = strpos($dob, "/");
		
				if($pos === FALSE)
				{
					$dateArray = explode("-", $dob);
				}
				else
				{
					$dateArray = explode("/", $dob);
				}
		
				$dob = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
				$calendarDob  = new DateTime($dob);
				$calendarDob = $calendarDob->format('Y-m-d\TH:i:s.\0\0\0O\Z');

				$args[0]->firstName = $first_name;
				$args[0]->lastName = $last_name;
				$args[0]->dateOfBirth = $calendarDob;
				$args[0]->resetUserName = true;
				$args[0]->resetPassword = true;
				$entityUtil = new EntityUtil();
				$paramArray = array();
				$paramArray[0] = json_encode($args[0]);
				$portalRes = $entityUtil->getObjectFromServer($paramArray, "resetCredentials", VMCPortalConstants::$API_ADMIN);
				setcookie("status","UN",0,'/', '', false, false);
				if($portalRes != "" AND $portalRes->{errorMessage} == "")
				{
					
					$information = "Your request for your username and/ or password has been sent. Please check the email associated with this account for a message with your information. Thank you.";

					if($_POST['reset']== VMCPortalConstants::$FORGOT_USERNAME)
					{
						$page = "loginUserName";
						setcookie("status","UN",0,'/', '', false, false);

					}
					else if($_POST['reset']== VMCPortalConstants::$FORGOT_PASSWORD)
					{
						$page = "loginPassword";
					}
				}
			
				
				if($portalRes->{errorMessage} != "")
				{
					throw new Exception("The entered information does not match to our records. Please confirm you have entered the information correctly and resubmit.");
				}
			}
			else
			{
				throw new Exception("Email or First , Last & Middle Name and Date of Birth are mandatory.");
			}
		}
		 catch(Exception $e)
	  {
		$msg = $e->getMessage();
  	  } 
  }
  ?>
