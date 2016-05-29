<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../script/css/self-registration.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="../../common/script/js/query.min_1.7.1.js"></script>
<script src="../../common/script/js/jquery-ui.js"></script>
<?php
include 'controller/self_registration_controller.php';
if($_REQUEST['EDIT'])
{
 $patientRegistrationId = $_REQUEST['patientRegistrationId'];
 $employerName =$_REQUEST["InstitutionName"];
 $employer = $_COOKIE['employer'];
 $paramArray = array();
 $paramArray[0] = $patientRegistrationId;
 $patientRegInfo = $entityUtil->postDataToregisterPatient($employerName,"findPatientRegistrationById",$paramArray,VMCPortalConstants::$API_EMR);
 $patientRegId = $patientRegInfo->{patientRegistrationId};
 $dateUtil = new DateUtil();
 $dateOdBirthStr = $dateUtil->formatDatetoStr($patientRegInfo->{dob});
 $employerName = $patientRegInfo->{employerName};
 $existingPatId =$patientRegInfo->{patientId};
}
else{
$employerName =$_REQUEST["InstitutionName"];
$employer=$_REQUEST["employerName"];
}
?>
 
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>
<!--Including css files used in all the html pages -->
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<script language="javascript">
$(document).ready(function(){
$(".imgcaptcha").attr("src","captcha.php?_="+((new Date()).getTime()));
$(".refresh").click(function () {
    $(".imgcaptcha").attr("src","captcha.php?_="+((new Date()).getTime()));
	var str = document.getElementById("captcha").value;
	showResult(str);
});

	$(".captial").focusout(function(){
		var arr = $(this).val().split(' ');
		var result = "";
		for (var x=0; x<arr.length; x++)
			result+=arr[x].substring(0,1).toUpperCase()+arr[x].substring(1)+' ';
		$(this).val(result.substring(0, result.length-1));
	}); 

 });
 function loding()
 {

	$('.ajax-loading').show();
	$('.wrapper2').show();
	$('.wrapper2').css({"background":"#ccc","opacity":".5"});

 }
</script>
<style>
html {
	height: 100%;
}
body {
	height: 100%;
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
.reg_step_left {
    padding-right: 0;
}
.reg_self_wapper {
    padding-right: 0;
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
<?php
	$entityUtil = new EntityUtil();
	$employerList  = $entityUtil->getAllEmployerList();
?>
<h1>Patient Registration</h1>
<form name="self_registration" id="self_registration" method="post" onSubmit="loding();">
<div class="col-md-12" style="padding:0">
<?php if($_REQUEST['EDIT'])
{?>
	<div class="col-md-1 self_reg_step1" style="padding:0">
	<a href="#">Step 1</a>
	</div>

	<div class="col-md-1 self_reg_step2">
	<a href="self_registration_insurance.php?EDIT=edit&existingPatId=<?php echo $existingPatId; ?>&employerName=<?php echo $employerName; ?>&patientRegistrationId=<?php echo $patientRegId; ?>">Step 2</a>
	</div>
<?php
}
else{
?>

	<div class="col-md-1 self_reg_step1" style="padding:0">
	<a href="#">Step 1</a>
	</div>

	<div class="col-md-1 self_reg_step2">
	<a href="#">Step 2</a>
	</div>
  <?php}
?>
</div>


<div class="col-md-12 self_pat_reg_form" style="padding:0">

<div class="col-md-6 reg_step_left" style="padding:0">

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding-left:0">Name <span>*</span> </label>
  <div class="col-md-8">
  <div class="col-md-5" style="padding:0 5PX 0 0"><input id="firstName" name="firstName" type="text" placeholder="First name " class="form-control input-md captial"  maxlength="50" value="<?php echo $patientRegInfo->{firstName} ?>"/></div>
  <div class="col-md-2" style="padding:0 5PX 0 0"><input id="middle" name="middle" type="text" placeholder="Middle " class="form-control input-md captial"  maxlength="15" value="<?php echo $patientRegInfo->{middleInitial} ?>"/></div>
  <div class="col-md-5" style="padding:0"><input id="lastName" name="lastName" type="text" placeholder="Last name " class="form-control input-md captial" value="<?php echo $patientRegInfo->{lastName} ?>" maxlength="50"></div>
  </div>

</div>

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">DOB <span>*</span></label>
  <div class="col-md-8">
 <input  name="dob" type="text" placeholder="MM/DD/YYYY " id="dob" class="form-control input-md"   maxlength="10" value="<?php echo $dateOdBirthStr ?>">
  </div>
</div>


<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Email address<span>*</span></label>
  <div class="col-md-8">
  <input id="email" name="email" type="text" placeholder="Email address" class="form-control input-md"   maxlength="50" value="<?php echo $patientRegInfo->{emailAddress} ?>">
  </div>



</div>

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Primary contact <span>*</span></label>
  <div class="col-md-8">
  <input id="phone" name="phone" type="text" placeholder="Phone number" class="form-control input-md"  maxlength="15" value="<?php echo $patientRegInfo->{phoneNumber} ?>">
  </div>



</div>

</div>


<div class="col-md-6 reg_step_left">

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Employer name </label>
  <div class="col-md-8">
   <input type="hidden" name="employer" id="employer" value="<?php echo $employerName;?>" class="form-control input-md" readonly />
  <input type="text" name="employerName" id="employerName" value="<?php echo $employer;?>" class="form-control input-md" readonly />
	<input id="username" name="username" type="hidden"  class="form-control input-md" maxlength="50" value="<?php echo $patientRegInfo->{userName} ?>">
 </div>

</div>




 <?php
			if(!is_null($patientRegInfo->{password}))
			{
		?>
		
         <input type="hidden"  value="<?php echo $patientRegInfo->{password}; ?>" class="form-control col-sm-4" id="oldpassword" name="oldpassword"/>
<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Password <span>*</span></label>

  <div class="col-md-8">
  <input id="password" name="password" type="password" placeholder="Password " class="form-control input-md" maxlength="15" value="*********">
   8 chars mixed case with numbers
  </div>

</div>

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Confirm password <span>*</span></label>
  <div class="col-md-8">
  <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm password  " class="form-control input-md"  maxlength="15" value="*********" >
  </div>

</div>
<?php
}
else
{
?>
<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Create Password  <span>*</span></label>

  <div class="col-md-8">
  <input id="password" name="password" type="password" placeholder="Password " class="form-control input-md" maxlength="15" >
   8 chars mixed case with numbers
  </div>

</div>

<div class="form-group">
  <label class="col-md-4 control-label " for="textinput" style="padding:0">Confirm password <span>*</span></label>
  <div class="col-md-8">
  <input id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm password  " class="form-control input-md"  maxlength="15"  >
  </div>

</div>
<?php
}
?>

		<div>
			<label class="col-md-4 control-label " style="padding-left: 0px;font-size:11px;">Type in characters as you see them on the right <span>*</span></label>
			<div class="col-md-8">
			<input type="text" placeholder="Enter Code" id="captcha" name="captcha" class="inputcaptcha" required="required" />
			<input type="hidden" placeholder="Enter Code" id="captchaResponse" value="0" class="inputcaptcha" required="required" />
			<img src="captcha.php" class="imgcaptcha" alt="captcha"  />
			<img src="../images/refresh.png" alt="reload" class="refresh" /></div>
		</div>

<div class="col-md-11" style="margin-top:15px; margin-left: -14px;">
<div class="col-md-2 self_reg_but">
<?php
if($patientRegId != "" || $patientRegId > 0)
{
?>
<input type="hidden" value="<?php echo $patientRegId; ?>" name="patientRegId"  id="patientRegId">
<?php }?>
<input type="submit" value="Next" name="submit"  id="submit">
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
include '../../login/pages/popup/error_popup.php';
include '../../common/pages/footer.php';
?>
<script>
		$(function(){
			$('#employer').change();
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
		$('#employer').change(function(){
				var val = $(this).val();
				var requestScheme = "http://";
<?php
if(!empty($_SERVER['HTTPS']))
{
?>
					requestScheme = "https://";
<?php }?>
				var action = requestScheme+val+"/gladstone/portal/bloom/selfregistration/pages/self_registration.php";
				$('#self_registration').attr('action',action);
			});
	});

$("#captcha").on('mouseout focusout click focus keyup', function() {
var str=$(this).val();
showResult(str);
});
</script>

<!--end footer -->
</body>
</html>
<script>
if($("#okay,.okay").hasClass("localStorage"))
{
var firstName = localStorage["firstName"];
 $("#firstName").val(firstName);
var middle = localStorage["middle"];
 $("#middle").val(middle);
var lastName = localStorage["lastName"];
 $("#lastName").val(lastName);
var dob = localStorage["dob"];
 $("#dob").val(dob);
var email = localStorage["email"];
 $("#email").val(email);
var phone = localStorage["phone"];
 $("#phone").val(phone);
var username = localStorage["username"];
 $("#username").val(username);
var password = localStorage["password"];
 $("#password").val(password);
 $("#confirmPassword").val(password);
var employer = localStorage["employer"];
	$("#employer").val(employer);
	var employerName = localStorage["employerName"];
	$("#employerName").val(employerName);
	
}

$(document).ready(function(){
var employerName = $("#employer").val();
var page = true;
if(employerName !="" || '<?php echo $_POST ["employer"];?>'!="")
{

}
else{
var url = "index.php";
$(location).attr('href',url);
}
});
</script>
<script>
function showResult(str) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("captchaResponse").value=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","validatecaptcha.php?captcha="+str,true);
  xmlhttp.send();
}

</script>

