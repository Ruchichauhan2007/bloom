<?php include 'controller/portal_rxdetail_controller.php'; ?>
<?php
  		$institutionName = explode(":", $_SERVER['HTTP_HOST']);
		$entityUtil = new EntityUtil();
  		$userType = strtoupper($_COOKIE['type']);
		if (isset ( $_REQUEST['type'] ) or $userType == "PATIENT") {
			if($userType == "PATIENT")
			{
			$patientId = $_COOKIE['id'];
			}
			else{
			$patientId = $_REQUEST['patientId'];
			}
			
			 $paramArray = array() ;
			$paramArray[0] = $patientId;
			$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
			
			
			 $paramArray = array() ;
			$paramArray[0] = $patientId;
			$getAllPrescription = $entityUtil->getObjectFromServer($paramArray, "getAllPrescriptionByPatientId", VMCPortalConstants::$API_EMR);
			//var_dump($getAllPrescription);
			
			
		}
?>

 <link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css" rel="stylesheet" type="text/css">
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/script/jquery.tablesorter.js"></script>
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/script/jquery.tablesorter.widgets.js"></script>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/NPI_Style.css">
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
.tablesorter-header.tablesorter-headerDesc,.tablesorter-header.tablesorter-headerAsc,.tablesorter-headerUnSorted{
	background:url('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_lib_bullet.png') no-repeat scroll right center !important;
}
.libraryTable thead.content_Library_addeddate_tittle tr th {
    color: #000;
    font-size: 17px;
    padding: 8px 0;
    text-align: center;
}
.libraryTable {
    color: #000;
    font-size: 16px;
    text-align: center !important;
}
.libraryTable {
    color: #000;
    font-size: 17px;
    text-align: center;
}
.libraryTable td {
    padding-left: 35px;
    text-align: center !important;
}
.Fax-history .table-responsive {
    max-height: 254px;
    min-height: 254px;
    overflow-y: scroll;
}
.fileUploadNew input.uploadFileNew {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  padding: 0;
  font-size: 20px;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
  background-color: #993300;
}
.fileUploadNew.btn.btn-primary:active{
	ursor: pointer;
    font-size: 14px;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
	border-bottom:0px;
}
input#fileNameGet.filename {
    border: 1px solid #ccc;
    height: 33px;
}
.Fax-history .table-responsive {
background:url('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Screen_BG.png') repeat-x;
}
</style>

 
<div class="dashboard_top_nav">
<?php
if (isset ( $_REQUEST['type']) or $userType == "PATIENT") {
?>
  <ul id="addPatientMenu">
    <li  id="profile"><a href="#"   onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	
	
	<li  id="Insurance"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo[0]->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo[0]->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT&edit=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$INSURANCE;?></a></li>
	
    <li  id="device"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
	
    <li  id="device_schedule"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
       <li><a href="#" class="active" onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" ><?php echo constantAppResource::$PRESCRIPTION;?></a></li>
	
	<span class="nmaePatFormat spanHide"><?php echo $patientInfo->{lastName}." ".$patientInfo->{firstName} ?></span>
	<?php
	if($dateOdBirthStr!= "")
	{
	?>
	<span class="dobPatFormat spanHide">
     DOB	
	<?php 
	echo $dateOdBirthStr;
	}
	?>
	</span>
  </ul>
  <?php
  }
  else
  {
  ?>
   <ul id="addPatientMenu">
    <li><a href="#" class="active"><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	 <!--<li><a href="#">Contact Detail</a></li>-->
	 <li><a href="#"><?php echo constantAppResource::$INSURANCE;?></a></li>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
    <li><a href="#"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
       <li><a href="#"><?php echo constantAppResource::$PRESCRIPTION;?></a></li>
  </ul>
  <?php
  }
  ?>
</div>

<div class="container">
<div class="col-lg-12">
<div class="col-md-12 Fax-history">
<ul class="PrescriptionTab">
<li ><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" ><?php echo constantAppResource::$PRESCRIBING_PROVIDER;?></a></li>
<li class="active"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_rxDetail.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_rxDetail.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" ><?php echo constantAppResource::$RX_DETAIL;?></a></li>
<li ><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_faxHistory.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"data="openPageWithAjax('../../dashboard/pages/portal_faxHistory.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$FAX_HISTORY;?></a></li>
</ul>
<div class="table-responsive">
<table class="table table-striped libraryTable" id="tableId">
      
       <?php
	    $counter =0;
/*	   if($getAllPrescription != NULL)
	   {*/
	   ?>
         <thead class="content_Library_addeddate_tittle">
        <tr>
          <th>Acquired Date</th>
          <th>Renewal Date</th>
          <th>Frequency</th>
          <th>Length</th>
          <th style="display:none;">No Of Refills</th>
          <th style="display:none;">Refill Allowed</th>
          <th><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/PdfIconBlack.png" /></th>
          <!--<th><img src="<?php //$_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Edit_Bottun.png" /></th>-->
        </tr>
      </thead>
      <tbody>  
       <?php
	  
		   foreach($getAllPrescription as $getPrescription)
		   {	$counter ++;
				$dateUtil = new DateUtil();
				$prescriptionDate = $dateUtil->formatDatetoStr($getPrescription->{prescriptionDate});
				$renewalDate = $dateUtil->formatDatetoStr($getPrescription->{renewalDate});
		?>
                <tr id="<?php echo $getPrescription->{prescriptionId}; ?>" acquireDate="<?php echo $prescriptionDate; ?>" renewalDate="<?php echo $renewalDate; ?>" frequency="<?php echo $getPrescription->{frequency}; ?>" length="<?php echo $getPrescription->{length}; ?>">
                  <td scope="row" ><?php echo $prescriptionDate;?></th>
                  <td><?php echo $renewalDate; ?></td>
                  <td><?php echo $getPrescription->{frequency}; ?></td>
                  <td><?php echo $getPrescription->{length}; ?></td>
                  <td style="display:none;"><?php echo $getPrescription->{numberOfRefills}; ?></td>
                  <td style="display:none;"><?php echo $getPrescription->{refillsAllowed}; ?></td>
                  <td  style="cursor:pointer" onclick="openRxDetail(<?php echo $getPrescription->{prescriptionId}; ?>);"><a href="javascript:void(0);" ><?php echo $getPrescription->{rxFileName}; ?></a></td>
                 <!-- <td><a href="#"  class="edit" id="<?php //echo $getPrescription->{prescriptionId}; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>-->
                </tr>
		<?php
			}
			?>
              </tbody>
            <?php 
			
		/*}*/
		 ?>
    
    </table>
 
 </div>   <div class="content_lib_button">
          <ul>
            <li><a href="#" id="addRxDetail"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_plus.jpg" alt=""></a></li>
            <li><a href="javascript:void(0)"  onclick = "deleteContent()" id="deleteRxDetail"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/contentlibrary/images/content_ms.jpg" data-toggle="modal" data-target="#myModal" alt="" /></a></li>
                       </ul>
        </div>

</div>
</div>
</div>

<div class="container" id="rx-form" style="display:none;">
<div class="col-md-12 Fax-history FormRX">
<form action="" method="post"  enctype="multipart/form-data" onSubmit="return validateForm(this,event)" id="add-rxDetail-form" autocomplete="off">

<div class="col-md-6 LeftFormRX">
<!-- Appended Input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="appendedtext">Acquired Date<span style="color:#FF0000;">*</span></label>
  <div class="col-md-8">
    <div class="input-group">
      <input  name="acqDate" id="acquiredDate" class="form-control" placeholder="Acquired Date" type="text">
        <!--<textarea id="description" name="description" placeholder="Message" maxlength="500"></textarea>
        <input type="text" id="title" name="title"/>-->
    </div>
  </div>
</div>
<!-- Appended Input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="appendedtext">Renewal Date<span style="color:#FF0000;">*</span></label>
  <div class="col-md-8">
    <div class="input-group">
      <input  name="renewalDate" id="renewalDate" class="form-control" placeholder="Renewal Date" type="text">
    
    </div>
  </div>
</div>
<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Length<span style="color:#FF0000;">*</span></label>  
  <div class="col-md-6">
  <input  name="length" style="width: 94%;" id="length" type="text" placeholder="Length" class="form-control input-md">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">PDF<span style="color:#FF0000;">*</span></label>
  <div class="col-md-8">
      <input type="text" placeholder="Browse File"  name="newFileName" id="newFileName"  style="padding-left: 8px; padding-right: 0px; height:34px;" class="filename" />
        <div class="fileUploadNew btn btn-primary"> <span>Browse</span>
          <input type="file" id="pdfFile" name="isMultipart" accept="application/pdf" class="uploadFileNew" />
        </div>
  </div>
</div>
</div>
<div class="col-md-6 LeftFormRX">
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Frequency<span style="color:#FF0000;">*</span></label>  
  <div class="col-md-8">
  <input  name="frequency" id="frequency" type="text" placeholder="Frequency" class="form-control input-md">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">No. Of Refills<span style="color:#FF0000;">*</span></label>  
  <div class="col-md-8">
  <input  name="noOfRefills" id="noOfRefills" type="text" placeholder="No. Of Refills" class="form-control input-md">
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Refill Allowed<span style="color:#FF0000;">*</span></label>  
  <div class="col-md-8">
  <input  name="refillAllowed" id="refillAllowed" type="text" placeholder="Refill Allowed" class="form-control input-md">
  </div>
</div>
</div>


<div class="col-md-12 RXFormDetail">
<button class="btn-Blue" type="reset"><?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?></button>
<input  name="insert" id="insert" type="hidden">
<button type="submit" id="submitBtn"  class="btn-Orange"><?php echo constantAppResource::$COMMON_BUTTON_SAVE;?></button>
</div>
<input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
<input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
<input  name="prescriptionId" id="prescriptionId" type="hidden" value="">

<input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
<input type="hidden" name="entityId" value="<?php echo $_COOKIE['id'] ?>"  />
<input type="hidden" name="imageName" value=""  />
<input type="hidden" name="contentType" id="contentType" value="RX_DETAILS"  />
<input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"  />
</form>
</div>
</div>

<!-- pop end-->

<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Rx Detail</h4>
      </div>
      <div class="modal-body pat-body" id="message">
       Are you sure you want to delete it.
      </div>
      <div class="modal-footer" style="margin-top:30px; padding:15px;">
		<form id="deleterx-form"
  onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_rxDetail.php','deleterx-form','deleteContent-add',event,'myModal')">
			<input type="hidden" id="patientId" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"/>
            <input type="hidden" id="deleteRxId" name="deleteRxId" />
			<input type="hidden" name="userId" value="<?php echo $_COOKIE['id'];?>" />
			<input type="hidden" id="acquireDate1" name="acquireDate11" />
			<input type="hidden" id="renewalDate1" name="renewalDate"/>
			<input type="hidden"  id="frequency1" name="frequency1" />
			<input type="hidden" id="length1" name="length1"/>
	        <input type="reset" class="btn btn-default" data-dismiss="modal" id="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CLOSE;?>" />
  <input type="submit" style="margin:0px;" value="<?php echo constantAppResource::$COMMON_BUTTON_DELETE;?>"  class="btn btn-primary btnpatlist1" id="deleteBtn" onclick="return  deleteContentConfirm();" />
    <input type="hidden" id="Delete" name="Delete" />
  </form>
      </div>
    </div>
  </div>
</div>
<script>
function controlMenu()
{

	  var arr = new Array();
      var dataVal = JSON.stringify(arr);
      postDataToServer(dataVal, 'ADMIN', 'login', printResult);

}

function printResult(result)
{
	  if (result == null || result.success == false || result.message == "") {} else {
		  var messageJson = JSON.parse(result.message);
		  var availableMenus = [];
		 for (i = 0; i < messageJson.moduleConfigInfos.length; ++i)
			 {
			 	var key = messageJson.moduleConfigInfos[i].moduleConfigKey;
			 	var value = messageJson.moduleConfigInfos[i].moduleConfigValue;
				availableMenus.push($.trim(key));
			}
			hideMenu(availableMenus);
		}
}
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}
function hideMenu(availableMenu)
{
	$('ul#addPatientMenu li').find('a').each(function(){
			var html = $.trim($(this).html());
			if(!availableMenu.contains(html))
			{	
				var resClass = html.split(" ");
				$(this).parents('li').hide();
				$("#headerMenu").find("."+resClass[0]).hide();
			}
		});
}
</script>
<script>
$(document).ready(function()
{
controlMenu();
$("table thead th").data("sorter", false);
	   $("table.libraryTable").tablesorter({
    theme : 'blue',
    // initialize zebra striping and resizable widgets on the table
    widgets: [ "zebra", "resizable" ],
    widgetOptions: {
       resizable: true,
	  sorter: false,
	   resizable_widths : [ '20%', '20%', '20%', '20%', '20%' ]
    }
	
  });


 $("#frequency,#length,#noOfRefills,#refillAllowed").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                // Allow: Ctrl+V
                (event.ctrlKey == true && (event.which == '118' || event.which == '86')) ||  
                // Allow: Ctrl+c
                (event.ctrlKey == true && (event.which == '99' || event.which == '67')) || 
                // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
  
	$("#tableId tbody tr").click(function()
	{
		if($(this).hasClass("selected"))
		{
		$("#tableId tbody tr").removeClass("selected");
		$("#rx-form").hide();
		$("#insert").attr("name","insert");
		$("#submitBtn").html("Save");
		
		$("#acquiredDate").val("");
		$("#renewalDate").val("");
		$("#frequency").val("");
		$("#length").val("");
		
		$("#noOfRefills").val("");
		$("#refillAllowed").val("");
		
		//$("#pdfFile").val("");
		$("#prescriptionId").attr("disabled","disabled");
		$("#prescriptionId").val("");
		$("#newFileName").val("");
		}
		else
		{
		$("#tableId tbody tr").removeClass("selected");
		$(this).addClass("selected");
		var eleTd = $(this).children().siblings();
		var acquiredDate = $(eleTd).eq(0).text();
		var renewalDate = $(eleTd).eq(1).text();
		var frequency = $(eleTd).eq(2).text();
		var length = $(eleTd).eq(3).text();
		var noOfRefills = $(eleTd).eq(4).text();
		var refillAllowed = $(eleTd).eq(5).text();
		var fileName = $(eleTd).eq(6).text();
		var prescriptionId = $(this).attr("id");
		$("#prescriptionId").removeAttr("disabled");
		//var pdfFile = $(eleTd).eq(4).text();
		$("#acquiredDate").val(acquiredDate);
		$("#renewalDate").val(renewalDate);
		$("#frequency").val(frequency);
		$("#length").val(length);
		$("#noOfRefills").val(noOfRefills);
		$("#refillAllowed").val(refillAllowed);
		$("#prescriptionId").val(prescriptionId);
		$("#newFileName").val(fileName);
		//$("#pdfFile").val(pdfFile);
		$("#rx-form").show();
		$("#insert").attr("name","update");
		$("#submitBtn").html("Update");

		}
	
	});
	
	$("#addRxDetail").click(function()
	{
		$("#rx-form").show();
		$("#insert").attr("name","insert");
		$("#submitBtn").html("Save");
		
		$("#acquiredDate").val("");
		$("#renewalDate").val("");
		$("#frequency").val("");
		$("#length").val("");
		$("#tableId tbody tr").removeClass("selected");
		$("#noOfRefills").val("");
		$("#refillAllowed").val("");
		
		//$("#pdfFile").val("");
		$("#prescriptionId").attr("disabled","disabled");
		$("#prescriptionId").val("");
		$("#newFileName").val("");
	
	});
	
	
	$(".edit").click(function()
	{
		var eleTd = $(this).parent().siblings();
		var acquiredDate = $(eleTd).eq(0).text();
		var renewalDate = $(eleTd).eq(1).text();
		var frequency = $(eleTd).eq(2).text();
		var length = $(eleTd).eq(3).text();
		var noOfRefills = $(eleTd).eq(4).text();
		var refillAllowed = $(eleTd).eq(5).text();
		var fileName = $(eleTd).eq(6).text();
		var prescriptionId = $(this).attr("id");
		$("#prescriptionId").removeAttr("disabled");
		//var pdfFile = $(eleTd).eq(4).text();
		$("#acquiredDate").val(acquiredDate);
		$("#renewalDate").val(renewalDate);
		$("#frequency").val(frequency);
		$("#length").val(length);
		$("#noOfRefills").val(noOfRefills);
		$("#refillAllowed").val(refillAllowed);
		$("#prescriptionId").val(prescriptionId);
		$("#newFileName").val(fileName);
		//$("#pdfFile").val(pdfFile);
		$("#rx-form").show();
		$("#insert").attr("name","update");
		$("#submitBtn").html("Update");
	
	});
	
$( "#acquiredDate" ).datepicker({
		showOn: "button",
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		maxDate: new Date(),
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+0"
});	
	
	 	
$( "#renewalDate" ).datepicker({
		showOn: "button",
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		minDate: new Date(),
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+0"
});	 	
	
});

function deleteContent()
{

	//$('tr.active-row').remove();
	var currentContentId=$('tr.selected').attr('id');
	
	if(currentContentId === undefined  || currentContentId === "")
	{
		$("#message").html("Please select a content to delete.");
		$("#deleteBtn").hide();
	}
	else{
		var acquireDate=$('tr.selected').attr('acquireDate');
		var renewalDate=$('tr.selected').attr('renewalDate');
		var frequency=$('tr.selected').attr('frequency');
		var length = $('tr.selected').attr('length');
		$("#deleteRxId").val(currentContentId);
		$("#acquireDate1").val(acquireDate);
		$("#renewalDate1").val(renewalDate);
		$("#frequency1").val(frequency);
		$("#length1").val(length);
		$("#message").html("Are you sure you want to delete it.");
		$("#deleteBtn").show();
	}
}
function deleteContentConfirm()
{
var rowId=$("#deleteRxId").val();
$("#"+rowId).css('display','none');
$("#rx-form").hide();
return true;
}

$(".aboutHref").click(function()
{
	$(".focus").focus();
});

function validateForm(ele,e)
{
	var acquiredDate=$("#acquiredDate").val();
	var renewalDate = $("#renewalDate").val();
	var length = $('#length').val();
	var frequency = $('#frequency').val();
	var newFileName = $("#newFileName").val();
	var noOfRefills = $('#noOfRefills').val();
	var refillAllowed = $('#refillAllowed').val();
	var pdfFile = $('#pdfFile').val();
	var type = $("#insert").attr("name");
	var msg = "";
	$("form input").removeClass("focus");
	if(acquiredDate == "" || acquiredDate == null)
	{
		msg += "Acquired date is required."
		$("#acquiredDate").addClass("focus");
	}
	else if(renewalDate == "" || renewalDate == null)
	{
		msg += "Renewal date is required.";
		$("#renewalDate").addClass("focus");
	}

	else if(newFileName == "" || newFileName == null)
	{
		msg += "File is required.";
		$("#newFileName").addClass("focus");
	}
	else if(length == "" || length == null)
	{
		msg += "Length is required.";
		$("#length").addClass("focus");
	}
	else if(pdfFile == "" && type == "insert")
	{
		msg += "File is required.";
		$("#newFileName").addClass("focus");
	}

	

	else if(frequency == "" || frequency == null)
	{
		msg += "Frequency is required.";
		$("#frequency").addClass("focus");
	}

	else if(noOfRefills == "" || noOfRefills == null)
	{
		msg += "No. of refills  is required.";
		$("#noOfRefills").addClass("focus");
	}

	else if(refillAllowed == "" || refillAllowed == null)
	{
		msg += "Refill allowed is required.";
		$("#refillAllowed").addClass("focus");
	}

	if(msg != "")
	{
				 $("#aboutPopup").show();
  				 $("#About_fadediv").show();
				 $(".cart_page").html("Rx Detail");
   				 $(".txt_div").html(msg);
        		$('body').addClass('modal-open');

		return false;
	}
	else
	{
		console.log('in else');

		if(pdfFile == "" && type == "update")
		{
		postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_rxDetail.php','add-rxDetail-form','menu-content',e);
		}
		else
		{
		postContentMultipartForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/content',ele, e);
		}
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
        data:formData ,//$('#add-rxDetail-form').serialize(),
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
				 $(".cart_page").html("Rx Detail");
   				 $(".txt_div").html("Incorrect File! Please choose different file or upload file with different name.");
        		$('body').removeClass('modal-open');
        		$('.modal-backdrop').remove();
        },
        complete: function() {
			hideLoading();
			console.log('completed')
			openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_rxDetail.php','patientId=<?php echo $patientInfo->{patientId} ?>','menu-content',e,this)
		 }
    });
}

 $('#pdfFile').change( function() {
  if ($(this).val() != '') {
    var file = $(this)[0].files[0];
    var fileName = file.name;
    var fileExt = fileName.split('.').pop();
    $("#newFileName").val(fileName);
  }
});


function openRxDetail(contentId)
{
	var contentHref=contentId;
	window.open('show_content.php?rxDetail='+contentHref,'video','top=150, left=352, width=700, height=500, toolbar=no, menubar=no, location=no, scrollbars=no, resizable=no');
	return false;
}
</script>

<style>
.FormRX input#acquiredDate {
  width: 81%;
}
.FormRX img.ui-datepicker-trigger {
  width: 31px;
  margin-left: 5px;
}

.FormRX input#renewalDate {
  width: 81%;
}
.nmaePatFormat {
    float: left;
    font-size: 15px;
    padding-left: 35px;
    padding-top: 4px;
}
.content_Library_addeddate_tittle {
    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #e8e8ea 0%, #eeeef0 3%, #ededef 5%, #e8e7ec 8%, #e9e8ed 11%, #e3e2e8 16%, #e4e3e9 19%, #dadbe0 30%, #cbcbd7 54%, #bab9c7 78%, #bab9c9 100%) repeat scroll 0 0;
    height: 40px;
}
</style>
