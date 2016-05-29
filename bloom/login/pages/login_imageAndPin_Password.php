<?php
include 'controller/login_imageAndPin_password_controller.php';

$vmcService->setUserName($_COOKIE['user']);
$institutionName = explode(":", $_SERVER['HTTP_HOST']);
$vmcService->setInstitutionName($institutionName[0]);
$authInfo=$admin->getAuthInfo($vmcService);
$imageInfos = $authInfo->getAuthImageNames();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title>Gladstone</title>

<!--Including css files used in all the html pages -->
<script src="../script/js/set_pin_gallery.js"></script>
<script src="/gladstone/portal/bloom/common/script/js/set_pin.mousewheel.min.js"></script>
<script type="text/javascript" src="../script/js/set_pin_script.js"></script>
<script>


</script>

<link href="../script/css/login-css.css" rel="stylesheet" type="text/css">
<link href="../script/css/set_pin_gallery.css" rel="stylesheet" type="text/css">
<link href="../script/css/Responcive.css" rel="stylesheet" type="text/css">
<!--***** -->
<style>

.first_num
{width: 20px;
float: left;
height: 10px;
padding: 18px;
border: 1px solid gray;
}

.second_num
{width: 20px;
float: left;
height: 10px;
padding: 18px;
border: 1px solid gray;
}

.thired_num
{width: 20px;
float: left;
height: 10px;
padding: 18px;
border: 1px solid gray;
}

.fourth_num
{
width: 20px;
float: left;
height: 10px;
padding: 18px;
border: 1px solid gray;
}
.black_overlay
{
position:absolute;
top:0px;
left:0px;
width:100%;
height:100%;
z-index:1001;
opacity:0.5;
background-color:#CCCCCC;
display:none;

}
.sub_button
{
text-decoration: none;
background-color: #ff8900;
border-bottom: solid 5px #c85c03;
border-radius: 7px;
color: #fff;
font-size: 18px;
border-left: none;
border-top: none;
border-right: none;
cursor: pointer;
padding: 10px;
text-align: center;}
.hidediv
{width: 598px;
height: 300px;
position: relative;
padding:10px;
top:-320px;
left: 0px;
z-index: 1001;
display:none;
background-color:#999999;
opacity:0.5;

}

@media (min-width:992px) and (max-width:1199px) {
	footer{position:relative !important;}
	.login_gallery_pin {
    margin-bottom: 90px;
}
}
@media (width:600px) {
body {
    background-size: 100% 100% !important;
    height: auto !important;
}
	footer{position:relative !important;}
}
@media (min-width:768px) and (max-width:991px) {
footer{position:relative !important;}
}
@media (max-width:767px) {
footer{position:relative !important;}
}
@media (max-width:482px) {
#imageContainer {
    float: left;
    position: relative;
	width:300px !important;
}
}
@media (max-width:482px) {
#submit_button.submit {
    float: left !important;
    margin: 18px 0 23px 5px !important;
}
}
@media (width:640px) {
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}

}
html
{
	height:100%;
}
#imageBox {
height: 230px;
/* overflow-y: hidden; */
overflow: hidden;
}
.login_gallery_pin input[type=reset] {
margin-top: 290px;
}
.login_gallery_pin input[type=submit] {
margin-top: 290px;
}
</style>
<body>
<!--start header -->
<div class="wrapper2">
<?php include '../../common/pages/header.php'; ?>
<!--end header -->
<!--start wapper -->

<div class="container">
<div id="imageContainer" class="col-lg-8">
    <h3><?php echo constantAppResource::$LOGIN_IMAGEANDPIN_PASSWORD_TEXT_WELCOME;?><?php echo $_COOKIE['user'];?></h3>
    <h5><?php echo constantAppResource::$LOGIN_IMAGEANDPIN_PASSWORD_TEXT_PLEASE_SELECT_IMAGEPIN;?></h5>
	<ul id="imageBox">
	<?php
		$i=0;

		foreach($imageInfos as $imageInfo)
		{
			$i++;
	?>
			<li class="galleryimages<?php echo " ".$imageInfo->getImageName().'-'.$imageInfo->getImageId();?>" id="<?php echo $imageInfo->getImageName(); ?>"> </li>
	<?php
		if($i == 4)
		{?>
		<div style="clean:both"></div>
		<?php
			}
		}
	?>
</ul>
    <div class="Winimages" style="margin-left: 92px;"><br>
	      <input type="button" value="<?php echo constantAppResource::$LOGIN_IMAGEANDPIN_PASSWORD_BUTTON_FORGOT_IMAGEORPIN;?>" onClick="window.location.replace('portal_reset_credentials.php');"> <br/>
          <div class="login_Lchoose_button" onClick="window.location.replace('logout.php');" style="margin-top:2px;"><?php echo constantAppResource::$LOGIN_IMAGEANDPIN_PASSWORD_TEXT_LOGIN_DIFFERENT_USER;?></div>
    </div>
  </div>
<div class="col-lg-4 login_gallery_pin">
  <aside>
      <form method="post"  id="pin_form"  action="" name="pinForm">
        <h2><?php echo constantAppResource::$LOGIN_IMAGEANDPIN_PASSWORD_TEXT_PIN;?></h2>
        <input type="password"  maxlength="1" name="firstpin"   id="firstpin">
        <input type="password"  maxlength="1" name="secondpin"  id="secondpin">
        <input type="password"  maxlength="1" name="thirdpin" id="thirdpin">
        <input type="password"  maxlength="1" name="fourthpin"  id="fourthpin">
		<input type="hidden" id="imageName" name="imageName" value=""   >
        <div class="but_pin">
		<input type="submit"  id="submit_button" value="<?php echo constantAppResource::$COMMON_BUTTON_SUBMIT;?>" class="submit"  name="submit" >
		<input type="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>" id="cancel"  name="cancel" >
        </div>
      </form>
    </aside>
  </div>
</div>
<!--end wapper -->

<!--start footer -->
<div class="clear"></div>
<div class="push"></div>
</div>
<?php include '../../common/pages/footer.php';
 include 'popup/error_popup.php';
 ?>
<!--end footer -->
<script>
$(document).ready(function(){
			$("#submit_button").attr('disabled','disabled');
			$("#submit_button").fadeTo(100,0.33);
});
$("#imageBox li").click(function(){
	var cls = $(this).attr('class');
	var image_Id = $(this).attr('id');
	var position = cls.split(' ')[1];
	$('#imageName').val(image_Id);
	//$('#imageBox li').css('background','none');
	$('#imageBox li').css('background','black');
	$("#firstpin").focus();
	checkFieldValues();
});

function checkFieldValues()
{
	var allValues = true;
	$('#pin_form input[type=password]').each(function(){
		if($(this).val() == "" || $(this).val() == null )
			allValues = false;
	});
	var imageName = $('#imageName').val();
	imageName = $.trim(imageName);
	if(imageName == null || imageName == '')
	{
		allValues = false;
	}
	if(!allValues)
	{
		disableSubmit();
	}
	else
	{
		enableSubmit();
	}
}

function disableSubmit()
{
		$('#submit_button').attr('disabled','disabled');
		$('#submit_button').css('opacity',0.33);
}

function enableSubmit()
{
	$('#submit_button').removeAttr('disabled');
	$('#submit_button').css('opacity',1);
}
function  submitButton()
{

}



$(function(){
$("#pin_form input[type=password]").keyup(function(){
	checkFieldValues();
	console.log("");
});
  $("#pin_form input[type=password]").keyup(function (e) {
     // if not number
	 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.keyCode < 96 || e.keyCode > 105))
	 {	$(this).val('')
	    return false;
     }
	else
	{
		// this is fourth text box
		if($(this).attr('id') != 'fourthpin')
		{
			if(e.which != 8)
			{
				$(this).next().focus();
			}
		}
	}
   });

   				$("#cancel").click(function()
				{
					$("#pin_form input[type=password]").val('');
					$('#imageBox li').css('background','');
					$('#imageName').val('');
					disableSubmit();
				});


  });
</script>

</body>
</html>
