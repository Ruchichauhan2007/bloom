<?php
include ('controller/portal_addDevices_controller.php');
	$entityUtil = new EntityUtil();
	
	try 
	{
		$paramArray = array();
		$devicelist = $entityUtil->postObjectToServer($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
		$patientId = $_GET["patientId"];
		
		 $paramArray = array() ;
		$paramArray[0] = $patientId;
		$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
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
		$di = 0;
		if(!empty($devicelist))
		{
			foreach($devicelist as $device)
			{
				if (!empty($assignedDevices))
				{
					foreach($assignedDevices as $adevice)
					{
						if($device->deviceConfigId == $adevice->fkdeviceConfigId)
						{
							unset($devicelist[$di]);
						}
					}
				}
				$di++;
			}
		}
	}
	catch ( Exception $e )
	{
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
?>
<!--Including css files used in all the html pages -->
<link
	href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css"
	rel="stylesheet" type="text/css">
<link
	rel="stylesheet"
	href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dsashboard_AddDevices.css"/>
     <link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboardNew.css" rel="stylesheet" type="text/css">

<!--***** -->
<!--start wapper -->
<!--start dashboard_header -->
<div >
	<?php
if (isset ( $_REQUEST['type'] ))
{
?>
<div class="mytab">
  <ul class="nav nav-tabs" role="tablist" id="addPatientMenu">
    <li role="presentation" ><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfo->{patientId} ;?>&type=EDIT','','menu-content',event,this)"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT','','menu-content',event,this)">Profile</a></li>
    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" 
    onClick="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT&edit=true','','menu-content',event,this)"
     data="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId} ;?>&type=EDIT&edit=true','','menu-content',event,this)">Support</a></li>
    <li role="presentation"><a onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Prescription</a></li>
      <li role="presentation" id="tab_supplies">
        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"  
          onClick="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">
          Supplies
        </a>
      </li>
    <li role="presentation" class="active"><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">Devices</a></li>
    <li role="presentation"><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Device Schedule</a></li>
 <li role="management"><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Care Management</a></li>

  </ul>
   <div class="pDet">
   <a href="#" id="showNotesBtn">Notes</a>
    <div class="pName">
   <?php 
	$patName =  $patientInfo->{lastName}." ".$patientInfo->{firstName};
	$patDisplayName = "";
	 if(strlen($patName) > 23) 
	{
	 $patDisplayName = substr($patName,0,23).'...' ;
	 echo $patDisplayName;
	 }
	 else
	 {
	 	echo $patName;
	 }
	
	 ?>
    </div>
     <div class="pDate">
    <?php
	if($dateOdBirthStr!= "")
	{
	$dateOfB = "DOB";
	echo $dateOfB." ".$dateOdBirthStr;
	}
	?>
	</div>
 
  </div>
  </div>
  <?php
  }
 
  ?>
</div>
<!--end dashboard_header -->
<!-- Notes & History : START -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/notes-history.css" rel="stylesheet" type="text/css">
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
<div class="col-md-8 padd-top20">
	<div id="imageContainer">
		<h3 style="padding-left: 20px;">
			<?php echo constantAppResource::$dashboard_PORTAL_ADDEVICES_INTRO.$patientLastName." ".$patientFirstName?>
		</h3>
		<ul id="imageBox">
			<?php
			if (!empty($devicelist))
			{
				foreach($devicelist as $device)
				{
					?>
				<li id="<?php echo $device->deviceConfigId ?>">
				<span><?php	echo $device->deviceType?> </span>
				<img
				src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/<?php echo $device->deviceImageName?>.png"
				alt="" /></li>
			<?php
				}
			}
			?>
		</ul>
		<h4 style="padding-left: 20px;">
			Assigned
		</h4>
		<div>
			<form id="addDevicesForm" action="" onSubmit="submitForm(event)">
				<div class="dashboard_inventory_leftpart" style="overflow-x:auto;overflow-y:hidden;">

					<ul id="selectedDevices" class="imageContainer">
						<?php
						if (!empty($assignedDevices))
						{
							foreach($assignedDevices as $device)
							{
								?>

						<li ref="<?php echo $device->{deviceConfigId} ?>">
						<span><?php	echo $device->{deviceName} ?> </span>
						<img
							src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/<?php echo $device->deviceImageName;?>.png"
							alt="" /></li>
						<input type="hidden" ref="<?php echo $device->{deviceConfigId} ?>"
							value="<?php echo $device->deviceConfigId ?>" name="deviceId[]">
						<?php
							}
						}
						?>
					</ul>
				</div>
				<div class="dashboard_inventory_rightpart">

					<input type="hidden" name="patientId" id="patientId"
						value="<?php echo  $patientId; ?>" /> <input type="reset"
						value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>" id="cancel">
					<input type="submit" class="submit"	id="addDevices"
						value="<?php echo constantAppResource::$dashboard_PORTAL_ADDDEVICES_TEXT_ORDER;?>">
					<?php
					if($type == "EDIT")
					{
						?>
					<input type="hidden" name="update"
						value="<?php echo constantAppResource::$dashboard_PORTAL_ADDDEVICES_TEXT_ORDER;?>" />
					<?php
					}
					else
					{
						?>
					<input type="hidden" name="submit"
						value="<?php echo constantAppResource::$dashboard_PORTAL_ADDDEVICES_TEXT_ORDER;?>" />
					<?php
					}
					?>


				</div>
				<!---->
			</form>
		</div>

	</div>
</div>
<div class="clear"></div>
<div class="push"></div>

<!--end wapper -->
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
				$("#headerMenu").find("."+resClass[0]).hide();
			}
		});
}
</script>
<script type="text/javascript">
$(document).ready(function()
{	
controlMenu();
		window.location.hash = '/add_device';
			var liCount=$("#selectedDevices li").length;
			if(liCount>2)
			{
				var ulFullwidth=$("#selectedDevices").outerWidth()+(liCount-2)*210;
				$("#selectedDevices").outerWidth(ulFullwidth);
			}
});


		$(document).on('click', '#imageBox li' ,function(e){
		e.stopImmediatePropagation();
			var devHtml = $(this).html();
			var id = $(this).attr("id");
			var selectedDevice = $('<li ref='+id+'></li>');
			selectedDevice.append(devHtml);
			$('#selectedDevices').append(selectedDevice);
			var hiddenInput = "<input type='hidden' name='deviceId[]' value="+id+" ref="+id+" />";
			$('#addDevicesForm').append(hiddenInput)
			$(this).remove();
			var liCount=$("#selectedDevices li").length;
			if(liCount>2)
			{
				var ulFullwidth=$("#selectedDevices").outerWidth()+210;
				$("#selectedDevices").outerWidth(ulFullwidth);
			}
		});
		$(document).on('click', '#selectedDevices li' ,function(e){console.log('clicked')
			e.stopImmediatePropagation();
			var liCount=$("#selectedDevices li").length;
			console.log('count :'+liCount);
			if(liCount>2)
			{
				var ulFullwidth=$("#selectedDevices").outerWidth();
				ulFullwidth=ulFullwidth-210;
				$("#selectedDevices").outerWidth(ulFullwidth);
			}

			var hiddenDiv = $(this).attr('ref');
			var devHtml = $(this).html();
			$('#'+hiddenDiv).show();
			$('input[ref='+hiddenDiv+']').remove();
			$(this).remove();
			var selectedDevice = $('<li id='+hiddenDiv+'></li>');
			selectedDevice.append(devHtml);
			$('#imageBox').append(selectedDevice);

		});
	function submitForm(e)
	{
		postForm("<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_addDevices.php",'addDevicesForm','menu-content',e)
	}
	
	$(function() {
	
$('#cancel').click(function(e){
openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>','','menu-content',e);
});
});
</script>
 <?php include("popup/CientSiderror_popup_add_Device.php");?>
</body>
</html>
