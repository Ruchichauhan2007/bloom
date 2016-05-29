<?php
include 'controller/login_userName_controller.php';
$requestScheme = "http://";
if(!empty($_SERVER['HTTPS']))
{
	$requestScheme = "https://";
}
?>
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
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../script/css/Responcive.css" rel="stylesheet" type="text/css">
<!--***** -->
<style>
html{ height:100%;}
body{ height:100%;}
@media (max-width:320px) {
.login_logo_right_img > img {
    margin-bottom: 24px !important;
}
}
@media (min-width:320px) and (max-width:415px) {
footer {
    position: fixed !important;
    bottom: 0px;
    display: block;
}
}
@media (min-width:638px) and (max-width:642px) {
footer {
    position: fixed !important;
    bottom: 0px;
    display: block;
}
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}
}
@media (max-width:480px) {
body {
    background-size: 100% 100% !important;
    height: 100% !important;
}
}
</style>
	<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></script>

<script>
localStorage.clear();
</script>
</head>

<body>
	<div class="wrapper2">
		<!--start header -->
<?php
include '../../common/pages/header.php';
unset($_COOKIE["employer"]);
?>
<!--end header -->

		<!--start wapper -->

		<div class="container">
			<div class="login_mid_section">
				<div class="col-lg-12 login_leftpart_form">
					
						 <label>Your registration is in progress please check back later. <a href="<?php echo $requestScheme.$_SERVER['HTTP_HOST']."/gladstone/portal/bloom/login/pages/login_userName.php"; ?>"> Click here for login.</a></label>
			</div>
		</div>
		</div>
		<div class="clr"></div>
		<div class="push"></div>
	</div>
	<!--end wapper -->

	<!--start footer -->
<?php
include '../../common/pages/footer.php'; 
?>

<!--end footer -->
</body>
</html>
