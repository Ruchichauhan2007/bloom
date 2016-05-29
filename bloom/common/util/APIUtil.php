<?php
include 'VMCPortalConstants.php';
import com.vmc.core.info.VMCServiceInfo;
import com.vmc.core.info.RequestInfo;
import com.vmc.core.info.FilterInfo;
import com.vmc.core.info.PageInfo;
import com.vmc.core.api.Admin;
import com.vmc.emr.api.EMR;
import com.vmc.core.util.VMCLogger;
import com.vmc.core.util.FileUtil;

function formatISO8601Date($date){
	$time = date('Y-m-d\TH:i:s.\0\0\0O\Z', $date);
	return $time ;
}


function   getVMCServiceInfo($state)
{
	$currentPage = "";
	$vmcService = new VMCServiceInfo();
	$vmcService->setUserName($_COOKIE['user']);
	$vmcService->setPassword($_COOKIE['password']);
	$vmcService->setAuthType($_COOKIE['authType']);
	$vmcService->setImageName($_COOKIE['imageLoginName']);
	$vmcService->setVersionNumber(getVersion());
	$institutionName = explode(":", $_SERVER['HTTP_HOST']);
	$vmcService->setInstitutionName($institutionName[0]);
	if($state == false)
	{
		$currentPage = 0;
	}
	else
	{
		$currentPage = $_REQUEST['currentPage'];
	}
	if($currentPage > 0)
	{
	$filterInfo = new FilterInfo();
	$pageInfo = new PageInfo();
	$pageInfo->setCurrentPageNo($_REQUEST['currentPage']);	
	$pageInfo->setRecordsPerPage(VMCPortalConstants::$RECORDS_PER_PAGE);
	$numberOfRecords = $pageInfo->getRecordsPerPage();

	?>
	<script>
			var numberOfRecords = '<?php echo $numberOfRecords;?>';
			 $("#moveNext").val(numberOfRecords);
	</script>
	<?php
	$filterInfo->setPageInfo($pageInfo);
	$vmcService->setFilterInfo($filterInfo);
	}
	
	return $vmcService ;
}
function callApiUsingJson($vmcServiceInfo, $methodName, $args, $argAPI)
{
	try
	{
		//TODO: (RUCHI)  This should never create new instance. It should call getInstance
		if($argAPI == VMCPortalConstants::$API_ADMIN)
		{
			$callAPI = new Admin();
		}
		else if($argAPI == VMCPortalConstants::$API_EMR)
		{
			$callAPI = new EMR();
		}

		/**           LOG EVENT      */
		$userLogInfo = array();
		$userLogInfo[0] = new stdClass;
		$userLogInfo[0]->userName = $_COOKIE['user'];
		$userLogInfo[0]->message = "Method Name - ".$methodName."   EntityType - ".$_COOKIE['type'];
		$userLogInfo[0]->messageType = " Log ";
		$userLogInfo[0]->state = 1;
		$userLogInfo[0]->userId = $_COOKIE['id'];
		logEventInfo($vmcServiceInfo, $userLogInfo);
		/**		END OF LOG EVENT */
		$requestInfo = new RequestInfo();
		$jsonParam  = json_encode($args);
		$param = addslashes($jsonParam);
		$requestInfo->setMethodName($methodName);
		$requestInfo->setJsonParams($jsonParam);
		$responseInfo = $callAPI->callAPIUsingJson($vmcServiceInfo, $requestInfo);
		
		logInformation("$$$$$$  Browser-Information   $$$$$  Method Called  == ".$callAPI.".".$methodName."   $$$$$$$  UserName  == ".$vmcServiceInfo->getUserName()."  $$$$  EntityType  == ".$_COOKIE['type']."  $$$$  ID == ".$_COOKIE['id'].  "    End$$$$$$");

		if(is_null($responseInfo))
		{	
			throw new Exception("General Error. Please contact system administrator");
		}
		
		if($responseInfo->isSuccess() == FALSE)
		{
			throw new Exception($responseInfo->getErrorMessage());
		}

	}
	catch (Exception $e)
	{

		logError(">>>>>>  Browser-ERROR   >>>>>  Method Called  == ".$methodName."   >>>>>  ####Exception#####  == ".$e->getMessage()."  >>>>>  EntityType  == ".$_COOKIE['type']."  $$$$  ID == ".$_COOKIE['id'].  "    End >>>>>>");
		throw new Exception($e->getMessage());
	}
	return $responseInfo;
}

function logEventInfo($vmcServiceInfo, $userInfo)
{
	$callAPI = new Admin();
	$requestInfo = new RequestInfo();
	$paramArray = array();
	$paramArray[0] = json_encode($userInfo);
	$jsonParam  = json_encode($paramArray);
	$requestInfo->setMethodName("logInformation");
	$requestInfo->setJsonParams($jsonParam);
	$callAPI->callAPIUsingJson($vmcServiceInfo, $requestInfo);
}

function logInformation($logInformation)
{
	$VMCLogger = VMCLogger::getInstance();
	$VMCLogger->info($logInformation);
}

function logError($logerror)
{
	$VMCLogger = VMCLogger::getInstance();
	$VMCLogger->getInstance()->error($logerror);
}

function getVersion()
{
	$fileUtil = new FileUtil();
	$retVersion = $fileUtil->getVersion();
	return $retVersion;
}
function loginServices($methodName,$serviceName,$userName)
{
	
	  $vmcServiceInfo = new VMCServiceInfo();
	  $vmcServiceInfo->userName = $userName;
		
		$institutionName = explode(":", $_SERVER['HTTP_HOST']);
		
		$vmcServiceInfo->institutionName = $institutionName[0];
		$args = array() ; 
		$response = callApiUsingJson($vmcServiceInfo,$methodName,$args,$serviceName);
		return $response;
}
function authenticateRegisteredUser($methodName, $paramArray ,$serviceName,$password) 
{
	try
	{
		  $vmcServiceInfo = new VMCServiceInfo();
		  $vmcServiceInfo->userName = $_COOKIE['user'];
		  $vmcServiceInfo->password = $password;
		  $vmcServiceInfo->authType = $_COOKIE['authType'];
		  $institutionName = explode(":", $_SERVER['HTTP_HOST']);
		  $vmcServiceInfo->institutionName = $institutionName[0];

		$responseInfo = callApiUsingJson($vmcServiceInfo, $methodName, $paramArray, $serviceName);

		if(!is_null($responseInfo) AND $responseInfo != VMCPortalConstants::$PHP_EMPTY AND $responseInfo->{success} == VMCPortalConstants::$PHP_TRUE AND $responseInfo->getErrorMessage() == VMCPortalConstants::$PHP_EMPTY) 
		{
			$message = $responseInfo->getMessage() ;
			$retVal =  json_decode($message);
		}
		else if($responseInfo->{success} != VMCPortalConstants::$PHP_TRUE AND $responseInfo->getErrorMessage() != VMCPortalConstants::$PHP_EMPTY )
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
	
function login($password)
 {
		try
		{
		  $vmcServiceInfo = new VMCServiceInfo();
		  $vmcServiceInfo->userName = $_COOKIE['user'];
		  $vmcServiceInfo->password = $password;
		  $vmcServiceInfo->authType = $_COOKIE['authType'];
		  $institutionName = explode(":", $_SERVER['HTTP_HOST']);
		  $vmcServiceInfo->institutionName = $institutionName[0];
			$paramArray = array() ;
			
			$responseInfo = callApiUsingJson($vmcServiceInfo, "login", $paramArray, VMCPortalConstants::$API_ADMIN);

			if(!is_null($responseInfo) AND $responseInfo != VMCPortalConstants::$PHP_EMPTY AND $responseInfo->isSuccess() == VMCPortalConstants::$PHP_TRUE AND $responseInfo-> getErrorMessage() == VMCPortalConstants::$PHP_EMPTY) 
			{
				$message = $responseInfo->getMessage() ;
				$loginResp =  json_decode($message);

				if($loginResp->{errorMessage} != VMCPortalConstants::$PHP_EMPTY AND $loginResp->{errorMessage} !=  VMCPortalConstants::$PASSWORD_CHANGE_REQUIRED)
				{
					throw new Exception($loginResp->{errorMessage});
				}
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
		
		return $loginResp;
}

function changeCredential($newCredentialInfo)
 {
	try
	{
		$vmcService = new VMCServiceInfo();
		$vmcService->userName = $_COOKIE['user'];
		$vmcService->password = $_COOKIE['password'];
		$institutionName = explode(":", $_SERVER['HTTP_HOST']);
		$vmcService->institutionName = $institutionName[0];
		
		$jsonString = json_encode($newCredentialInfo); 
		$paramArray = array() ;
		$paramArray[0] = $jsonString;
		$responseInfo = callApiUsingJson($vmcService, "changeCredential", $paramArray, VMCPortalConstants::$API_ADMIN);

		if(!is_null($responseInfo)) 
		{
			$message = $responseInfo->getMessage() ;
			$loginResp =  json_decode($message) ;
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
	
	return $loginResp;
}

function logout($methodName,$serviceName,$params)
 {
	try
	{
		$vmcService = new VMCServiceInfo();
		$vmcService->userName = $_COOKIE['user'];
		$vmcService->password = $_COOKIE['password'];
		$institutionName = explode(":", $_SERVER['HTTP_HOST']);
		$vmcService->institutionName = $institutionName[0];
		$paramArray = array();
		$paramArray[0] = $params;
		$responseInfo = callApiUsingJson($vmcService, $methodName, $paramArray, $serviceName);
		//var_dump($responseInfo->getMessage());
		if(!is_null($responseInfo)) 
		{
			$message = $responseInfo ;
			$loginResp =  json_decode($message) ;
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
	
	return $loginResp;
}
?>