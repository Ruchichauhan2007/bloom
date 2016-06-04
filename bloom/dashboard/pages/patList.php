<?php
include('controller/portal_patientList_controller.php');
$deviceConfigId = $_POST["deviceConfigId"];
$vitalType = $_POST["vitalType"];

?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css">
<?php
	$page = "";
	$setPatient = $_POST['selectPatient'];

	$selectPatient = FALSE;
	if(isset($_GET["param"]) OR $setPatient == true)
	{ 
		$selectPatient = TRUE;
		$page = "selectPatient";

		if( $setPatient == true)	$redirectTo  = "/login/pages/portal_dashbaordWithPatient.php";
	}

	if(isset($_GET["page"]))
	{
		$page = $_GET["page"];

		if( $page == "Messages")	$redirectTo  = "/messages/pages/messages.html";
		else if( $page == "Track Biometrics")	$redirectTo  = "/vitals/pages/setPath.php";
		else if( $page == "Learn")	$redirectTo  = "/portalLearn/pages/portal_learn.php";
		else if( $page == "Patient Care")	$redirectTo	 = "/patientcare/pages/patient_care.php";
		else if( $page == "Reports")	$redirectTo  = "/reports/pages/report_weekly_dashboard.php";
		else if( $page == "Lab Metrics")	$redirectTo	 = "/labMetrics/pages/labmetrics_graph.html";
		else if( $page == "Supplies")	$redirectTo	 = "/dashboard/pages/portal_supplies.php";
		else if( $page == "Survey")	$redirectTo	 = "/survey/pages/showSurvey.php";
		else if( $page == "Faxes")	$redirectTo	 = "/provider/pages/pending_fax.php?selectPatientFax=true";
		else if( $page == "selectPatient")	$redirectTo  = "/login/pages/portal_dashbaordWithPatient.php";
		else{
			$redirectTo  = "/login/pages/portal_dashbaordWithPatient.php";
		}
	}
$currentPage = $_REQUEST["currentPage"];
if($currentPage == "" && $setPatient != true)
{
$selectPatient = false;
}
?>

            <?php  echo addPatientsCards($entityDetailInfos, "ALL", $selectPatient); ?>
<script type="text/javascript">

var taHTML = $('#PatientList_part_bg_all').html();
var showScroll = $("#getScroll").val();
var counter = 0;



	$(".editbtn").click(function(){
		
		var id= $(this).attr('id').split('_');
		$('#menu-content-container li').attr('ref', id[1]);
	});
	
      $('#mCSB_1 div.PatientList_part_bg').click(function(event){
		  if(event.target.nodeName == "A"){
			  
		  }
		  else{
		  <?php if($redirectTo !="")
		  {?>
			setPatientValue($(this).attr('id'),'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom<?php echo $redirectTo;?>');
		<?php
		  }else{?>
		  setPatientValue($(this).attr('id'),'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/login/pages/portal_dashbaordWithPatient.php');
		  <?php}?>
		  }
			// hidden values in header
			var image = $(this).find('img').attr('src');
			var name = $(this).find('h2').text();
			var id = $(this).attr('id');
			$("#edit_"+id).show();
			$("#delete_"+id).show();
			$('#contextPatientName').val(name);
			$("#headerMenu li").attr("ref",id);
			$("ul.withPatient li ").find('a.patient').attr("id",id);

			
			
			
      $('#contextPatientId').val(id);
			$('#contextPatientImage').val(image);
            $('#patientName').html(name);
		$("ul.withoutPatient").hide();
	 	$("ul.withPatient").show();
		$("div.Patient .page-header span").text(name);


		});
</script>
