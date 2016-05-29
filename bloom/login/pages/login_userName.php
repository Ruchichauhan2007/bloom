<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/auth-helper.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/ajax-default.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/angular.min.js"></script>
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
include 'controller/login_userName_controller.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
	<h1 class="title">Log in to Kannact</h1>
		<form method="post" action="" name="loginForm" >
	</div>
	<div class="widget-body">
		  <div class="group float-input">
			<input type="email" name="userName" id="userName" maxlength="50" ng-model="userName" ><span class="highlight"></span><span class="bar"></span>
			<label><?php echo constantAppResource::$LOGIN_LABEL_EMAILADDRESS;?><span style="color:red;">*</span></label>
		  </div>
		  <div class="group float-input">
			<input type="password" name="password" id="password"><span class="highlight"></span><span class="bar"></span>
			<label>Password</label>
		  </div>
		  <div class="group float-input errorMsgDiv"style="display:none" id="errorMsgDivd">
		  <span id="errorMsg"> </span> <img src="/gladstone/portal/bloom/app/assets/image/error-icon.png" alt="" />
		  </div>
		  <div class="actions">
			<a href="reset_credential.php?page=forgot_password.php" class="pull-left"><?php echo constantAppResource::$LOGIN_BUTTON_FORGOT_PASSWORD;?></a><br>
			<a href="reset_credential.php?page=account_recovery.php" class="pull-left"><?php echo constantAppResource::$LOGIN_BOTTON_FORGOT_USER_NAME;?></a>
			<button type="button" id="Login_submit" name="next" class="button button-login" click="doLogin(login)" ng-disabled="loginForm.$invalid" >LOG IN
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
//include 'popup/error_popup.php';

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
});
$(document).ready(function()
{
	$("#Login_submit").attr("disabled", "disabled");
});
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
$("input[type='email'],input[type='password'] ").on("keyup change blur", function(){
    if($("#userName").val() != "" && $("#password").val() != "" && isEmail($("#userName").val())){
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

<script>
$(document).ready(function()
{
		$("#Login_submit").click(function()
		{
		//	var token = createAuthToken(token);
			createAuthToken(function(token) {
				var password = $("#password").val();
				setCookie("password", password)
				login(token);
			});
			
		});
		
		
function login(token) {
				var username = $("#userName").val();
				var password = $("#password").val();
	$.ajax({
		type: 'PUT',
		beforeSend: function (request) {
			request.setRequestHeader("Authorization", token);
		},
		url: window.location.origin + "/gladstone/rest/admin/login/entity",
		success: function (data) {
			if(data.success)
			{
				var userNameField = data.entityInfo.firstName+" "+data.entityInfo.lastName;
				var requestScheme = "https://";
				if (window.location.protocol != "https:")
				{
					 requestScheme = "http://";
				}
					setCookie("password", password)
					console.log(window.location.protocol);
					if(data.entityInfo.status == "AV")
					{
					window.location.href = requestScheme+data.institutionURL+"/gladstone/portal/bloom/login/pages/setlogin_password.php?id="+data.entityInfo.entityId+"&type="+data.entityInfo.entityType+"&user="+username+"&userName="+userNameField;
					
					}
					else{
						alert("status is unavailable");
						hideLoading();
					}
			}
			else{
				hideLoading();
				
				if(data.errorMessage == "PASSWORD_CHANGE_REQUIRED")
				{
					setCookie("user", username);
					setCookie("status", "AV");
					window.location.href = window.location.origin+"/gladstone/portal/bloom/login/pages/login_newPassword.php";
				}
				else{
					alert(data.errorMessage);
				}
			}
		},
		error: function (data) {
			alert(data);
		}

	});
}

function setCookie(cname, cvalue) {
	var expires = ("path=/");
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
		
	
});

</script>
<div class="ajax-loading" style="position:absolute;display:none">
	<img style="height:65px" src="/gladstone/portal/bloom/common/images/ajax_loader.gif"/>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="wrapper2 modal fade in"></div>
<!--end footer -->
</body>
</html>
