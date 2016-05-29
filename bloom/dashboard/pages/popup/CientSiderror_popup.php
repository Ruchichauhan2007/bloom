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
</style>
<script>
$(document).ready(function()
{	$("#firstName").focus();
	$("#lightbox").hide();
	$("#fadediv").hide();
	$("#btnSave").click(function()
	{
	$("add-profile-form input,select").removeClass("focus");
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var regularExpression = /^(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{0,16}$/;
		var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
		var now = new Date();
		//var today = (now.getMonth() + 1) + '/' + now.getDate() + '/' +  now.getFullYear();
		var dd = now.getDate();
		var mm = now.getMonth()+1; //January is 0!
	
		var yyyy = now.getFullYear();
		if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 
		var today = mm+'/'+dd+'/'+yyyy;
		today = today.split("/");
		todayDate = parseInt(today[2]+today[0]+today[1]);
		var fname = $("#firstName").val();
		var mname = $("#initName").val();
		var lname = $("#lastName").val();
		var prefName = $("#prefName").val();
		var dob = $("#dob").val();
		DOB = dob.split("/");
		dateOfBirth = parseInt(DOB[2]+DOB[0]+DOB[1]);
		var gander_male = $('input[name="gender"]:checked').val();
		var preferredContactType = $('input[name="preferredContactType"]:checked').val();
		var phonePrimary = $('input[name="phone[0][phonePrimary]"]:checked').val();	
		var phoneCPrimary = $('input[name="phone[1][phonePrimary]"]:checked').val();	
		var phoneWPrimary = $('input[name="phone[2][phonePrimary]"]:checked').val();	
		var gander_female = $("#radios-1").val();
		var username = $("#username").val();
		var password = $("#password").val();
		var status = $("#isActive").val();
		
		var isActive = $("#isActive").val();
		var programType = $("#programType").val();
		var timeZone = $("#timeZone").val();
		
		var primaryProvider = $("#primaryProv").val();
		var secondaryProvider = $("#secondaryProv").val();
		var territoryProvider = $("#tertiaryProv").val();
		var page = $("#page").attr('name');
		var patientId = $("#patientId").val();
		var editType = $("#editType").val();
		var userType = "<?php echo strtoupper($_COOKIE['type'])?>"; 
		
		var Daddress1=$("#addressLine").val();
		var Daddress2=$("#addressLine2").val();
		var Dcity=$("#city").val();
		var Dzip=$("#zip").val();
		var Dstate=$("#state").val();
		var Dphone=$("#hPhone").val();
		var Cphone=$("#cPhone").val();
		var Wphone=$("#wPhone").val();
		var Demail=$("#email").val().trim();
		var sEmail=$("#sEmail").val().trim();

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
		
		/*else if(prefName == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Preferred Name ");
		$("#txt_div").text("Please enter the preferred name.");
		$("#prefName").addClass('focus');
		return false;
		}*/
		else if(dob == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Date of Birth ");
		$("#txt_div").text("Please enter the date of birth.");
		$("#dob").addClass('focus');
		return false;
		}
		else if(dateOfBirth > todayDate)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Date of Birth ");
		$("#txt_div").text("Future date not allowed.");
		$("#dob").addClass('focus');
		return false;
		}			
		else if(dob != '' && !re.test(dob)) {
		  $("#lightbox").show();
		  $("#fadediv").show();
		  $("#cart_page").text("Date of Birth ");
		  $("#txt_div").text("Invalid date format.");
		  $("#dob").addClass('focus');
		  return false;
		}	
		else if($('#divGender input[type=radio]:checked').length == 0)
		{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Gender ");
			$("#txt_div").text("Please select a gender.");
			return false;     
		}
		
			else if(isActive == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Status");
			$("#txt_div").text("Please select Status.");
			$("#addressLine").addClass('focus');
			return false;
			}
			else if(programType == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Program Type");
			$("#txt_div").text("Please select program type.");
			$("#addressLine").addClass('focus');
			return false;
			}
						
			else if(Daddress1 == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Address");
			$("#txt_div").text("Please enter  address.");
			$("#addressLine").addClass('focus');
			return false;
			}
			else if(Dcity == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("City");
			$("#txt_div").text("Please enter  City.");
			$("#city").addClass('focus');
			return false;
			}
			else if(Dzip == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Zip");
			$("#txt_div").text("Please enter  Zip.");
			$("#zip").addClass('focus');
			return false;
			}
			else if(Dzip.length < 5)
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Zip");
			$("#txt_div").text("Please enter 5 digit zip code.");
			$("#zip").addClass('focus');
			return false;
			}
			else if(Dphone == "" && Cphone == "" && Wphone == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Phone");
			$("#txt_div").text("Please enter Phone Number.");
			$("#Dphone").addClass('focus');
			return false;
			}			
			else if((Dphone.length < 10 || Dphone.length > 15 )&& Dphone != "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Phone");
			$("#txt_div").text("Home Phone must contain 10-15 digits.");
			$("#Dphone").addClass('focus');
			return false;
			}
			
			else if((Cphone.length < 10 || Cphone.length > 15) && Cphone != "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Phone");
			$("#txt_div").text("Cell Phone must contain 10-15 digits.");
			$("#Dphone").addClass('focus');
			return false;
			}
			
			else if((Wphone.length < 10 || Wphone.length > 15) && Wphone != "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Phone");
			$("#txt_div").text("Work Phone must contain 10-15 digits.");
			$("#Dphone").addClass('focus');
			return false;
			}
			
			else if(Demail == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Email");
			$("#txt_div").text("Please enter email.");
			$("#hPhone").addClass('focus');
			return false;
			}
			else if (!filter.test(Demail) && Demail !="")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Email");
			$("#txt_div").text("Please enter proper email address.");
			$("#email").addClass('focus');
			return false;
			}
		
			else if (!filter.test(sEmail) && sEmail != "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Email");
			$("#txt_div").text("Please enter proper email address.");
			$("#sEmail").addClass('focus');
			return false;
			}
			else if((sEmail != "" && Demail !="") && (sEmail.trim() == Demail.trim()))
			{
				$("#lightbox").show();
				$("#fadediv").show();
				$("#cart_page").text("Email");
				$("#txt_div").text("Please enter different secondary email address.");
				$("#sEmail").addClass('focus');
				return false;
			}
		
		else if(password == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Please enter Password .");
		$("#password").addClass('focus');
		return false;
		}
		else if(password.length < 8)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Password must be 8 characters long.");
		$("#password").addClass('focus');
		return false;
		}
		else if(!regularExpression.test(password))
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Password ");
		$("#txt_div").text(" Password should contain atleast one special character.");
		$("#password").addClass('focus');
		return false;
		}
		
		else if(primaryProvider == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Primary Escalation ");
		$("#txt_div").text("Please select the primary escalation.");
		$("#primaryProv").addClass('focus');
		return false;
		}
		
		else if(secondaryProvider == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Secondary Escalation ");
		$("#txt_div").text("Please select the secondary escalation.");
		$("#secondaryProv").addClass('focus');
		return false;
		}
		
		else if(primaryProvider == secondaryProvider)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning ");
		$("#txt_div").text("Secondary escalation provider should not be same as primary escalation provider.");
		$("#secondaryProv").addClass('focus');
		return false;
		}
		
		else if(territoryProvider == secondaryProvider )
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning ");
		$("#txt_div").text("Secondary escalation provider should not be same as Tertiary escalation provider.");
		$("#secondaryProv").addClass('focus');
		return false;
		}
		
		else if(territoryProvider == primaryProvider)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning ");
		$("#txt_div").text("Tertiary escalation provider should not be same as primary escalation provider.");
		$("#tertiaryProv").addClass('focus');
		return false;
		}
		
		else
		{
		
		$("#username").val(Demail);
		localStorage["first_name"] = fname;
		localStorage["middle_name"] = mname;
		localStorage["last_name"] = lname;
		localStorage["dob"] = dob;
		//localStorage["gander"] = gander_male;		
		localStorage.setItem('preferredContactType',preferredContactType);
		if(phonePrimary != "")
		{
			localStorage.setItem('phonePrimary',phonePrimary);
		}
		else if(phoneCPrimary != "")
		{
			localStorage.setItem('phonePrimary',phoneCPrimary);
		}
		else if(phoneWPrimary != "")
		{
			localStorage.setItem('phonePrimary',phoneWPrimary);
		}		
		localStorage.setItem('gander',gander_male);
		localStorage["username"] = username;
		
		localStorage["Daddress1"] = Daddress1;
		localStorage["Daddress2"] = Daddress2;
		localStorage["Dcity"] = Dcity;
		localStorage["Dstate"] = Dstate;
		localStorage["Dzip"] = Dzip;
		localStorage["email"] = Demail;
		localStorage["prefName"] = prefName;
		localStorage["hPhone"] = Dphone;
		localStorage["cPhone"] = Cphone;
		localStorage["wPhone"] = Wphone;
		
		
		localStorage["password"] = password;
		localStorage["status"] = status;
		localStorage["primaryProvider"] = primaryProvider;
		localStorage["secondaryProvider"] = secondaryProvider;
		localStorage["territoryProvider"] = territoryProvider;
		
		localStorage["isActive"] = isActive;
		localStorage["programType"] = programType;
		localStorage["timeZone"] = timeZone;
		
		localStorage["page"] = page;
		localStorage["patientId"] = patientId;
		localStorage["editType"] = editType;
		localStorage["sEmail"] = sEmail;
		
		
		return true;
		}
	
	});
$("#okey").click(function()
{
$(".focus").focus();

});	
	
	$('#patientSearch').click(function(e){
     
			var fieldVal = $.trim($("#searchInput").val());
			var currentPage = $.trim($("#currentPage").val());
			var Page = $.trim($("#Page").val());
			
			if(fieldVal == null || fieldVal == "")
			{
				$("#lightbox").show();
				$("#fadediv").show();
				$("#cart_page").text("Warning");
				$("#txt_div").text("Please enter some value.");
				$("#okey").focus();
				
				return false;
			}
			else if(fieldVal != null && fieldVal.replace(" ","").length < 4 )
			{
				$("#lightbox").show();
				$("#fadediv").show();
				$("#cart_page").text("Warning");
				$("#txt_div").text("Value must be atleast 4 characters. ");
				$("#okey").focus();

				return false;
			}

			var patientSelectVal = $('#patientList').val();
			<?php
if(isset($_POST["deviceConfigId"]) && ($_POST["vitalType"]))
{
	$deviceConfigId = $_POST["deviceConfigId"];
	$vitalType = $_POST["vitalType"];
	?>
			openPageWithAjax("<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php?param='SELECTPATIENT'&currentPage="+currentPage+"&page="+Page+"&patientSelectVal="+patientSelectVal, 'deviceConfigId=<?php echo $deviceConfigId?>&vitalType=<?php echo $vitalType?>&search=true&searchStr='+fieldVal, 'menu-content', e, null);
	<?php
}
else{
?>
			openPageWithAjax("<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php?param='SELECTPATIENT'&currentPage="+currentPage+"&page="+Page+"&patientSelectVal="+patientSelectVal, 'search=true&searchStr='+fieldVal, 'menu-content', e, null);
<?php
}
?>



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
    <a href = "javascript:void(0)" id="okey" onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a></div>
	</div>
	<div id="fadediv" class="black_overlay"  onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"></div>
 

<style>
.black_overlay {
display:none;
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

}
</style>