<?php
include('controller/pending_fax_controller.php');
//include '../../common/pages/fax_script.php';
			// $entityUtil = new EntityUtil();
			//$getAllPendingFaxes = $entityUtil->getObjectFromServer("BLANK", "getAllPendingFaxes", VMCPortalConstants::$API_EMR);
			//var_dump($getAllPendingFaxes);	

?>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/NPI_Style.css">
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script>
$(document).ready(function(){
//changeFax();
$("#getpatientId").val($("#contextPatientId").val());


$("#faxes").change(function(){
console.log('clicked');
changeFax();
		});
		});
function changeFax()
  {
  	  var faxes = $("#faxes").val();
  	 	  if(faxes == "Select a Patient")
  			{
  	 		openPageWithAjax('../../dashboard/pages/portal_patientList.php?param=SELECTPATIENT&currentPage=1&page=Faxes','selectPatient=true&currentPage=1&page=Faxes','menu-content','');
  			}
  	 
  }
</script>

<style>
#pagination .wrapper1 {
    float: right;
    margin: -101px 0 0;
    padding-right: 36px;
    position: relative;
    text-align: right;
    width: auto;
    z-index: 9999;
}
.content_lib_button {
    position: relative;
    z-index: 0;
}
</style>
<div class="col-md-8 padd-top20">
<div class="col-lg-12">
<div class="col-md-12 PendingFax">
<div class="row">
<form action="" style=" margin-top: 15px;" name="fax-form" id="fax-form" onSubmit="postFormWithPagination('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/pending_fax.php','fax-form','menu-content',event)" method="post">
<div class="col-md-4" style="padding-right:0px;">
<select id="faxes" name="faxes" class="form-control">
<option value="Pending Faxes" selected="selected">Pending Faxes</option>
<option   value="All Faxes">All Faxes</option>
<option value="Select a Patient"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_SELECT_PATIENTS;?></option>
</select>

</div>
<div class="col-md-3"  style="padding-right:0px;">
<div class="form-group">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' placeholder="Start Date" class="form-control" id="startDate" name="startDate"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
</div>
<div class="col-md-3" style="padding-right:0px;">
<div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' placeholder="End Date" class="form-control" id="endDate" name="endDate"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
</div>
<div class="col-md-2" style="padding-right:0px;">
<button class="btn btn-primary" style="padding: 8px 23px; border-radius: 0;" name="searchFax" id="searchFax"><span class="glyphicon glyphicon-search" ></span></button>
<input type="hidden" name="searchFax" />
<input type="hidden" name="getpatientId" id="getpatientId" />
<input type="hidden" name="currentPage"  value="1" />

</div>
</form>
</div>
<div class="table-responsive" id="loadFaxes">
<table class="table table-striped" id="tableId">
      <thead>
        <tr>
          <th><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/TopBottom.png" /></th>
          <th>Date</th>
          <th>Fax</th>
          <th><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/PdfIcon.png" /></th>
          <th>Patient</th>
        </tr>
      </thead>
      <tbody>
      <?php
	 echo getAllFaxes($getAllPendingFaxes);
	  ?>
       </tbody>
    </table>

</div><div class="content_lib_button"></div>

<div class="bttnSubmit">
<form method="post"  id="sendFax-form" onSubmit="postFormWithPagination('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/pending_fax.php','sendFax-form','menu-content',event)">
<button class="btn btn-success" id="pendingFaxSubmit" type="button" name="assign"><span>
<img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/Submiticon.png" /></span> Submit</button>
<input type="hidden" name="faxNumber" id="faxNumber" />
<input type="hidden" name="faxId" id="faxId" />
<input type="hidden" name="patientId" id="patientId" />
<input type="hidden" name="assign" id="assign" />
 <input type="hidden" name="currentPage"  value="1" />

<!--
<input type="hidden" name="patientName" id= "patientName" value=""  /> 
<input type="hidden" name="fileName" id= "fileName" value=""  /> 
-->  </form>
</div>

</div>
</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/Cross_Modal.png" /></span></button>
        <h4 class="modal-title" id="myModalLabel">Patient  Search</h4>
      </div>
      <div class="modal-body">
       <div class="form-group">
  <div class="col-md-12 searchformone">
    <div class="input-group">
    
    <form method="post" id="npi-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/showPatientResult.php?updateFaxId=','npi-form','searchResult',event)">
      <input id="appendedtext" name="searchStr" class="form-control" placeholder="Patient Name" type="text">
       <input type="hidden" name="faxId"  id="faxIds" value=""/>
     <span  class="input-group-addon"> <button name="npiSearch" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true" id="npiSearch"></span></button></span>
    
      </form>
    </div>
    </div>
    <div id="searchResult">
    <h1 class="headingPopNPI">Search Result :</h1>
   
  
    </div>
 </div>   
      </div>
      
      <div class="modal-footer" >
          <form  method="post" id="attach-form1" onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/showPatientResult.php','attach-form1','searchResult',event,'myModal')">
      <input type="hidden" name="faxPID"  id="faxPID" />
      <input type="hidden" name="faxId"  id="faxId" value=""/>
      <input type="hidden" name="attach" id="attach" value="" />
      
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="npiNameAttach" disabled="disabled">Attach</button>
      </div>
      </form>
      </div>
    </div>
  </div>
</div>
<script>

$(document).ready(function()
{
$(document).on('click','div.selectPatient',function ()
{
$("div.selectPatient").removeClass("selectedPatient");
$(this).addClass("selectedPatient");
$("#npiNameAttach").removeAttr("disabled");
});

$("#pendingFaxSubmit").css({"opacity":"0.33"});
$("#pendingFaxSubmit").attr("disabled","disabled");
	$("#tableId tbody tr").click(function()
	{
			$("#tableId tbody tr").removeClass("selected");
			$(this).addClass("selected");
			$("#pendingFaxSubmit").css({"opacity":"1"});
			$("#pendingFaxSubmit").removeAttr("disabled");
			var patientName = $(this).attr("name");
			var fileName = $(this).attr("fileName");
			var faxNum = $(this).attr("faxNum");
			var faxId = $(this).attr("faxId");
			var patientId = $(this).attr("patientId");
			
			$("#faxNumber").val(faxNum);
			$("#patientName").val(patientName);
			$("#fileName").val(fileName);
			$("#patientId").val(patientId);
			$("#faxId").val(faxId);

			
	});
	
	$("#pendingFaxSubmit").click(function()
	{
		$("#patientId").val($("tr.selected").attr('patientid'));
		$("#faxId").val($("tr.selected").attr('faxid'));
		$("#sendFax-form").submit();
	});
	
	
	$("a.searchNpiName").click(function()
	{
		var npiName = $(this).text();
		$("#appendedtext").val(npiName);
	});
	
	$("#npiNameAttach").click(function()
	{
	$("tr.selected").css({"font-style": "italic"});
	var patientName = $("div.selectedPatient .SearchInfo p").eq(0).find(".col-sm-8").text();
	$("tr.selected td a.searchNpiName").text(patientName);
	$("tr.selected").attr('name',patientName);
	$("tr.selected").attr('patientid',$("#faxPatientId").val());
	var clickValue=$("tr.selected td a.searchNpiName").attr("onclick");
	var clickValue1=clickValue.split(",");
	var patientValue = clickValue1[1].split("&");
	var patientnames = patientValue[0];
	patients = patientnames.split("=");
	var clickFunction = clickValue1[0]+","+patients[0]+"="+patientName+"&"+patientValue[1]+","+clickValue1[2]+","+clickValue1[3]+","+clickValue1[4];
	console.log(clickFunction);
	var clickValue=$("tr.selected td a.searchNpiName").attr("onclick",clickFunction);
	});	
	
});
function openPendingFax(contentId)
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
.SearchInfo p {
    float: left;
    width: 100%;
}
/*#npi-form #appendedtext {
    float: left;
    width: 80%;
}
.input-group {
    float: left;
    width: 100%;
}
#npi-form > button {
    background: blue none repeat scroll 0 0;
    border: 0 none;
    color: #fff;
    margin-top: 0;
    padding: 7px 0;
    width: 20%;
}*/
.modal .close img {
    margin: 3px 0;
    width: 37px;
}
.searchformone .input-group-addon button {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    padding: 3px 6px;
}
.modal-body .input-group {
    margin-bottom: 10px;
}
.searchformone .input-group {
    width: 100%;
}
.searchformone input#appendedtext {
  width: 90%;
}
.PendingFax .table-responsive {
	/*background:url('<?php //$_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Screen_BG.png') repeat-x; */
	background-size: 605px 286px;
	float: left;
    max-height: 274px !important;
    min-height: 274px !important;
    overflow-x: hidden;
    overflow-y: scroll;
    width: 100%;}
.content_lib_button {
    float: left;
    width: 100%;
	margin-bottom:20px;
}
#tableId.table-striped > tbody > tr:nth-of-type(2n+1) {
    background-color: #f9f9f9  !important;
}
div.selectedPatient{
background-color:#4b79a1 ;
color:#FFFFFF;
}
</style>
<script type="text/javascript">
            $(document).ready(function () {
                $('#datetimepicker1').datetimepicker(
				{
				 pickTime: false,
				 maxDate: new Date()

				});
                 $('#datetimepicker2').datetimepicker(
				 {
				 pickTime: false,
				  maxDate: new Date()
				});
            });
        </script>
<?php
if(isset($_POST["searchFax"]))
{
		$faxFilterType = $_POST["faxes"];
		$endDate = $_POST["endDate"];
		$startDate = $_POST["startDate"];
?>
<script type="text/javascript">
$(document).ready(function () {
$('#startDate').val("<?php echo $startDate;?>");
$('#endDate').val("<?php echo $endDate;?>");
$('#faxes').val("<?php echo $faxFilterType;?>");
});
</script>
<?php
}
if(isset($_REQUEST['selectPatientFax']))
{
?>
<script type="text/javascript">
$(document).ready(function () {
$("#faxes").val("Select a Patient");
});
</script>
<?php
}
?>        