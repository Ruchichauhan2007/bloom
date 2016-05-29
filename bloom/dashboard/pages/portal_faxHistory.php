<?php
  include 'controller/portal_faxHistory_controller.php';?>
  <?php
  $userType = strtoupper($_COOKIE['type']);
	   if (isset ($_REQUEST['type'] ) or $userType == "PATIENT")
	    {
			if($userType == "PATIENT")
			{
			$patientId = $_COOKIE['id'];
			}
			else{
			$patientId = $_REQUEST['patientId'];
			}
			 $paramArray = array();
			 $entityUtil = new EntityUtil();
			$paramArray[0] = $patientId;
			$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
			//var_dump($patientInfo);
			
			$paramArray[0] = $patientId;
			$getAllPatientFaxes = $entityUtil->getObjectFromServer($paramArray, "getAllPatientFaxes", VMCPortalConstants::$API_EMR);
			
		}
		?>
  <link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/NPI_Style.css">
<div class="dashboard_top_nav">
<?php
if (isset ( $_REQUEST['type']) or $userType == "PATIENT") {
?>
  <ul id="addPatientMenu">
    <li  id="profile"><a href="#"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_PROFILE;?></a></li>
	
	
	<li  id="Insurance"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo[0]->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/insurance.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&dob=<?php echo $dateOfBirthStr ?>&email=<?php echo $emailaddressinfo[0]->{emailAddress}; ?>&phone=<?php echo $phoneInfo[0]->{phoneNumber}; ?>&type=EDIT&edit=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$INSURANCE;?></a></li>
	
    <li  id="device"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICES;?></a></li>
	
    <li  id="device_schedule"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$DASHBOARD_TEXT_DEVICE_SCHEDULE;?></a></li>
	<!--<li><a href="#" style="cursor: not-allowed;">Supplies</a></li>-->
       <li><a href="#"  class="active" onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" ><?php echo constantAppResource::$PRESCRIPTION;?></a></li>
	
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
<li><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_rxDetail.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_rxDetail.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" ><?php echo constantAppResource::$RX_DETAIL;?></a></li>
<li class="active"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_faxHistory.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"data="openPageWithAjax('../../dashboard/pages/portal_faxHistory.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)"><?php echo constantAppResource::$FAX_HISTORY;?></a></li>
</ul>
<div class="table-responsive">
<table class="table table-striped" id="tableId">
      <thead>
        <tr>
          <th><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/TopBottomBlack.png" /></th>
          <th>Date</th>
          <th>Fax</th>
          <th>NPI</th>
          <th><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/PdfIconBlack.png" /></th>
          <th>Remove</th>
        </tr>
      </thead>
      <tbody>
      <?php 
      foreach($getAllPatientFaxes as $getPatientFaxes)
			{
			
				$dateUtil = new DateUtil();
				$faxNumber = $getPatientFaxes->{faxNumber};
				$faxId =$getPatientFaxes->{patientFaxId};
				$NPI = $getPatientFaxes->{nPINumber};
				$fileName = $getPatientFaxes->{fileName};
				$inOut = $getPatientFaxes->{inOut};	
				$date = $dateUtil->formatDatetoStr($getPatientFaxes->{createTimeStamp}); ?>			
				
			
                <tr>
                <?php
					if($inOut == "INCOMING")
					{
					?>
                  	<th scope="row"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/BottomArrow.png" /></th>
                  	<?php
					}
					else if ($inOut == "OUTGOING")
					{
					?>
                      <th scope="row"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/TopArrow.png" /></th>
                    <?php					
					}
					else
					{
					?>
						<th scope="row"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Wrong.png" /></th>
                     <?php
					}
					?>
                  <td><?php echo  $date ;?></td>
                  <td><?php echo  $faxNumber ;?></td>
                  <td style="cursor:pointer"><a onClick="openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/pages/show_npi.php?patientId=<?php echo $patientInfo->{patientId}; ?>','NpiId=<?php echo $NPI;?>','showNpi',event,'this')" data-toggle="modal" id="showNPI" name="showNPI" data-target="#myModal12"><?php echo $NPI;?></a></td>
                  <td style="cursor:pointer" onclick="openRxDetail(<?php echo $faxId; ?>);"><a href="javascript:void(0);"><?php echo  $fileName; ?></a></td>
                  <td><a href="#" class="deleteFax" id="<?php echo $faxId;?>" ><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/CrossNPI.png" data-target="#myModal" data-toggle="modal" /></a></td>
                </tr>        
		  <?php
          }
          ?>
       
      </tbody>
    </table>



</div><div class="content_lib_button"></div>
</div>
</div>
</div>
<div class="modal fade" id="myModal12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modelContent">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img class="close" align="right" src="../images/close.jpg"></span></button>
        <h4 class="modal-title" id="myModalLabel">NPI Detail</h4>
      </div>
      <div class="modal-body" id="showNpi">
       
        
      </div>
      <div class="modal-footer">
        <div class="col-lg-12"><button type="button" class="btn btn-default btn-primary" style="  background-color: #03aeff;
  border-bottom: solid 5px #0395d1;
  border-radius: 7px;
  color: #fff;
  font-size: 19px;
  border-left: none;
  border-top: none;
  border-right: none;
  cursor: pointer;
  padding: 10px 20px;
  margin: 5px;" data-dismiss="modal">Close</button></div>
      </div>
    </div>
  </div>
</div>





<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pending Fax</h4>
      </div>
      <div class="modal-body pat-body" id="message">
       Are you sure you want to delete it.
      </div>
      <div class="modal-footer" style="margin-top:30px; padding:15px;">
		<form id="deletefax-form"
  onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_faxHistory.php','deletefax-form','menu-content',event,'myModal')">
			<input type="hidden" id="patientId" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"/>
            <input type="hidden" id="deleteFaxId" name="deleteFaxId" />
			<input type="hidden" name="userId" value="<?php echo $_COOKIE['id'];?>" />
	        <input type="reset" class="btn btn-default" data-dismiss="modal" id="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CLOSE;?>" />
  <input type="submit" style="margin:0px;" value="<?php echo constantAppResource::$COMMON_BUTTON_DELETE;?>"  class="btn btn-primary btnpatlist1" id="deleteBtn" />
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
	$("#tableId tbody tr").click(function()
	{
	
	if($(this).hasClass("selected"))
	{
		$("#tableId tbody tr").removeClass("selected");
	}
	else{
	$("#tableId tbody tr").removeClass("selected");
	$(this).addClass("selected");
	}
	
	});
	
	
	$(".deleteFax").click(function()
	{
		var deleteFaxId=$(this).attr("id");
		$("#deleteFaxId").val(deleteFaxId);
	
	}); 	
	
});


function openRxDetail(contentId)
{
	var contentHref=contentId;
	window.open('show_content.php?rxDetail='+contentHref,'video','top=150, left=352, width=700, height=500, toolbar=no, menubar=no, location=no, scrollbars=no, resizable=no');
	return false;
}
</script>

<style type="text/css">
#tableId thead {
    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #e8e8ea 0%, #eeeef0 3%, #ededef 5%, #e8e7ec 8%, #e9e8ed 11%, #e3e2e8 16%, #e4e3e9 19%, #dadbe0 30%, #cbcbd7 54%, #bab9c7 78%, #bab9c9 100%) repeat scroll 0 0;
}
</style>

<style>
.ADD_Detail_NPI.table-responsive h2 {
    border-bottom: 1px solid #ccc;
    font-size: 15px;
    margin-bottom: 5px;
    padding-bottom: 5px;
}
.btnedit {
    margin-top: 15px;
    padding-right: 28px;
    text-align: right;
}
.btnedit1{
	padding-right: 43px;
}
.nmaePatFormat {
    float: left;
    font-size: 15px;
    padding-left: 35px;
    padding-top: 4px;
}
#moredetail,#lessDetail {
    cursor: pointer;
}
.input-group-addon button#npiSearchPrescription {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 0;
}
#npi-form .input-group-addon {
    padding: 0 17px;
}
.LeftFormRX span.input-group-addon {
  padding: 0px 16px;
}
.LeftFormRX .glyphicon-search:before {
  font-size: 17px;
  color: #ccc;
}
#npiSearchPrescription .glyphicon-search:before {
  font-size: 17px;
  color: #ccc;
}
.content_lib_button {
    float: left;
    width: 100%;
}
.modal-body .name {
    font-size: 15px;
}
.modal-body .moredetail {
  float: left;
  font-size: 14px;
  text-align: right;
  width: 100%;
}

.modal-body .lessDetail {
  float: left;
  font-size: 14px;
  text-align: right;
  width: 100%;
  padding: 0 12px;
}


.modal-body .ADD_Detail_NPI.table-responsive {
  border: 0 none;
  margin: 10px 0px 0px;
  min-height: 93px;
}
.ADD_Detail_NPIMain {
  float: left;
  width: 100%;
  min-height: 50px;
}
#myModal12 .close {
    margin-right: 0;
    margin-top: -1px;
    opacity: 1;
}

.ADD_Detail_NPI p {
  padding-bottom: 12px;
}
.modal-content.modelContent .modal-body {
    overflow:hidden;
	max-height: 400px;
    overflow-y: scroll;
}
.Fax-history .table-responsive {
	background:url('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Screen_BG.png') repeat-x;
	background-size: 909px 314px;
	float: left;
    max-height: 274px !important;
    min-height: 274px !important;
    overflow-x: hidden;
    overflow-y: scroll;
    width: 100%;
}
.PendingFax tbody {
  text-align: center;
}
</style>