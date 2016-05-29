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
	$("#addPatient").click(function()
	{
		$("#contact-patient-form input,select").removeClass("focus");

		var address1 = $("#address1").val();
		var address2 = $("#address2").val();
		var city = $("#city").val();
		var state = $("#state").val();
		var zip = $("#zip").val();
		var email = $("#email").val();
		var hPhone = $("#hPhone").val();
		var cPhone = $("#cPhone").val();
		var wPhone = $("#wPhone").val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		
		var Daddress1 = $("#Daddress1").val();
		var Daddress2 = $("#Daddress2").val();
		var Dcity = $("#Dcity").val();
		var Dstate = $("#Dstate").val();
		var Dzip = $("#Dzip").val();
		var Demail = $("#Demail").val();
		var Dphone = $("#Dphone").val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		var DeliveryAddress = $("#DeliveryAddress").is(':checked');
		var DeliveryPhone = $("#DeliveryPhone").is(':checked');
		var DeliveryEmail=$("#DeliveryEmail").is(':checked');
		
		if(address1 == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Address ");
		$("#txt_div").text("Please enter the billing address.");
		$("#address1").addClass('focus');
		return false;
		}
		 else if(city == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("City ");
		$("#txt_div").text("Please enter the billing  city.");
		$("#city").addClass('focus');
		return false;
		}
		 else if(state == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("State ");
		$("#txt_div").text("Please select the billing state.");
		$("#state").addClass('focus');
		return false;
		}
		/*
		else if(!( /^[a-z]+$/i.test(city)))
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("City ");
		$("#txt_div").text("Please enter only alphabetical characters  in the city.");
		$("#city").focus();
		$("#city").addClass('focus');
		return false;

		
		}
		*/
		 else if(zip == "" || zip.length<=4)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Zip ");
		$("#txt_div").text("Please enter the billing  zip code.");
		$("#zip").addClass('focus');
		return false;
		}
		
		else if(hPhone == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone ");
		$("#txt_div").text("Please enter the Home  phone number.");
		$("#phone").addClass('focus');
		return false;
		}
		else if(cPhone == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone ");
		$("#txt_div").text("Please enter the Cell  phone number.");
		$("#phone").addClass('focus');
		return false;
		}
		else if(wPhone == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone ");
		$("#txt_div").text("Please enter the Work  phone number.");
		$("#phone").addClass('focus');
		return false;
		}
		

		else if (email =="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please provide billing email address.");
		$("#email").addClass('focus');
		return false;
		}
		else if (!filter.test(email) && email !="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please enter proper billing email address.");
		$("#email").addClass('focus');
		return false;
		}
		else if(Daddress1 == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Address ");
		$("#txt_div").text("Please enter the delivery address.");
		$("#Daddress1").addClass('focus');
		return false;
		}

		

		 else if(Dcity == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("City ");
		$("#txt_div").text("Please enter the delivery city.");
		$("#Dcity").addClass('focus');
		return false;
		}

		 else if(Dstate == ""  || Dstate == null )
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("State ");
		$("#txt_div").text("Please enter the delivery State.");
		$("#Dstate").addClass('focus');
		return false;
		}
		/*
		else if(!( /^[a-z]+$/i.test(city)))
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("City ");
		$("#txt_div").text("Please enter only alphabetical characters  in the city.");
		$("#city").focus();
		$("#city").addClass('focus');
		return false;

		
		}
		*/
		 else if(Dzip == "" || zip.length<=4)
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Zip ");
		$("#txt_div").text("Please enter the delivery zip code.");
		$("#Dzip").addClass('focus');
		return false;
		}
		
		else if (Demail =="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please provide delivery email address.");
		$("#Demail").addClass('focus');
		return false;
		}
		else if (!filter.test(Demail) && Demail !="")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Please enter proper delivery email address.");
		$("#Demail").addClass('focus');
		return false;
		}
				
		else if(Dphone == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone ");
		$("#txt_div").text("Please enter the delivery phone number.");
		$("#Dphone").addClass('focus');
		return false;
		}
		
		else if(!($("#DeliveryPhone").is(':checked')) && Dphone == phone && phone!="" && Dphone !="" )
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Phone");
		$("#txt_div").text("Billing phone and Preferred phone do not same.");
		$("#Dphone").addClass('focus');
		return false;
		}
		
		
		else if(!($("#DeliveryEmail").is(':checked')) && Demail == email  && email!="" && Demail !="" )
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Email");
		$("#txt_div").text("Billing email and Preferred email do not same.");
		$("#Demail").addClass('focus');
		return false;
		}
		

		else
		{
		localStorage["address1"] = address1;
		localStorage["address2"] = address2;
		localStorage["city"] = city;
		localStorage["state"] = state;
		localStorage["zip"] = zip;
		localStorage["email"] = email;
		localStorage["phone"] = phone;
		
		localStorage["Daddress1"] = Daddress1;
		localStorage["Daddress2"] = Daddress2;
		localStorage["Dcity"] = Dcity;
		localStorage["Dstate"] = Dstate;
		localStorage["Dzip"] = Dzip;
		localStorage["Demail"] = Demail;
		localStorage["Dphone"] = Dphone;
		
		localStorage["DeliveryAddress"] = DeliveryAddress;
		localStorage["DeliveryPhone"] = DeliveryPhone;
		localStorage["DeliveryEmail"] = DeliveryEmail;
		return true;
		}
	
	});
	
});


	
$("#okey").click(function()
{
$(".focus").focus();

});	
	
$('#DeliveryAddress').click(function () {
	if($("#DeliveryAddress").is(':checked'))
	{
		var address1 = $("#address1").val();
		var address2 = $("#address2").val();
		var city = $("#city").val();
		var state = $("#state").val();
		var zip = $("#zip").val();

		$("#Daddress1").val(address1);
		$("#Daddress2").val(address2);
		$("#Dcity").val(city);
		$("#Dstate").val(state);
		$("#Dzip").val(zip);
/*
		if(!$("#insurance-form").hasClass("change"))
		{
			$("#insurance-form").addClass("change");
			$("#addPatientMenu li a").removeAttr("onClick");
			$("#pageCancel").removeAttr("onClick");
			$("#cancel").removeAttr("onClick");
		}
	*/		
	}
	else
	{
		$("#Daddress1").val("");
		$("#Daddress2").val("");
		$("#Dcity").val("");
		$("#Dstate").val("");
		$("#Dzip").val("");
	}
});		

$('#DeliveryPhone').click(function () {
	if($("#DeliveryPhone").is(':checked'))
	{
		var phone = $("#phone").val();
		$("#Dphone").val(phone);
	}
	else
	{
		$("#Dphone").val("");
	}
});		

$('#DeliveryEmail').click(function () {
	if($("#DeliveryEmail").is(':checked'))
	{
		var email = $("#email").val();

		$("#Demail").val(email);
	}
	else
	{
		$("#Demail").val("");
	}
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
top: 30%!important;
left: 25%!important;
width: 410px !important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002 !important;
overflow: auto !important;
height:240px !important;;
}
</style>