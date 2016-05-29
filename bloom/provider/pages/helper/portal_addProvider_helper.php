<?php
$credential = new stdClass;
$admin = new stdClass;
$providerInfo = new stdClass;
$emailaddressinfo = array();
$phoneInfo = array();

$msg = "";

	if (isset ($_POST['submit'] )) {
		$page_error = "Add Provider";
		try {
		// Set CredentialInfo
		$credential->userName =$_POST ["username"];
		$credential->password =$_POST ["password"] ;
		// Set Patient Details
		$providerInfo->firstName = $_POST ['first_name'] ;
		$providerInfo->middleInitial = $_POST ['middle_name'];
		$providerInfo->lastName =  $_POST ['last_name'] ;
		$dob = $_POST ['dob'];
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
		$providerInfo->dateOfBirth =$calendarDob;
		
		// Set PhoneInfo
		$phoneInfo[0] = new stdClass;
		$phoneInfo[0]->phoneNumber = $_POST ["phone"];
		$phoneInfo[0]->phoneType = "HOME";
		$phoneInfo[0]->phoneTypeDesc_i18nId = 159 ;
		$phoneInfo[0]->state  = VMCPortalConstants::$INSERT  ;
		$providerInfo->phoneInfo = $phoneInfo;

		$providerInfo->state = VMCPortalConstants::$INSERT ;
		$providerInfo->genderCode =$_POST ['gender'];
		$providerInfo->isActive = VMCPortalConstants::$ENTITY_STATUS_ACTIVE ;
		$providerInfo->status=VMCPortalConstants::$USERSTATUS_UNAVAILABLE ;

		$providerInfo->entityType=  VMCPortalConstants::$ENTITYTYPE_PROVIDER;
		$providerInfo->providerType=$_POST ['providertype'];
		$providerInfo->credentials= $_POST ['credentials'] ;
		$providerInfo->specialityCode=$_POST ['speciality'];
		$providerInfo->googleMail=$_POST ['googleMail'];
		
		$emailaddressinfo[0] = new stdClass;
		$emailaddressinfo[0]->emailAddress = $_POST ['email'];
		$emailaddressinfo[0]->state = VMCPortalConstants::$INSERT ;
		$emailaddressinfo[0]->emailTypeDesc_18nId=161;
		$emailaddressinfo[0]->emailType = "PRIMARY";
		//$emailaddressinfo[0]->emailType=VMCPortalConstants::$EMAIL_TYPE;
		$providerInfo->emailAddressInfo = $emailaddressinfo ;
		
		// Set RoleInfo
		$entityUtil = new EntityUtil();
		$array = $entityUtil->getObjectFromServer("BLANK", "getRoles", VMCPortalConstants::$API_ADMIN);
		
		foreach ( $array as $value ) {
			if ($value->{description} == $_POST ['assignrole']) {
				$entityRoleInfo[0] = new stdClass();
				$entityRoleInfo[0] ->roleId =  $value->{roleId};
				$entityRoleInfo[0] ->state =VMCPortalConstants::$INSERT ;
				$providerInfo->entityRoleInfos = $entityRoleInfo;
				break;
			}
		}
				$paramArray = array();
				$paramArray[0] = json_encode($providerInfo);
				$paramArray[1] = json_encode($credential);
				$retProvider = $entityUtil->postObjectToServer($paramArray, "addProvider", VMCPortalConstants::$API_EMR);

				$retVal = $retProvider->{providerId};
				if($_POST["hasImage"] == false || $_POST["hasImage"] == "false")
				{
				?><script>
				openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php','currentPage=1','menu-content','','this')
				
				</script><?php
				}
				else
				{
					header("providerId:".$retProvider->{providerId});
				}
			
				//header("Location:portal_providerList.php");
		
			} catch ( Exception $e ) {
				$msg = $e->getMessage ();
			}
	}
	
	if (isset ($_POST['update'] )) {
		$page_error = "Edit Provider";
		try {
			// Set CredentialInfo
			$entityUtil = new EntityUtil();
			$providerId = $_POST['providerId'];
			$paramArray[0] = $providerId ;
			$providerInfo = $entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);
			
			//var_dump($providerInfo);
			// Set Patient Details
			$providerInfo->firstName = $_POST ['first_name'];
			$providerInfo->middleInitial = $_POST ['middle_name'];
			$providerInfo->lastName = $_POST ['last_name'];
			$providerInfo->dateOfBirth = $_POST ['dob'] ;

			$dob = $_POST ['dob'];

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
			$calendarDob = formatISO8601Date(strtotime($dob));
			$providerInfo->dateOfBirth = $calendarDob ;
			$providerInfo->providerId  = $providerId;
			$providerInfo->entityId = $providerId;
			$providerInfo->state = VMCPortalConstants::$UPDATE ;
			$providerInfo->genderCode = $_POST ['gender'];
			$providerInfo->isActive = VMCPortalConstants::$ENTITY_STATUS_ACTIVE ;
			$providerInfo->entityType=  VMCPortalConstants::$ENTITYTYPE_PROVIDER;
			$providerInfo->providerType= $_POST['providertype'];
			$providerInfo->credentials= $_POST['credentials'] ;
			$providerInfo->specialityCode=$_POST['speciality'];
			$providerInfo->googleMail=$_POST ['googleMail'];

			$phoneInfo = $providerInfo->{phoneInfo};
			$phoneInfo[0]->phoneNumber = str_replace("-","",$_POST ["phone"]);
			$phoneInfo[0]->state  = VMCPortalConstants::$UPDATE  ;
			$phoneInfo[0]->entityId =$providerId ;
			$providerInfo->phoneInfo = $phoneInfo;

			$emailaddressinfo = $providerInfo->{emailAddressInfo};
			if($emailaddressinfo[0]->emailAddress == $_POST ['email'])
			{
				$emailaddressinfo[0]->state = VMCPortalConstants::$NO_UPDATE ;
			}
			else
			{
			$emailaddressinfo[0]->emailAddress = $_POST ['email'];
			$emailaddressinfo[0]->state = VMCPortalConstants::$UPDATE ;
			}
			$providerInfo->emailAddressInfo = $emailaddressinfo;
			$updatePassword = false;
			
			// Set CredentialInfo
			$paramArray = array() ;
			$paramArray[0] = $_POST['providerId'];
			$credential = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
			if($credential->userName != $_POST ["username"])
			{
			$credential->userName = $_POST ["username"];
			$credential->state = VMCPortalConstants::$UPDATE;
			$updatePassword = true;
			}
			$credential->isPasswordChangeReqd = VMCPortalConstants::$PHP_FALSE;
			if((!($_POST ["password"] == "********")) AND $_POST ["password"] != "")
			{
					$credential->password = $_POST ["password"];
					$credential->isPasswordChangeReqd = true;
					$credential->userLoginMethodDesc = VMCPortalConstants::$AUTHENTICATION_METHOD_PASSWORD;
					$credential->state = VMCPortalConstants::$UPDATE;
					$updatePassword = true;
			}
			$paramArray = array();
			$paramArray[0] = json_encode($providerInfo);
			$paramArray[1] = json_encode($credential);
			$retProvider = $entityUtil->postObjectToServer($paramArray, "createUpdateProvider", VMCPortalConstants::$API_EMR);
			$retVal = $retProvider->{providerId};
			// image code
				if($_POST["hasImage"] == false || $_POST["hasImage"] == "false")
			{
				if($_COOKIE['id'] == $_POST['providerId'] and $updatePassword == true)
				{
					echo "<script>showPopLogout();</script>";
					
				}
				else
				{
				?><script>
				openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php','currentPage=1','menu-content','','this')
				
				</script><?php
				}
			}
			else
			{
				header("providerId:".$retProvider->{providerId});
			}
		} catch ( Exception $e ) {
			$msg = $e->getMessage ();
		}
	}
	else if(isset ( $_POST['forward'] ))
	{
		if($_COOKIE['id'] == $_POST['providerId'] and $updatePassword == true)
				{
				
						echo "<script>showPopLogout();</script>";
				}
				else
				{
				?><script>
				openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php','currentPage=1','menu-content','','this')
				
				</script><?php
				}
	}
?>
