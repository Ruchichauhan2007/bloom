<?php 
	include '../../common/pages/header.php';

    ?> 
<!--end header -->

<div class="login-widget">
<div class="widget-header">
	<h1 class="title">Password Recovery</h1>
    </div>
	<div class="widget-body">
	<p>Please check your email for instructions to reset your password.</p>
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



<div class="ajax-loading" style="position:absolute;display:none">
	<img style="height:65px" src="/gladstone/portal/bloom/common/images/ajax_loader.gif"/>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="wrapper2 modal fade in"></div>
<!--end footer -->
</body>
</html>
