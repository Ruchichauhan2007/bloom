<?php 
	include '../../common/pages/header.php';
	include 'controller/portal_reset_credentials_controller.php'; 
	include 'popup/CientSiderror_popup.php';
    ?> 
<!--end header -->

<div class="login-widget">
	<div class="widget-header">
	<h1 class="title">Password Recovery</h1>
		<form method="post" autocomplete="off">
	</div>
	<div class="widget-body">
	<p>Please enter the email address you used to create your Kannact account </p> <br>
		  <div class="group float-input">
			<input type="email" name="email" id="email" maxlength="50"><span class="highlight"></span><span class="bar"></span>
			<label><?php echo constantAppResource::$LOGIN_LABEL_EMAILADDRESS;?><span style="color:red;">*</span></label>
		  </div>
		  
		  <div class="group float-input" style="display:none;" id="errorMsgDivd">
		  <span id="errorMsg"> </span> <img  src="/gladstone/portal/bloom/app/assets/image/error-icon.png" alt="" />
		  </div>
		  <div class="actions">
			<button type="submit" id="Login_submit" name="forgotSubmit" class="button button-login" >SUBMIT
				<div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>	
			</button>
			<button type="reset" id="reset_submit" name="reset" class="" onclick="window.location.href='login_userName.php'">CANCEL
				<div class=" buttonRipples"><span class="ripplesCircle"></span></div>	
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
/*include '../../common/pages/footer.php'; */
?>

<script>
$(document).ready(function()
{
var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
if(isChrome)
{
$("#dowanloadBrowser").hide();

}
$("#userName").focus();
	$("#okay").click(function()
	{
	$("#userName").focus();
	});
});
$(document).ready(function()
{
	$("#Login_submit").attr("disabled", "disabled");
});
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,3})+$/;
  return regex.test(email);
}
$("#email").on("click keyup change focusout mouseout", function(){
    if($("#email").val() != ""  && isEmail($("#email").val())){
        $("#Login_submit").removeAttr("disabled");
    } else {
        $("#Login_submit").attr("disabled", "disabled");
    }
});
</script>
<script>
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
<div class="ajax-loading" style="position:absolute;display:none">
	<img style="height:65px" src="/gladstone/portal/bloom/common/images/ajax_loader.gif"/>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="wrapper2 modal fade in"></div>
<!--end footer -->
</body>
</html>
