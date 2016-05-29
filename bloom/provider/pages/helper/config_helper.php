<?php
$entityUtil = new EntityUtil();
$fieldNameInfo = new stdClass;
$msg = "";
if(isset($_POST["submitForm"]))
{	
	try
	{
			
		$fieldNameInfo->fieldCode = $_POST["fieldName"];
		$fieldNameInfo->state = VMCPortalConstants::$INSERT;
		$paramArray =array();
		$paramArray[0] = json_encode($fieldNameInfo);
		$insertFields = $entityUtil->postObjectToServer($paramArray, "createUpdateField", VMCPortalConstants::$API_ADMIN);
		$msg = "Category successfully added";
		
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
}
else
{
		try
	{
		$findAllFieldName = $entityUtil->getObjectFromServer("BLANK", "findAllFieldName", VMCPortalConstants::$API_EMR);
		var_dump($findAllFieldName);
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}

}

?>