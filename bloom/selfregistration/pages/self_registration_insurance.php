<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../script/css/self-registration.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="../../common/script/js/query.min_1.7.1.js"></script>
<script src="../../common/script/js/jquery-ui.js"></script>
<?php
include 'controller/self_registration_insurance_controller.php';
$employerName =$_REQUEST["employerName"];
if(!$employerName)
{
header("location:index.php");
}
 $entityUtil = new EntityUtil();
$paramArray = array();
$statesInfo = $entityUtil->postDataToregisterPatient($employerName, "getStateListWithOutRegistration", $paramArray ,VMCPortalConstants::$API_ADMIN);
  
  $addressInfo = null;

	// $employerName =$_REQUEST["InstitutionName"];
	// $employer=$_REQUEST["employerName"];
	 

if(isset($_REQUEST['EDIT']))
{
$employer = $_COOKIE['employer'];
$employerName =$_REQUEST["employerName"];
$retPatientId =$_REQUEST["existingPatId"];
$patientRegistrationId = $_REQUEST["patientRegistrationId"];
$retPatientId = $_REQUEST['existingPatId'];
}
else{
$employerName =$_REQUEST["employerName"];
$patientRegistrationInfo =$_REQUEST["patientRegistrationInfo"];
$patientRegistrationId = $_REQUEST["patientRegistrationId"];
$retPatientId = $_REQUEST['existingPatId'];
$employer = $_REQUEST["employer"];
setcookie("employer",$employer,0,'/', '', false, true);
}
if(!empty($retPatientId) and $retPatientId > 0)
{
	$paramArray = array();
	$paramArray[0] = $retPatientId;
	$patientInfo = $entityUtil->postDataToregisterPatient($employerName, "getPatientDetailsOnReg",$paramArray, VMCPortalConstants::$API_EMR);
	$addressInfos = $patientInfo->{addressInfo};
	
	foreach($addressInfos as $address)
	{
		if($address->{addressType} == "BILLING")
		{
			$addressInfo = $address;
		}
	}
	
	$patientInsuranceInfo = $patientInfo->{patientInsuranceInfo};
}
?>
 
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>
<!--Including css files used in all the html pages -->
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">

<style>
html {
	height: 100%;
}
body {
	height: 100%;
}
.reg_step_left {
    padding-right: 0;
}
.reg_self_wapper {
    padding-right: 0;
}
 @media (min-width: 1200px) {
.container {
width: 1000px;
}
}
.form-control.input-md.hasDatepicker {
    float: left;
    width: 89%;
}
.ui-datepicker-trigger {
    margin-left: 5px;
    margin-top: -4px;
    width: 27px;
}
#captcha.inputcaptcha {
    border: 1px solid #ccc;
    height: 27px;
    padding: 0 0 0 8px;
    width: 50%;
	float:left;
}
.imgcaptcha {
    margin-left: 5px;
    width: 39%;
}
.stap
{
cursor:pointer;
}
.col-md-6.reg_step_left > h1 {
    font-size: 20px;
    font-weight: normal;
    padding-bottom: 28px;
}
#selectbasic.form-control {
    font-size: 12px;
}
.reg_step_left > h1 {
    float: left;
    font-size: 20px;
    width: 100%;
	padding-left: 15px;
}
</style>
</head>
<body>
<div class="wrapper2">
  <!--start header -->
<?php
include '../../common/pages/header.php';
?>
</header>
  <!--end header -->
  <!--start wapper -->
<div class="container">
<div class="row">
<div class="col-lg-12 reg_self_wapper">
<div class="col-md-12" style="margin-bottom: 10px;">
	<div class="col-md-1 self_reg_step2" style="padding:0">
	<a  id="self_registrationPage" href="self_registration.php?EDIT=edit&patientRegistrationId=<?php echo $patientRegistrationId ?>&InstitutionName=<?php echo $employerName ?>" data="self_registration.php?EDIT=edit&patientRegistrationId=<?php echo $patientRegistrationId ?>&InstitutionName=<?php echo $employerName ?>">Step 1</a>
	</div>
	<div class="col-md-1 self_reg_step1">
	<a href="#">Step 2</a>
	</div>

</div>

<h1 class="col-md-6">Supplies Delivery Address</h1>
<h1 class="col-md-6" style="padding-left:30px;">Insurance Detail</h1>
<form name="self_registration_Ins" id="self_registration_Ins" method="post"	action="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/selfregistration/pages/self_registration_insurance.php">
<input id="patientRegistrationId" name="patientRegistrationId" type="hidden" value="<?php echo $patientRegistrationId ;?>" class="form-control input-md">
<input id="retPatientId" name="retPatientId" type="hidden" value="<?php echo $retPatientId ;?>" class="form-control input-md">
<input id="employerName" name="employerName" type="hidden" value="<?php echo $employerName ;?>" class="form-control input-md">


<div class="col-md-12 self_pat_reg_form" style="padding:0">

<div class="col-md-6 reg_step_left" style="padding:0;  border-right: solid 1px #ccc;">


<div class="form-group">
  <div class="col-md-12">
  <div class="checkbox" style="margin: 0px;">
    <label for="checkboxes-0">
      <input name="checkboxes" id="myCheck" value="1" type="checkbox">
      Check this box to make changes to address below
    </label>
	</div>
  </div>
</div>
<div>
<?php
if(!is_null($addressInfo))
{
?>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address Line 1 <span>*</span></label>  
  <div class="col-md-8">
  <input id="address1" name="address1"  maxlength="50" placeholder="Address Line 1" class="form-control input-md" type="text" value="<?php echo $addressInfo->{addressLine1}?>">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address Line 2 </label>  
  <div class="col-md-8">
  <input  id="address2" name="address2"  maxlength="50" placeholder="Address Line 2" class="form-control input-md" type="text" value="<?php echo $addressInfo->{addressLine2}?>">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">City/State <span>*</span></label>  
  <div class="col-md-5">
  <input  id="city" name="city"  placeholder="City/State"  maxlength="50" class="form-control input-md" type="text" value="<?php echo $addressInfo->{city}?>">
  </div>
   <div class="col-md-3">
	<select name="stateId"  id="stateId"  class="form-control">
		 <?php
					 foreach($statesInfo as $state)
					  {
						if(!is_null($addressInfo))
						{
							if($state->{stateId} == $addressInfo->{stateId})
							{
						?><option selected="selected" value="<?php	echo $state->{stateId};?>"><?php	echo $state->{stateCode};?></option><?php
							}
							else{
							?><option value="<?php	echo $state->{stateId};?>"><?php	echo $state->{stateCode};?></option><?php
							  }
						}
						else
						{
						?><option value="<?php	echo $state->{stateId};?>"><?php	echo $state->{stateCode};?></option><?php
						}
					}
					  ?>
	</select>  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Zip <span>*</span></label>  
  <div class="col-md-8">
  <input  id="zip" name="zip" placeholder="Zip" maxlength="5" class="form-control input-md" type="text" value="<?php echo $addressInfo->{postalCode};?>">
  </div>
</div> 
<?php
}
else
{	
?>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address Line 1 <span>*</span></label>  
  <div class="col-md-8">
  <input id="address1" name="address1" maxlength="50" placeholder="Address Line 1" class="form-control input-md" type="text" value="">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address Line 2 </label>  
  <div class="col-md-8">
  <input  id="address2" name="address2"  maxlength="50" placeholder="Address Line 2" class="form-control input-md" type="text" value="">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">City/State <span>*</span></label>  
  <div class="col-md-5">
  <input  id="city" name="city"  maxlength="50"  placeholder="City/State" class="form-control input-md" type="text" value="">
  </div>
 <div class="col-md-3">
	<select name="stateId" id="stateId" class="form-control">
		 <?php
					 foreach($statesInfo as $state)
					  {
							if(!is_null($addressInfo))
							{
								if($state->{stateId} == $addressInfo->{stateId})
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
	</select>  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Zip <span>*</span></label>  
  <div class="col-md-8">
  <input  id="zip" maxlength="5" name="zip" placeholder="Zip" class="form-control input-md" type="text" value="">
  </div>
</div> 
<?php
}
?>
</div>        
        
  

</div>


<div class="col-md-6 reg_step_left" style="margin-top: 55px;">


<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Member ID <span>*</span></label>  
  <div class="col-md-8">
  <input id="patientInsuranceId" name="patientInsuranceId" type="hidden" value="<?php echo $patientInsuranceInfo ->{patientInsuranceId}?>" class="form-control input-md">
  <input  id="memberId" name="memberId" maxlength="10"  placeholder="Member Id" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{memberId}?>">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Group ID <span>*</span></label>  
  <div class="col-md-8">
  <input  id="groupId" name="groupId"  maxlength="10"name="textinput" placeholder="Group Id" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{groupId}?>">
  </div>
</div>
<div style="height: 105px;"></div>
<div class="col-md-11" style="margin-top:10px;margin-left: -14px;">
<div class="col-md-2 self_reg_but">
<input  type="submit" id="submit" name="submit" value="Submit">
</div>
</div>

</div>

</div>

</form>
</div>
</div>
</div>

<div class="clr"></div>
<div class="push"></div>
</div>
<!--end wapper -->
<!--start footer -->
<?php
include 'popup/CientSiderror_popup_insurance.php';
//include '../../login/pages/popup/error_popup.php';
include '../../common/pages/footer.php';
?>

<!--end footer -->
</body>
</html>
<script>
$("#zip").keydown(function(event)
{
        if (($(this).val().length > 5 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode != 190 && event.keyCode != 110)
             {   console.log("keyCode1:"+event.which);
				return false;
				}

});
var patientId='<?php echo $retPatientId?>';
console.log("patientId:"+patientId);
if( patientId != 0 )
	{
	$("#address1").attr("readonly","readonly"); 
	 $("#address2").attr("readonly","readonly"); 
	 $("#city").attr("readonly","readonly");
	 $("#zip").attr("readonly","readonly");
	 $("#memberId").attr("readonly","readonly"); 
	 $("#groupId").attr("readonly","readonly");
	 $("#stateId").attr("disabled","disabled");
		 $('#myCheck').click(function () {
		 if($("#myCheck").is(':checked'))
		 {
		 $("#address1").removeAttr("readonly"); 
		 $("#address2").removeAttr("readonly"); 
		 $("#city").removeAttr("readonly");
		 $("#zip").removeAttr("readonly");
		 $("#stateId").removeAttr("disabled");

		 }
		 else
		 {
		 $("#address1").attr("readonly","readonly"); 
		 $("#address2").attr("readonly","readonly"); 
		 $("#city").attr("readonly","readonly");
		 $("#zip").attr("readonly","readonly");
		 $("#stateId").attr("disabled","disabled");

		 }
		 });
		 
}
</script>
