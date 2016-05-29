<?php 
include 'controller/set_imageAndPin_controller.php'; 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>

<!--Including css files used in all the html pages -->
<script src="../script/js/set_pin_gallery.js"></script>
<script src="/gladstone/portal/bloom/common/script/js/set_pin.mousewheel.min.js"></script>
<script type="text/javascript" src="../script/js/set_pin_script.js"></script>
<script>


</script>

<link href="../script/css/login-css.css" rel="stylesheet" type="text/css">
<link href="../script/css/set_pin_gallery.css" rel="stylesheet" type="text/css">
<link href="../script/css/Responcive.css" rel="stylesheet" type="text/css">
<style>
.login_gallery_pin input[type="submit"] {
    float: right;
	margin-bottom: 50px;
	margin-top: 260px !important;
	margin-right: 34px;
}
html
{
	height:100%;
}
@media (max-width:480px) {
.Login_choose_button {
    margin-right: 0 !important;
}
#preview {
    left: -78px;
    position: absolute;
    top: 375px !important;
}
#submit_button.submit {
    float: left !important;
    margin: 0 0 9px 15px !important;
}
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}
}
@media (max-width:320px) {
body {
    background-size: 100% 100% !important;
    height: auto  !important;
}
#submit_button.submit {
    float: left !important;
    margin: 12px 0 9px 15px !important;
}
}
</style>
<!--***** -->
</head>
<body>
<!--start header -->
<div class="wrapper2">
<?php include '../../common/pages/header.php'; ?>
<!--end header -->

<!--start wapper -->

<div class="container">

<div id="imageContainer" class="col-lg-8">
    <h3><?php echo constantAppResource::$LOGIN_SET_IMAGEANDPIN_TEXT_SET_IMAGEANDPIN;?></h3>
   <!-- <h5></div>/?php echo constantAppResource::$LOGIN_SET_IMAGEANDPIN_TEXT_SELECTANIMAGEANDPIN;?></h5>-->
    <ul id="imageBox">
      <li class="galleryimages airplane-1" id="airplane"></li>
      <li class="galleryimages apple-2" id="apple"></li>
      <li class="galleryimages banana-3" id="banana"></li>
      <li class="galleryimages barn-4" id="barn"></li>
      <li class="galleryimages bear-5" id="bear"></li>
      <li class="galleryimages beaver-6" id="beaver"></li>
      <li class="galleryimages book-7" id="book"></li>
      <li class="galleryimages butterfly-8" id="butterfly"></li>
      <li class="galleryimages candle-9" id="candle"></li>
      <li class="galleryimages car-10" id="car"></li>
      <li class="galleryimages cat-11" id="cat"></li>
      <li class="galleryimages cookie-12" id="cookie"></li>
      <li class="galleryimages cow-13" id="cow"></li>
      <li class="galleryimages dino-14" id="dino"></li>
      <li class="galleryimages dog-15" id="dog"></li>
      <li class="galleryimages drop-16" id="drop"></li>
      <li class="galleryimages drum-17" id="drum"></li>
      <li class="galleryimages duck-18" id="duck"></li>
      <li class="galleryimages eagel-19" id="eagel"></li>
      <li class="galleryimages egg-20" id="egg"></li>
      <li class="galleryimages FIRE-21" id="FIRE"></li>
      <li class="galleryimages firehydrant-22" id="firehydrant"></li>
      <li class="galleryimages frog-23" id="frog"></li>
      <li class="galleryimages gate-24" id="gate"></li>
      <li class="galleryimages giza-25" id="giza"></li>
      <li class="galleryimages hal-26" id="hal"></li>
      <li class="galleryimages hamburger-27" id="hamburger"></li>
      <li class="galleryimages heart-28" id="heart"></li>
      <li class="galleryimages house-29" id="house"></li>
      <li class="galleryimages island-30" id="island"></li>
      <li class="galleryimages kite-31" id="kite"></li>
      <li class="galleryimages leaf-32" id="leaf"></li>
      <li class="galleryimages lemon-33" id="lemon"></li>
      <div style="clear:both;"></div>
      <li class="galleryimages lighthouse-34" id="lighthouse"></li>
      <li class="galleryimages lion-35" id="lion"></li>
      <li class="galleryimages manwpipe-36" id="manwpipe"></li>
      <li class="galleryimages mms-37" id="mms"></li>
      <li class="galleryimages moonwolf-38" id="moonwolf"></li>
      <li class="galleryimages motorcycle-39" id="motorcycle"></li>
      <li class="galleryimages mouse-40" id="mouse"></li>
      <li class="galleryimages orangejuice-41" id="orangejuice"></li>
      <li class="galleryimages paw-42" id="paw"></li>
      <li class="galleryimages peace-43" id="peace"></li>
      <li class="galleryimages pengiun-44" id="pengiun"></li>
      <li class="galleryimages pepper-45" id="pepper"></li>
      <li class="galleryimages piano-46" id="piano"></li>
      <li class="galleryimages pond-47" id="pond"></li>
      <li class="galleryimages popcorn-48" id="popcorn"></li>
      <li class="galleryimages pumpkinpie-49" id="pumpkinpie"></li>
	  <li class="galleryimages rocket-50" id="rocket"></li>
      <li class="galleryimages sailboat-51" id="sailboat"></li>
      <li class="galleryimages salad-52" id="salad"></li>
      <li class="galleryimages saturn-53" id="saturn"></li>
      <li class="galleryimages skate-54" id="skate"></li>
      <li class="galleryimages snowflake-55" id="snowflake"></li>
      <li class="galleryimages statueliberty-56" id="statueliberty"></li>
      <li class="galleryimages sun-57" id="sun"></li>
      <li class="galleryimages taj-58" id="taj"></li>
      <li class="galleryimages toucan-59" id="toucan"></li>
      <li class="galleryimages tree-60" id="tree"></li>
      <li class="galleryimages truck-61" id="truck"></li>
      <li class="galleryimages tuba-62" id="tuba"></li>
      <li class="galleryimages umbrella-63" id="umbrella"></li>
      <li class="galleryimages wheel-64" id="wheel"></li>
      <li class="galleryimages wizardhat-65" id="wizardhat"></li>
    </ul>
    <div>
      <div id="preview">
      <p class="image_text"><span  style="color: black; padding: 0 3px;">*</span><?php echo constantAppResource::$LOGIN_SET_IMAGEANDPIN_TEXT_IMAGESELECT;?></p>
      </div>
	 	<div class="Login_choose_button">
		<h4  onClick="window.location.replace('login_chooseAuthentication_method.php');" ><?php echo constantAppResource::$LOGIN_BUTTON_TEXT_CHOOSE_ANOTHER_LOGIN_METHOD;?></h4>
		
		</div>
		
	  </div>
      
    
  </div>
  <div class="col-lg-4 login_gallery_pin">
  <aside>
      <form method="post"  id="pin_form" name="pinForm" onSubmit="return formsubmit();">
        <h2><?php echo constantAppResource::$LOGIN_IMAGEANDPIN_PASSWORD_TEXT_PIN;?></h2>
        <input type="text"  maxlength="1"   id="firstpin">
        <input type="text"  maxlength="1"  id="secondpin">
        <input type="text"  maxlength="1" id="thirdpin">
        <input type="text"  maxlength="1"  id="fourthpin">
		<input type="hidden" id="imageName" value="" class="image_name">
		<input type="submit" class="submit" value="<?php echo constantAppResource::$COMMON_BUTTON_SUBMIT;?>"  name="imageAndPin" id="submit_button">
      </form>
      </aside>
  </div>
</div>

<!--end wapper -->

<!--start footer -->
<div class="clear"></div>
<div class="push"></div>
</div>
<?php include '../../common/pages/footer.php'; ?>

<!--end footer -->
<script>
$(document).ready(function(){ 
			$("#submit_button").attr('disabled','disabled');
			$("#submit_button").fadeTo(100,0.33);
});

$('#preview').hide();
	$("#preview").css({"border-color": "#FFF", "border-weight":"0px","border-style":"none"});

$("#imageBox li").click(function(){
	$("#imageBox li").css({"border-color": "#FFF", "border-weight":"0px","border-style":"none"});
	$(this).css({"border-color": "#C1E0FF", "border-weight":"1px","border-style":"solid"});
	var cls = $(this).attr('class');
	var image_Id = $(this).attr('id');
	var position = cls.split(' ')[1];
	$('#preview').attr('class','');
	$('#preview').addClass(position);
	$('#imageName').val(image_Id);
	$('#preview').show();
	$("#firstpin").focus();
	checkFieldValues();
});

function checkFieldValues()
{
	var allValues = true;
	$('#pin_form input[type=text]').each(function(){
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
$("#pin_form input[type=text]").keyup(function(){
	checkFieldValues();
});
  $("#pin_form input[type=text]").keypress(function (e) {
     // if not number
	 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 {
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
					$("#pin_form input[type=text]").val('');
					var priew=$("#preview").attr('class');
					$("#preview").attr('class','');
					$('#pop_img').removeClass("galleryimages "+priew);
					$("#firstpin").focus();
					$("#imageBox li").css({"border-color": "#FFF", "border-weight":"0px","border-style":"none"});
					$('#preview').hide();
					$("#light").hide();
					$("#fade").hide();
					$('#imageName').val('');
					disableSubmit();
				});
   
   
  }); 
function formsubmit()
{
				$("#light").show();
				$("#fade").show();
				var priew=$('#preview').attr('class');
				$('#pop_img').addClass("galleryimages "+priew);
				var firstval=$('#firstpin').val();
				var secondval=$('#secondpin').val();
				var thiredval=$('#thirdpin').val();
				var fourthval=$('#fourthpin').val();
				var imageName_pin=$('#imageName').val();
				$('#first_num').val(firstval);
				$('#second_num').val(secondval);
				$('#thired_num').val(thiredval);
				$('#fourth_num').val(fourthval);
				$('#imageNamepin').val(imageName_pin);
				$('#preview').hide();		
		return false;
}


		
</script>



	<div id="light" class="white_content" style="display:none;"><p class="cart"> <b> <?php echo constantAppResource::$LOGIN_LABEL_IMAGE_AND_PIN;?> </b><a href = "" onclick ="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';"><img src="../images/close.jpg" align="right" class="close"></a></p>
	<div style="margin-top: 35px; font-weight: bold; margin-left: 91px; font-size: 17px;"> <?php echo constantAppResource::$LOGIN_SET_IMAGEANDPIN_TEXT_SET_YOURIMAGEIS;?> </div>
    <div style="margin-top:15px;" id="pop_img"> </div>
<form method="post" action="" id="imagePin">
<div style="font-weight: bold; font-size: 12pt; margin-bottom: 17px; position: relative; left: 294px; top: -204px;margin-top: 62px;"><?php echo constantAppResource::$LOGIN_SET_IMAGEANDPIN_TEXT_SET_YOURPINIS;?> </div>

<div class="main_num" > 
		<input type="text" id="first_num" readonly="readonly" name="firstpin" class="first_num" />
		<input type="text" id="second_num"  readonly="readonly" name="secondpin" class="second_num" />
		<input type="text" id="thired_num" readonly="readonly"  name="thirdpin" class="thired_num" />
		<input type="text" id="fourth_num" readonly="readonly"  name="fourthpin"  class="fourth_num" />
		<input type="hidden" id="imageNamepin" name="imageNamepin"  class="image_name" />
</div>
<div class="main_num1" style="float:left; position:relative;top:-112px; left:220px;"></div>
<input type="reset" id="cancel" class="sub_button" style="margin-top: -92px;margin-left:38px;margin-right:10px;" name="cancel"  value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>"/>
<input type="submit" class="submit"  name="submit_form" id="submit_button" style="position: relative; top:-102px;right:-148px;" value="<?php echo constantAppResource::$COMMON_BUTTON_OKEY;?>"/>
</form>
</div>
	</div>
	<div id="fade" class="black_overlay"></div>

</body>
</html>
