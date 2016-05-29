  <?php
  
	include '../../common/util/VMCErrorMessage.php'; 
	if($msg)
	{
		$VMCMessage=new  VMCErrorMessage();
	if($msg=="USER_NAME_TAKEN_PLEASE_CHOOSE_ANOTHER_USER_NAME")
	{
		$msg="User name is taken, please choose another user name.";
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError=="Cannot insert duplicate key row in object 'dbo.CR_Emails' with unique index 'Email Address is already registered.'. The duplicate key value is" or $emailError=="Cannot insert duplicate key row in object 'dbo.CR_Emails' with unique index 'CR_EmailAddress_Emails_UX'. The duplicate key value is " or $emailError== "EMAILADDRESS_ALREADY_REGISTERED")
	{
	$msg="Email address is already registered.";
	}
	else if($msg=="STRING_LENGTH_EXCEED_SPECIFIED_LENGTH")
	{
	$msg="String length exceed specified length.";
	}
	else if($msg=="OLD_PASSWORD_AND_NEW_PASSWORD_ARE_SAME")
	{
	$msg="Old password and new password are same.";	
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError=="Violation of UNIQUE KEY constraint 'uc_PatientDetail'. Cannot insert duplicate key in object 'dbo.EM_PatientRegistration'. The duplicate key value is ") 
	
	{
	$msg="PATIENT_ALREADY_REGISTERED_WITH_SAME_DETAILS";
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError=="Violation of UNIQUE KEY constraint 'uc_PatientUsername'. Cannot insert duplicate key in object 'dbo.EM_PatientRegistration'. The duplicate key value is ") 
	
	{
	$msg="User name is taken, please choose another user name.";
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError=="Violation of UNIQUE KEY constraint 'uc_PatientEmail'. Cannot insert duplicate key in object 'dbo.EM_PatientRegistration'. The duplicate key value is ") 
	
	{
	$msg="This email is already registered please use other email, if problem continues please contact Kannact support.";
	}
	
	$providerDuplicate=explode("(",$msg);
	$providerDuplicate=$providerDuplicate[0];
	if($providerDuplicate == "Cannot insert duplicate key row in object 'dbo.CR_Users' with unique index 'CR_USERS_UserName_Deleted_UX'. The duplicate key value is ")
	{
		$msg="DUPLICATE_USER";
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError == "Cannot insert duplicate key row in object 'dbo.EM_PatientSupplies' with unique index 'EM_PatientSupplies_SupplyConfigId_UX'. The duplicate key value is ")
	{
		$msg = "Device AdapterId already assigned to another patient";
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError == "Cannot insert duplicate key row in object 'dbo.EM_PatientDeviceDetail' with unique index 'EM_PatientDeviceDetail_VendorDeviceId_UX'. The duplicate key value is ")
	{
		$msg = "Device AdapterId already assigned to another patient";
	}
	
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError == "Cannot insert duplicate key row in object 'dbo.CR_Phones' with unique index 'CR_Phones_PhoneNumber_UX'. The duplicate key value is ")
	{
		$msg = "Phone Number already exist";
	}
	$emailError=explode("(",$msg);
	$emailError=$emailError[0];
	if($emailError == "Cannot insert duplicate key row in object 'dbo.EM_PatientSupplies' with unique index 'EM_PatientSupplies_VendorDeviceId_UX'. The duplicate key value is")
	{
		$msg = "Device AdapterId already assigned to another patient.";
	}
 ?>   
 <link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/script/css/login-css.css" rel="stylesheet" type="text/css">

	<div id="light" class="white_content lightClassBox1" style="display:block;" ><p class="cart"><b><?php echo $page_error; ?> </b><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/images/close.jpg" align="right" class="close"></a></p>
	<div class="alert"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/images/alert.jpg" align="left">   <div id="txt"><?php echo $VMCMessage->errorMessage($msg);?></div>
    <br>
    <a href = "javascript:void(0)" class="okay localStorage" id="okay" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a></div>
	</div>
	<div id="fade" class="black_overlay"  onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></div>
 <?php
 }
 ?>  

<style>
.black_overlay {
position: absolute !important;
top: 0%!important;
left: 0%!important;
width: 100%!important;
background-color:#e8e8e8!important;
opacity: 0.5;
height:100%;
z-index: 1001!important;
}
.white_content {
/*position: absolute !important;
top: 30% !important;
left: 36.5% !important;
width: 410px !important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002!important;
overflow: auto!important;*/
height:220px;
}
@media (max-width:767px) {
.white_content.lightClassBox1{
    left: 20px !important;
    top: 72px !important;
    width: 280px !important;
}
}
</style>