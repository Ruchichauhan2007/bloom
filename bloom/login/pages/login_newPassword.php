<?php
	include 'controller/login_newPassword_controller.php';
	include '../../common/pages/header.php'; 
?>
<div class="login-widget">
	<div class="widget-header">
	<h1 class="title">Reset Password</h1>
		<form method="post" action="" >
	</div>
	<div class="widget-body">
			<p>Please enter and confirm a new password for  your Kannact account </p> <br>
		  <div class="group float-input">
			<input type="password" name="newPassword" id="newPassword"><span class="highlight"></span><span class="bar"></span>
			<label><?php echo constantAppResource::$LOGIN_LABEL_PASSWORD;?></label>
		  </div>
		  <div class="group float-input">
			<input type="password" name="confirmPassword" id="confirmPassword"><span class="highlight"></span><span class="bar"></span>
			<label>Confirm password</label>
		  </div>
		   <div class="group float-input" style="display:none;" id="errorMsgDivd">
		  <span id="errorMsg"> </span> <img  src="/gladstone/portal/bloom/app/assets/image/error-icon.png" alt="" />
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
//include 'popup/error_popup_login.php';
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
		return false;
    }
	else{
	return true;
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
