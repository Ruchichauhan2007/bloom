<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></script>

<script>
$(document).ready(function()
{
	$("#lightbox").hide();
	$("#fadediv").hide();
	$("#Login_submit").click(function()
	{
		var userValue=$("#userName").val();
		if(userValue == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Username");
		$("#txt_div").text("Username field is required");
		return false;
		}
		else
		{
		return true;
		}
	});
	
	
	$("#password_submit").click(function()
	{
		var passwordValue=$("#passwordVal").val();

		if(passwordValue == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password");
		$("#txt_div").text("Password field is required");
		return false;
		}
		else
		{
		return true;
		}
	});


	
	$("#submitNewpassword").click(function()
	{
		var passwordlength=$("#newPassword").val().length;
		var password=$("#newPassword").val();
		if(password == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("New password ");
		$("#txt_div").text("There is a problem with old password");
		return false;
		}
		else if(passwordlength < 8)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password Error");
		$("#txt_div").text("Password too short, must be at least 8 characters");
		return false;
		}        
		else
		{
		return true;
		}
	});
	
	
	$("#error").click(function()
	{
		
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Error");
		$("#txt_div").text("Please contact your administrator to reset your password");
		return false;
		
	});

});
</script>
  
	<div id="lightbox" class="white_content lightClassBox" style="display:none;" ><p class="cart"><b><span  id="cart_page"></span></b><a href = "javascript:void(0)" onclick ="document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none';"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/images/close.jpg" align="right" class="close"></a></p>
	<div class="alert"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/images/alert.jpg" align="left">   <div id="txt_div"></div>
    <br>
    <a href = "javascript:void(0)" id="okay" onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a></div>
	</div>
	<div id="fadediv" class="black_overlay"  onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"></div>
 

<style>
.black_overlay {
position: absolute !important;
top: 0%!important;
left: 0%!important;
width: 100%!important;
background-color:#e8e8e8!important;
opacity: 0.5;
height:100%;
z-index: 1001!important;
}
.white_content {
/*position: absolute !important;
top: 260px !important;
left: 36.5% !important;
width: 410px !important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002!important;
overflow: auto!important;*/
height:220px;
}

@media (max-width:767px) {
.white_content.lightClassBox{
    left: 20px !important;
    top: 72px !important;
    width: 280px !important;
}
}
</style>