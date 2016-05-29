<?php
include('controller/npi_detail_controller.php');
if(isset($_POST['npiSearch']))
{
?>
<script type="text/javascript">
	$(document).ready(function(){
	
	$("#npi-form").hide();
	
	
	});
    
    </script>

<?php

}/*
else
{*/
?>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/NPI_Style.css">
<style>

.form-group {
    float: left;
    width: 100%;
}

.New_Form_Bloom {
    margin-top: 15px;
}

button.btn.btn-blue {
    background: #04aefc none repeat scroll 0 0;
    border-bottom: 4px solid #0492d4;
    color: #fff;
    font-size: 20px;
}

button.btn.btn-orange {
    background: #ff8900 none repeat scroll 0 0;
    border-bottom: 4px solid #c85c03;
    color: #fff;
    font-size: 20px;
	margin-left:10px;
}

.button_Group{ text-align:right;}

.col-md-2.buttons-group img {
    cursor: pointer;
	margin-top: 3px;
    padding: 2px;
}

</style>
<script>

$/*(document).keydown(".form-control" , function(event)
{ 	
	if ((event.which != 8) && (event.keyCode < 96 || event.keyCode > 105) && (event.keyCode < 46 || event.keyCode > 57))
	{
		return false;
	}

});
*/
function CreateTextBox()
{
$("div.buttons-group").find("span").remove();
var htmlContent="<div class='form-group textBoxDiv'><div class='col-md-5'><input name='textinput[]' placeholder='NPI Number' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-5'><input name='textinput[]' placeholder='NPI Number' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-2 buttons-group'><span  onclick='javascript:CreateTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/add_button.png'  /></span><span onclick='javascript:DeleteTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/delete_button.png'  /></span></div></div>";
var divLength = $("#npi-form .New_Form_Bloom .textBoxDiv").length;
if(divLength == 5)
{
var htmlContent="<div class='form-group textBoxDiv'><div class='col-md-5'><input name='textinput[]' placeholder='NPI Number' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-5'><input name='textinput[]' placeholder='NPI Number' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-2 buttons-group'><span onclick='javascript:DeleteTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/delete_button.png'  /></span></div></div>";
}
$("#npi-form .New_Form_Bloom").append(htmlContent);


}

function DeleteTextBox()
{

var divLength = $("#npi-form .New_Form_Bloom .textBoxDiv").length;
$(".textBoxDiv").eq(divLength-1).remove();
console.log("divLength :"+divLength);
var addButton = "<span  onclick='javascript:CreateTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/add_button.png'  /></span><span onclick='javascript:DeleteTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/delete_button.png'  /></span>";

$("#npi-form .New_Form_Bloom .textBoxDiv").eq(divLength-2).find(".buttons-group").append(addButton);
	if(divLength== 2)
	{
	$("#npi-form .New_Form_Bloom .textBoxDiv").eq(divLength-2).find("span").eq(1).remove();
	}
}
</script>
<div class="col-md-8 padd-top20">
<h1 style="font-size: 32px; padding:5px 0px 5px 10px;">NPI Search Results</h1>
<form method="post" id="npi-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/npi_detail.php','npi-form','menu-content',event)">
<div class="col-lg-12 New_Form_Bloom">

<div class="form-group textBoxDiv">
<div class="col-md-5">
  <input name="textinput[]" placeholder="NPI Number" class="form-control input-md npiNumber" type="text"> 
  </div>
  <div class="col-md-5">
  <input name="textinput[]" placeholder="NPI Number" class="form-control input-md npiNumber" type="text"> 
  </div>
  <div class="col-md-2 buttons-group">
  <span onclick="CreateTextBox()"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/add_button.png"  /></span>
  </div>
</div></div>
<div class="col-lg-12 button_Group">
<input type="hidden" name="npiSearch" value="npiSearch" />
<button type="reset" class="btn btn-blue" onclick="openPageWithAjax('../../provider/pages/npi_detail.php','','menu-content',event,this)"><?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?></button>
<button type="submit" class="btn btn-orange" value="npiSearch" id="npiSearch"><?php echo constantAppResource::$COMMON_BUTTON_SEARCH;?></button>
</div>
</form>
</div>
<?php
/*}*/
?>
<div class="col-md-8 padd-top20">

<div id="showNPIDetail">
<?php




//var_dump($npiDetail);

 echo showNPIDetail($npiDetail); ?></div></div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".moredetail").click(function(){
		$(".lessDetail").click();
			var id =$(this).attr("id");
			id=id.split("_");
		 	id = id[1];
		  $("#NPI_CardDetails_"+id).slideDown();
		   $("#lessDetail_"+id).show();
		  $("#moredetail_"+id).hide();
		}); 
		
		$(".lessDetail").click(function(){
			var id =$(this).attr("id");
			id=id.split("_");
		 	id = id[1];
		  	$("#NPI_CardDetails_"+id).slideUp();
		    $("#lessDetail_"+id).hide();
		  	$("#moredetail_"+id).show();
		}); 
		
/*$(".aboutHref").click(function()
{
	$(".focus").focus();
});

		
$("#npiSearch").click(function()
{

var eleIndex = $('.npiNumber').length;
for(var i=0; i<eleIndex; i++)
{
	var statusInfo =true;
	$("form input").removeClass("focus");
	var check =$('.npiNumber').eq(i).val();
	if(check =="")
	{	  $('.npiNumber').eq(i).addClass('focus');
		 $("#aboutPopup").show();
		 $("#About_fadediv").show();
		 $(".cart_page").html("NPI Detail");
		 $(".txt_div").html("Please enter NPI number.");
		$('body').addClass('modal-open');
		statusInfo = false;
		return false;
	}
}
return statusInfo;

});		
*/		
	});
</script>

<style>
.moredetail {
    cursor: pointer;
}
.lessDetail {
    cursor: pointer;
}
</style>