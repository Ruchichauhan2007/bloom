<?php 
include 'controller/login_chooseAuthentication_method_controller.php'; 
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script>

$(document).ready(function(){ 
			$("#submitbtn").attr('disabled','disabled');
			$("#submitbtn").fadeTo(100,0.33);
 
});

function   chooseRadio()
{

$("#submitbtn").removeAttr('disabled');
$("#submitbtn").fadeTo(100,1);
  }
function   selectRadio1()
{
//alert()
document.getElementById('radio1').checked = true;
document.getElementById('radio2').checked = false;
$("#submitbtn").removeAttr('disabled');
$("#submitbtn").fadeTo(100,1);

}
function   selectRadio2()
{
//alert()
document.getElementById('radio2').checked = true;
document.getElementById('radio1').checked = false;
$("#submitbtn").removeAttr('disabled');
$("#submitbtn").fadeTo(100,1);

}

</script>
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
<link href="../script/css/login-css.css" rel="stylesheet" type="text/css">
<link href="../script/css/Responcive.css" rel="stylesheet" type="text/css">
<!--***** -->
<style>
@media (max-width:384px) {
footer{position:relative !important;}
}
.login-ChooseAuth form p {
    padding: 23px 0;
}
.login-ChooseAuth {
    padding-left: 47px;
}
@media (width:480px) {
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}
}
</style>
</head>
<body>
<!--start header -->
<div class="wrapper2">

<?php 
	include '../../common/pages/header.php';
	
 ?>
<!--end header -->

<!--start wapper -->

<div class="container">
<!--start login-ChooseAuth -->
  <div class="col-lg-11 col-xs-offset-1 login-ChooseAuth">
    <h3><?php echo constantAppResource::$LOGIN_TEXT_PLEASE_CHOOSE_AN_AUTHENTICATION;?></h3>
    <form method="post" action="">
      <div class="login_Authentica_img"> <a href="#" id="userNameAuth" onClick="selectRadio1();"><img src="../images/<?php echo constantAppResource::$LOGIN_IMAGE_lOGIN_AUTHENTICA_IMG2;?>" alt=""></a>
        <p>
          <input type="radio" name="authType" id="radio1" onClick="chooseRadio();"  value="<?php echo constantAppResource::$LOGIN_BUTTON_TRADITIONAL;?>" class="css-checkbox">
          <label for="radio1" class="css-label radGroup1 radGroup1"><?php echo constantAppResource::$LOGIN_LABEL_TRADITIONAL_USERNAME;?></label>
        </p>
      </div>
      <div class="login_Authentica_img"> <a href="#" id="imagePinAuth" onClick="selectRadio2();"><img src="../images/<?php echo constantAppResource::$LOGIN_IMAGE_lOGIN_AUTHENTICA_IMG1;?>" alt=""></a>
        <p>
          <input type="radio" name="authType" id="radio2" onClick="chooseRadio();" class="css-checkbox"  value="<?php echo constantAppResource::$LOGIN_BUTTON_IMAGE_PIN;?>">
          <label for="radio2" class="css-label radGroup1 radGroup1"><?php echo constantAppResource::$LOGIN_LABEL_IMAGE_AND_PIN;?></label>
        </p>
      </div>
      <div class="auth_but">
        <input type="reset" onClick="window.location.replace('login_userName.php');" value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>">
        <input type="submit" class="submit" id="submitbtn" value="<?php echo constantAppResource::$COMMON_BUTTON_NEXT;?>" name="submit">
      </div>
    </form>
    <div class="clear"></div>
  </div>
  
  <!--endt login-ChooseAuth -->
</div>
<div class="clear"></div>
<div class="push"></div>
</div>
<!--end wapper -->

<!--start footer -->

<?php
 include '../../common/pages/dashboard_footer.php';
 include 'popup/error_popup.php';  
 ?>

<!--end footer -->
</body>
</html>
