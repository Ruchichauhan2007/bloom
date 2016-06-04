<?php
$entityUtil = new EntityUtil();
$fetched = false;
if (isset ($_REQUEST['Delete'] )) 
{
	try
	{
		$msg = "Delete provider";
		$providerId = $_REQUEST['providerId'];
		$paramArray[0] = "";
		$paramArray[1] = $providerId;
		$entityUtil->postObjectToServer($paramArray, "deleteProvider", VMCPortalConstants::$API_EMR);
		header("Location:portal_providerList.php");
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
else
{
	try
	{
		$msg = "";
		$checkChar = "";
		if($_REQUEST["checkChar"])
		{
			$checkChar = $_REQUEST["checkChar"];
		}
		else
		{
			$checkChar = "";
		}
		$paramArray =array();
		$paramArray[0] = VMCPortalConstants::$PHP_FALSE;
		$paramArray[1] = $checkChar;
		$providerList = $entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
		$fetched = true;
		$moveNext = $providerList[4]->{nextPage};
		?><script>
		$("#getScroll").val('<?php echo $moveNext; ?>');
		$("#nextButton").val('<?php echo $moveNext; ?>');
		</script>
		<?php

	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}

	if(!$fetched)
	{
		$paramArray =array();
		$paramArray[0] = VMCPortalConstants::$PHP_FALSE;
		$providerList = $entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
		//$providerList = $providerUtil->getProviderList(VMCPortalConstants::$PHP_FALSE);
	}
?>