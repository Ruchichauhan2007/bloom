<?php
include 'controller/index_controller.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../script/css/self-registration.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>
<!--Including css files used in all the html pages -->
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<style>
html
{
height:100%;
}
body
{
height:100%;
}
.reg_emp_name 
{
text-align: center;
font-size: 36px;
margin-top: 175px;
font-weight: normal;}
.reg_emp_name_text select {
width: 64%;
height: 43px;
margin-top: 41px;
margin-left: 44%;
background-color: #DFEDF0;
margin-bottom: 15px;
}
.self_reg_but
{
margin-top: 52px;
}

.self_reg_but a
{
background-color: #428bca;
color: #fff;
padding: 14px 28px;
}
.container1
{
width:800px;
margin:0 auto;
}
.self_reg_but a#btnLogin {
    background-color: #1adb82;
    border-color: #18ab67;
    border-radius: 5px;
    border-style: none none solid;
    border-width: medium medium 5px;
    color: #fff;
    cursor: pointer;
    font-size: 16pt;
    height: 44px;
    margin: 10px 10px 10px 0;
    padding: 11px 25px;
	text-decoration:none;
    text-align: center;
    width: 100px;
}
.self_reg_but2 a#btnSignup {
background-color: #ff8900;
border-color: #c85c03;
border-radius: 5px;
border-style: none none solid;
border-width: medium medium 5px;
color: #fff;
cursor: pointer;
font-size: 16pt;
height: 44px;
margin: 10px 10px 10px 0;
padding: 11px 25px;
text-align: center;
width: 100px;
text-decoration: none;
}
.self_reg_but {
    text-align: right;
	margin-top: 10px;
}
.self_reg_but2 {
    text-align: left;
	margin-top: 9px;
}
#employer{
    font-size: 16px;
}
</style>
<script>
function employeVal(){
var url=document.getElementById("employer").value;
var institutionName=document.getElementById("employer").value;
var employerName=document.getElementById("employer");
employerName = employerName.options[employerName.selectedIndex].text;

var requestScheme = "http://";
<?php
if(!empty($_SERVER['HTTPS']))
{
?>
	requestScheme = "https://";
<?php }?>
			postDataToins();
		function postDataToins()
		{
		   var form = document.createElement("form");
			   document.body.appendChild(form);
			   form.method = "POST";
			   form.action = requestScheme+url+"/gladstone/portal/bloom/selfregistration/pages/self_registration.php";
			   var element1 = document.createElement("INPUT");
			    element1.name="employerName"
			    element1.value = employerName;
			    element1.type = 'hidden'
			    form.appendChild(element1);
			    var element2 = document.createElement("INPUT");
			    element2.name="InstitutionName"
			    element2.value = institutionName;
			    element2.type = 'hidden'
			    form.appendChild(element2);
			    form.submit();
			}

}

function employeValLogin(){
var url=document.getElementById("employer").value;
var institutionName=document.getElementById("employer").value;
	var requestScheme = "http://";
<?php
if(!empty($_SERVER['HTTPS']))
{
?>
	requestScheme = "https://";
<?php }?>
	window.location.assign(requestScheme+url+"/gladstone/portal/bloom/login/pages/login_userName.php");
	
}
</script>
</head>
<body>

<?php 
	$entityUtil = new EntityUtil();
	$employerList  = $entityUtil->getAllEmployerList();
?>
<div class="container"> 

<div class="form-group">
  <label class="col-md-12 control-label reg_emp_name" for="textinput" style="padding:0">Select Employer Name  </label> 
  <div class="col-lg-12"> 
  
  <div class="col-md-8 reg_emp_name_text" style="text-align:center;">
 <select name="employer" id="employer">
 <?php  foreach($employerList as $employer) 
		{ 	?>
		 <option value="<?php echo $employer->{institutionName};?>"><?php echo $employer->{employerName}; ?></option>
 <?php 	} ?> 
 </select>
  </div>

</div>



<div class="col-md-12">
<div class="col-lg-3"></div>
<div class="col-md-3 self_reg_but">
<a  id="btnLogin" type="reset" onClick="employeValLogin();">Log In</a> 
</div>

<div class="col-md-3 self_reg_but2" style="padding:0px;">
<a  id="btnSignup" onClick="employeVal();">Sign Up</a>
</div>
<div class="col-lg-3"></div>
</div>

</div>
</div>


</body>
</html>
