<?php
	include 'controller/login_newPassword_controller.php'; 
?>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/auth-helper.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/ajax-default.js"></script>
<?php
/*foreach ($_COOKIE as $c_id => $c_value)
{
	unset($_COOKIE[$c_id]);
	setcookie($c_id, null, -1, '/');
}
*/
if(!$_COOKIE['status'])
{
	setcookie("status","UN",0,'/', '', false, false);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700' rel='stylesheet' type='text/css'>
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- Set the viewport width to device width for mobile -->
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>
<!--Including css files used in all the html pages -->
<link href="../script/css/login.css" rel="stylesheet" type="text/css">
<link href="../script/css/login-css.css" rel="stylesheet" type="text/css">
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../script/css/Responcive.css" rel="stylesheet" type="text/css">
<!--***** -->
<style>
body{
	background-image:none;
}
</style>
</head>
<body>
		<!--start header -->
<?php
include '../../common/pages/header.php';
?>
<!--end header -->
<div class="login-widget">
	<div class="widget-header">
	<h1 class="title">Reset Password</h1>
		<form method="post" action="" >
	</div>
	<div class="widget-body">
			<p>Please enter and confirm a new password for  your Kannact account </p> <br>
		  <div class="group float-input">
			<input type="password" name="newPassword" id="newPassword"><span class="highlight"></span><span class="bar"></span>
			<label><?php echo constantAppResource::$LOGIN_LABEL_PASSWORD;?><span style="color:red;">*</span></label>
		  </div>
		  <div class="group float-input">
			<input type="password" name="confirmPassword" id="confirmPassword"><span class="highlight"></span><span class="bar"></span>
			<label>Confirm password</label>
		  </div>
		  <div class="errorMsgDiv"style="display:none;">
		  <span id="errorMsg"> </span> <img src="/gladstone/portal/bloom/app/assets/image/error-icon.png" alt="" />
		  </div>
		  <div class="actions">
			<button type="submit" id="submit" name="submit" class="button button-login" >SUBMIT
				<div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
			</button>
		  </div>
		</form>
	</div>
</div>
<div class="login-widget">
	<div class="widget-body">
	<p>If you need help, please contact us: </p>
		  <div class="actions">
			<a href="#" class="pull-left"><?php echo constantAppResource::$LOGIN_LABEL_WEBMAIL;?></a><br>
			<a href="#" class="pull-left"><?php echo constantAppResource::$LOGIN_LABEL_NUMBER;?></a>
		  </div>
		</form>
	</div>
</div>
		<!--start wapper -->

		<div class="container">
			<div class="login_mid_section">
				<div class="col-lg-8 login_leftpart_form">
				
				</div>

				<aside class="col-lg-4 login_logo_right_img">
					<img
						src="../images/<?php echo constantAppResource::$LOGIN_IMAGE_BLOOM;?>"
						alt="">
				</aside>
			</div>
		</div>
		<div class="clr"></div>
		<div class="push"></div>
	<!--end wapper -->

	<!--start footer -->
<?php
include 'popup/error_popup_login.php';
include 'popup/message_popup_login.php';
?>

<script>
$(document).ready(function()
{
	$("#submit").attr("disabled", "disabled");
});
$("#newPassword,#confirmPassword").on("keyup change blur", function(){
    if($("#newPassword").val() != "" && $("#confirmPassword").val() != "" )
	{
        $("#submit").removeAttr("disabled");
    } else {
        $("#submit").attr("disabled", "disabled");
    }
	
});
$("#submit").click(function(){
    if($("#newPassword").val() != $("#confirmPassword").val() )
	{
        $("#errorMsg").text("PASSWORD_MATCH_FAIL");
		$(".errorMsgDiv").show();
    } 
	
});
$(window, document, undefined).ready(function() {

  $('input').blur(function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  var $ripples = $('.ripples');

  $ripples.on('click.Ripples', function(e) {

    var $this = $(this);
    var $offset = $this.parent().offset();
    var $circle = $this.find('.ripplesCircle');

    var x = e.pageX - $offset.left;
    var y = e.pageY - $offset.top;

    $circle.css({
      top: y + 'px',
      left: x + 'px'
    });

    $this.addClass('is-active');

  });

  $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
  	$(this).removeClass('is-active');
  });

});
</script>



<!--end footer -->
</body>
</html>
