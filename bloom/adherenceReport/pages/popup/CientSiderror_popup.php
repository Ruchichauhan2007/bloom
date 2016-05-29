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
{	$("#first_name").focus();
	$("#lightbox").hide();
	$("#fadediv").hide();
	$("#addPatient").click(function()
	{
	$("#add-patient-form input,select").removeClass("focus");
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var fname = $("#first_name").val();
		var mname = $("#middle_name").val();
		var lname = $("#last_name").val();
		var dob = $("#dob").val();
		
		var gander_male = $("#radio1").val();
		var gander_female = $("#radio2").val();
		var username = $("#username").val();
		var password = $("#password").val();
		var status = $("#status").val();
		var primaryProvider = $("#primaryProvider").val();
		var secondaryProvider = $("#secondaryProvider").val();
		var territoryProvider = $("#territoryProvider").val();
		var page = $("#page").attr('name');
		var patientId = $("#patientId").val();
		var editType = $("#editType").val();
		var userType = "<?php echo strtoupper($_COOKIE['type'])?>"; 
		
		var Daddress1=$("#Daddress1").val();
		var Daddress2=$("#Daddress2").val();
		var Dcity=$("#Dcity").val();
		var Dzip=$("#Dzip").val();
		var Dstate=$("#Dstate").val();
		var Dphone=$("#Dphone").val();
		var Demail=$("#email").val().trim();
				
		if(fname == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("First Name ");
		$("#txt_div").text("Please enter the first name.");	
        $("#first_name").addClass('focus');		
		return false;
		
		}
		
		else if(lname == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Last Name ");
		$("#txt_div").text("Please enter the last name.");
		$("#last_name").addClass('focus');
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
		
		
		
		 if($('input[type=radio]:checked').length == 0)
		{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Gender ");
			$("#txt_div").text("Please select a gender.");
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

			else if(Daddress1 == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Address");
			$("#txt_div").text("Please enter  address.");
			$("#Daddress1").addClass('focus');
			return false;
			}
			else if(Dcity == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("City");
			$("#txt_div").text("Please enter  City.");
			$("#Dcity").addClass('focus');
			return false;
			}
			else if(Dzip == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("zip");
			$("#txt_div").text("Please enter  Zip.");
			$("#Dzip").addClass('focus');
			return false;
			}
			else if(Dphone == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Phone");
			$("#txt_div").text("Please enter Phone.");
			$("#Dphone").addClass('focus');
			return false;
			}
			else if(Demail == "")
			{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Email");
			$("#txt_div").text("Please enter email.");
			$("#Demail").addClass('focus');
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
		
		else if(primaryProvider == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Primary Escalation ");
		$("#txt_div").text("Please select the primary escalation.");
		$("#primaryProvider").addClass('focus');
		return false;
		}
		
		else if(secondaryProvider == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Secondary Escalation ");
		$("#txt_div").text("Please select the secondary escalation.");
		$("#secondaryProvider").addClass('focus');
		return false;
		}
		
		else if(primaryProvider == secondaryProvider)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning ");
		$("#txt_div").text("Secondary escalation provider should not be same as primary escalation provider.");
		$("#secondaryProvider").addClass('focus');
		return false;
		}
		
		else if(territoryProvider == secondaryProvider )
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning ");
		$("#txt_div").text("Secondary escalation provider should not be same as Tertiary escalation provider.");
		$("#secondaryProvider").addClass('focus');
		return false;
		}
		
		else if(territoryProvider == primaryProvider)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Warning ");
		$("#txt_div").text("Tertiary escalation provider should not be same as primary escalation provider.");
		$("#territoryProvider").addClass('focus');
		return false;
		}
		
		else
		{
		$("#username").val(Demail);
		localStorage["first_name"] = fname;
		localStorage["middle_name"] = mname;
		localStorage["last_name"] = lname;
		localStorage["dob"] = dob;
		localStorage["gander"] = gander_male;
		localStorage["username"] = username;
		
		localStorage["Daddress1"] = Daddress1;
		localStorage["Daddress2"] = Daddress2;
		localStorage["Dcity"] = Dcity;
		localStorage["Dstate"] = Dstate;
		localStorage["Dzip"] = Dzip;
		localStorage["email"] = Demail;
		localStorage["Dphone"] = Dphone;
		
		localStorage["password"] = password;
		localStorage["status"] = status;
		localStorage["primaryProvider"] = primaryProvider;
		localStorage["secondaryProvider"] = secondaryProvider;
		localStorage["territoryProvider"] = territoryProvider;
		localStorage["page"] = page;
		localStorage["patientId"] = patientId;
		localStorage["editType"] = editType;
		
		
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

			openPageWithAjax("<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php?param='SELECTPATIENT'&currentPage="+currentPage+"&page="+Page+"&patientSelectVal="+patientSelectVal, 'search=true&searchStr='+fieldVal, 'menu-content', e, null);

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