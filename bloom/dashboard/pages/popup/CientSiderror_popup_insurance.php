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
{	$("#stage").focus();
	$("#lightbox").hide();
	$("#fadediv").hide();
		$("#statusSave").click(function()
	{
	var stage = $("#stage").val();
	
		if(stage == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Stage");
		$("#txt_div").text("Please select stage.");	
        $("#insuredFirstName").addClass('focus');		
		return false;
		}
		
	});
	$("#goalsSave").click(function()
	{
		var goal1 = $("#goal1").val();
		var goal2 = $("#goal2").val();
		var goal3 = $("#goal3").val();
		
		if(goal1 == "" && goal2 == "" && goal3 == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Goal");
		$("#txt_div").text("Please select goal.");	
        $("#insuredFirstName").addClass('focus');		
		return false;
		}
		
	});
	$("#insurance,#insuranceSave").click(function()
	{
	$("#add-insurance-form input,select").removeClass("focus");
		var groupId = $("#groupId").val();
		var memberId = $("#memberId").val();
		var insuredFirstName = $("#insuredFirstName").val();
		var insuredLastName = $("#insuredLastName").val();
		
		
		
		var insuredDob = $("#insuredDob").val();
		var address1 = $("#address1").val();
		var city = $("#city").val();
		var zip = $("#zip").val();
		var phone = $("#insuredPhone").val();
		var page = $("#page").attr('name');
		var state = $("#state").val();
		var patientId = $("#patientId").val();
		var editType = $("#editType").val();
		var userType = "<?php echo strtoupper($_COOKIE['type'])?>"; 
		
	if(insuredFirstName == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("First Name ");
		$("#txt_div").text("Please enter the first name.");	
        $("#insuredFirstName").addClass('focus');		
		return false;
		}
		
		else if(insuredLastName == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Last Name ");
		$("#txt_div").text("Please enter the last name.");
		$("#insuredLastName").addClass('focus');
		return false;
		}
		
		else if(phone == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone");
		$("#txt_div").text("Please enter the phone.");
		$("#insuredPhone").addClass('focus');
		return false;
		}
		
		else if(address1 == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Address");
		$("#txt_div").text("Please enter the address .");
		$("#address1").addClass('focus');
		return false;
		}
		
		else if(city == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("City");
		$("#txt_div").text("Please enter the city.");
		$("#city").addClass('focus');
		return false;
		}
				
		else if(zip == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Zip");
		$("#txt_div").text("Please enter the zip.");
		$("#zip").addClass('focus');
		return false;
		}
		
		else if(groupId == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Group Id ");
		$("#txt_div").text("Please enter the Group Id.");	
        $("#groupId").addClass('focus');		
		return false;
		}
		
		else if(memberId == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Member Id");
		$("#txt_div").text("Please enter the Member Id.");
		$("#memberId").addClass('focus');
		return false;
		}
		// else if(insuredDob == "")
		// {
		// $("#lightbox").show();
		// $("#fadediv").show();
		// $("#cart_page").text("Date of Birth ");
		// $("#txt_div").text("Please enter the date of birth.");
		// $("#insuredDob").addClass('focus');
		// return false;
		// }
		else
		{
		localStorage["memberId"] = memberId;
		localStorage["insuredFirstName"] = insuredFirstName;
		localStorage["insuredLastName"] = insuredLastName;
		localStorage["insuredDob"] = insuredDob;
		localStorage["address1"] = address1;
		localStorage["city"] = city;
		localStorage["state"] = state;
		localStorage["zip"] = zip;
		localStorage["phone"] = phone;
		localStorage["patientId"] = patientId;
		localStorage["editType"] = editType;
		return true;
		}
	
	});
		$("#okey").click(function()
		{
		$(".focus").focus();

		});	
  $("#zip").keypress(function (e) {
     // if not number
	 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
	 {
	    return false;			   
     }
	 });
	 
	$(".captial").focusout(function(){
		var arr = $(this).val().split(' ');
		var result = "";
		for (var x=0; x<arr.length; x++)
			result+=arr[x].substring(0,1).toUpperCase()+arr[x].substring(1)+' ';
		$(this).val(result.substring(0, result.length-1));
	}); 
});</script>
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
height:240px !important;;
}
</style>