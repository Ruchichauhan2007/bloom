<?PHP include '../util/VMCAppResource.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title><?php echo constantAppResource::$LOGIN_TITLE_GLADSTONE;?></title>

<!--Including css files used in all the html pages -->
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>

 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
 
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


<script>
$(document).ready(function() {
var width=$(document).innerWidth();
var height=$(document).innerHeight();
$('.ajax-loading').css({'top':height/2,'left':width/2});
/*
var d = new Date();
var n = d.getFullYear();
document.getElementById("copyRight").innerHTML ='<?php echo constantAppResource::$LOGIN_FOOTER_TEXT_COPYRIGHT;?> '+n;*/
});
</script>
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<!--***** -->

<body>
<!--start header -->
<header class="top-header">
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="navbar-header">
          <a class="navbar-brand" href="#"><img src="../../common/images/logo.png" alt="" /></a>
		  <ul class="nav navbar-nav navbar-right">
            <li class="hidden-xs">1-855-722-5513</li>
			<li class="hidden-xs">SUPPORT@KANNACT.COM</li>
			<li><?php //echo constantAppResource::$LOGIN_TEXT_VERSION ."".getVersion();?></li>
          </ul>
        </div>
	</nav>
</header>
<?php
$path = $_SERVER['SERVER_NAME']."/gladstone";
$username= $_COOKIE['user'];
$password= $_COOKIE['password'];
?>
<!--end header -->
</body>
</html>
