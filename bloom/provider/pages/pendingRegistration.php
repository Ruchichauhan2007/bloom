<?php
include('controller/pendingRegistration_controller.php');?>

<style>
.insurance {
    background: none repeat scroll 0 0 #f4f4f4;
    border-radius: 5px;
    box-shadow: 0 4px 0 0 #a6a9b8;
    float: left;
    margin-left: 7px;
    margin-top: 7px;
    padding: 0 0 8px;
    width: 98%;
}
.insuranceDOB p {
    color: #4a4a4a;
    font-size: 15px;
}
.insuranceDOB h1 {
    color: #4a4a4a;
    font-size: 25px;
    margin: 8px 0;
}
.col-lg-3.insuranceBttn {
    text-align: right;
}
.closing.bttnGrp {
    float: right;
    margin-right: 12px;
    margin-top: -39px;
}
.employeeDetail {
    background: none repeat scroll 0 0 #f0f0f0;
    float: left;
    padding: 10px 0 8px;
    width: 100%;
}
.insuranceDetails {
    float: left;
    margin-top: 6px;
    width: 100%;
}
.insuranceDetails > h1 {
    background: none repeat scroll 0 0 #e2e1e1;
    color: #434343;
    font-size: 20px;
    font-weight: normal;
    padding: 9px 0;
    text-align: center;
}
.insuranceDetails > p {
    padding: 15px 70px;
	color:#010101;
	border-bottom:1px solid #e2dfdf;
	font-size: 15px;
}
.insuranceDetails > a {
    float: left;
    padding: 14px 87px 10px;
    text-decoration: underline;
}
.insuranceDOB > a {
    text-decoration: underline;
}
.moreDetail{
cursor: pointer;
}
.lessDetail{
cursor: pointer;
}
.moreDetailFade
{
opacity:0.2;
}
</style>
 <?php
$entityUtil = new EntityUtil();
 $statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);

 echo pendingApplicantCards($pendingApplicant,$statesInfo) 
 
 ?>
<script type="text/javascript">
	$(document).ready(function(){
	var PendingPatientTrue ="PendingPatientTrue";
	$(".patient_detail_link").click(function()
	{
	var peddingPatientId=$(this).attr('id');
	localStorage["PendingPatientTrue"] = PendingPatientTrue;	
	localStorage["peddingPatientId"] = peddingPatientId;	
	});
	
	
	$('.address').html("");
	
		$(".moredetail").click(function(){
			var id = $(this).attr('id');
			var splittedId = id.split("-");
			var pk = splittedId[1];
		  $("#insuranceDetails-"+pk).slideDown();
		  $("#moredetail-"+pk).css("display","none")
		});

		$(".lessDetail").click(function(){
			var id = $(this).attr('id');
			var splittedId = id.split("-");
			var pk = splittedId[1];
		  $("#insuranceDetails-"+pk).slideUp();
		  $("#moredetail-"+pk).css("display","block")
		});

		$(".approvePatient").click(function(){
			var id = $(this).attr('id');
			var splittedId = id.split("-");
			var pk = splittedId[1];
			updateCard(pk,'insert')
		});

		$(".rejectPatient").click(function(){
			var id = $(this).attr('id');
			var splittedId = id.split("-");
			var pk = splittedId[1];
			updateCard(pk,'delete')
		});
	});
	function updateCard(pk,command)
	{
		$.ajax({
	         url: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/pendingRegistration.php",
	         type: 'POST',
	         data: "command="+command+"&registrantId="+pk,
	         crossDomain: true,
	         beforeSend: function() {
	             showLoading()
	         },
	         success: function(result) {
			 if(command=="insert")
			 {
	             $("#menu-content").html(result);
			 }
	        	 $('#insurance-'+pk).remove();
	         },
	         error: function() {
	             console.log('error');
	         },
	         complete: function() {
	             hideLoading();

	         }
		 	});
	}
</script>