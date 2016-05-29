<?php
$fieldNameId = $_POST["fieldNameId"];

include('controller/fieldOption_controller.php');
?>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/NPI_Style.css">
<script>
function CreateTextBox()
{
$("div.buttons-group").find("span").remove();
var htmlContent="<div class='form-group textBoxDiv'><div class='col-md-5'><input name='textinput[]' placeholder='Options' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-5'><input name='textinput[]' placeholder='Options' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-2 buttons-group'><span  onclick='javascript:CreateTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/add_button.png'  /></span><span onclick='javascript:DeleteTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/delete_button.png'  /></span></div></div>";
var divLength = $("#npi-form .New_Form_Bloom .textBoxDiv").length;
<?php /*?>if(divLength == 5)
{
var htmlContent="<div class='form-group textBoxDiv'><div class='col-md-5'><input name='textinput[]' placeholder='Options' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-5'><input name='textinput[]' placeholder='Options' class='form-control input-md  npiNumber' type='text'></div><div class='col-md-2 buttons-group'><span onclick='javascript:DeleteTextBox()'><img src='<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/delete_button.png'  /></span></div></div>";
}<?php */?>
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
<h1 style="font-size: 32px; padding:5px 0px 5px 10px;">Category Options</h1>
<form method="post" id="npi-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/fieldOptions.php','npi-form','menu-content',event)">
<div class="col-lg-12 New_Form_Bloom">

<div class="form-group textBoxDiv">
<div class="col-md-5">
  <input name="textinput[]" placeholder="Options" class="form-control input-md npiNumber" type="text"> 
  </div>
  <div class="col-md-5">
  <input name="textinput[]" placeholder="Options" class="form-control input-md npiNumber" type="text"> 
  </div>
  <div class="col-md-2 buttons-group">
  <span onclick="CreateTextBox()"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/add_button.png"  /></span>
  </div>
</div></div>
<div class="col-lg-12 button_Group">
<input type="hidden" name="submit" value="submit" />
<input type="hidden" value="<?php echo $fieldNameId ?>" name="fieldNameId" />
<button type="reset" class="btn btn-blue" onclick="openPageWithAjax('../../provider/pages/fieldOptions.php','','menu-content',event,this)"><?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?></button>
<button type="submit" class="btn btn-orange" value="npiSearch" id="npiSearch">Save</button>
</div>
</form>
</div>
<?php
/*}*/
?>
<div id="showNPIDetail">
<?php




//var_dump($npiDetail);

 echo showNPIDetail($npiDetail); ?></div>

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