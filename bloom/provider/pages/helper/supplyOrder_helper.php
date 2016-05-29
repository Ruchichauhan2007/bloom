<?php
$entityUtil = new EntityUtil();
	try
	{
		$paramArray = array();
		$getAllPendingOrders = $entityUtil->getObjectFromServer($paramArray, "getPendingShipment", VMCPortalConstants::$API_EMR);
		
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
?>