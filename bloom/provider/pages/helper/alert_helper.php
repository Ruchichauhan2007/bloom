<?php
$entityUtil = new EntityUtil();
$getDefaultInfo = new stdClass;
$msg = "";
if(isset($_POST["update"]))
{	
	try
	{
			
		$OnCallProviderId = $_POST["OnCallProviderId"];
		$getDefaultInfo->defaultKey = VMCPortalConstants::$ONCALL_PROVIDER_ID;
		$getDefaultInfo->defaultValue = $OnCallProviderId;
		$getDefaultInfo->defaultId = $_POST["defaultId"];
		$getDefaultInfo->state = VMCPortalConstants::$UPDATE;
		$getDefaultInfo->updateCounter = $_POST["updateCounter"];
		$paramArray =array();
		$paramArray[0] = json_encode($getDefaultInfo);
		$updateDefaults = $entityUtil->postObjectToServer($paramArray, "createUpdateDefaults", VMCPortalConstants::$API_ADMIN);
		//echo "Success";
			
		$paramArray =array();
		$paramArray[0] = VMCPortalConstants::$PHP_FALSE;
		$paramArray[1] = "";
		$providerList = $entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
		

		$paramArray =array();
		$paramArray[0] = VMCPortalConstants::$ONCALL_PROVIDER_ID;
		$getDefaultInfo = $entityUtil->getObjectFromServer($paramArray, "getDefaultInfo", VMCPortalConstants::$API_ADMIN);			
			
		$msg = "Successfully updated";
		
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
}
else
{
		try
	{
		$paramArray =array();
		$paramArray[0] = VMCPortalConstants::$PHP_FALSE;
		$paramArray[1] = "";
		$providerList = $entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
		
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
	try
	{
		$paramArray =array();
		$paramArray[0] = VMCPortalConstants::$ONCALL_PROVIDER_ID;
		$getDefaultInfo = $entityUtil->getObjectFromServer($paramArray, "getDefaultInfo", VMCPortalConstants::$API_ADMIN);
		
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}

}

?>