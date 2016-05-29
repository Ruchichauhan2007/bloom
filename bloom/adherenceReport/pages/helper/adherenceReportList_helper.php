<?php
 $entityUtil = new EntityUtil();

	try
	{
		$msg = "";
		$paramArray = array();
		$paramArray[0] = $_REQUEST["extractType"];
		$aReportList = $entityUtil->getObjectFromServer($paramArray, "getAllAdherenceExtractContent", VMCPortalConstants::$API_EMR);
		//var_dump($aReportList);
		
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}


if($adherenceExtractContentId != "")
{
 $entityUtil = new EntityUtil();

	try
	{
		$msg = "";
		$paramArray = array();
		$paramArray[0] = $adherenceExtractContentId;
		$adherenceExtractContentUrl = $entityUtil->getObjectFromServer($paramArray, "getAdherenceExtractContentUrl", VMCPortalConstants::$API_EMR);
		//var_dump($adherenceExtractContentUrl);
		?>
        <script>
       window.location.href ='<?php echo $adherenceExtractContentUrl ?>';
        </script>
        <?php
		//var_dump($aReportList);
		
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
?>
