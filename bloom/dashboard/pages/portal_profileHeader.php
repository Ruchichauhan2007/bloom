<?php 
$primaryProvider = "";
$entityUtil = new EntityUtil();
$paramArray = array();
$patientId = $_GET["patientId"];

$paramArray = array() ;
$paramArray[0] = $patientId;
$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
$patientProviderInfos = $patientInfo->{patientProviderInfos};
foreach($patientProviderInfos AS $patientProviderInfo)
{
	$no = $patientProviderInfo->{priorityNo};
	if($no == 1)
	{
		$primaryProvider = $patientProviderInfo->{providerId};
	}
}
$providerId = $primaryProvider;
$paramArray[0] = $providerId ;
$providInfo = $entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);

$phoneInfo = $patientInfo->{phoneInfo};
$emailaddressinfo = $patientInfo->{emailAddressInfo};
$dateUtil = new DateUtil();
$dateOdBirthStr = $dateUtil->formatDatetoStr($patientInfo->{dateOfBirth});

$paramArray = array();
$paramArray[0] = $patientId;

// get devices by ptientId
$assignedDevices = $entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
if($patientInfo)
{
$patientLastName = $patientInfo->{lastName};
$patientFirstName = $patientInfo->{firstName};
}
else
{
$patientLastName = $_GET["patientLastName"];
$patientFirstName = $_GET["patientFirstName"];
}

?>
<!--Including css files used in all the html pages -->
<link
  rel="stylesheet" type="text/css"
	href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css" />
<link
	rel="stylesheet" type="text/css"
	href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dsashboard_AddDevices.css" />
<link 
  rel="stylesheet" type="text/css"
  href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboardNew.css" />

<!--***** -->
<!--start wapper -->

<!--start dashboard_header -->
<div>
  <?php
  if (isset ( $_REQUEST['type'] ))
  {
  ?>
  <div class="mytab">
    <ul class="nav nav-tabs" role="tablist" id="addPatientMenu">
      <li role="presentation" id="tab_profile" >
        <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" 
          data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfo->{patientId} ;?>&type=EDIT','','menu-content',event,this)"  
          onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT','','menu-content',event,this)">
          Profile
        </a>
      </li>
      
      <li role="presentation" id="tab_more">
        <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" 
          onClick="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT&edit=true','','menu-content',event,this)"
          data="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId} ;?>&type=EDIT&edit=true','','menu-content',event,this)">
          Support
        </a>
      </li>
      
      <li role="presentation" id="tab_prescription">
        <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" 
          onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">
          Prescription
        </a>
      </li>
      
      <li role="presentation" id="tab_supplies">
        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"  
          onClick="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">
          Supplies
        </a>
      </li>
      
      <li role="presentation" id="tab_devices">
        <a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" 
          onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">
          Devices
        </a>
      </li>
      
      <li role="presentation" id="tab_deviceschedule">
        <a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" 
          onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">
          Device Schedule
        </a>
      </li>
	   <li  id="careManagement" role="presentation"><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Care Management</a></li>
    </ul>
    <div class="pDet">
      <a href="#" id="showNotesBtn">Notes</a>
      <div class="pName"><?php echo $patientInfo->{lastName}." ".$patientInfo->{firstName} ?></div>
      <div class="pDate">DOB	
        <?php
        if($dateOdBirthStr!= "")
        {
        echo $dateOdBirthStr;
        }
        ?>
      </div>
    </div> <!-- END of pDet -->
  </div> <!-- END of class="myTab" -->
  <?php 
  }
  ?>
</div>
<!--end dashboard_header -->

<!-- Notes & History : START -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/notes-history.css" rel="stylesheet" type="text/css">
<script>
function controlMenu()
{

	  var arr = new Array();
      var dataVal = JSON.stringify(arr);
      postDataToServer(dataVal, 'ADMIN', 'login', printResult);

}

function printResult(result)
{
	  if (result == null || result.success == false || result.message == "") {} else {
		  var messageJson = JSON.parse(result.message);
		  var availableMenus = [];
		 for (i = 0; i < messageJson.moduleConfigInfos.length; ++i)
			 {
			 	var key = messageJson.moduleConfigInfos[i].moduleConfigKey;
			 	var value = messageJson.moduleConfigInfos[i].moduleConfigValue;
				//console.log(key);
				availableMenus.push($.trim(key));
			}
			hideMenu(availableMenus);
		}
}
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}
function hideMenu(availableMenu)
{
	$('ul#addPatientMenu li').find('a').each(function(){
			var html = $.trim($(this).html());
			if(!availableMenu.contains(html))
			{	
				var resClass = html.split(" ");
				$(this).parents('li').hide();
			}
		});
}
</script>
<script type="text/javascript">
var patId = '<?php echo $patientInfo->{ patientId }; ?>';
var CURRENT_TIME = '<?php echo date('d M h: i A'); ?>';
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/notes-history.js"></script>

<div class="sidebarBox" style="z-index: 1;">
  <div class="scrollingBox" style="overflow-y: scroll; height:1000px;">
    <ul class="notesList">
      <li class="active" id="NH_allTab"><a href="#">All</a></li>
      <li id="NH_notesTab"><a href="#">Notes</a></li>
      <li id="NH_histTab"><a href="#">History</a></li>
    </ul>
    
    <div class="addCmtBox">
      <textarea id="cmtTextArea"></textarea>
      <div>
        <button id="addCmtBtnIcon" class="addCmtBtn" disabled="true" /> 
        <button class="addCmtBtn" style="font-size: 15px; display: inline-block; vertical-align: top; margin-top: 10px;background:none;border:none; color:rgb(203,203,203)" disabled="true">ADD COMMENT</button>
        
        <input class="pinInput1" type="checkbox" id='pinNewCmt' />
        <label for="pinNewCmt" style="width: 25px; height: 25px; margin-top: 5px;" />
      </div>
    </div>
    <div class="pinnedNotes">
	  </div>
    <div class="notesBox"> 
    </div>
  </div>
</div>
<!-- Notes & History : END -->

<!--end wapper -->