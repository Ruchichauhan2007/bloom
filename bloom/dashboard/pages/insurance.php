<?php
  $userType = strtoupper($_COOKIE['type']);

  include 'controller/insurance_controller.php';
  include 'popup/CientSiderror_popup_insurance.php';
  
  $patientLastName = $_GET["patientLastName"];
  $patientFirstName = $_GET["patientFirstName"];
  $patientdob = $_GET["dob"];
  $patientEmail = $_GET["email"];
  $patientPhone = $_GET["phone"];
	 $statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);
  $paramArray = array() ;
  if (isset ( $_REQUEST['type'] or $userType==="PATIENT")) {
    $entityUtil = new EntityUtil();

	if($userType === "PATIENT")
	{
	$patientId = $_COOKIE['id'];
	}
	else{
	$patientId = $_REQUEST['patientId'];
	}
	$paramArray = array() ;
	$paramArray[0] = $patientId;
	$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
	$addressInfo = $patientInfo->{addressInfo};
	$phoneInfo = $patientInfo->{phoneInfo};
	$emailaddressinfo = $patientInfo->{emailAddressInfo};
	$dateUtil = new DateUtil();
	$dateOfBirthStr = $dateUtil->formatDatetoStr($patientInfo->{dateOfBirth});
	
	$paramArray = array() ;
	$paramArray[0] = $patientId;
	$patientInsuranceInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientInsuranceByPatientId", VMCPortalConstants::$API_EMR);
	// Format Date as per MM/DD/YYYY format
	$dateUtil = new DateUtil();
	$employeeDateofBirth = $dateUtil->formatDatetoStr($patientInsuranceInfo->{employeeDateofBirth});
	
	if(!is_null($patientInfo))
	{
		$addressInfo = $patientInfo->{addressInfo};
		
		if($addressInfo[0]->{addressType} == "BILLING")
		{
			
			$addressInfo[1] = $addressInfo[0];
		}
		
		$phoneInfo = $patientInfo->{phoneInfo};
		if($phoneInfo[0]->{phoneType} == "BILLING")
		{
			$phoneInfo[1] = $phoneInfo[0];
		}
		
		$emailaddressinfo = $patientInfo->{emailAddressInfo};
		
		/*if($emailaddressinfo[0]->{preferred} == VMCPortalConstants::$PHP_TRUE)
		{
			$emailaddressinfo[1] = $emailaddressinfo[0];
		}*/
	}
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../selfregistration/script/css/self-registration.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">


<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<!--Including css files used in all the html pages -->
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<style>
.but_cancel_bg {
    padding: 8px 20px !important;
}
html {
	height: 100%;
}
body {
	height: 100%;
}
.dashboard_top_nav li a {
    background: linear-gradient(to bottom, #99979a 0%, #807e81 46%, #6f6d6e 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-right: 2px solid #424251;
    border-top: 1px solid #000;
    color: #fff;
    float: left;
    font-size: 19px;
    height: 32px;
    padding: 4px 10px;
    text-decoration: none;
}
.dashboard_top_nav li {
    float: left;
}
.col-md-4.self_reg_but {
    float: right;
}
 @media (min-width: 1200px) {
.container {
width: 1000px;
}
}
.form-control.input-md.hasDatepicker {
    float: left;
    width: 87%;
}
.ui-datepicker-trigger {
    margin-left: 5px;
    margin-top: -1px;
    width: 27px;
}
.dashboard_top_nav{
    background: none repeat scroll 0 0 #d6dadd !important;
    border-bottom: 3px solid #77a72f !important;
    height: 35px;
    margin-bottom: 20px !important;
    width: 100%;
}
.nmaePatFormat {
    font-size: 15px;
    padding-left: 35px;
    padding-top: 4px;
}
.dobPatFormat {
    font-size: 15px;
    padding-left: 35px;
    padding-top: 4px;
}
.reg_self_wapper .col-md-5 > span {
    font-size: 20px;
    margin-left: 10px;
	padding-bottom:5px;
}
.col-md-6.reg_step_left .form-group {
    padding-bottom: 25px;
}
.reg_self_wapper {
    margin-top: 0;
}
#add-patient-form .form-group {
  margin-bottom: 1px;
}
.spanHide {
    margin: 0 12px;
}
.MarginBottom10{ margin-bottom:10px;}
.margin4_left{margin-left: 5px;}
</style>
<div class="wrapper2">
  <!--start header -->
  <!--end header -->
  <!--start wapper -->

<div class="dashboard_top_nav">
	<?php
if (isset($_REQUEST['type']  or $userType==="PATIENT")) {
?>
  <ul id="addPatientMenu">
    <li><a href="#"  data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	
	<li><a href="#" class="active" data="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr; ?>&email=<?php echo $emailaddressinfo[0]->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)" onClick="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr; ?>&email=<?php echo $emailaddressinfo[0]->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$INSURANCE;?></a></li>
	
    <li><a href="#" id="device" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
	
    <li><a href="#" id="device_schedule" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
    
    <li id="prescription"><a href="#"  onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" ><?php echo constantAppResource::$PRESCRIPTION;?></a></li>  
	
	<span class="nmaePatFormat spanHide"><?php echo $patientInfo->{lastName}." ".$patientInfo->{firstName} ?></span>
	<?php
	if($dateOfBirthStr!= "")
	{
	?>
	<span class="dobPatFormat spanHide">
     DOB	
	<?php 
	echo $dateOfBirthStr;
	}
	?>
	</span>
  </ul>
  <?php
  }
  else
  {
  ?>
   <ul id="addPatientMenu">
    <li><a href="#" ><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	<!-- <li><a href="#">Contact Detail</a></li>-->
	 <li><a href="#" class="active"><?php echo constantAppResource::$INSURANCE;?></a></li>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
    <li><a href="#"><?php echo constantAppResource::$PRESCRIPTION;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
    
  </ul>
  <?php
  }
  ?>
</div>
<div class="col-lg-12 reg_self_wapper" style="padding:0">
<form method="post"  id="insurance-form" onSubmit="postPatientForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/insurance.php','insurance-form','menu-content',event)">

<?php /*?><div class="col-md-5 spanHide" style="padding: 0" >
	<span><input type="checkbox" id="myCheck" /> Copy from profile</span>
</div><?php */?>
<div class="col-md-12" style="padding:0">

	</div>
    
    
<div class="col-md-12 MarginBottom10">
<div class="col-md-12 self_form_bbg">

<div class="col-md-12 self_pat_reg_form" style="padding:0px;">

<div class="col-md-6 reg_step_left" style="padding:0">

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput">Group Id <span  >*</span></label>  
  <div class="col-md-8">
  <input id="patientId" name="patientId" type="hidden" value="<?php echo $patientId ;?>" class="form-control input-md">
  <input id="patientInsuranceId" name="patientInsuranceId" type="hidden" value="<?php echo $patientInsuranceInfo ->{patientInsuranceId}?>" class="form-control input-md">
  <input id="groupId" name="groupId" type="text" placeholder="Group Id"  maxlength="10"value="<?php echo $patientInsuranceInfo ->{groupId}?>" class="form-control input-md" />
  </div>
  
</div>

<div class="form-group" >
  <label class="col-md-4 control-label " for="textinput">Member Id <span  >*</span></label>  
  <div class="col-md-8">
  <input id="memberId" name="memberId" type="text" placeholder="Member Id" maxlength="10" class="form-control input-md" value="<?php echo $patientInsuranceInfo ->{memberId}?>" />
  </div>
</div>


<?php /*?><div class="form-group" >
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Email address </label>  
  <div class="col-md-8">
  <input id="insuredEmail" name="insuredEmail" type="text" placeholder="Email" class="form-control input-md"  value="<?php echo $patientInsuranceInfo ->{employeeEmailAddress}?>"/>
  </div>
</div><?php */?>


</div>


<div class="col-md-6 reg_step_left">

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Name<span  >*</span></label>  
  <div class="col-md-8" style="padding:0">
  <div class="col-md-6"><input id="insuredFirstName" name="insuredFirstName" type="text" placeholder="First name" class="form-control input-md captial" value="<?php echo $patientInsuranceInfo ->{employeeFirstName}?>" maxlength="50"  /></div>
  <div class="col-md-6"><input id="insuredLastName" name="insuredLastName" type="text" placeholder="Last name" class="form-control input-md captial" value="<?php echo $patientInsuranceInfo ->{employeeLastName}?>" maxlength="50"  /></div>
  </div>
  
  
</div>


<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Date of birth</label>  
  <div class="col-md-8">
  <?php 
  if(!$patientInsuranceInfo->{employeeDateofBirth})
  {
 
  ?>
  
  <input id="insuredDob" name="insuredDob" maxlength="10" type="text" placeholder="MM/DD/YYYY" class="form-control input-md" value=""/>
 
  <?php 
  }
  else
  {
  
  ?>
   <input id="insuredDob" name="insuredDob" maxlength="10" type="text" placeholder="MM/DD/YYYY" class="form-control input-md"  value="<?php echo $employeeDateofBirth ;?>"/>
  <?php 
  }
  ?>
  </div> 
</div>

<?php /*?><div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Phone number</label>  
  <div class="col-md-8">
  <input id="insuredPhone" maxlength="15" name="insuredPhone" type="text" placeholder="Phone number" class="form-control input-md"  value="<?php echo $patientInsuranceInfo ->{employeePhoneNumber}?>"/>
  </div>
  
</div><?php */?>

</div>

</div>

</div>
</div>


<div class="PROVIDER">
<?php /*?><div class="col-md-12">
<div class="col-md-12 self_form_bbg">
<div class="rightFormContact">
<!--<h1> Insurance Information: </h1> -->
</div>
<div class="col-md-6 reg_step_left">
<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">First Name</label>  
  <div class="col-md-8" style="padding:0">
  <div class="col-md-12"><input id="insuredFirstName" name="insuredFirstName" type="text" placeholder="First name" class="form-control input-md" value="<?php echo $patientInsuranceInfo ->{employeeFirstName}?>" /></div>
  </div>
  
  
</div>
<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0"> Last Name</label>  
  <div class="col-md-8" style="padding:0">
  <div class="col-md-12"><input id="insuredLastName" name="insuredLastName" type="text" placeholder="Last name" class="form-control input-md" value="<?php echo $patientInsuranceInfo ->{employeeLastName}?>" /></div>
  </div>
  
  
</div>

</div>
<div class="col-md-6 reg_step_left">
<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding-left:0">Group Id </label>  
  <div class="col-md-8">
  <input id="patientId" name="patientId" type="hidden" value="<?php echo $patientId ;?>" class="form-control input-md">
  <input id="patientInsuranceId" name="patientInsuranceId" type="hidden" value="<?php echo $patientInsuranceInfo ->{patientInsuranceId}?>" class="form-control input-md">
  <input id="groupId" name="groupId" type="text" placeholder="Group Id"  maxlength="10"value="<?php echo $patientInsuranceInfo ->{groupId}?>" class="form-control input-md" />
  </div>
  
</div>

<div class="form-group" style="">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Member Id </label>  
  <div class="col-md-8">
  <input id="memberId" name="memberId" type="text" placeholder="Member Id" maxlength="10" class="form-control input-md" value="<?php echo $patientInsuranceInfo ->{memberId}?>" />
  </div>
</div>
</div>
</div>
</div><?php */?>


<div class="col-md-12">
<div class="col-md-12 self_form_bbg">
<div class="col-md-6 reg_step_left" style="padding: 0;">


<div class="rightFormContact">
<!--<h1>Billing Information:</h1> -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address<span  >*</span></label>  
  <div class="col-md-8">
  <input  name="address1" id="address1" maxlength="50"  placeholder="Address Line 1" class="form-control input-md" value="<?php echo $addressInfo[1]->{addressLine1}?>" type="text" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput"></label>  
  <div class="col-md-8">
  <input  name="address2" id="address2" maxlength="50"  placeholder="Address Line 2" class="form-control input-md" value="<?php echo $addressInfo[1]->{addressLine2}?>" type="text" />
  </div>
</div>

<div class="form-group" style="float:left; padding:0px;">
  <label class="col-md-4 control-label"  for="textinput">City / State<span  >*</span></label>  
  <div class="col-md-4" style="padding: 0 9px 0 17px">
  <input   name="city" id="city" maxlength="50" placeholder="City / State" class="form-control input-md margin4_left" value="<?php echo $addressInfo[1]->{city}?>" type="text">
  </div>
  <div class="col-md-4">
    <span class="custom-dropdown custom-dropdown--white" style=" left:129; position: absolute; height: 30px; top: 1px;">
          
          </span><select name="state"  id="state" class="custom-dropdown__select custom-dropdown__select--white" style="width:116px; height: 33px;">
            <?php
					 foreach($statesInfo as $state)
					  {
						if(!is_null($addressInfo[0]))
						{
							if($state->{stateId} == $addressInfo[0]->{stateId})
							{
						?>
            <option selected="selected" value="<?php	echo $state->{stateId};?>">
            <?php	echo $state->{stateCode};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $state->{stateId};?>">
			<?php	echo $state->{stateCode};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $state->{stateId};?>">
            <?php	echo $state->{stateCode};?>
            </option>
            <?php
							}
					  }
					  ?>
          </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Zip<span  >*</span></label>  
  <div class="col-md-4" style="padding-right:10px;">
  <input  name="zip" id="zip" maxlength="5"  placeholder="Zip" class="form-control input-md" value="<?php echo $addressInfo[1]->{postalCode}?>" type="text">
  </div>
</div>

</div>  
  
</div>
<div class="col-md-6 reg_step_left" style="padding: 0;">
<div class="rightFormContact">
<!--<h1>Billing Phone / Email:</h1>-->

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Phone Number<span  >*</span></label>  
  <div class="col-md-8" style="padding-left: 20px;">
  <input style="width: 95%;" id="phone" name="phone" maxlength="15"  placeholder="Phone" class="form-control input-md" value="<?php echo $phoneInfo[1]->{phoneNumber};?>" type="text">
  </div>
</div>
<?php /*?><div class="form-group">
  <label class="col-md-4 control-label" for="textinput">E-mail Address<span  ></span></label>  
  <div class="col-md-8">
  <input maxlength="50"  id="email" name="email" placeholder="E-mail" class="form-control input-md" value="<?php echo $emailaddressinfo[0]->{emailAddress};?>" type="text">
  </div>
</div><?php */?>

</div></div>
</div>

</div>
</div>


<div class="col-md-4 self_reg_but"  style="text-align: right; padding: 0px; margin-top:40px;">
<?php
if (!$patientInsuranceInfo) {
?>
<input id="pageCancel" class="but_cancel_bg" type="button"  onClick="postFormAndHideAlert('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,'myModal')" value="Cancel">
<input type="submit" value="Save" id="saveinsurance" name="saveinsurance" />
<input type="hidden" value="Save" id="" name="saveinsurance" />

<?php
}
else
{
?>
<input id="pageCancel" class="but_cancel_bg" type="button" data="postFormAndHideAlert('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,'myModal')" onClick="postFormAndHideAlert('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,'myModal')" value="Cancel">
<input type="submit" value="Save" id="insurance" name="insurance" />

<input type="hidden" value="Save" id="" name="insurance" />
<?php
}
?>
</div>

<!-- Cancel Popup  -->
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header pat_but_bg11">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" style="padding:6px;">Cancel</h4>
      </div>
      <div class="modal-body pat-body" id="popup_text">
       Are you sure you want to Cancel? All changes will be lost.
      </div>
      <div class="modal-footer" style="padding:15px;margin-top:0px;">
		<input type="reset" id="cancel" value="Yes" class="btn btn-default" data-dismiss="modal" />
		 <input type="submit"  class="btn btn-default" data-dismiss="modal" value="No" id="no" style="margin:0px;"/>		  
      </div>
    </div>

<!-- Cancel popup end  -->


</div>
 </form>
 </div>
<div class="clr"></div>
<div class="push"></div>
</div>
<!--end wapper -->
<!--start footer -->
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
<script>
		$(function(){
if($.trim($("#insuredDob").val())=="//")
{
$("#insuredDob").val("");
}
		if($("div").hasClass("fade"))
		{
		$('.fade').hide();
		}
		
		$( "#insuredDob" ).datepicker({
		showOn: "button",
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		maxDate: new Date(),
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+0"
});

	});
	
var patientLastName='<?php echo $patientLastName?>';
var patientFirstName='<?php echo $patientFirstName?>';
var patientdob='<?php echo $dateOfBirthStr?>';
var patientEmail='<?php echo $patientEmail?>';
var patientPhone='<?php echo $patientPhone?>';


$('#myCheck').click(function () {
	if($("#myCheck").is(':checked'))
	{
		$("#insuredFirstName").val(patientFirstName);
		$("#insuredLastName").val(patientLastName);
		$("#insuredDob").val(patientdob);
		$("#insuredEmail").val(patientEmail);
		$("#insuredPhone").val(patientPhone);
		if(!$("#insurance-form").hasClass("change"))
		{
			$("#insurance-form").addClass("change");
			$("#addPatientMenu li a").removeAttr("onClick");
			$("#pageCancel").removeAttr("onClick");
			$("#cancel").removeAttr("onClick");
		}
			
	}
	else
	{
		$("#insuredFirstName").val("");
		$("#insuredLastName").val("");
		$("#insuredDob").val("");
		$("#insuredEmail").val("");
		$("#insuredPhone").val("");
	}
});		

var currntMenu="";
$("#addPatientMenu li a").click(function()
{
	var currntMenu=$(this).attr('data');
	console.log("url:"+currntMenu);
	if($("#insurance-form").hasClass("change"))
	{
	$('#myModal').modal();
	$("#cancel").attr("onClick",currntMenu);
	$("#popup_text").text("Do you really want to move ? All changes will be lost.");
	$("#myModalLabel").text("warning");
	}
});

$("#pageCancel").click(function()
{
	if($("#insurance-form").hasClass("change"))
	{
		$('#myModal').modal();
		
	}
});

$("#insurance-form input,select,radio").on('change', function()
{
	if(!$("#insurance-form").hasClass("change"))
	{
		$("#insurance-form").addClass("change");
		$("#addPatientMenu li a").removeAttr("onClick");
		$("#pageCancel").removeAttr("onClick");
		$("#cancel").removeAttr("onClick");
	}
});

$("#cancel").click(function()
{
	$("#insurance-form")[0].reset();
	$("#insurance-form").removeClass("change");
	var cancelData=$("#pageCancel").attr('data');
	$("#pageCancel").attr("onClick",cancelData);
	 setUrl();
});

function  setUrl()
{
	$("#addPatientMenu li a").each(function(index, value) { 
    var dataUrl = $(this).attr('data'); 
	$(this).attr("onClick",dataUrl);
	});
}

$(document).ready(function()
{
controlMenu();
$("#insuredDob").datepicker({defaultDate: null});
var userType='<?php echo $userType;?>';
	if(userType == "PATIENT")
	{
		$("#prescription").hide();
		$("#device").hide();
		$("#device_schedule").hide();
		$("#contact").hide();
		$("#pageCancel").attr('disabled','disabled');
		$("#insurance").attr('disabled','disabled');
		$("#insurance").css("opacity","0.5");
		$("#pageCancel").css("opacity","0.5");
/*		$("#groupId").attr('readonly','readonly');
		$("#memberId").attr('readonly','readonly');
		$("#insuredPhone").attr('readonly','readonly');
		$("#insuredDob").attr('readonly','readonly');
		$("#insuredLastName").attr('readonly','readonly');
		$("#insuredFirstName").attr('readonly','readonly');
		$("#insuredEmail").attr('readonly','readonly');
*/		$(".spanHide").hide();
		$(".spanHide").html("");
		$("#saveinsurance").attr('disabled','disabled');
		$("#saveinsurance").css("opacity","0.5");
	}
	else
	{
/*	$(".PROVIDER").hide();
	$(".PROVIDER").html("");
*/	} 
});

</script>
<script>
$(document).ready(function()
{
var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
if(isChrome)
{
$("#city").removeClass("margin4_left");

}

});
</script>

<!--end footer -->
