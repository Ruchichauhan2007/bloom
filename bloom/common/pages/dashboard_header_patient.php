<?PHP include '../util/VMCAppResource.php'; ?>
<?PHP include 'controller/portal_dashboard_controller.php';
$type = strtoupper($_COOKIE['type']);
if($_COOKIE['type'] == "Patient" or $_COOKIE['type'] == "PATIENT") $hideFilter = TRUE;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../common/script/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="../../common/script/css/bloom.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"/>
<link href="../../common/script/css/Dashboard-Responcive.css" rel="stylesheet" type="text/css">
<!-- Optional: Include the jQuery library -->
<!--<script src="../../common/script/js/query.min_1.7.1.js"></script>-->
<script type="text/javascript">

if(typeof jQuery == 'undefined'){
        document.write('<script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></'+'script>');
  }

</script>
<script src="../../common/script/js/bootstrap.min.js"></script>
<script src="../../common/script/js/jquery-ui.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/jquery.cookie.js"></script>
<script src="../../common/script/js/ajax-default.js"></script>
<!-- Added JS libraries for JS PDF -->
<!--<script src="../../common/script/js/jquery-ui-1.8.17.custom.min.js"></script>-->
<script src="../../common/script/js/jspdf.debug.js"></script>


<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title>Gladstone</title>
<!--Including css files used in all the html pages -->

<!--***** -->
<script type="text/javascript">
   var onchangeCardOption = function() {
 var cardValue=$("#cards").val();
  $.ajax({
        url: 'get_cardByTypes.php',
        type: 'POST',
        data: {cardtype : cardValue},
        success: function(html) {
   document.getElementById("patientreview").innerHTML = html;
        }
    });
}
$(function(){
calculateHeight();
	$('#dashboard-logo').click(function(){
	 if ($("#menu-content").attr('class') =='col-md-12')
		$("#menu-content").attr('class','col-md-8');

	$('#portal-menu').slideToggle("slow",function(){
			 if ($('#portal-menu').is(':hidden'))
			{
				$("#menu-content").attr('class','col-md-12');
			}
		});
	});

	// calculate middle portion height
	$( window ).resize(function() {
		calculateHeight();
	});

	$('div.menu-down-btn').click(function(){
		$('div.login-nav-container').animate({scrollTop: ($('div.login-nav-container').scrollTop() + 50) + 'px'}, 100);
	});
	$('div.menu-up-btn').click(function(){
		$('div.login-nav-container').animate({scrollTop: ($('div.login-nav-container').scrollTop() - 50) + 'px'}, 100);
	});
});

function calculateHeight()
{
	var  height = window.innerHeight - $('footer').height() - $('header').height();
	var width = window.innerWidth;
	$('#wrap-container,#menu-content').css('height',height);
	$('#menu-content').css('height',height);
	$('#menu-content-aj').css('height',height);
	//navigation control
	$('#portal-menu').css('height',height);
	$('div.login-nav-container').css('height',height-35);
	// this div has scroll bar
	var upBtn = $('div.menu-up-btn');
	var downBtn = $('div.menu-down-btn');
	if($('div.login-nav-container').hasScrollBar())
	{
		console.log('has scroll bar');
		// add div up and down buttons
		$(upBtn).show();
		$(downBtn).show();
	}
	else
	{
		$(upBtn).hide();
		$(downBtn).hide();
	}
	$('.ajax-loading').css({'top':height/2,'left':width/2});
}
// check if there is a scroll bar on div
(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);
</script>

<style>
h5.time_date.VITALS_MISSED {
padding-top: 25px;
}
.header-select {
    background: transparent none repeat scroll 0 0;
    border: 0 none;
    color: #fff;
    font-size: 22px;
}
.logo > img {
    padding: 9px 0;
    width: 44px;
}
#patImage > img {
    padding-left: 9px;
}
<?php
	$entityUtil = new EntityUtil();
	$entityType = $entityUtil->getEntityTypeFromContext();
?>
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<!--start header -->
<div  id="wrap">
<!-- Fixed navbar -->
<header class="top-header">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="../../common/images/logo.png" alt="" /></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul id="headerMenu" class="nav navbar-nav">
			<li class="active" onClick="filterMenu(this)" ><a href="">Activity</a></li>            
			<li id="menu-content-container" onClick="filterMenu(this);" class="<?php echo constantAppResource::$COMMON_MENU_TEXT_TRACK_BIOMETRICES;?>"><a href="#" onClick="openPageWithAjax('../../vitals/pages/setPath.php','','menu-content','',this)" id="headerBiomatric"><img  alt="" title="Track Biometrics">Biometrics</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
			<li  onClick="filterMenu(this),openPageWithAjax('../../dashboard/pages/portal_addPatient.php','','menu-content',event,this)"><a href="#">Profile</a></li>
			<li  onClick="filterMenu(this),openPageWithAjax('../../login/pages/login_support.php','','menu-content',event,this)"><a href="#">Support</a></li>
            <li class=""><a href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/pages/logout.php">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<input type="hidden" id="moveNext"  />
<input type="hidden" id="deviceConfigID"  />
<input type="hidden" id="nextButton"  />
<input type="hidden" id="prevButton"  />
<input type="hidden" id="userType" value="<?php echo $_COOKIE['type']; ?>" />
<input type="hidden" id="currentUserId" />
<input type="hidden" id="currentUserName" />
<input type="hidden" id="contextPatientName"/>
<input type="hidden" id="contextPatientImage"/>
<input type="hidden" id="contextPatientId"/>
<input type="hidden" id="getScroll"/>
<input type="hidden" id="headerDeviceId"  />
<input type="hidden" id="currentProvId"  value="<?php echo $_COOKIE['id']; ?>" />
<input type="hidden" id="currentProvName" value="<?php echo $_COOKIE['userName']; ?>"  />



<script src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script>
var userId = <?php echo $_COOKIE['id'] ?>;
$("#currentUserId").val(userId);

var userName = "<?php echo $_COOKIE['userName'] ?>";
userName = userName.replace('+', ' ');
$("#currentUserName").val(userName);

$(document).ready(function() {
            var visitortime = new Date();
            var visitortimezone = (moment().zone() * 60 * 1000);
            $.ajax({
                type: "GET",
                url: "/gladstone/portal/bloom/common/util/TimeZoneUtil.php",
                data: 'timezoneOffset='+ visitortimezone,
                success: function(){
                }
            });
    });
</script>
<script type="text/javascript">
$(document).ready(function()
{
 var bodyWidth = window.innerWidth;
 if(bodyWidth <=991)
 {
 $('#portal-menu').slideUp("100",function(){
 if ($('#portal-menu').is(':hidden'))
 {
 $("#menu-content").attr('class','col-md-12');
 }
 });
 }
});
function headerBiomatric(event)
 {
 	var devId = $("#headerDeviceId").val();
	var headerBiomatric = $("#headerBiomatric");
	openPageWithAjax('../../vitals/pages/vitals_graphBG.php','deviceConfigId='+devId+'&vitalType=Blood-Glucose','menu-content',event,headerBiomatric);
 }
</script>
</header>
<!--end header -->
<!-- Main container -->
<div class="container-fluid" id="wrap-container">