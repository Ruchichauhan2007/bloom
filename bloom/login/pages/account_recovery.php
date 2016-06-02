<?php 	
	include '../../common/pages/header.php';
	include 'controller/portal_reset_credentials_controller.php'; 
	include 'popup/CientSiderror_popup.php';
	
    ?> 
<!--end header -->
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<div class="login-widget">
	<div class="widget-header">
	<h1 class="title">Account Recovery</h1>
		<form method="post">
	</div>
	<div class="widget-body">
		<p>Please enter the names and date of birth you used to create your Kannact account </p> <br>
		  <div class="group float-input">
			<input type="text" name="first_name" id="first_name" maxlength="50"><span class="highlight"></span><span class="bar"></span>
			<label><?php echo constantAppResource::$LOGIN_LABEL_FIRSTNAME;?></label>
		  </div>
		  <div class="group float-input">
			<input type="text" name="last_name" id="last_name" maxlength="50"><span class="highlight"></span><span class="bar"></span>
			<label><?php echo constantAppResource::$LOGIN_LABEL_LASTNAME;?></label>
		  </div>
                                 <div class="group float-input">
                                    <div class='input-group date' id='datetimepicker1'>
                                       <input type='text'   id="dob" name="dob"/><span class="highlight"></span><span class="bar"></span>
                                       <span class="input-group-addon" style="border-radius:0;background: #fff; border: 0px none; box-shadow: 0px 0px 0px;">
                                          <!-- <span class="glyphicon glyphicon-calendar"></span>-->
                                          <img class="picDate" src="/gladstone/portal/bloom/login/images/date-range.svg">
                                       </span>
									   			<label><?php echo constantAppResource::$LOGIN_LABEL_DATE_OF_BIRTH;?></label>
                                    </div>
                                 </div>	
	 <div class="group float-input" style="display:none;" id="errorMsgDivd">
		  <span id="errorMsg"> </span> <img  src="/gladstone/portal/bloom/app/assets/image/error-icon.png" alt="" />
		  </div>						
		  <div class="actions">
			<button type="submit" id="Login_submit" name="submit_recovery" class="button button-login" >SUBMIT
				<div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
			</button>
			<button type="reset" id="Reset_submit" name="next" class="" onclick="window.location.href='login_userName.php'" >CANCEL
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
?>

<script>
$(document).ready(function()
{
	$("#Login_submit").attr("disabled", "disabled");
});
$("#first_name,#last_name,#dob").on("keyup change blur", function(){
    if($("#first_name").val() != "" && $("#last_name").val() != "" && $("#dob").val() != "" ){
        $("#Login_submit").removeAttr("disabled");
    } else {
        $("#Login_submit").attr("disabled", "disabled");
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




    $('#datetimepicker1').datetimepicker(
   {
   pickTime: false,
   autoclose: true,
   maxDate: new Date()
   
   });
$('.input-group').find('.picDate').on('click', function(){
    $('#dob').trigger('focus');
});   
</script>


<div class="ajax-loading" style="position:absolute;display:none">
	<img style="height:65px" src="/gladstone/portal/bloom/common/images/ajax_loader.gif"/>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="wrapper2 modal fade in"></div>
<!--end footer -->
</body>
</html>
