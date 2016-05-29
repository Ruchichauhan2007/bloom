<?php
include 'controller/self_registration_insurance_controller.php';
if(isset($_REQUEST['EDIT']))
{
$employer = $_COOKIE['employer'];
$employerName =$_REQUEST["employerName"];
$patientRegistrationInfo =$_REQUEST["patientRegistrationInfo"];
$patientRegistrationId = $_REQUEST["patientRegistrationId"];
}
else{
$employerName =$_REQUEST["employerName"];
$patientRegistrationInfo =$_REQUEST["patientRegistrationInfo"];
$patientRegistrationId = $_REQUEST["patientRegistrationId"];
$employer = $_REQUEST["employer"];
setcookie("employer",$employer,0,'/', '', false, true);
}
$entityUtil = new EntityUtil();
$paramArray = array();
$statesInfo = $entityUtil->postDataToregisterPatient($employerName, "getStateListWithOutRegistration", $paramArray ,VMCPortalConstants::$API_ADMIN);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../script/css/self-registration.css" rel="stylesheet"
	type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet"
	type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet"
	type="text/css">
<link rel="stylesheet"
	href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="../../common/script/js/query.min_1.7.1.js"></script>
<script src="../../common/script/js/jquery-ui.js"></script>

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>
<!--Including css files used in all the html pages -->
<link	href="/gladstone/portal/bloom/common/script/css/common-css.css"
	rel="stylesheet" type="text/css">
	
	

	
<style>
html {
	height: 100%;
}

body {
	height: 100%;
}

@media ( min-width : 1200px) {
	.container {
		width: 1000px;
	}
}

.form-control.input-md.hasDatepicker {
	float: left;
	width: 45%;
}

.ui-datepicker-trigger {
	margin-left: 5px;
	margin-top: -4px;
	width: 27px;
}
.reg_self_wapper .col-md-5 > span {
    font-size: 20px;
    margin-left: 10px;
	padding-bottom:5px;
}

</style>
</head>
<body>
	<div class="wrapper2">
		<!--start header -->
		<?php
		include '../../common/pages/header.php';
		?>
		<!--end header -->
		<!--start wapper -->
		<div class="container">
			<div class="row">
				<div class="col-lg-12 reg_self_wapper" style="padding: 0">
					<h1>Insurance Detail</h1>
					<form name="self_registration_Ins" id="self_registration_Ins" method="post"
						action="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/selfregistration/pages/self_registration_insurance.php">
						<input type="hidden" name="employerName"
							value="<?php echo $employerName?>" /> <input type="hidden"
							name="patientRegistrationId"
							value="<?php echo $patientRegistrationId?>" />
						<div class="col-md-12 reg_self_wapper" style="padding: 0">

							<div class="col-md-1 self_reg_step2">
								<a  id="self_registrationPage" href="self_registration.php?EDIT=edit&patientRegistrationId=<?php echo $patientRegistrationId ?>&InstitutionName=<?php echo $employerName ?>" data="self_registration.php?EDIT=edit&patientRegistrationId=<?php echo $patientRegistrationId ?>&InstitutionName=<?php echo $employerName ?>">Step 1</a>
							</div>

							<div class="col-md-1 self_reg_step1" style="padding: 0">
								<a href="#">Step 2</a>
							</div>
							<div class="col-md-5" style="padding: 0">
								<span><input type="checkbox" id="myCheck" /> Copy from profile</span>
							</div>

						</div>

						<div class="col-md-12 self_form_bbg">

							<div class="col-md-12 self_pat_reg_form" style="padding: 0px;">

								<div class="col-md-6 reg_step_left" style="padding: 0">

									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding-left: 0">Group Id </label>
										<div class="col-md-8">
											<input id="groupId" name="groupId" type="text"
												placeholder="Group Id" class="form-control input-md" maxlength="15">
										</div>

									</div>

									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Name</label>
										<div class="col-md-8" style="padding: 0">
											<div class="col-md-6">
												<input id="firstName" name="firstName" type="text"
													placeholder="First name" class="form-control input-md captial"
													maxlength="50">
											</div>
											<div class="col-md-6">
												<input id="lastName" name="lastName" type="text"
													placeholder="Last name" class="form-control input-md captial"
													maxlength="50">
											</div>
										</div>


									</div>


									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Date of brith</label>
										<div class="col-md-8">
											<input id="dob" name="dob" type="text" placeholder="mm/dd/yy"
												class="form-control input-md" maxlength="10">
										</div>

									</div>

									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Phone number</label>
										<div class="col-md-8">
											<input id="phone" name="phone" type="text"
												placeholder="Phone number" class="form-control input-md"
												maxlength="15">
										</div>

									</div>


									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Email address</label>
										<div class="col-md-8">
											<input id="email" name="email" type="text"
												placeholder="Email " class="form-control input-md">
										</div>

									</div>


								</div>


								<div class="col-md-6 reg_step_left">
									<!--<p class="self_reg_text">First name, last name and DOB of insured </p>-->

									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Member Id </label>
										<div class="col-md-8">
											<input id="memberId" name="memberId" type="text" placeholder="Member Id"
												class="form-control input-md" maxlength="15"/>
										</div>

									</div>



									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Address 1</label>
										<div class="col-md-8">
											<input id="address1" name="address1" type="text"
												placeholder="Address1" class="form-control input-md">
										</div>
									</div>


									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Address 2</label>
										<div class="col-md-8">
											<input id="address2" name="address2" type="text"
												placeholder="Address" class="form-control input-md">
										</div>
									</div>




									<div class="form-group">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">City/State</label>
										<div class="col-md-5" style="padding-right: 0px;">
											<input id="city" name="city" type="text" placeholder="City"
												class="form-control input-md" />
										</div>
										<div class="col-md-3">
											<select name="stateId">
												<?php
												foreach($statesInfo as $state)
												{
													?>
												<option value="<?php	echo $state->{stateId};?>">
													<?php	echo $state->{stateCode};?>
												</option>
												<?php
												}
												?>
											</select>

										</div>
									</div>
									
									<div class="form-group" style="margin-top: 18px;">
										<label class="col-md-4 control-label " for="textinput"
											style="padding: 0">Zip</label>
										<div class="col-md-8">
											<input id="zip" name="zip" type="text"
												placeholder="Zip" class="form-control input-md">
										</div>
									</div>
									
									
								</div>

							</div>

							<div class="col-md-2 self_reg_but">
								<input type="submit" value="Save" id="submit" name="submit">
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
include '../../login/pages/popup/error_popup.php';
include '../../common/pages/footer.php';
?>
	<script>
		$(function(){
		$( "#dob" ).datepicker({
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

var patientRegistrationInfo='<?php echo $patientRegistrationInfo?>';
patientRegistrationInfo=patientRegistrationInfo.split("=");

$('#myCheck').click(function () {
	if($("#myCheck").is(':checked'))
	{
	$("#firstName").val(patientRegistrationInfo[0]);
	$("#lastName").val(patientRegistrationInfo[1]);
	$("#dob").val(patientRegistrationInfo[4]);
	$("#email").val(patientRegistrationInfo[3]);
	$("#phone").val(patientRegistrationInfo[2]);
	if(!$("#self_registration_Ins").hasClass("change"))
	{
		$("#self_registration_Ins").addClass("change");
		$("#self_registrationPage").removeAttr("href");
	}

  // checked
	}
	else
	{
	$("#firstName").val("");
	$("#lastName").val("");
	$("#dob").val("");
	$("#email").val("");
	$("#phone").val("");
	}
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
var currntMenu="";
$("#self_registrationPage").click(function()
{
	var currentUrl=$(this).attr('data');
	if($("#self_registration_Ins").hasClass("change"))
	{
	$('#lightbox').show();
	$('#fadediv').show();
	$("#txt_div").text("Do you really want to move ? All changes will be lost.");
	$("#cart_page").text("warning");
	$("#okay").html("Yes");
	$("#okay").attr("href",currentUrl);
	$("#no").show();
	}
});

$("#self_registration_Ins input,select,radio").on('change', function()
{		$("#self_registrationPage").removeAttr('href');
	if(!$("#self_registration_Ins").hasClass("change"))
	{
		$("#self_registration_Ins").addClass("change");
		$("#self_registrationPage").removeAttr("onClick");
	}
});


$("#no,#fadediv,#error").click(function()
{
	$('#lightbox').hide();
	$('#fadediv').hide();
	$("#txt_div").text("");
	$("#cart_page").text("warning");
	$("#okay").html("Okay");
	$("#okay").attr("href","javascript:void");
	$("#no").hide();
});

</script>

	<!--end footer -->
</body>
</html>
