<script>
$(document).ready(function()
{	$("#first_name").focus();
	$("#lightbox").hide();
	$("#fadediv").hide();
	$("#submit").click(function()
	{	
		$("#self_registration input").removeClass("focus");
	
		var fname = $("#firstName").val();
		var middle = $("#middle").val();
		var lname = $("#lastName").val();
		var dob = $("#dob").val();
		var email = $("#email").val().trim();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var phone = $("#phone").val();
		var username = $("#username").val().trim();
		var password = $("#password").val();
		var confirmPassword = $("#confirmPassword").val();
		var employer = $("#employer").val();
		var employerName = $("#employerName").val();
		var  captchaResponse= $("#captchaResponse").val();
		
		if(fname == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("First Name ");
		$("#txt_div").text("Please enter the first name.");	
        $("#firstName").addClass('focus');		
		return false;
		
		}
		
		else if(lname == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Last Name ");
		$("#txt_div").text("Please enter the last name.");
		$("#lastName").addClass('focus');
		return false;
		}
				
		else if(dob == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Date of Birth ");
		$("#txt_div").text("Please enter the date of birth.");
		$("#dob").addClass('focus');
		return false;
		}
		
		
		
		else if (email =="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please enter email address.");
		$("#email").addClass('focus');
		return false;
		}
		
		
		
		
		else if (!filter.test(email) && email !="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please enter proper email address.");
		$("#email").addClass('focus');
		return false;
		}
		
		
		else if(phone == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone ");
		$("#txt_div").text("Please enter phone number.");
		$("#phone").addClass('focus');
		return false;
		}
		
		
		// else if(username == "")
		// {
		// $("#lightbox").show();
		// $("#fadediv").show();
		// $("#cart_page").text("Username ");
		// $("#txt_div").text("Please enter username.");
		// $("#username").addClass('focus');
		// return false;
		// }
		
		
		else if(password == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Please enter Password .");
		$("#password").addClass('focus');
		return false;
		}
		else if(password.length <= 7)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Password must be 8 characters long .");
		$("#password").addClass('focus');
		return false;
		}
		
		else if(confirmPassword == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Confirm Password ");
		$("#txt_div").text(" Please re-enter Password .");
		$("#confirmPassword").addClass('focus');
		return false;
		}
		else if(password != confirmPassword)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text("Password not matched .");
		return false;
		}
		
		else if(captchaResponse != 1)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Captcha");
		$("#txt_div").text("Wrong captcha code!");	
        $("#captcha").addClass('focus');
		$(".imgcaptcha").attr("src","captcha.php?_="+((new Date()).getTime()));
		var str = document.getElementById("captcha").value;
		showResult(str);	
		return false;
		}
		
		else
		{
		$("#username").val(email);
		localStorage["firstName"] = fname;
		localStorage["lastName"] = lname;
		localStorage["dob"] = dob;
		localStorage["email"] = email;
		localStorage["phone"] = phone;
		localStorage["username"] = email;
		localStorage["password"] = password;
		localStorage["middle"] = middle;
		localStorage["employerName"] = employerName;
		localStorage["employer"] = employer;
		return true;
		}
	
	});
	
	$("#okay").click(function()
	{
	if( $("#self_registration input").hasClass('focus'))
	{
	$(".focus").focus();
	}
	});
});


</script>
	<div id="lightbox" class="white_content" style="display:none;"><p class="cart1"><span  id="cart_page"></span><a id="error" href = "javascript:void(0)" onclick ="document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none';"><img src="../images/close.jpg" align="right" class="close"></a></p>
	<div class="alert"><img src="../images/alert.jpg" align="left">   <div id="txt_div"></div>
    <br>
    <a href = "javascript:void(0)" id="okay" onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a></div>
	</div>
	<div id="fadediv" class="black_overlay"  onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"></div>
 

<style>
.focus
{
border:1px solid #0492d4;
box-shadow:0 1px 2px 1px #ccc;
}

.cart1 {
padding: 2px 0 0 10px;
background: linear-gradient(to bottom, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f9', endColorstr='#b9b8c6',GradientType=0 );
height: 37px;
}
.alert {
margin: 29px 0px 10px 5px;
line-height: 22px;
font-size: 18px;
}
.alert a {
background-color: #99cc00;
text-decoration: none;
color: #fff;
padding: 5px 25px;
float: right;
margin-bottom: 20px;
box-shadow: 0px 2px 6px #999;
margin: 10px 10px 5px 0px;
}

.black_overlay {
display:block;
position: absolute !important;
top: 0%!important;
left: 0%!important;
width: 100%!important;
background-color:#e8e8e8!important;
opacity: 0.5;
height:100%;
z-index: 1000!important;
}
.white_content {
position: absolute !important;
top: 37%!important;
left: 25%!important;
width: 410px !important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002!important;
overflow: auto!important;
height:240px;
}
</style>