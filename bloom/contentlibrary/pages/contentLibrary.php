<?php
include ('controller/contentLibrary_controller.php');
$institutionName = explode(":", $_SERVER['HTTP_HOST']);
?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/script/css/content_lib.css">
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/script/jquery.tablesorter.js"></script>
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/script/jquery.tablesorter.widgets.js"></script>
<style>
.libraryTable *,
.libraryTable *:before,
.libraryTable *:after {
    -webkit-box-sizing: content-box !important;
    -moz-box-sizing: content-box !important;
    box-sizing: content-box !important;
}
.libraryTable{width:100%}
/*div#menu-content {
padding: 0 !important;
}*/

input#viewableToAll {
width: 20px;
height: 20px;
}

</style>
<div class="col-md-8 padd-top20">
  <div class="content_sc_x">
    <aside>

      <div class="row content_Library_addeddate">
			<table class="libraryTable">
				<thead class="content_Library_addeddate_tittle">
					<tr>
						<th class="col-md-2">Type</th>
						<th>Title</th>
						<th>Added date</th>
						<th>Public</th>
					</tr>
				</thead>
				<tbody>
					<?php echo addNewContentLibraryCards($contentResp); ?>
				</tbody>
			</table>

        
      </div>
    </aside>
  </div>
  <div class="clear"></div>
  <div class="push"></div>
  <div class="content_lib_button">
          <ul>
            <li><a  href = "javascript:void(0)" onclick = "addContent()">
			<img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_plus.jpg" alt=""></a></li>
            <li><a href="javascript:void(0)"  onclick = "deleteContent()"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_ms.jpg"data-toggle="modal" data-target="#myModal" alt=""></a></li>
             <?php /*?><li><a href="javascript:void(0)" onclick = "deleteContent()"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_ms.jpg"data-toggle="modal" data-target="#popnew" alt=""></a></li><?php */?>
          </ul>
        </div>		
</div>		
<!-- pop up-->

<div class="modal" id="schedulePopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content popup-body">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" style="font-size:20px;">Add Content</h4>
      </div>
	  <form id="content-popup-form" enctype="multipart/form-data" onSubmit="return validateForm(this,event)">
      <div class="modal-body">

      <div class="content_form_dsg">
	  	  <div id="fileBrowser" style="color:red;margin-left:163px; height:20px; font-size:12px;"></div>

        <label style="width:23%;">Name<span style="color:red;">*</span></label>
        <input type="text" class="filename" id="fileNameGet" />
        <div class="fileUpload btn btn-primary"> <span>Browse</span>
          <input type="file" name="newFileName" id="newFileName" accept="video/*,application/pdf" class="upload" />
        </div>
		<br clear="all"/>
      </div>
      <div class="content_form_dsg">
        <label>Assign to</label>
        <span class="custom-dropdown custom-dropdown--white" style="width:353px;">
        <select name="assignTo" id = "assignTo" class="custom-dropdown__select custom-dropdown__select--white" style="width:353px;">
          <option value="ALL">Leave blank for all patients</option>
		  <?php

			$list = $patientList;
			$entities = $list->{entityDetailInfos};
			foreach($entities as $pat)
			{?>
				<option value="<?php echo $pat->{entityId}; ?>"> <?php	echo $pat->{lastName}."  ".$pat->{firstName};?></option><?php
			}
			?>
        </select>
        </span>
      </div>
      <div class="content_form_dsg">
        <label>Title<span class="required">*</span></label>
        <input type="text" id="title" name="title"/>
      </div>
      <div class="content_form_dsg">
        <label>Description<span class="required">*</span></label>
        <textarea id="description" name="description" placeholder="Message" maxlength="500"></textarea>
      </div>
      <div class="content_form_dsg">
        <label>Public<span class="required"></span></label>
        <input name="viewableToAll" id="viewableToAll" type="checkbox" />
      </div>
	  <input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
	  <input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
	  <input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"/>
	   <input type="hidden" name="imageName" value="<?php echo $_COOKIE['imageLoginName'];?>"/>
	   <input type="hidden" name="contentType" id="addContentLibrary" />
	  <br clear="all"/>

      </div>
      <div class="modal-footer" style="margin-top:0px;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary btn-bg" delete-id="0" id="provider-delete-button">Add</button>
      </div>
	  </form>
    </div>
  </div>


</div>

<!-- pop new-->

<div class="modal" id="popnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog pat_list_pop" >
    <div class="modal-content popup-body">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" style="font-size:20px;">Add Content </h4>

      </div>
	  <form id="content-popup-form" enctype="multipart/form-data" onSubmit="return validateForm(this,event)">
       <p class="popup_replace">There is already a file with the same name in this location. <br />Rename the file you are adding</p>
      <div class="modal-body">

      <div class="content_form_dsg pat_list_popup1">
        <label class="pat_pop_but">Name</label>
        <input type="text" class="filename" />
		<br clear="all"/>
         <p class="popup_replace" style="padding-top:0">Replace the file in the library with the file you are adding</p>
      </div>
      <div class="content_form_dsg">
        <label class="pat_pop_but1">Replace</label>
       <p class="popup_replace" style="padding:0">/sdcard/Download/beattheload.pdf </p>
       <span>Size: 32KB</span>
        <span>Date modified: </span><br />
        <span>  12/08/201308:27P.M.</span>
      </div>

		<input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
	  <input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
	  <input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"/>
	   <input type="hidden" name="imageName" value="<?php echo $_COOKIE['imageLoginName'];?>"/>
	   <input type="hidden" name="contentType" value="pdf"/>
	  <br clear="all"/>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

      </div>
	  </form>
    </div>
  </div>


</div>
<!-- pop end-->

<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Content Library</h4>
      </div>
      <div class="modal-body pat-body" id="message">
       Are you sure you want to delete it.
      </div>
      <div class="modal-footer" style="margin-top:30px; padding:15px;">
		<form id="deleteContent-form"
  onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/pages/contentLibrary.php','deleteContent-form','deleteContent-add',event,'myModal')">
			<input type="hidden" id="deleteContentId" name="deleteContentId" />
			<input type="hidden" name="userId" value="<?php echo $_COOKIE['id'];?>" />
			<input type="hidden" id="contentType" name="contentType" />
			<input type="hidden" id="titleDelete" name="title"/>
			<input type="hidden"  id="fileUploadDate" name="fileUploadDate" />
			<input type="hidden" id="viewableToAll" name="viewableToAll"/>
	        <input type="reset" class="btn btn-default" data-dismiss="modal" id="reset" value="Close" />
  <input type="submit" style="margin:0px;"  class="btn btn-primary btnpatlist1" id="deleteBtn" onclick="deleteContentConfirm();" name="Delete" value="Delete" />
    <input type="hidden" id="Delete" name="Delete" />
  </form>
      </div>
    </div>
  </div>
</div>
<!--
<style>
.grip{
	background:url("<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_lib_bullet.png");
	cursor: e-resize;
    height: 36px;
    margin-left: -5px;
    margin-top: 4px;
    position: relative;
    width: 18px;
    z-index: 88;
}
</style>-->
<script>
$(document).ready(function() {
window.location.hash = '/content_library';

    $("table.libraryTable").tablesorter({
    theme : 'blue',
    // initialize zebra striping and resizable widgets on the table
    widgets: [ "zebra", "resizable" ],
    widgetOptions: {
       resizable: true
    }
  });
	$('.libraryTable tbody tr').click(function(){
		$('.libraryTable tbody tr').removeClass('active-row');
		$('.libraryTable tbody tr').css('background','');
		$('.libraryTable tbody tr').css('color','');
		$(this).css('background','#365878');
		$(this).css('color','#fff');
		$(this).addClass('active-row');
	});
    $('input[type="file"]').change(function() {
        var val = ($(this).val()) ? $(this).val() : "No file selected.";
		val= val.replace("C:\\fakepath\\", "");
        $('.filename').val(val);
    });
});
function addContent()
{
	$('#schedulePopup').modal();
}

$("#reset").click(function()
{
	$("#message").html("Are you sure you want to delete it.");
	$("#deleteBtn").show();
});




function deleteContent()
{
	//$('tr.active-row').remove();
	var currentContentId=$('tr.active-row').attr('id');
	if(currentContentId === undefined  || currentContentId === "")
	{
	$("#message").html("Please select a content to delete.");
	$("#deleteBtn").hide();
	}
	else{
	var currentContentTitle=$('tr.active-row').attr('title');
	var currentcontentType=$('tr.active-row').attr('content-type');
	var currentfileUploadDate=$('tr.active-row').attr('fileUploadDate');
	var viewableToAll = $('tr.active-row').attr('viewableToAll');
	$("#deleteContentId").val(currentContentId);
	$("#titleDelete").val(currentContentTitle);
	$("#contentType").val(currentcontentType);
	$("#viewableToAll").val(viewableToAll);
	$("#fileUploadDate").val(currentfileUploadDate);
	}
}

 $('#newFileName').change( function() {
  if ($(this).val() != '') {
    var file = $(this)[0].files[0];
    var fileName = file.name;
    var fileExt = fileName.split('.').pop();
    $("#addContentLibrary").val(fileExt);
  }
  else {
    alert('Please select a file.')
  }
});
    $("#newFileName").change(function(){
		var fileExtension = ['mp4', 'mov','pdf']
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			$("#fileBrowser").html("Application supports PDF, MOV and MP4 files only");
			$("#provider-delete-button").attr("disabled","disabled");
			$("#provider-delete-button").css("opacity","0.33");
		}
		else{
			$("#fileBrowser").html("");
			$("#provider-delete-button").removeAttr("disabled");
			$("#provider-delete-button").css("opacity","1");
		}
    });
//add form start


function deleteContentConfirm()
{
var rowId=$("#deleteContentId").val();
$("#"+rowId).css('display','none');
}

function validateForm(ele,e)
{
	var title = $('#title').val();
	var description = $('#description').val();
	var msg = "";
	if(title == "" || title == null)
	{
		msg += "Title is required"
	}
	else if(description == "" || description == null)
	{
		msg += "Description is required";
	}

	if(msg != "")
	{
		alert(msg);
		return false;
	}
	else
	{
		console.log('in else');
		postContentMultipartForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/content',ele, e);

		return false;
	}
}
function postContentMultipartForm(action, ele, e) {
    if (typeof e != undefined) {
        e.preventDefault();
    }
	var formData = new FormData($(ele)[0]);
    $.ajax({
        url: action,
        type: 'POST',
        data: formData,//$('#' + formId).serialize(),
        crossDomain: true,
		 // async: false,
           cache: false,
           contentType: false,
           processData: false,
		 beforeSend: function(){showLoading()},
        success: function(result) {
		 $('.close').click()
          // alert('sent successfully');
		// $("#" + resultingDivId).html(result);
        },
        error: function( request, textStatus, errorThrown) {
       	 //request.getResponseHeader('VMCErrorCode')
           // console.log('jqXHR'+formData.elements['title'].value);
		 //  alert("Incorrect File! Please choose different file or upload file with different name.");
		   		 $("#aboutPopup").show();
  				 $("#About_fadediv").show();
				 $(".cart_page").html("Content Library");
   				 $(".txt_div").html("Incorrect File! Please choose different file or upload file with different name.");

        		$('body').removeClass('modal-open');
        		$('.modal-backdrop').remove();
        },
        complete: function() {
			hideLoading();
			console.log('completed')
			openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/pages/contentLibrary.php','','menu-content',e,this)
		 }
    });
}
</script>
<!--end-->
<!--0
<div id="popup_nomatch_alrt" class="white_content" style="width:75%">
  <p class="cart">Add Content<a href = "javascript:void(0)" onclick = "document.getElementById('popup_nomatch_alrt').style.display='none';document.getElementById('fade').style.display='none'">
  <img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/close_but.jpg" align="right" class="close"></a></p>
  <div class="alert">
<form>
<script>
$(document).ready(function() {
    $('input[type="file"]').change(function() {
        var val = ($(this).val()) ? $(this).val() : "No file selected.";
        $('.filename').val(val);
    });
});
</script>


      <div class="content_form_dsg">
        <label>Name</label>
        <input type="text" class="filename" />
        <div class="fileUpload btn btn-primary"> <span>Browse</span>
          <input type="file" class="upload" />
        </div>
      </div>
      <div class="content_form_dsg">
        <label>Assign to</label>
        <select name="assignTo" id = "assignTo">
          <option value="ALL">Leave blank for all patients</option>
		  <?php
			$list = $patientList;
			$entities = $list->{entityDetailInfos};
			foreach($entities as $pat)
			{?>
				<option value="<?php	echo $pat->{entityId}; ?>"> <?php	echo $pat->{lastName}."  ".$pat->{firstName};?></option><?php
			}
			?>
        </select>
      </div>
      <div class="content_form_dsg">
        <label>Title</label>
        <input type="text">
      </div>
      <div class="content_form_dsg">
        <label>Description</label>
        <textarea placeholder="Message"></textarea>
      </div>
      <div class="content_form_dsg1">
        <input type="reset" value="Cancel" name="Cancel">
        <input type="submit" value="Submit" name="Submit">
      </div>
</form>
  </div>
</div>
<div id="fade" class="black_overlay"></div>
-->
