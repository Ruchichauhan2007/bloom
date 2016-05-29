<?php
include 'controller/self_registration_controller.php';
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
.reg_emp_name_text select
{
width: 64%;
height: 43px;
margin-top: 41px;
margin-left: 40%;
background-color: #DFEDF0;
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
</style>
<script>
function employeVal(){

var url=document.getElementById("employer").value;
var institutionName=document.getElementById("employer").value;
	if(url=="beltechnology")
	{
	url=url+":8080";
	}
window.location.assign("http://"+url+"/gladstone/portal/bloom/selfregistration/pages/self_registration.php?InstitutionName="+institutionName+"");
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
<div class="col-md-4 self_reg_but">
<a  id="btn" onClick="employeVal();">GO</a>
</div>
</div>
</div>
</div>


</body>
</html>
