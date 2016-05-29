<script>
$(document).ready(function()
{	$("#address1").focus();
	$("#lightbox").hide();
	$("#fadediv").hide();
	$("#submit").click(function()
	{	
		$("#self_registration_Ins input").removeClass("focus");
	
		var groupId = $("#groupId").val();
		var memberId = $("#memberId").val();
		var address1 = $("#address1").val();
		var city = $("#city").val();
		var zip = $("#zip").val();
		
		if(address1 == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Address1");
		$("#txt_div").text("Please enter address1.");
		$("#address1").addClass('focus');
		return false;
		}

		else if(city == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("City");
		$("#txt_div").text("Please enter city.");
		$("#city").addClass('focus');
		return false;
		}
		
		else if(zip == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Zip ");
		$("#txt_div").text("Please enter zip.");
		$("#zip").addClass('focus');
		return false;
		}
		else if(memberId == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("MemberId ");
		$("#txt_div").text("Please enter member id.");
		$("#memberId").addClass('focus');
		return false;
		}				
		
		else if(groupId == "")
		{
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("GroupId ");
		$("#txt_div").text("Please enter group id.");	
        $("#groupId").addClass('focus');		
		return false;
		
		}
		else
		{
		$("#stateId").removeAttr("disabled");
		$("#stateId").attr("readonly","readonly");
		return true;
		}
	

		
	});
	
	$("#okay").click(function()
	{
	if( $("#self_registration_Ins input").hasClass('focus'))
	{
	$(".focus").focus();
	}
	});
});


</script>
	<div id="lightbox" class="white_content" style="display:none;"><p class="cart1"><span  id="cart_page"></span><a id="error" href = "javascript:void(0)" onclick ="document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none';"><img src="../images/close.jpg" align="right" class="close"></a></p>
	<div class="alert"><img src="../images/alert.jpg" align="left">   <div id="txt_div"></div>
    <br>
    <a href = "javascript:void(0)" id="okay" onclick = "document.getElementById('lightbox').style.display='none';document.getElementById('fadediv').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a>
    <a href = "javascript:void(0)" id="no">No</a></div>
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
.alert a#no {
    background: none repeat scroll 0 0 orange;
    box-shadow: 1px 2px 5px 0 #9f9f9f;
    color: #fff;
    float: right;
    padding: 6px 29px;
	display:none;
	
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
<script>
var currntMenu="";
$("#self_registrationPage").click(function()
{
	var currentUrl=$(this).attr('data');
	if($("#self_registration_Ins").hasClass("change"))
	{
	$('#lightbox').show();
	$('#fadediv').show();
	$("#txt_div").text("Do you really want to move ? All changes will be lost.");
	$("#cart_page").text("warning");
	$("#okay").html("Yes");
	$("#okay").attr("href",currentUrl);
	$("#no").show();
	}
});

$("#self_registration_Ins input,select,radio").on('change', function()
{		$("#self_registrationPage").removeAttr('href');
	if(!$("#self_registration_Ins").hasClass("change"))
	{
		$("#self_registration_Ins").addClass("change");
		$("#self_registrationPage").removeAttr("onClick");
	}
});


$("#no,#fadediv,#error").click(function()
{
	$('#lightbox').hide();
	$('#fadediv').hide();
	$("#txt_div").text("");
	$("#cart_page").text("warning");
	$("#okay").html("Okay");
	$("#okay").attr("href","javascript:void");
	$("#no").hide();
});

</script>
