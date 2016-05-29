<style>
.focus
{
border:1px solid #0492d4;
box-shadow:0 1px 2px 1px #ccc;
}
#error .close {
    height: 41px;
    margin-top: -10px;
}
</style>
<script>
$(document).ready(function()
{	$("#first_name").focus();
	$("#lightbox").hide();
	$("#fadediv").hide();
	$("#submit").click(function()
	{
		var fname = $("#first_name").val();
		var mname = $("#middle_name").val();
		var lname = $("#last_name").val();
		var dob = $("#dob").val();
		var username = $("#username").val();
		var password = $("#password").val();
		var retypepassword = $("#retypepassword").val();
		var email = $("#providerEmail").val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var credentials = $("#credentials").val();
		var providerPhone = $("#providerPhone").val();
		var gander = $("#gander").val();
		var speciality = $("#speciality").val();
		var providertype = $("#providertype").val();
		var assignrole = $("#assignrole").val();
		var page = $("#page").attr('name');
		var providerId = $("#providerId").val();
		if(fname == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("First Name ");
		$("#txt_div").text("Please enter the first name.");	
        $("#first_name").focus();
        $("#first_name").addClass('focus');		
		return false;
		
		}
		
		else if(lname == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Last Name ");
		$("#txt_div").text("Please enter the last name.");
		$("#last_name").focus();		
		$("#last_name").addClass('focus');
		return false;
		}
				
		else if(dob == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Date of Birth ");
		$("#txt_div").text("Please enter the date of birth.");
		$("#dob").focus();
		$("#dob").addClass('focus');
		return false;
		}
		else if(email=="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text(" Please enter the email.");
		$("#providerEmail").focus();
		$("#providerPhone").addClass('focus');
		return false;
		}
		/*else if(username == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Username ");
		$("#txt_div").text("Please enter username.");
		$("#username").focus();
		$("#username").addClass('focus');
		return false;
		}*/
		else if(password == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Please enter Password .");
		$("#password").focus();
		$("#password").addClass('focus');
		return false;
		}
		
		else if(password.length <= 7)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Password must be 8 characters long .");
		$("#password").focus();
		$("#password").addClass('focus');
		return false;
		}
		else if(retypepassword == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Retype Password ");
		$("#txt_div").text(" Please retype Password .");
		$("#password").focus();
		$("#password").addClass('focus');
		return false;
		}
		
		else if(password!= retypepassword)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Password not match.");
		$("#password").focus();
		$("#password").addClass('focus');
		return false;
		}
		
	/*	else if(providerPhone=="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone");
		$("#txt_div").text(" Please enter phone.");
		$("#providerPhone").focus();
		$("#providerPhone").addClass('focus');
		return false;
		}
		*/
		
		
		else if (!filter.test(email) && email !="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please enter proper email address.");
		$("#providerEmail").focus();
		$("#providerEmail").addClass('focus');
		return false;
		}
		
		else if(gander=="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Gender");
		$("#txt_div").text(" Please select  a gender.");
		$("#gander").focus();
		$("#gander").addClass('focus');
		return false;
		}
		
	
		else if(credentials == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Credentials ");
		$("#txt_div").text("Please enter the credentials.");
		$("#credentials").focus();
		$("#credentials").addClass('focus');
		return false;
		}
		else if(speciality== "")
		{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Speciality ");
			$("#txt_div").text("Please enter a speciality.");
			return false;     
		}
		else if(providertype== "")
		{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Provider Type ");
			$("#txt_div").text("Please select a Provider type.");
			return false;     
		}
/*		 if($(speciality== "")
		{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("speciality ");
			$("#txt_div").text("Please select a speciality.");
			return false;     
		}

	/*	else if(assignrole == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Assignrole ");
		$("#txt_div").text("Please enter the assignrole.");
		$("#assignrole").focus();
		$("#assignrole").addClass('focus');
		return false;
		}
		*/
		else
		{
		$("#username").val(email);
		localStorage["first_name"] = fname;
		localStorage["middle_name"] = mname;
		localStorage["last_name"] = lname;
		localStorage["dob"] = dob;
		localStorage["gander"] = gander;
		localStorage["email"] = email;
		localStorage["providerPhone"] = providerPhone;
		localStorage["username"] = username;
		localStorage["password"] = password;
		localStorage["credentials"] = credentials;
		localStorage["speciality"] = speciality;
		localStorage["providertype"] = providertype;
		localStorage["assignrole"] = assignrole;
		localStorage["page"] = page;
		localStorage["providerId"] = providerId;
		
		return true;
		}
	
	});
	
	
	
	

});
</script>

    <script type="text/javascript">
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);  
			document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;

        }
    </script>
  
	<div id="lightbox" class="white_content" style="display:none;"><p class="cart1"><span  id="cart_page"></span><a id="error" href = "javascript:void(0)" onclick ="document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none';"><img src="../images/close.jpg" align="right" class="close"></a></p>
	<div class="alert"><img src="../images/alert.jpg" align="left">   <div id="txt_div"></div>
    <br>
    <a href = "javascript:void(0)" onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a></div>
	</div>
	<div id="fadediv" class="black_overlay"  onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"></div>
 

<style>
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
.cart1 {
background: linear-gradient(to bottom, #f7f7f7 0%, #f5f5f7 6%, #e4e3e8 32%, #e4e3e9 35%, #bab9c7 100%) repeat scroll 0 0 rgba(0, 0, 0, 0);
height: 40px;
margin: 0;
padding: 10px 0 0 10px;
}

.alert {
margin: 20px;
line-height: 30px;
font-size: 18px;
color: #000;
}

.alert a {
background-color: #99cc00;
text-decoration: none;
color: #fff;
padding: 5px 25px;
float: right;
margin-bottom: 20px;
box-shadow: 0px 2px 6px #999;
}
</style>