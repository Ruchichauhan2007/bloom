<?php
include ('controller/portal_addDeviceSchedule_controller.php');
include 'popup/CientSiderror_popup_add_Device.php';
	$patientId = $_POST["patientId"];
	if($patientId == "")
		$patientId = $_REQUEST["patientId"];
	
	$patDeviceDtlId = $_POST["patientDeviceDetailId"];
	if($patDeviceDtlId == "")
		$patDeviceDtlId = $_GET["patientDeviceDetailId"];
		
	try 
	{		
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
		
		if(!is_null($patientId))
		{
			$devicelist = $entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
			$assignedDevices = $devicelist; //$entityUtil->postObjectToServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
		}
	}
	catch ( Exception $e )
	{
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}

?>
<link
	href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css"
	rel="stylesheet" type="text/css">
<style>
.cal ul li {
    border-color: #555555;
    border-style: solid;
    border-width: 3px 3px 3px 3px;
    color: white;
    cursor: pointer;
    float: left;
    font-weight: bold;
    list-style: outside none none;
    padding: 7px 21px;
}

#weekdays-list {
	list-style: none;
	margin-top: 8px;
}
.col-md-8 > span {
    font-size: 21px;
}
#weekdays-list li:first-child {
	margin-left: 0
}

.weekdays {
    background: none repeat scroll 0 0 #888888;
    border-color: #888888;
    border-style: solid;
    border-width: 3px 5px 5px 3px;
    color: #fff;
    float: left;
    font-size: 24px;
    height: 42px;
    margin-left: 12px;
    text-align: center;
    width: 59px;
}

.li-color {
	background: #555555;
	font-size: 20px;
    font-weight: lighter !important;
}

.hour-selected {
background: none repeat scroll 0 0 #33b5e5;
border-bottom:3px solid #2c9dc6 !important;
border-right:3px solid #2c9dc6 !important;
border-left:3px solid #79cfee !important;
border-top:3px solid #79cfee !important;
}

.minute-container {
	background: #33b5e5;
	color: #fff;
	font-weight: bold;
	height: 35px;
	line-height: 1.8;
	padding: 10px;
	position: absolute;
	top: 78px;
	width: 35px;
}

.min-span {
	background: #555555;
	color: #fff;
	cursor: pointer;
	height: 30px;
	padding: 5px;
	width: 30px;
}

.minute-pm-container {
	background: none repeat scroll 0 0 #33b5e5;
	border-bottom:3px solid #2c9dc6 !important;
	border-right:3px solid #2c9dc6 !important;
	border-left:3px solid #79cfee !important;
	border-top:3px solid #79cfee !important;
	color: #fff;
	font-weight: bold;
	height: 35px;
	line-height: 1.8;
	padding: 2px 5px;
	position: absolute;
	top: 53px !important;
	width: 35px;
    z-index: 1;
}

 .minute-container {
	background: none repeat scroll 0 0 #33b5e5;
	border-bottom:3px solid #2c9dc6 !important;
	border-right:3px solid #2c9dc6 !important;
	border-left:3px solid #79cfee !important;
	border-top:3px solid #79cfee !important;
	color: #fff;
	font-weight: bold;
	height: 35px;
	line-height: 1.8;
	padding: 2px 5px;
	position: absolute;
	top: -39px !important;
	width: 35px;
	z-index: 1;
}
#min-selector {
    z-index: 9999;
}
.ampmText {
	font-size: 22px;
	line-height: 55px;
	text-align: right;
	padding: 0;
}

.activeDays {
/*background:url(<?php// $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/bg_Day.png)  no-repeat scroll center center / 57px 49px rgba(0, 0, 0, 0);*/
background: none repeat scroll 0 0 #33b5e5;
border-bottom:3px solid #2c9dc6;
border-right:3px solid #2c9dc6;
border-left:3px solid #79cfee;
border-top:3px solid #79cfee;
}

.popup-body {
	background: #EAEAEA;
	max-width: 870px;
}

#popup_close {
	background-color: #04AEFC;
	width: 100px;
	height: 44px;
	border-radius: 5px;
	border-bottom: solid 5px #0492D4;
	font-size: 18px;
	color: #FFF;
	margin-top: 7px;
}

#footer_button {
	padding: 40px 15px 15px 15px;
}

#model_boby {
	padding: 0px 15px 15px 15px;
}
.modal-header {

    background: -moz-linear-gradient(90deg, rgba(185,185,200,1) 0%, rgba(236,236,239,1) 100%); /* ff3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(236,236,239,1)), color-stop(100%, rgba(185,185,200,1))); /* safari4+,chrome */
    background: -webkit-linear-gradient(90deg, rgba(185,185,200,1) 0%, rgba(236,236,239,1) 100%); /* safari5.1+,chrome10+ */
    background: -o-linear-gradient(90deg, rgba(185,185,200,1) 0%, rgba(236,236,239,1) 100%); /* opera 11.10+ */
    background: -ms-linear-gradient(90deg, rgba(185,185,200,1) 0%, rgba(236,236,239,1) 100%); /* ie10+ */
    background: linear-gradient(0deg, rgba(185,185,200,1) 0%, rgba(236,236,239,1) 100%); /* w3c */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ececef', endColorstr='#b9b9c8',GradientType=0 ); /* ie6-9 */

	height: 45px;
    padding: 9px 16px;
}
#weekdays-list {
    margin-top: 10px;
}
.glucometere_pat {
    background: none repeat scroll 0 0 #fff;
    border-radius: 5px;
    box-shadow: 0 5px 0 0 #a6a9b8;
    height: 190px;
    margin: 4px 0 5px 63px;
}

.glucometere_pat h1 {
    color: #4f4f4f;
    font-size: 25px;
    padding: 8px 0px;
}
.timingEverydayschedule p {
    font-size: 16px;
    color: #707074;
	text-align:center;
}
p.timingEveryday {
    background: url("/gladstone/portal/bloom/dashboard/images/clock.png") no-repeat scroll 0 1px / 22px auto rgba(0, 0, 0, 0);
    max-height: 80px;
    overflow-x: hidden;
    overflow-y: auto;
    padding-left: 30px;
    text-align: left;
    width: 220px;
	height:80px;
}

p.timingEverydayMin {
    background: url(<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/bell.png) no-repeat scroll 0 1px / 26px auto rgba(0, 0, 0, 0);
    margin: 20px 1px 9px;
    padding-left: 30px;
    padding-top: 8px;
	 padding-bottom: 21px;
	 text-align:left;
}
.device_glucometere_1 {
    height: 105px;
    padding: 10px 0 0;
    text-align: center;
    width: 100%;
}
.device_glucometere_1 img {
    height: 88px;
}

#menu-content.col-md-8 .col-xs-offset-1.col-lg-5.glucometere_pat {
    width: 81%;
}

@media (max-width:767px) {
.modal-footer {
    margin-bottom: 20px !important;
    padding: 0 0 15px !important;
}
}
/* popup detail*/
.modal-head {
	padding: 8px 0 0 10px;
	background: linear-gradient(to bottom, #f7f7f9 0%, #f6f6f8 6%, #e4e3e8 31%, #e2e1e7 37%, #d9dadf 49%, #ceceda 66%, #cbcbd5 69%, #c7c7d3 77%, #c2c1cf 83%, #b9b8c6 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f9', endColorstr='#b9b8c6', GradientType=0 );
	height: 37px;
	border:none;

}
.popup_weight_scale {
	width: 698px;
	height: 555px;
	background-color: #e8e8e8;
	padding:0px;
}

.weight_scale_text
{
margin-top:30px;
}

.weight_scale_text h2
{
margin: 0px;
font-size: 17px;
padding-bottom: 10px;
}

.weight_scale_text select
{
background-color: #f3f3f3;
padding: 14px 18px
}
.weight_scale_input input
{
width: 55px;
height: 43px;
border: solid 1px #ccc;
padding: 5px;
text-align: center;
font-size:20px;
}
.weight_scale_input span
{
text-align: center;
padding-left: 13px;
/* font-weight: bold; */
color: #000;
}

.weight_scale_but
{
position:absolute;
bottom:0;
}

.col-lg-12.weight_scale_but input[type=reset] {
background-color: #04AEFC;
width: 100px;
height: 44px;
border-radius: 5px;
border-bottom: solid 5px #0492D4;
font-size: 18px;
color: #FFF;
margin-top: 7px;
border-right: none;
}

.col-lg-12.weight_scale_but input[type=submit] {
font-size: 18px;
background-color: #1adb82;
color: #fff;
border-radius: 5px;
border-bottom: solid 5px #18ab67;
border-left: none;
border-top: none;
border-right: none;
padding: 3px;
margin: 10px 10px;
height: 44px;
width: 100px;
text-align: center;
margin-left: 0px;
cursor: pointer;

}
.weight_scale_input p
{
padding-top:10px;
font-size:17px;
}
::-webkit-input-placeholder {
   color: #000;
   font-size:14px;
}

:-moz-placeholder { /* Firefox 18- */
   color: #000;
   font-size:15px;
}

::-moz-placeholder {  /* Firefox 19+ */
  color: #000;
  font-size:15px;
}

:-ms-input-placeholder {
   color: #000;
   font-size:15px;
}
.but_detail a {
    background: none repeat scroll 0 0 #000;
    border-radius: 5px;
    color: #fff;
    padding: 3px 10px;
}
.but_detail li {
    display: inline;
    list-style: outside none none;
}
.col-md-3.weight_scale_input {
color: #000;
float: left;
font-size: 25px;
margin-right: 19px;
text-align: center;
width: 87px;
padding: 0;
}
.col-md-3.weight_scale_input p{
	font-size: 23px;
    margin-top: 4px;
}
#RangeGlucose > p {
    font-size: 18px;
    padding: 8px 0;
}
#RangeGlucose > h1 {
    font-size: 25px;
}
#RangeGlucose span.col-md-9 {
    padding: 0;
}
.white_content.Date_Pop_For_Okey {
    background: none repeat scroll 0 0 #e8e8e8;
    border: 1px solid #3c3c3c;
    position: absolute !important;
    width: 56%;
    z-index: 99999;
	top: 15px !important;
}
.cart1 {
margin: 0px;
background-color: #ccc;
background: linear-gradient(to bottom, #f7f7f7 0%, #f5f5f7 6%, #e4e3e8 32%, #e4e3e9 35%, #bab9c7 100%);
padding: 10px;
}
.btnpatlist1 {
    float: right;
    margin-top: 70px;
    padding: 6px 18px;
}
.alert > div#txt {
    float: left;
    margin: 13px 0 0 6px;
	width: 75%;
	word-break: break-word;
}
.white_content {
	min-height: 220px !important;
	height: auto;
	
}

.set-range h1 {
    font-size: 25px;
    margin: 20px 0;
}
.range-work h2 {
    color: #999999;
    font-size: 20px;
    padding-top: 6px;
}
.range-work label {
    color: #666666;
    font-weight: normal;
}

.set-range p {
    font-size: 18px;
    margin-bottom: 20px;
    text-align: justify;
    width: 85%;
}
.btn.btn-default.btngreen {
    background: #6aa84f none repeat scroll 0 0;
    border: 0 none;
    border-radius: 0;
    box-shadow: 0 0 0;
    color: #fff;
    padding: 13px 35px;
	font-size:20px;
}
.setRange-buttonGrp {
    margin: 65px 0 25px;
    text-align: right;
}
.btn.btn-default.btnblue {
    background: #2DB0F6 none repeat scroll 0 0;
    border: 0 none;
    border-radius: 0;
    box-shadow: 0 0 0;
    color: #fff;
    padding: 13px 35px;
	font-size:20px;
}
</style>
 <link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboardNew.css" rel="stylesheet" type="text/css">
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
			}
		});
}
controlMenu();
</script>
<!--start dashboard_header -->
<div class="mytab">
	<?php
if (isset ( $_REQUEST['type'] ))
{
?>
  <ul class="nav nav-tabs" role="tablist"  id="addPatientMenu">
    <li role="presentation"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfo->{patientId} ;?>&type=EDIT','','menu-content',event,this)"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT','','menu-content',event,this)">Profile</a></li>
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
    <li role="presentation"><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">Devices</a></li>
    <li role="presentation" class="active"><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Device Schedule</a></li>
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
	echo $dateOfB." ". $dateOdBirthStr;
	}
	?>
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
<div class="shiftDown">
	<!-- display devices -->
	<?php
	foreach( $devicelist AS $device )
	{

		?>
<div class="col-md-8 padd-top20">
		<!-- Range Div-->
	<div class="col-xs-offset-1 col-lg-5 glucometere_pat deviceName_<?php echo $device->{deviceName};?>" onclick="setDate('<?php echo $device->{patientDeviceDetailId} ?>',<?php echo $device->{deviceConfigId} ?>,'<?php echo $device->{measurementName1} ?>',this)">
    <input type="hidden" name="setRangeFlow" id="setRangeFlow"/>
<div class="row">
<div class="col-lg-7 timingEverydayschedule">
<h1><?php	echo $device->{deviceName};?></h1>

					<div style="display: inline-block;" class="device-schedule">
					<p class="timingEveryday">
						<input type="hidden" class="startDate"
							value="<?php echo $device->startDate?> " />

							<span>
						<?php
						$vitalInfos = $device->patientVitalScheduleInfos;
						if(!empty($vitalInfos))
						{
							foreach( $vitalInfos AS $vitalInfo )
							{

								$day = $vitalInfo->{day};
								if($day != "EVERYDAY")
									$day = substr( $vitalInfo->{day},0,3);
								$hour = $vitalInfo->{hour};
								$min = $vitalInfo->{minute};
								if($min == 0)
								{
									$min = "00";
								}
								$ampm = "am";

								if($hour > 12)
								{
									$ampm = "pm";
									$hour = $hour - 12;
								}
								if($hour < 10)
								{
									$hour = "0".$hour;
								}

								?>
						<label><?php echo $day ?>&nbsp;<?php echo $hour?>:<?php echo $min?>&nbsp;<?php echo $ampm?>
						</label><br />

						<?php
							}
						}
						?>
					 </span>


						</p>
						</div>
<p class="timingEverydayMin"></p>

		</div>
		<div class="col-lg-5 timingEverydayschedule">
<div class="device_glucometere_1">

<a id="<?php echo $device->{deviceConfigId} ?>" href="#">

<img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/<?php echo $device->{deviceImageName};?>.png" alt="" />
</a>
</div>
<p>Acceptable Range<br />
<?php if($device->{deviceName} == "Weight Scale")
{
 ?>
<span class="rangesSpan"><?php echo $device->{minUnitValue1}."-".$device->{maxUnitValue1}." ".$device->{unitName1} ?></span></p>
<?php
}
else
{
?>
<span class="rangesSpan"><?php echo $device->{minUnitValue2}."-".$device->{maxUnitValue2}." ".$device->{unitName1} ?></span></p>

<?php
}
?>
</div>
</div>


	</div>
	</div>

	<?php

	}
	?>

	<div class="clear dashboard_device_head">

		<div class="dashboard_inventory_rightpart">
			<form
				onSubmit="openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php','patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','menu-content',event,'myModal')">
				<input type="reset" value="Cancel" id="cancel">
				<input type="submit" class="submit" value="Save">
			</form>
		</div>
	</div>
</div>
</div>
<div class="clear"></div>
<div class="push"></div>

<div class="modal bs-example-modal-lg" id="schedulePopup" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content popup-body">

			<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel"  style="width: 97%; float: left;">Glucometer</h4>
				<!--<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
				</button>-->

			</div>
<div class="dashboardpopup_glucometer_nav">
					<ul>
						<li><a href="#" id="schedule"><img id="schedule_img"
								src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/schedule.png">
						</a></li>
						<li><a href="#" id="range"><img id="range_img"
								src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/ranges.jpg">
						</a></li>
					</ul>
				</div>
				<div style="clear:both"></div>
			<div class="modal-body" id="model_boby">
				<div id="schedule12">
					<form action="" method="post" id="hidden-fields"
						onSubmit="return validateDate(event)">
						<div class="row">
							<div class="col-xs-offset-1 col-md-3 chooseDate1" style="margin-top: 38px; padding-left: 0;">

									<!--<input type="text" placeholder=""
									id="startDate" name="startDate" />-->
									<div class="col-md-4" style="padding-right:0px;">
									<a href="#"><input type="hidden" placeholder=""
                                id="startDate" name="startDate"  /></a>
									</div>
									<div class="col-md-8" style="padding: 0px; font-size: 22px; line-height: 24px; margin-top: 7px;">
									<p>Start Date<br />
										<span id="date1">May 2, 2014</span></p>
									</div>
							</div>
							<div class="col-md-8 chooseEveryday" style="margin-top: 15px;margin-left: 33px;width: 60%;">
								<input type="checkbox" name="everyday" id="checked" /> <span>Everyday</span>
								<ul id="weekdays-list">
									<li class="weekdays" ref="Sunday">Sun</li>
									<li class="weekdays" ref="Monday">Mon</li>
									<li class="weekdays" ref="Tuesday">Tue</li>
									<li class="weekdays" ref="Wednesday">Wed</li>
									<li class="weekdays" ref="Thursday">Thu</li>
									<li class="weekdays" ref="Friday">Fri</li>
									<li class="weekdays" ref="Saturday">Sat</li>
								</ul>
							</div>
						</div>
						<div class="row" style="margin-top: 60px">
							<div class="col-md-1 ampmText">AM</div>
							<div class="col-md-11">
								<div id="min-selector" style="display: none; position: absolute">
									<span class="min-span">00</span> <span class="min-span">15</span>
									<span class="min-span">30</span> <span class="min-span">45</span>
								</div>
								<div style="clear: both"></div>
								<div id="amTimePick" class="cal">
									<ul>
										<li class="li-color" ref="12">12</li>
										<li class="li-color" ref="1">1</li>
										<li class="li-color" ref="2">2</li>
										<li class="li-color" ref="3">3</li>
										<li class="li-color" ref="4">4</li>
										<li class="li-color" ref="5">5</li>
										<li class="li-color" ref="6">6</li>
										<li class="li-color" ref="7">7</li>
										<li class="li-color" ref="8">8</li>
										<li class="li-color" ref="9">9</li>
										<li class="li-color" ref="10">10</li>
										<li class="li-color" ref="11">11</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: 50px">
							<div class="col-md-1 ampmText">PM</div>
							<div class="col-md-11">
								<div id="min-pm-selector"
									style="display: none; position: absolute">
									<span class="min-span">00</span> <span class="min-span">15</span>
									<span class="min-span">30</span> <span class="min-span">45</span>
								</div>
								<div style="clear: both"></div>
								<div id="pmTimePick" class="cal">
									<ul>
										<li class="li-color" ref="12">12</li>
										<li class="li-color" ref="1">1</li>
										<li class="li-color" ref="2">2</li>
										<li class="li-color" ref="3">3</li>
										<li class="li-color" ref="4">4</li>
										<li class="li-color" ref="5">5</li>
										<li class="li-color" ref="6">6</li>
										<li class="li-color" ref="7">7</li>
										<li class="li-color" ref="8">8</li>
										<li class="li-color" ref="9">9</li>
										<li class="li-color" ref="10">10</li>
										<li class="li-color" ref="11">11</li>
									</ul>
								</div>
							</div>

						</div>
						<div class="modal-footer" id="footer_button">

							<input type="hidden" name="patientId"
								value="<?php echo $patientId ?>" /> <input type="hidden"
								name="patientDeviceDetailId" class="patientDtlId"
								id="patientDeviceDetailId"
								value="<?php echo $patDeviceDtlId; ?>" /> <input type="hidden"
								name="submitSchedule" value="true" />
							<button type="reset" class="btn btn-default popup_close"
								 id="popup_close">Cancel</button>
							<input type="submit" class="btn btn-primary" delete-id="0"
								id="provider-delete-button" name="submitSchedule" value="Save" />

						</div>
					</form>
				</div>
				<!-- schedule end -->


				<!-- ranges start -->
                 <?php
				if (!empty($assignedDevices))
					{
						foreach($assignedDevices as $deviceModel)
						{
							//var_dump($deviceModel);
							if($deviceModel->{measurementName1} == "Glucose")
							{
							?>
				<div class="range12 <?php echo $patDeviceDtlId; ?>" id="range12" style="">
					<form action="" method="post" id="ranges-form"
						onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_addDeviceSchedule.php','ranges-form','menu-content',event)">
						<input type="hidden" id="devId" value="" />
						<div class="dashboardpopup_glucometer_left">
						
											<div class="dataGroupSection">
											<label>Make/Model</label><br>
											<span class="custom-dropdown custom-dropdown--white" style=" margin-right:70px;">
											<select name="model" id="model" class="custom-dropdown__select custom-dropdown__select--white">
												
												<option ><?php	echo $deviceModel->{model};?></option>
												
											</select>
											</span>
										</div>
										   <div class="dataGroupSection">
											<div class="form-group">
												<label class="control-label" for="textinput" style="margin-top: 15px;">Adapter ID</label>  
												 <div class="col-md-12" style="padding: 0; width: 73%;">
						  <input id="adapterId" name="adapterId" placeholder="123456789012345" style="height: 43px; border-radius: 5px; font-weight: normal; width: 80%;" class="form-control input-md" type="text" value="<?php echo $deviceModel->{vendorDeviceId};?>">
													  <span class="help-block" style="color: #000; font-size: 17px;">See sticker on back of adapter</span>  
													  </div>
													</div>
											<div class="form-group">
												<label class="control-label" for="textinput" style="margin-top: 15px;">Frequency Reading</label>  
												 <div class="col-md-12" style="padding: 0; width: 73%;">
						  <input id="frequencyReading" name="frequencyReading" placeholder="123" style="height: 43px; border-radius: 5px; font-weight: normal; width: 80%;" class="form-control input-md" type="text" value="<?php echo $deviceModel->{frequencyReading};?>">
													   
													  </div>
													</div>
											</div>
										
						</div>						
						<div class="dashboardpopup_glucometer_left">

						
						<div id="RangeGlucose">
                       
                                <h1>Glucose Range</h1>
                                    <?php
                                        if($patientInfo->{programType} == "IOP")
                                        {
                                    ?>
                                <p><span class="col-md-9">Hi</span> <?php echo $deviceModel->{deviceMaxValue} ?> mg/dl</p>
                                <p><span class="col-md-9">Caution Zone High (Yellow)</span> <input type="text" name="maxUnitValue2" value="<?php echo $deviceModel->{upperRangeUnit2} ?>" 	 style="  line-height: normal;text-transform: none;  width: 38px;height: 23px;text-align:center;  border: 1px solid #ccc;  border-radius: 5px;"/> mg/dl</p>
                                <p><span class="col-md-9">Target Zone High (Green)</span> <?php echo $deviceModel->{lowerRangeUnit2} ?> mg/dl</p>
                                <p><span class="col-md-9">Target Zone Low (Green)</span> <?php echo $deviceModel->{upperRangeUnit1} ?> mg/dl</p>
                                <p><span class="col-md-9">Caution Zone Low (Yellow)</span><input type="text" name="minUnitValue1" value="<?php echo $deviceModel->{lowerRangeUnit1} ?>" style="  line-height: normal;text-transform: none;  width: 38px;height: 23px;text-align:center;  border: 1px solid #ccc;  border-radius: 5px;"/> mg/dl</p>
                                <p><span class="col-md-9">Lo</span> <?php echo $deviceModel->{deviceMinValue} ?> mg/dl</p>								
                                 <?php
                                    }
                                    else
                                        {
                                    ?>
                                         <p><span class="col-md-9">Hi</span> <?php echo $deviceModel->{deviceMaxValue} ?> mg/dl</p>
                                <p><span class="col-md-9">Caution Zone High (Yellow)</span> <?php echo $deviceModel->{upperRangeUnit2}?> mg/dl</p>
                                <p><span class="col-md-9">Target Zone High (Green)</span> <?php echo $deviceModel->{lowerRangeUnit2} ?> mg/dl</p>
                                <p><span class="col-md-9">Target Zone Low (Green)</span> <?php echo $deviceModel->{upperRangeUnit1}?> mg/dl</p>
                                <p><span class="col-md-9">Caution Zone Low (Yellow)</span> <?php echo $deviceModel->{lowerRangeUnit1} ?> mg/dl</p>
                                <p><span class="col-md-9">Lo</span> <?php echo $deviceModel->{deviceMinValue} ?> mg/dl</p>	
                                <?php
                                }
							?>
							</div>

						</div>
						<div style="clear: both"></div>

						<br clear="all" />
						<div class="modal-footer" style="margin-top:0px;">

							<input type="hidden" name="patientId"
								value="<?php echo $patientId ;?>" /> <input type="hidden"
								name="patientDeviceDetailId" class="patientDtlId"
								value="<?php echo $patDeviceDtlId; ?>" />
							<button type="reset" class="btn btn-default popup_close"
								 id="popup_close">Cancel</button>
							<input type="submit" class="btn btn-primary" delete-id="0"
								id="provider-delete-button" name="submitRange" value="Save" />
							<input type="hidden" name="submitRange" value="true" />
                          
						</div>
					</form >
				</div>
                <?php
										}
									  else if($deviceModel->{measurementName1} == "Peak Flow")
									  {
									  
									  ?>
										<div class="set-range" id="setFlowRange">
                                        <form action="" method="post" id="ranges-flow"
						onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_addDeviceSchedule.php','ranges-flow','menu-content',event)">
                        <input type="hidden" name="patId"
								value="<?php echo $patientId ?>" /> 
                                <input type="hidden"
								name="patDeviceDetailId" class="patientDtlId"
								id="patDeviceDetailId"
								value="<?php echo $patDeviceDtlId; ?>" />
                                 <input type="hidden" name="flowRangeSubmit" value="true" />
                                        <h1>Set Range</h1>
                                        <div class="row form-group range-work">
  <label class="col-md-3 control-label" for="textinput">Peak Flow Goal</label>  
  <div class="col-md-3">
  <input name="flowUnit" id="flowUnit" placeholder="" class="form-control input-md" type="text" value="<?php echo $deviceModel->{upperRangeUnit1} ; ?>">
     </div>
     <div class="col-md-6">
  <h2>L/min</h2>
     </div>
</div>

<p>When set, the Peak Flow Goal and is shown on the Peak Flow Chart, for patients and providers. The Danger level is set to 50% of the Peak Flow Goal. This dose not trigger high or low alarms.</p>

<div class="setRange-buttonGrp">
<button class="btn btn-default btngreen" name="cancel" type="reset">Cancel</button>
<button class="btn btn-default btnblue" type="submit" name="flowRangeSubmit" id="flowRangeSubmit">Save</button>
</div>

                                        </form>
                                        </div>
										<?php
									  }
									  else
									  {
									  }
									}
								}
								?>  
				<!-- ranges end -->
			</div>
			<!--Model body ends-->
		</div>

	</div>

</div>

<script>
function validateDate(e)
{
	if($('#startDate').val() == "")
	{
		//alert('Start Date is required');
		e.preventDefault();
		showPop();
		$("#fadediv_popup").show();
		$("#light").show();
		$("#txt").html("Start Date is required.")

		return false;
	}
	else  if(!$("#weekdays-list li").hasClass("activeDays"))
	{
	 //alert("Please select day");
	 	showPop();
			$("#fadediv_popup").show();
		$("#light").show();
		$("#txt").html("Please select day.")
	 return false;

	}
	else  if(!$(".cal ul li").hasClass("hour-selected"))
	{
	 //alert("Please select time");
	 showPop();
	$("#fadediv_popup").show();
	$("#light").show();
	$("#txt").html("Please select time.")
	 return false;

	}
	postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_addDeviceSchedule.php','hidden-fields','menu-content',e);
}

function hidePopup() {
    $("#light").hide();
    $("#fadediv_popup").hide();
	
}



function showPop() {
    $("#model_boby").prepend("<div class='white_content Date_Pop_For_Okey' id='light'><p class='cart1'>Message<a href='#' id='img_close'  onClick='javascript:hidePopup()'><img src='../images/close.jpg' align='right' class='close'></a></p><div class='dashboard_box_bg_text'><a href='#'></a></div><div class='alert'><img src='../images/alert.jpg' align='left'  /><div id='txt'></div><a href = '#' class='btnpatlist1' id='okey_close'  onClick='javascript:hidePopup()'>Okay</a></div>");
    $("#model_boby").prepend("<div id='fadediv_popup' class='black_overlay' onClick='javascript:hidePopup()'  style='display: block;'></div>");

}
window.location.hash = '/add_device_schedule';
$('#cancel').click(function(e){
postFormAndHideAlert('../../dashboard/pages/portal_addDevices.php?type=EDIT&patientId=<?php echo $patientId; ?>&patDeviceDtlId=<?php echo $patDeviceDtlId; ?>','','menu-content',event,'myModel');
});

/*var rangesTab = function rangeTab()
{
        $("#range12").css('display', 'block');
		$("#schedule12").css('display','none');
		$("#schedule_img").attr('src','/gladstone/portal/bloom/dashboard/images/dashboard_schedule.png');
		$("#range_img").attr('src','/gladstone/portal/bloom/dashboard/images/dashboard_ranges.png');

}
*/



function setDate(deviceId,deviceConfigId,deviceName,ele)
{
	$('#setRangeFlow').val(deviceName);
	if(deviceName =="Glucose" || deviceName =="Peak Flow")
	{
	$('#range').on("click", function (e) {
        e.preventDefault();
		rangesTab(deviceName);
    });
	//$("#range").bind('click',rangesTab(deviceName));
	}
	else
	{
	$('#setRangeFlow').val();
	//$("#range").off('click');
	$("#range").unbind( "click" );

	}
	//$("#devId").append('<input type="text" id="devId" value='+deviceId+' />');
	var titlePopup = $(ele).find('.timingEverydayschedule h1').text();
//	console.log(titlePopup);
	$("#myModalLabel").html(titlePopup);
	
	 $("#devId").val(deviceConfigId);
	$("#schedulePopup").show();
	$('#schedulePopup').modal('show');
	// set device detail Id
	$('.patientDtlId').val(deviceId);
	// set popup values
	$('.minute-container').remove();
	$('.li-color').removeClass('hour-selected');
	$( "input[id^='am-']" ).remove();
	$( "input[id^='pm-']" ).remove();
	$( "input[id^='wd-']" ).remove();

	var startDate = $(ele).find('input.startDate').val();
	var fomattedDate = getFormattedDate(startDate);
	$('#startDate').val($.trim(fomattedDate));
	$('#date1').html(fomattedDate);
	var timeslabel = $(ele).find('div.device-schedule label');

	// no time is selected

	if(timeslabel.length == 0)
	{
		setDay('EVERYDAY');
	}

	$(timeslabel).each(function(){
		var timeLabelHTML = $.trim($(this).html());
		splitLabel(timeLabelHTML);
	});

	// set range value

	setRanges(ele);

	 $("#range12").css('display', 'none');
	 $("#setFlowRange").css('display', 'none');
		$("#schedule12").css('display', 'block');
		$("#schedule_img").attr('src','/gladstone/portal/bloom/dashboard/images/schedule.png');
		$("#range_img").attr('src','/gladstone/portal/bloom/dashboard/images/ranges.jpg');
}

function setRanges(ele)
{
	var rangesHtml  = $.trim($(ele).find('.rangesSpan').html());
	if(rangesHtml != null && rangesHtml != "")
	{
		//120-180 mg/dL
		var rangeStr = rangesHtml.split(" ");
		var range = rangeStr[0].split("-");
		// low range value
		$('#lower-range').html(range[0]);
		// high range value
		$('#upper-range').html(range[1]);
		// device unit
		$('#device-unit').html(rangeStr[1]);
	}
}

function getFormattedDate(startDate)
{
	//2014-11-09T18:44:40.000+0530
	startDate = $.trim(startDate);
	if(startDate != null && startDate != "")
	{
		var dateTime = startDate.split("T");
		var date = dateTime[0].split("-");

		//12/04/2014
		//Dec 05,2014
		var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		return monthNames[date[1]-1]+" "+date[2]+","+date[0];
	}
	return "";
}

function splitLabel(time)
{
// time is in format EVERYDAY 3:45 am
	//weekdays[]
	//time[]
	//1:30-am
	if(time != undefined && time != "" && time != null)
	{
		var timeArr = time.split("&nbsp;");
		var day = timeArr[0];

		setDay(day);

		var hm = timeArr[1].split(":");
		var hour = hm[0];


		var minute = hm[1];

		var ampm = timeArr[2];
		setHourLi(hour,ampm,minute);

	}
}

function setDay(day)
{
	if(day != undefined && day != "" && day != null)
	{
	 var ref;
		switch(day)
		{
		  case 'EVERYDAY':
			$('input[name=everyday]').attr('checked','checked');
			$('#weekdays-list li').addClass('activeDays');
			break;
		   case 'Sun':
			ref="Sunday";
			selectAndAppendDay(ref);
			break;
		  case 'Mon':
			ref="Monday";
			selectAndAppendDay(ref);
			break;
		  case 'Tue':
			ref="Tuesday";
			selectAndAppendDay(ref);
			break;
		  case 'Wed':
			ref="Wednesday";
			selectAndAppendDay(ref);
			break;
		  case 'Thu':
			ref="Thursday";
			selectAndAppendDay(ref);
			break;
		  case 'Fri':
			ref="Friday";
			selectAndAppendDay(ref);
			break;
		  case 'Sat':
			ref="Saturday";
			selectAndAppendDay(ref);
			break;
			}
	}
}
function selectAndAppendDay(ref)
{
	if($('#wd-'+ref).val() == undefined || $('#wd-'+ref).val()== "" || $('#wd-'+ref).val() == null)
	{
		$('#weekdays-list li[ref='+ref+']').addClass('activeDays');
			var hiddenfield = $('<input type="hidden" name="weekdays[]"/>');
			$(hiddenfield).attr('id','wd-'+ref);
			$(hiddenfield).val(ref);
			$("#hidden-fields").append(hiddenfield);
	}
}

function setHourLi(hour,ampm,min)
{
	if(hour != undefined && hour != "" && hour != null)
	{
		var ref;
		switch(hour)
		{
		  case '01':
			ref=1;
			$('#weekdays-list li').addClass('activeDays');
			selectAndAppendHour(ref,ampm,min);
			break;
		   case '02':
			ref=2;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '03':
			ref=3;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '04':
			ref=4;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '05':
			ref=5;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '06':
			ref=6;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '07':
			ref=7;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '08':
			ref=8;
			selectAndAppendHour(ref,ampm,min);
			break;
		  case '09':
			ref=9;
			selectAndAppendHour(ref,ampm,min);
			break;
		 case '10':
			ref=10;
			selectAndAppendHour(ref,ampm,min);
			break;
		case '11':
			ref=11;
			selectAndAppendHour(ref,ampm,min);
			break;
		 case '12':
			ref=12;
			selectAndAppendHour(ref,ampm,min);
			break;
		}
	}
}
function selectAndAppendHour(ref,ampm,min)
{
		var id = 'amTimePick';
		if(ampm == "pm")
		{
			id = 'pmTimePick';
		}
		else
		{
			id = 'amTimePick';
		}
		var li = $('#'+id+' li[ref='+ref+']');
		$(li).addClass('hour-selected');
		// show min

		var position = $(li).position();
			var left = position.left;
			var top = position.top+65;
			var minHtml = "<div style='top:"+top+"px;left:"+left+"px' class='minute-container'>"+min+"</div>"
			$(minHtml).css('top',top);
			$(minHtml).css('left',left);
			$(minHtml).insertAfter(li);


			var hiddenfield = $('<input type="hidden" name="time[]"/>');
			$(hiddenfield).attr('id',ampm+'-'+ref);
			var value = ref+':'+min+'-'+ampm;
			$(hiddenfield).val(value);
			$("#hidden-fields").append(hiddenfield);
}

            // When the document is ready
            $(document).ready(function () {
		
                 $('#startDate').datepicker({
           			showOn: "button",
					buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calendar_popup.png",
					buttonImageOnly: true,
					buttonText: "Select date",
					dateFormat: "M dd,yy",
					minDate: 0
					});
			  var datestart = $('#startDate').val();
					$('#date1').html(datestart);
				$('#startDate').change(function(){
					var date1 = $(this).val();
					$('#date1').html(date1);
					});
            // am

			$('#amTimePick li').click(function(){
				var ref = $(this).attr('ref');
				if($(this).hasClass('hour-selected'))
				{
					$(this).removeClass('hour-selected');
					if($(this).next().hasClass('minute-container'))
					{
						$(this).next().remove();
					}
					$('#am-'+ref).remove();
					$('#min-selector').hide();
				}
				else
				{
					$('#amTimePick li').removeClass('hour-active');
					$(this).addClass('hour-active');
					$(this).addClass('hour-selected');
					var position = $(this).position();
					var left = position.left-30;
					var top = position.top-30;
					$('#min-selector').css('top',top)
					$('#min-selector').css('left',left)
					$('#min-selector').show();

					// appends hidden field
					var hiddenfield = $('<input type="hidden" name="time[]"/>');
					$(hiddenfield).attr('id','am-'+ref);
					$(hiddenfield).val(ref);
					$("#hidden-fields").append(hiddenfield);
				}
			});
		$("#min-selector span").click(function(){
			var li = $('li.hour-active');
			var hml = $.trim($(this).html());
			var position = $(li).position();
			var left = position.left;
			var top = position.top+65;
			var minHtml = "<div style='top:"+top+"px;left:"+left+"px' class='minute-container'>"+hml+"</div>"
			$(minHtml).css('top',top);
			$(minHtml).css('left',left);
			$(minHtml).insertAfter(li);
			$('#min-selector').hide();
			var ref = $(li).attr('ref');
			var hiddenfieldVal = $('#am-'+ref).val();
			hiddenfieldVal += ":"+hml+"-am";
			$('#am-'+ref).val(hiddenfieldVal);
		});
		$('#pmTimePick li').click(function(){
		var ref = $(this).attr('ref');
					console.log(ref);

		if($(this).hasClass('hour-selected'))
		{
			$(this).removeClass('hour-selected');
			if($(this).next().hasClass('minute-container'))
			{
				$(this).next().remove();
			}
			$('#pm-'+ref).remove();
			$('#min-pm-selector').hide();
		}
		else
		{
			$('#pmTimePick li').removeClass('pm-hour-active');
			$(this).addClass('pm-hour-active');
			$(this).addClass('hour-selected');
			var position = $(this).position();
			var left = position.left-30;
			var top = position.top-30;
			$('#min-pm-selector').css('top',top)
			$('#min-pm-selector').css('left',left)
			$('#min-pm-selector').show();

			// appends hidden field
			var hiddenfield = $('<input type="hidden" name="time[]"/>');
			$(hiddenfield).attr('id','pm-'+ref);
			$(hiddenfield).val(ref+":00-pm");
			$("#hidden-fields").append(hiddenfield);
		}
		});
		$("#min-pm-selector span").click(function(){
			var li = $('li.pm-hour-active');
			var hml = $.trim($(this).html());
			var position = $(li).position();
			var left = position.left;
			var top = position.top+65;
			//var minHtml = "<div style='top:"+top+"px;left:"+left+"px' class='minute-pm-container'>"+hml+"</div>"
			var minHtml = "<div style='top:"+top+"px;left:"+left+"px' class='minute-container'>"+hml+"</div>"
			$(minHtml).css('top',top);
			$(minHtml).css('left',left);
			$(minHtml).insertAfter(li);
			$('#min-pm-selector').hide();
			var ref = $(li).attr('ref');
			//var hiddenfieldVal = $('#pm-'+ref).val();
			//hiddenfieldVal +=":"+hml+"-pm";
			hiddenfieldVal = ref+":"+hml+"-pm";
			$('#pm-'+ref).val(hiddenfieldVal);
					//	console.log(hiddenfieldVal);

		});

		$('#weekdays-list li').click(function(){
		var ref = $(this).attr('ref');
		if($(this).hasClass('activeDays'))
		{
			$(this).removeClass('activeDays');
			$('#wd-'+ref).remove();
		}
		else
		{
			$(this).addClass('activeDays');
			var hiddenfield = $('<input type="hidden" name="weekdays[]"/>');
			$(hiddenfield).attr('id','wd-'+ref);
			$(hiddenfield).val(ref);
			$("#hidden-fields").append(hiddenfield);
		}


		});

            });
	$(".close").click(function(){
	 $("#schedulePopup").hide();
	 });


	 $(".popup_close").click(function(){
	 //$("#schedulePopup").hide();
	 $("#schedulePopup").modal('hide');
	
	 });

	$(document).ready(function() {

	$("#range12").css('display', 'none');
	$("#setRangeFlow").css('display', 'none');
	//$("#range12").css('border', '1px solid red');
	//$("#schedule12").css('border', '1px solid red');


   $("#range").click(function() {
   		var compareData = $('#setRangeFlow').val();
		//alert(compareData);
		if(compareData == "Glucose")
		{
        	$("#range12").css('display', 'block');
			$("#setFlowRange").css('display', 'none');
		}
		else if(compareData == "Peak Flow")
		{
			 $("#setFlowRange").css('display', 'block');
			// alert();
			 $("#range12").css('display', 'none');
		}
		$("#schedule12").css('display','none');
		$("#schedule_img").attr('src','/gladstone/portal/bloom/dashboard/images/dashboard_schedule.png');
		$("#range_img").attr('src','/gladstone/portal/bloom/dashboard/images/dashboard_ranges.png');
	});

    $("#schedule").click(function() {
         $("#range12").css('display', 'none');
		 $("#setFlowRange").css('display', 'none');
		$("#schedule12").css('display', 'block');
		$("#schedule_img").attr('src','/gladstone/portal/bloom/dashboard/images/schedule.png');
		$("#range_img").attr('src','/gladstone/portal/bloom/dashboard/images/ranges.jpg');

    });
});

$('#checked').click(function () {
    if (!$('#checked').is(':checked')) {
		$('#weekdays-list li').removeClass('activeDays');

    }
	else{
		$('#weekdays-list li').addClass('activeDays');
	}
});
$("#frequencyReading").keydown(function(event)
{ 	
	if ((event.which != 8) && (event.keyCode < 96 || event.keyCode > 105) && (event.keyCode < 46 || event.keyCode > 57))
	{
		return false;
	}

});
$("#frequencyReading").focus(function()
{
if($(this).val() ==0)
{
$(this).val("");
}
});

function rangesTab(deviceName)
{
//alert(deviceName);
        if(deviceName == "Glucose")
		{
		//alert(deviceName);
			$("#range12").css('display', 'block');
			$("#setFlowRange").css('display', 'none');
		}
		else if(deviceName == "Peak Flow")
		{
		//alert(deviceName);
			$("#setFlowRange").css('display', 'block');
			$("#range12").css('display', 'none');
		}
			
			$("#schedule12").css('display','none');
			$("#schedule_img").attr('src','/gladstone/portal/bloom/dashboard/images/dashboard_schedule.png');
			$("#range_img").attr('src','/gladstone/portal/bloom/dashboard/images/dashboard_ranges.png');

}


</script>
<!-- popup end-->
