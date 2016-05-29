<?php 
include '../../common/util/APIUtil.php';
include '../../common/util/CardFactory.php';
include '../../common/util/DateUtil.php';
include '../../common/classes/PatientUtil.php';
include '../../common/classes/EntityUtil.php';
//include ('../set_status.php');
include '../../common/util/VMCAppResource.php';
include '../../common/util/VMCPortalConstants.php';
include '../../login/pages/popup/error_popup.php';

	$msg = "";
	
	$page_error = "Adhoc Report";		
		
	$entityUtil = new EntityUtil();
		try 
		{
			$entityType = $entityUtil->getEntityTypeFromContext();			
			$paramArray = array() ;
			
			$allKannactReportConfig = $entityUtil->getObjectFromServer($paramArray, "getAllKannactReportConfig", VMCPortalConstants::$API_EMR);
		}	
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}	

	if (isset($_REQUEST['submit'])) 
	{
		try 
		{
			$dateUtil = new DateUtil;
			$patientUtil = new PatientUtil;
			$entityType = $entityUtil->getEntityTypeFromContext();
			date_default_timezone_set('UTC');
			$calendarStartDate = $dateUtil->formatInputDateIntoCalendar($_REQUEST ['fromDateInput']);						
			$calendarEndDate = $dateUtil->formatInputDateIntoCalendar($_REQUEST ['toDateInput']);
			$reportHistoryInfo = new stdClass;
			$reportHistoryInfo->reportTitle = $_REQUEST['textTitleinput'];
			$reportHistoryInfo->startDate = $calendarStartDate;
			$reportHistoryInfo->endDate = $calendarEndDate;
			$reportHistoryInfo->isAdhoc = true;
			$reportHistoryInfo->kannactReportConfigId  = $_REQUEST['reportConfigDropDown'];
			$reportHistoryInfo->providerId = $entityUtil->getLoggedInEntityId();
			$reportHistoryInfo->patientId = $_REQUEST['contextPId'];
			$reportHistoryInfo->state = 1;
			$paramArray = array();;
			$paramArray[0] = json_encode($reportHistoryInfo);
			$retVal = $entityUtil->postObjectToServer($paramArray, "scheduleAdhocReport", VMCPortalConstants::$API_EMR);
		}	
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}
	
?>
