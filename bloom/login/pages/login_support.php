<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/script/css/login.css" rel="stylesheet" type="text/css">
<div class="col-md-8 padd-top20">
    <div class="login-widget-support">
	<div class="widget-header support-widget">
	<h1 class="title">1-855-722-5513</h1>
    <h5>Telephone - Available weekdays from 9:00 AM to 5:PM PST</h5> 		
	</div>
    <div class="widget-header support-widget">
	<h1 class="title">Support@kannact.com</h1>
	<h5>Email - Receive a response within 72 hours</h5> 
	</div>
    <div class="widget-header support-widget">
	<h1 class="title">Create a support request</h1>
	<h5>Receive a response within 72 hours</h5> 	
	
    <form method="post">
	<div class="widget-body">
		
		  <div class="group float-input name-group">
			<input type="text" name="fullName" id="fullName" maxlength="50"><span class="highlight"></span><span class="bar"></span>
			<label>Full Name</label>
            
		  </div>
          
          <div class="group float-input email-group">
          <input type="text" name="emailId" id="emailId" maxlength="50"><span class="highlight"></span><span class="bar"></span>
			<label>Email Address</label>
            </div>
          
          
            <div class="group float-input help-group">                                    
               <input type="text" name="message" id="message" maxlength="50"><span class="highlight"></span><span class="bar"></span>
                <label>How can we help you?</label>
            </div>      
           <div class="group float-input" style="display:none;" id="errorMsgDivd">
              <span id="errorMsg"> </span> <img  src="/gladstone/portal/bloom/app/assets/image/error-icon.png" alt="" />
           </div>						
		   <div class="actions">
           <div class="submit-btn">
			<button type="submit" id="supportSubmit" name="supportSubmit" class="button button-login btn-purple" >SUBMIT SUPPORT REQUEST
				<div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
			</button>
            </div>
            
		  </div>
        </div>	
		</form>
        </div>
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
        </div>
         <div class="col-md-4 padd-top50">
			<div class="sidebar-filter">
            </div>
            </div>
	<!--end wapper -->

	<!--start footer -->
<?php
//include 'popup/error_popup_login.php';
//include 'popup/message_popup_login.php';
?>

<script>
$(document).ready(function()
{
	$("#supportSubmit").attr("disabled", "disabled");
});
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,3})+$/;
  return regex.test(email);
}
$("#emailId,#fullName,#message").on("keyup change blur", function(){
    if($("#fullName").val() != "" && $("#emailId").val() != "" && $("#message").val() != "" && isEmail($("#emailId").val()){
        $("#supportSubmit").removeAttr("disabled");
    } else {
        $("#supportSubmit").attr("disabled", "disabled");
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


<div class="ajax-loading" style="position:absolute;display:none">
	<img style="height:65px" src="/gladstone/portal/bloom/common/images/ajax_loader.gif"/>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="wrapper2 modal fade in"></div>
<!--end footer -->
</body>
</html>
