<?php 
	
	include 'controller/portal_reset_credentials_controller.php'; 
	 include 'popup/CientSiderror_popup.php';
	 

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>
<!--Including css files used in all the html pages -->
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../script/css/provider.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../script/css/provider_link.css" rel="stylesheet" type="text/css">
<link href="../script/css/login-css.css" rel="stylesheet" type="text/css">
 <link href="../script/css/Responcive.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-29231762-1']);
  _gaq.push(['_setDomainName', 'dzyngiri.com']);
  _gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<style>
@media (min-width:992px) and (max-width:1199px) {
input.col-lg-1 {
    width: 10%;
}
input.col-lg-3 {
    width: 25%;
}
}
@media (width:600px) {
input.col-lg-1 {
    width: 25%;
}
input.col-lg-3 {
    width: 25%;
}
}
@media (max-width:482px) {
input.col-lg-1 {
    width: 85%;
	margin: 5px 0 !important;
}
input.col-lg-3 {
    width: 85%;
	margin: 5px 0 !important;
}
footer {
    margin-top: 15px;
    position: relative !important;
}
}
@media (width:640px) {
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}

}
</style>
</head>
<!--***** -->
<body>
<!--start header -->
<div class="wrapper2">
<?php include '../../common/pages/header.php';
  ?>
  <!--end header -->
  <!--provider_wrapper header -->
  <div class="container provider_wrapper">
    <form method="post" action="">
      <div class="provider_form">
        <div class="col-lg-6 provider_form_leftsection">
          <h2><?php echo constantAppResource::$LOGIN_PORTAL_RESET_CREDENTIALS_ENTERTHEEMAIL;?></h2>
          <div class="provider_input">
            <label style="font-size:18px;"><?php echo constantAppResource::$DASHBOARD_TEXT_EMAIL;?></label>
            <input type="text" name="email" id="emailVal" placeholder="Your Email Address" />
          </div>
        </div>
        <div class="col-lg-1 provider_mid">
          <h3><?php echo constantAppResource::$DASHBOARD_TEXT_OR;?></h3>
        </div>
        <div class="col-lg-5 provider_form_rightsection">
          <h2><?php echo constantAppResource::$LOGIN_PORTAL_RESET_CREDENTIALS_ENTERYOURNAME_AND_DATEOFBRITH;?></h2>
          <div class="provider_input_right">
            <label class="col-lg-4" style="font-size:18px;"><?php echo constantAppResource::$DASHBOARD_TEXT_NAME;?></label>
            
            <input class="col-lg-3 first captial" type="text"  placeholder="First" name="first_name" id="first_name" />
            <input class="col-lg-1 second captial" type="text"  placeholder="M"  name="middle_initial" id="middle_initial" />
            <input class="col-lg-3 third captial" type="text"  placeholder="Last"  name="last_name" id="last_name" />
			

          </div>
          <div class="clear"></div>
          <div class="date_birth">
            <label class="col-lg-4" style="font-size:18px;"><?php echo constantAppResource::$LOGIN_PORTAL_RESET_CREDENTIALS_DATEOFBRITH;?></label>
            <input class="col-lg-3" type="text" id="dob" name="dob" palceholder="mm/dd/yyyy">
			
          </div>
          <div class="clear"></div>
          <div class="provider_button" style="margin-right:55px; width: 220px;">
			<?php
			
			if(isset($_POST['forgot_username']) == "FORGOT_USERNAME")
			{
				
			?>
				<input type="hidden"  name="reset" id="reset" value="FORGOT_USERNAME" >
	            <input type="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>" onClick="window.location.replace('logout.php');">
			<?php
			}
			else
			{
			?>
				<input type="hidden"  name="reset" id="reset" value="FORGOT_PASSWORD" >
	            <input type="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>" onClick="window.location.replace('logout.php');">
			<?php
			} setcookie('reset_username', null, -1, '/'); ?>
            <input type="submit"  class="submit"  value="<?php echo constantAppResource::$COMMON_BUTTON_SUBMIT;?>" id="reset_submit" name="submit">
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="push"></div>
</div>
<!--start footer -->
<div class="clear"></div>
<?php 
include 'popup/error_popup.php';
include 'popup/message_popup.php';

include '../../common/pages/footer.php'; ?>
<!--end footer -->
<script>
	$(function(){
	 $( "#dob" ).datepicker({
showOn: "button",
buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
buttonImageOnly: true,
buttonText: "Select date",
dateFormat: "mm/dd/yy",
maxDate: '0',
changeMonth: true,
changeYear: true,
yearRange: "-100:+0"
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
</body>
</html>

