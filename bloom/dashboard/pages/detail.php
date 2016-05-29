
<?php
  include 'controller/contact_detail_controller.php';
  include 'popup/CientSiderror_popup_contact.php';
  include '../../common/util/Constants.php';
	$serverimgpath = constants::$WEB_ROOT;
	$imgKey =  constants::$IMAGE_KEY;
  $patientInfo = NULL;
  $entityUtil = new EntityUtil();
  $vmcService = getVMCServiceInfo();
  $statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);
  
  if (isset ( $_REQUEST['type'] )) {
	$patientId = $_REQUEST['patientId'];
	$paramArray[0] = $patientId;
	$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
	$patientProviderInfos = $patientInfo->{patientProviderInfos};
	$addressInfo = null;
	$phoneInfo = null;
	$emailInfo = null;
	
	if(!is_null($patientInfo))
	{
		$addressInfo = $patientInfo->{addressInfo};
		if($addressInfo[0]->{preferred} == VMCPortalConstants::$PHP_TRUE)
		{
			$addressInfo[1] = $addressInfo[0];
		}
		
		$phoneInfo = $patientInfo->{phoneInfo};
		if($phoneInfo[0]->{preferred} == VMCPortalConstants::$PHP_TRUE)
		{
			$phoneInfo[1] = $phoneInfo[0];
		}
		
		$emailaddressinfo = $patientInfo->{emailAddressInfo};
		
		if($emailaddressinfo[0]->{preferred} == VMCPortalConstants::$PHP_TRUE)
		{
			$emailaddressinfo[1] = $emailaddressinfo[0];
		}
	}
}

?>
<!--Including css files used in all the html pages -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css" rel="stylesheet" type="text/css">
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/contact_detail.css" rel="stylesheet" type="text/css">
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/js/pwdvalidation.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(function(){
	 if ($("#menu-content").attr('class') =='col-md-12')
		$("#menu-content").attr('class','col-md-9');

	$('#portal-menu').hide("0",function(){
			 if ($('#portal-menu').is(':hidden'))
			{
				$("#menu-content").attr('class','col-md-12');
			}
		});
	});




	$(".captial").focusout(function(){
		var arr = $(this).val().split(' ');
		var result = "";
		for (var x=0; x<arr.length; x++)
			result+=arr[x].substring(0,1).toUpperCase()+arr[x].substring(1)+' ';
		$(this).val(result.substring(0, result.length-1));
	}); 
	
	});
</script>

<script>
(function(){
    /*1*/var customSelects = document.querySelectorAll(".custom-dropdown__select");
    /*2*/for(var i=0; i<customSelects.length; i++){
        if (customSelects[i].hasAttribute("disabled")){
            customSelects[i].parentNode.className += " custom-dropdown--disabled";
        }
    }
});

$('#no').click(function(e){
	$("#myModalLabel").text("Cancel");
	$("#popup_text").text("Are you sure you want to Cancel? All changes will be lost.");
	$("#cancel").removeAttr("onClick");
});


</script>
<style>
.form-control
{
	height:30px;
}
.form-group {
margin-bottom: 9px;
}
.custom-dropdown__select
{
	height:36px;
}
.pat_bg_rate input
{
	width:30px !important;
	float:left;
	color: #000;
	margin-right: 6px !important;
}
.pat_bg_rate p
{
	color: #000;
	padding-left:5px;
}
.col-sm-6.custom-dropdown.custom-dropdown--white {
    margin-right: 7px;
    padding: 0;
    width: 47%;
}
.dashboard_patient_status select {
    width: 100%;
}
.dashboard_patient_status input[type="reset"]{

}

.nmaePatFormat {
    float: left;
    font-size: 15px;
    padding-left: 35px;
	padding-top: 4px;
}
.dobPatFormat {
    float: right;
    font-size: 15px;
    padding-right: 35px;
    padding-top: 4px;
}
#menu-content.col-md-8 .dobPatFormat {
    float: right;
    font-size: 13px;
    padding-right: 35px;
    padding-top: 6px;
}
#menu-content.col-md-8 .nmaePatFormat {
    float: left;
    font-size: 15px;
    padding-left: 35px;
    padding-top: 4px;
}
#menu-content.col-md-8 .dashboard_patient_status_replace {
    font-size: 10px;
}

label.col-sm-4 {
width: 27%;
padding: 0 0 0 15px;
}
@media (max-width:767px) {
.pull-right1 .col-sm-6 {
    float: left;
	width:auto !important;
}
.pull-right1 .col-sm-3 {
    float: left;
}
.pull-right1 {
    margin-bottom: 0 !important;
    width: 96%;
}
}
@media (max-width:482px) {
.pull-right1 .col-sm-6 {
    float: left;
	width: 45% !important;
}
.pull-right1 {
    margin-bottom: 0 !important;
    width: 91%;
}
}

.pat_but_bg11
{
min-height: 16.43px; */
padding: 2px 0 0 10px;
border-bottom: 1px solid #e5e5e5;
background: #f7f7f9;
background: -moz-linear-gradient(top, #f7f7f9 0%, #f6f6f8 6%, #e4e3e8 31%, #e2e1e7 37%, #d9dadf 49%, #ceceda 66%, #cbcbd5 69%, #c7c7d3 77%, #c2c1cf 83%, #b9b8c6 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f7f7f9), color-stop(6%,#f6f6f8), color-stop(31%,#e4e3e8), color-stop(37%,#e2e1e7), color-stop(49%,#d9dadf), color-stop(66%,#ceceda), color-stop(69%,#cbcbd5), color-stop(77%,#c7c7d3), color-stop(83%,#c2c1cf), color-stop(100%,#b9b8c6));
background: -webkit-linear-gradient(top, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
background: -o-linear-gradient(top, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
background: -ms-linear-gradient(top, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
background: linear-gradient(to bottom, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f9', endColorstr='#b9b8c6',GradientType=0 ) !important;
height: 37px;
padding:2px 0;
}
.but_cancel_bg
{
background-color: rgb(4,174,252);
width: 100px;
-moz-border-radius: 5px;
border-radius: 5px;
border-bottom: solid 5px #0492d4;
-ms-filter: "progid:DXImageTransform.Microsoft.dropshadow(OffX=0,OffY=5,Color=#ff0492d4,Positive=true)";
filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=0,OffY=5,Color=#ff0492d4,Positive=true);
/* font-size: 22pt; */
color: #fff;
margin-right: 5px;
height: 44px;
}
select:focus
{
    border-color:#66afe9;
    box-shadow: 0 0 10px #66afe9;
}
.dashboard_patient_status input[type="text"] {
    margin: 4px 0;
    padding: 5px;
    width: 100%;
}
#DHead {
    font-family: arial;
    font-size: 23px;
    padding-bottom: 5px;
}
#DHeadInfo {
    font-family: arial;
    font-size: 15px;
    padding-bottom: 13px;
	padding-top:10px;
}
.dashboard_top_nav{
	margin:0px !important;
}
</style>
<!--start wapper -->
<!--start dashboard_header -->

<script>
var currntMenu="";
$("#addPatientMenu li a").click(function()
{
	var currntMenu=$(this).attr('data');
	console.log("url:"+currntMenu);
	if($("#contact-patient-form").hasClass("change"))
	{
	$('#myModal').modal();
	$("#cancel").attr("onClick",currntMenu);
	$("#popup_text").text("Do you really want to move ? All changes will be lost.");
	$("#myModalLabel").text("warning");
	}
});

$("#contact-patient-form input,select,radio").on('change', function()
{
	if(!$("#contact-patient-form").hasClass("change"))
	{
		$("#contact-patient-form").addClass("change");
		$("#addPatientMenu li a").removeAttr("onClick");
		$("#pageCancel").removeAttr("onClick");
		$("#cancel").removeAttr("onClick");
	}
});

$("#pageCancel").click(function()
{
	if($("#contact-patient-form").hasClass("change"))
	{
		$('#myModal').modal();
		
	}
});

$("#cancel").click(function()
{
	$("#contact-patient-form")[0].reset();
	$("#contact-patient-form").removeClass("change");
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


</script>

<div class="dashboard_top_nav">
<?php
if (isset ( $_REQUEST['type'] )) {
?>
  <ul id="addPatientMenu">
    <li  id="profile"><a href="#"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	
	<li  id="contact"><a href="#" class="active" onClick="openPageWithAjax('../../dashboard/pages/contact_detail.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/contact_detail.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)">Contact Detail</a></li>
	<li  id="Insurance"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)">Insurance</a></li>
	
    <li  id="device"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
	
    <li  id="device_schedule"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
     
	
	<span class="nmaePatFormat"><?php echo $patientInfo->{lastName}." ".$patientInfo->{firstName} ?></span>
	<?php
	if($dateOdBirthStr!= "")
	{
	?>
	<span class="dobPatFormat">
     DOB	
	<?php 
	echo $dateOdBirthStr;
	}
	?>
	</span>
  </ul>
  <?php
  }
  else
  {
  ?>
   <ul>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	 <li><a href="#" class="active">Contact Detail</a></li>
	 <li><a href="#">Insurance</a></li>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
    
  </ul>
  <?php
  }
  ?>
</div>

<!--end dashboard_header -->
<form method="post" id="contact-patient-form" class="form-horizontal"  onSubmit="postPatientForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/contact_detail.php','contact-patient-form','menu-content',event)">

<div>
<div>
<div class="col-lg-12">
<div class="col-md-6 FormLeft1">

<div class="form-group">
        <label for="inputEmail3" class="col-sm-4  "><?php echo constantAppResource::$DASHBOARD_TEXT_NAME;?><span style="color:red;">*</span></label>
        <div class="col-sm-3" style="padding-right:6px">
          <input type="text" class="form-control col-sm-4" name="first_name" id="first_name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" placeholder="First Name" value="<?php echo $patientInfo->{firstName} ?>" maxlength="50">
        </div>
        <div class="col-sm-1" style="padding:0">
          <input type="text" placeholder="M" class="form-control col-sm-2" value="<?php echo $patientInfo->{middleInitial} ?>" name="middle_name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'M'" maxlength="10">
        </div>
        <div class="col-sm-3" style="padding-left:6px;">
          <input type="text" placeholder="Last Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'"class="form-control col-sm-4" name="last_name" id="last_name" value="<?php echo $patientInfo->{lastName} ?>" maxlength="50"/>
        </div>
      </div>

<div class="form-group">
        <label for="dob" class="col-sm-4  " style="padding-top: 7px;"><?php echo constantAppResource::$DASHBOARD_TEXT_DATE_OF_BIRTH;?><span style="color:red;">*</span></label>
        <div class="col-sm-8">
		<input type="text" id="dob" name="dob" palceholder="MM/DD/YYYY" class="date_add_patient" value="<?php echo $dateOdBirthStr; ?>" style="margin-right:20px;width: 40%;padding: 0 7px;" onfocus="this.placeholder = ''" onblur="this.placeholder = 'MM/DD/YYYY'" maxlength="10" />
         </div>
         
         </div>


<div class="rightFormContact">
<h1>Billing Information:</h1>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address<span style="color:#b30f2a;">*</span></label>  
  <div class="col-md-8">
  <input  name="address1" id="address1"  placeholder="Address Line 1" class="form-control input-md" value="<?php echo $addressInfo[0]->{addressLine1}?>" type="text" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput"></label>  
  <div class="col-md-8">
  <input  name="address2" id="address2"  placeholder="Address Line 2" class="form-control input-md" value="<?php echo $addressInfo[0]->{addressLine2}?>" type="text" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">City / State<span style="color:#b30f2a;">*</span></label>  
  <div class="col-md-4">
  <input  name="city" id="city" placeholder="City / State" class="form-control input-md" value="<?php echo $addressInfo[0]->{city}?>" type="text">
  </div>
  <div class="col-md-4">
    <span class="custom-dropdown custom-dropdown--white" style="width:116px;">
          <select name="state"  id="state" class="custom-dropdown__select custom-dropdown__select--white" style="width:116px;">
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
          </span>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Zip<span style="color:#b30f2a;">*</span></label>  
  <div class="col-md-8">
  <input  name="zip" id="zip"  placeholder="Zip" class="form-control input-md" value="<?php echo $addressInfo[0]->{postalCode}?>" type="text">
  </div>
</div>

</div>

<div class="rightFormContact">
<h1>Billing Phone / Email:</h1>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Phone<span style="color:#b30f2a;"></span></label>  
  <div class="col-md-8">
  <input style="width: 48%;" id="phone" name="phone"  placeholder="Phone" class="form-control input-md" value="<?php echo $phoneInfo[0]->{phoneNumber};?>" type="text">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">E-mail<span style="color:#b30f2a;"></span></label>  
  <div class="col-md-8">
  <input  style="width: 48%;"  id="email" name="email" placeholder="E-mail" class="form-control input-md" value="<?php echo $emailaddressinfo[0]->{emailAddress};?>" type="text">
  </div>
</div>

</div>
</div>
<div class="col-md-6 FormRight1">
 <div class="form-group">
        <label for="username" class="col-sm-4  "><?php echo constantAppResource::$LOGIN_LABEL_USER_NAME;?><span style="color:red;">*</span></label>
        <div class="col-sm-7">
		  <?php
			if(!is_null($credentialsInfo->{userName}))
			{
		?>
			<input type="text" name="username" value="<?php echo $credentialsInfo->{userName}; ?>" readonly  class="form-control col-sm-4" id="username" name="username" />
		<?php
        }
		else
		{
		?>
          <input type="text" placeholder="User name"  class="form-control col-sm-4" id="username" name="username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'User Name'"  maxlength="50"/>
		<?php
        }
		?>
        </div>
      </div>
<div class="rightFormContact">
<h1>Delivery Information: <span style="font-size: 13px; margin-left: 14px;"><span style="margin-right:10px;"><input id="DeliveryAddress" type="checkbox" checked="<?php echo $addressInfo[0]->{preferred}?>" name="DeliveryAddress" value="DeliveryAddress"/></span>Same as billings information</span></h1>
<!--<p><span style="margin-right:10px;"><input id="DeliveryAddress" type="checkbox" checked="<?php //echo $addressInfo[0]->{preferred}?>" name="DeliveryAddress" value="DeliveryAddress"/></span>Same as billings information</p>-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Address<span style="color:#b30f2a;">*</span></label>  
  <div class="col-md-8">
  <input  name="Daddress1" id="Daddress1"  placeholder="Address Line 1" value="<?php echo $addressInfo[1]->{addressLine1};?>" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput"></label>  
  <div class="col-md-8">
  <input  name="Daddress2" id="Daddress2"  placeholder="Address Line 2" value="<?php echo $addressInfo[1]->{addressLine2};?>" class="form-control input-md" type="text">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">City / State<span style="color:#b30f2a;">*</span></label>  
  <div class="col-md-4">
  <input name="Dcity" id="Dcity" value="<?php echo $addressInfo[1]->{city};?>" placeholder="City / State" class="form-control input-md" type="text">
  </div>
  <div class="col-md-4">
    <span class="custom-dropdown custom-dropdown--white" style="width:116px;">
          <select name="Dstate"  id="Dstate" class="custom-dropdown__select custom-dropdown__select--white" style="width:116px;">
            <?php
					 foreach($statesInfo as $state)
					  {
						if(!is_null($addressInfo[1]))
						{
							if($state->{stateId} == $addressInfo[1]->{stateId})
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
          </span>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Zip<span style="color:#b30f2a;"></span></label>  
  <div class="col-md-8">
  <input name="Dzip" id="Dzip"  placeholder="Zip" value="<?php echo $addressInfo[1]->{postalCode};?>" class="form-control input-md" type="text">
  </div>
</div>

</div>

<div class="rightFormContact">
<h1>Preferred Contact Information:</h1>
<!--<p><span style="margin-right:10px;"><input  id="DeliveryPhone" type="checkbox" checked="<?php // echo $phoneInfo[0]->{preferred}?>" name="DeliveryPhone" value="DeliveryPhone"/></span>Fill your billings Phone Number </p>-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Phone<span style="color:#b30f2a;">*</span></label>  
  <div class="col-md-8">
  <input style="width: 48%; float: left;" id="Dphone" name="Dphone"  placeholder="Phone" value="<?php echo $phoneInfo[1]->{phoneNumber};?>" class="form-control input-md" type="text"><span style="margin-left: 10px; float: left; margin-top: 4px;"><span style="margin-right:10px;"><input  id="DeliveryPhone" type="checkbox" checked="<?php echo $phoneInfo[0]->{preferred}?>" name="DeliveryPhone" value="DeliveryPhone"/></span>Same as billings</span>
  </div>
</div>

<!--<p><span style="margin-right:10px;"><input   id="DeliveryEmail" checked="<?php // echo $emailaddressinfo[0]->{preferred}?>" type="checkbox" name="DeliveryEmail" value="DeliveryEmail"/></span>Fill your billings E-mail</p>-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">E-mail<span style="color:#b30f2a;"></span></label>  
  <div class="col-md-8">
  <input style="width: 48%; float: left;" id="Demail" name="Demail"  value="<?php echo $emailaddressinfo[1]->{emailAddress};?>" placeholder="E-mail" class="form-control input-md" type="text"><span style="margin-left: 10px; float: left; margin-top: 4px;"><span style="margin-right:10px;"><input   id="DeliveryEmail" checked="<?php echo $emailaddressinfo[0]->{preferred}?>" type="checkbox" name="DeliveryEmail" value="DeliveryEmail"/></span>Same as billings</span>
  </div>
</div>

</div>
</div>
</div>
</div>
</div>
		<div class="form-group" >
        <div class="pull-right1 pull-right1-responcive">
          <div class="col-sm-6" style="padding-left:0px;">
            <input type="button" value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>" id="pageCancel" class="but_cancel_bg" data="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php','','menu-content',event,'myModal')"  onClick="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php','','menu-content',event,'myModal')"/>
          </div>
          <div class="col-sm-3" style="padding-left:0px;">
            <input type="submit" style="margin: 5px 0px;" value="<?php echo constantAppResource::$COMMON_BUTTON_SAVE;?>" class="submit" name="addPatient" id="addPatient">
          </div>
        </div>
      </div>
      </div>
	  
    </div>
	  
	<?php
	if((!is_null($patientInfo->{addressInfo}[0])) AND ($patientInfo->{addressInfo}[0]->{addressId} > 0))
	{
?>   <input type="hidden" name="update" value="<?php echo constantAppResource::$COMMON_BUTTON_SAVE;?>"/>
    <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId};?>"/>
    <?php }else{ ?>
	 <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId};?>"/>
    <input type="hidden" name="submit" value="<?php echo constantAppResource::$COMMON_BUTTON_SAVE;?>"/>
    <?php
}
?>  
</form>
<!-- Cancel popup end  -->
</div>
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
  </div>
</div>
<!-- Cancel popup end  -->

<style>
.cart1 {
    background: linear-gradient(to bottom, #f7f7f7 0%, #f5f5f7 6%, #e4e3e8 32%, #e4e3e9 35%, #bab9c7 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
    height: 40px;
    margin: 0;
    padding: 10px 0 0 10px;
}
.cart1 img
{
                margin-top:-10px;
                float:right;
}
.alert {
margin: 20px;
line-height: 30px;
font-size: 18px;
color:#000;
}
.alert a {
background-color: #99cc00;
text-decoration: none;
color: #fff;
padding: 5px 25px;
float: right;
margin-bottom: 20px;
box-shadow: 0px 2px 6px #999;
}
#profileImgDiv
{
opacity:0.0;
position:relative;
top:-28;
left:0;
overflow:hidden;
cursor:pointer;

}
</style>
<!--end wapper -->
<script>
if($("#okay").hasClass("localStorage"))
{
var address1 = localStorage["address1"];
 $("#address1").val(address1);
var address2 = localStorage["address2"];
 $("#address2").val(address2);
var city = localStorage["city"];
 $("#city").val(city);
var state = localStorage["state"];
 $("#state").val(state);
var zip = localStorage["zip"];
 $("#zip").val(zip);
var email = localStorage["email"];
 $("#email").val(email);
var phone = localStorage["phone"];
 $("#phone").val(phone);
}
</script>

