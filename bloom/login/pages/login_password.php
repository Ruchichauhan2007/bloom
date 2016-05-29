<?php
$user = $_COOKIE["user"];
$authType = $_COOKIE["authType"];
setcookie('user',$user,'','' ,'', false, false);
setcookie('authType',$authType, '','','', false, false);
$emailId = "";

include 'controller/login_password_controller.php';




if (isset ( $_POST ['forgot_password'] )) {
	setcookie("forgot_password",$_POST["forgot_password"], '','','', false, true);
	header ( "Location:portal_reset_credentials.php" );
}
?>

<!DOCTYPE html>
<html style=" height:100%;">
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
<style>
@media (max-width:320px) {
.login_logo_right_img > img {
    width: 34%;
}
.login_logo_right_img > img {
    margin-bottom: 24px !important;
}
}
@media (min-width:321px) and (max-width:415px) {
footer {
    position: fixed !important;
    bottom: 0px;
    display: block;
}
}
@media (max-width:767px) {
#lightbox{
    left: 20px !important;
    top: 72px !important;
    width: 280px !important;
}
}
@media (max-width:480px) {
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}
}

</style>
<!--***** -->
</head>
<body style=" height:100%;">
<!--start header -->
<div class="wrapper2">
<?php include '../../common/pages/header.php';
   
	
 ?>
<!--end header -->

<!--start wapper -->

<div class="container">

<div class="login_mid_section">
<div class="col-lg-8 login_leftpart_form">
      <form method="post" action="" id="password_form" autocomplete="off">
       
          <label><?php echo constantAppResource::$LOGIN_LABEL_PASSWORD;?><span style="color:red;">*</span></label>
		  <input type="password" name="password" style="display:none"/>
          <input type="password" name="password" id="passwordVal"   maxlength="15" autocomplete="off"/>
          <input type="submit"  name="submit" id="password_submit" class="submit"  value="<?php echo constantAppResource::$LOGIN_BUTTON_LOGIN;?>">
       </form>
       <form method="post" action="portal_reset_credentials.php">
       <input type="hidden" name="forgot_password" 	value="FORGOT_PASSWORD">
	   <?php
	   $entityUtil = new EntityUtil();
	   $paramArray[0] = $_COOKIE['user'];
				
	   $isRegisteredUser = $entityUtil->getObjectFromServer($paramArray, "isRegisteredUser", VMCPortalConstants::$API_ADMIN);
		
	   if($isRegisteredUser)
		   {
		   ?>
			  <input type="submit" value="<?php echo constantAppResource::$LOGIN_BUTTON_FORGOT_PASSWORD;?>" name="reset_password" class="forgot_username">
			<?php
		   }
      else	
		   {
		   ?>		  
		  <input type="submit" value="<?php echo constantAppResource::$LOGIN_BUTTON_FORGOT_PASSWORD;?>" name="error" class="forgot_username" id="error">
		   <?php
		   }
		   ?>
        <div class="password_Lchoose_button" style="margin-left:0px;">
		<h4 onClick="window.location.replace('logout.php');">Login as different user</h4></div>
		
        <p class="version_p"><?php echo constantAppResource::$LOGIN_TEXT_VERSION." ".getVersion();?></p>
		
       </form>
</div>

<aside class="col-lg-4 login_logo_right_img"> <img src="../images/<?php echo constantAppResource::$LOGIN_IMAGE_BLOOM;?>" alt=""> </aside>
</div>
</div>
<div class="clr"></div>
<div class="push"></div>
</div>
<!--end wapper -->

<!--start footer -->

<?php
 include '../../common/pages/footer.php';
 include 'popup/error_popup.php'; 
 include 'popup/CientSiderror_popup.php';

 ?>
<script>
$(document).ready(function()
{
$("#passwordVal").focus();
	$("#okay").click(function()
	{
	$("#passwordVal").focus();
	});
	
	$('#password_form').attr('autocomplete', 'off');
});

</script>


<!--end footer -->
</body>
</html>
