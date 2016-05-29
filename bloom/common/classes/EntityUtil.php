<?php include '../util/VMCPortalConstants.php';
include '../../login/pages/popup/error_popup.php';
$vmcService = getVMCServiceInfo(true);
class EntityUtil
{ 
// Get Entity Type 
function getEntityTypeFromContext() {

		// Get Entity Type 
		if(!is_null($_COOKIE['type']))
	
		{
			$entityType= $_COOKIE['type']; 
		}
		
		if($entityType)
		{
			return $entityType;
		}
		
		return FALSE;
	}	
function getObjectFromServer($param, $methodName, $serviceName) {
		try
		{

			$entityUtil = new EntityUtil;
			$entityUtil->checkLoginStatus();
			
			$vmcService = getVMCServiceInfo(true);

			if($param == "BLANK")
			{
				$paramArray = array();
			}
			else
			{
				$paramArray = $param;
			}
			$responseInfo = callApiUsingJson($vmcService, $methodName, $paramArray, $serviceName);
			
			if(!is_null($responseInfo)) 
			{
				$message = $responseInfo->getMessage() ;
				$loginResp =  json_decode($message) ;
			}
			else
			{
				throw new Exception(VMCPortalConstants::$API_RESPONSE_NULL);
			}
			
			//$entityUtil->extendLoginTimeOut();
		}
		catch(Exception $e)
		{
			try {
				
				if(is_null($e) || $e === NULL) throw new Exception("Error occured. Please retry again.");
				
				$ex =  $e->getMessage();
				
				if(is_null($ex) || $ex === NULL || $ex =="") throw new Exception("Error occured. Please retry again.");
				
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
				
			throw new Exception($ex);
			
		}
		return $loginResp;	
	}
	
	function getObjectWithoutFilter($param, $methodName, $serviceName) {
		try
		{
			$entityUtil = new EntityUtil;
			$entityUtil->checkLoginStatus();
			
			$vmcService = getVMCServiceInfo(false);

			if($param == "BLANK")
			{
				$paramArray = array();
			}
			else
			{
				$paramArray = $param;
			}
			$responseInfo = callApiUsingJson($vmcService, $methodName, $paramArray, $serviceName);
			
			if(!is_null($responseInfo)) 
			{
				$message = $responseInfo->getMessage() ;
				$loginResp =  json_decode($message) ;
			}
			else
			{
				throw new Exception(VMCPortalConstants::$API_RESPONSE_NULL);
			}
			
			//$entityUtil->extendLoginTimeOut();
		}
		catch(Exception $e)
		{
		    //echo 'Caught exception: ',  $e->getMessage(), " ====".$methodName."    \n";
			throw new Exception($e->getMessage());
		}
		return $loginResp;	
	}
	
function postObjectToServer($param, $methodName, $serviceName) 
	{
		try
		{
			$entityUtil = new EntityUtil();
			$loginResp = $entityUtil->getObjectFromServer($param, $methodName, $serviceName);
		}
		catch(Exception $e)
		{
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			//echo 'we are in Entity Utill exception';
			throw new Exception($e->getMessage());
		}
  		return $loginResp;
	}
	
	// Get login userId
	function getLoggedInEntityId() {

		// Get login userId
		if(!is_null($_COOKIE['id']))
	
		{
			$loginId = $_COOKIE['id']; 
		}
		
		if($loginId)
		{
			return $loginId;
		}
		
		return FALSE;
	}
	
	// Get login userName
	function getLoggedInUserNameFromContext() {

		// Get login userName
		if(!is_null($_COOKIE['userName']))
		{
			$userName = $_COOKIE['userName']; 
		}
		
		if($userName)
		{
			return $userName;
		}
		
		return FALSE;
	}	
	
	function getMenuBasedOnEntity()
	{
		$entityUtil =  new $EntityUtil;
		$loginResp = $entityUtil->getObjectFromServer($paramArray, "login", VMCPortalConstants::$API_ADMIN);
		$moduleConfig = $loginResp->moduleConfigInfos;
		
		$VMCMenuArray = array(
		$VMCMenuArray["Sticky Notes"]="false" ,
		$VMCMenuArray["Surveys"]="false" ,
		$VMCMenuArray["Care Team"]="false"
		);

		if($_COOKIE['type'] == "Provider")
		{
			foreach($moduleConfig as $module)
			{
				
				if($module->moduleConfigValue == true)
				{
					if($module->moduleConfigKey == "Sticky Notes")
					{
						$VMCMenuArray["Sticky Notes"]="True" ;
					}
					
					if($module->moduleConfigKey == "Surveys")
					{
						$VMCMenuArray["Surveys"]="True" ;
					}
					
					if($module->moduleConfigKey == "Care Team")
					{
						$VMCMenuArray["Care Team"]="True" ;
					}
				}
			}				
		}

		return $VMCMenuArray;
	}
	
	
	function checkLoginStatus()
	{
		if($_COOKIE['status'])
		{
			$status = $_COOKIE['status'];
			
			if($status == "UN" or $status == "" or $status == null)
			{
				$msg = "Please login again.";
				$url = '../../login/pages/login_userName.php';
				echo "<script>window.location = '../../login/pages/login_userName.php';</script>";
			}
		}
		else if(!$_COOKIE['status'])
		{
			$url = '../../login/pages/login_userName.php';
			echo "<script>window.location = '../../login/pages/login_userName.php';</script>";
		}
	}
	
	function extendLoginTimeOut()
	{
		// setcookie("status",$_COOKIE['status'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("password",$_COOKIE['password'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("imageLoginName",$_COOKIE['imageLoginName'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("type",$_COOKIE['type'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("user", $_COOKIE['user'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("userName", $_COOKIE['userName'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("id", $_COOKIE['id'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("authType", $_COOKIE['authType'],time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '', false, true);
		// setcookie("userName", $_COOKIE['userName']." ".$entityInfo->{lastName},time()+ VMCPortalConstants::$COOKIE_TIMEOUT,'/', '',false, true);
	}
	
	function getAllEmployerList() {
		try
		{
			$paramArray = array() ;
			$vmcService = getVMCServiceInfo(true);
			$responseInfo = callApiUsingJson($vmcService, "getAllEmployerList", $paramArray, VMCPortalConstants::$API_ADMIN);

			if(!is_null($responseInfo) AND $responseInfo != VMCPortalConstants::$PHP_EMPTY AND $responseInfo->isSuccess() == VMCPortalConstants::$PHP_TRUE AND $responseInfo->getErrorMessage() == VMCPortalConstants::$PHP_EMPTY) 
			{
				$message = $responseInfo->getMessage() ;
				$employerList =  json_decode($message);
			}
			else if($responseInfo->isSuccess() != VMCPortalConstants::$PHP_TRUE AND $responseInfo->getErrorMessage() != VMCPortalConstants::$PHP_EMPTY )
			{
				throw new Exception($responseInfo->getErrorMessage());
			}
			else
			{
				throw new Exception(VMCPortalConstants::$API_RESPONSE_NULL);
			}
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
		
		return $employerList;
	}
	
	function postDataToregisterPatient($institutionUrl, $methodName, $paramArray ,$serviceName) {
		try
		{
			$vmcService = getVMCServiceInfo(true);
			$vmcService->setInstitutionName($institutionUrl);
			$responseInfo = callApiUsingJson($vmcService, $methodName, $paramArray, $serviceName);

			if(!is_null($responseInfo) AND $responseInfo != VMCPortalConstants::$PHP_EMPTY AND $responseInfo->isSuccess() == VMCPortalConstants::$PHP_TRUE AND $responseInfo->getErrorMessage() == VMCPortalConstants::$PHP_EMPTY) 
			{
				$message = $responseInfo->getMessage() ;
				$retVal =  json_decode($message);
			}
			else if($responseInfo->isSuccess() != VMCPortalConstants::$PHP_TRUE AND $responseInfo->getErrorMessage() != VMCPortalConstants::$PHP_EMPTY )
			{
				throw new Exception($responseInfo->getErrorMessage());
			}
			else
			{
				throw new Exception(VMCPortalConstants::$API_RESPONSE_NULL);
			}
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
		
		return $retVal;
	}
	
    function callDropdownControls($param) 
	{

		try
		{
			$entityUtil = new EntityUtil();
			
			$paramArray = array() ;
			$paramArray[0] = $param;
			$getOptions=$entityUtil->getObjectFromServer($paramArray, "getFieldOptionsByFieldCode", VMCPortalConstants::$API_ADMIN);
			
		}
		catch(Exception $e)
		{
			throw new Exception($e->getMessage());
		}
  		return $getOptions;
	}	
	
 }

 
 
?>
