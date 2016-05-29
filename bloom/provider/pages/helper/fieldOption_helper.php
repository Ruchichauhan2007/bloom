<?php
	$entityUtil = new EntityUtil();
	$fetched = false;
	$fieldNameInfo = new stdClass;


if(isset($_POST['submit']))
{
	try
	{
		foreach ($_POST['textinput'] as $key => $value)
		{
			if (empty($value))
			{
				unset($_POST['textinput'][$key]);
			}
		}
		$options = $_POST['textinput'];
		$setOptions = array_values($options);
		$cnt = 0;
		foreach($setOptions as $option)
		{
			
			$fieldOptionInfo = new stdClass;
			$fieldOptionInfo->optionValue = $option;
			$fieldOptionInfo->state = VMCPortalConstants::$INSERT;
			$fieldOptionInfo->fieldNameId = $_POST["fieldNameId"];
			$fieldNameInfo->fieldOptionInfos[$cnt] = $fieldOptionInfo;
			$cnt++;
		}
		$fieldNameInfo->state = 0;
		$fieldNameInfo->fieldNameId = $_POST["fieldNameId"];

		$paramArray[0] = json_encode($fieldNameInfo) ;
		//var_dump($paramArray);
		$createUpdateField = $entityUtil->getObjectFromServer($paramArray, "createUpdateField", VMCPortalConstants::$API_ADMIN);
		$msg = "Successfully Inserted";
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}

?>