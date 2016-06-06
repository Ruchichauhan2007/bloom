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
<script type="text/javascript">
var taHTML = $('#PatientList_part_bg_all').html();
var showScroll = $("#getScroll").val();
var counter = 0;
//$('#menu-content').bind('scroll', function(e)
//{
	//	var win = $(window);
	// Each time the user scrolls
	    // win.scroll(function(e) {
		// var action = $("a.nextPage").attr("action");
		// var params = $("a.nextPage").attr("params");
		// var resultingDivId = "PatientList_part_bg_all";

	
		// // End of the document reached?
		// if ($(document).height() - win.height() == win.scrollTop()) {
			// console.log( win.scrollTop());
			// //$('#loading').show(); 
		// //if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)
		// //{
		// if(showScroll)
		 // { console.log("true"+counter);
		 		// if(counter == 0)
				// {	
			// //	openPagewithScroll(action,params,resultingDivId,e,"a.nextPage");
				
				// }
				// counter++;
				
		 // }		
// }
// });




	window.location.hash = '/patient_list';
  //$('#patientList').change();
	$(function() {

		// append navigation

$(document).ready(function()
{

	$("#patientSearch").attr("disabled", "disabled");
	
			 
});
	

		$("#searchInput").on("keyup change blur", function(e){
			 if( this.value.length > 3 ) 
			 {
	        var searchText = $(this).val().toLowerCase();
			 $("#patientSearch").removeAttr("disabled");
	        var text = searchText.split(" ");
			var selectVal = $('#patientList').val();
			var selection;
		//	if(selectVal === "MYPATIENT")
			//{
			//	selection = $('#PatientList_part_bg_mypatient').find('div.PatientList_part_bg');
			//}
			//else
			//{
				selection = $('#PatientList_part_bg_all').find('div.PatientList_part_bg');
			//}

	        $( selection ).each(function( index ) {
				var card = $(this);
	            var thisSearchText = $(card).find('div.patient_address').text().toLowerCase();
				var hasText = true;

				for(i = 0; i < text.length; i++)
				  {
					  var splitText = $.trim(text[i]);

						if(splitText != null && splitText != "" && e.which != 32 && splitText != " " && splitText.length>0)
			            {
			            	if(thisSearchText.indexOf(splitText) < 0) {
			 	               hasText = false;
			 	            }
			            	else
			            	{
				            	hasText = true;
				            }
			            }
				  }

				if(!hasText)
					{
		               //$(card).fadeOut(500);
		            }
	            else
		            {
		               $(card).show();
		            }

	            if(e.which == 13)
		         {
	            	$('#patientSearch').click();
		         }
			
	        });
			 }
			 else{ $("#patientSearch").attr("disabled", "disabled"); }
		});
		//$('#PatientList_part_bg_all').hide();
		/*$('#patientList').change(function(){
			if($('#patientList').val() == 'ALL') {
				$('#PatientList_part_bg_all').show();
				 $('#PatientList_part_bg_mypatient').hide();
				 $("#searchInput").keyup();

			} else {
				$('#PatientList_part_bg_all').hide();
				$('#PatientList_part_bg_mypatient').show();
				$("#searchInput").keyup();

			}

    });*/


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
			var name = $(this).find('h4').text();
			var id = $(this).attr('id');
			$("#edit_"+id).show();
			$("#delete_"+id).show();
			$('#contextPatientName').val(name);
			$("#headerMenu li").attr("ref",id);
			$("ul.withPatient li ").find('a.patient').attr("id",id);
			

			
			
			
      $('#contextPatientId').val(id);
			$('#contextPatientImage').val(image);
            $('#patientName').html(name);
			$("patient .page-header .title").text(name);
			setTimeout(patientName(), 5);
		$("ul.withoutPatient").hide();
	 	$("ul.withPatient").show();
		$("div.Patient .page-header span").text(name);


		});

		$('#patient-delete-button').click(function(e){
		var patientId= $(this).attr('delete-id');
		$('#'+patientId).hide();
		openWithAjaxAndClosePopup('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_patientList.php','delete=true&patientId='+patientId,'menu-content',e)

		});
});
function patientName()
 {
	 if($('#contextPatientName').val() != "")
	 {
		$('#patientName').text($('#contextPatientName').val());
		//$('#allPats').hide();
		
var patientName = $('#patientName').text();
var patName ;
if(patientName.length > 11)
{
 patName = patientName.substring(0,11)+"..";
 }
 else
 {
 	patName = patientName;
 }
$('#patients option[value="selectedPatient"]').show();
$('#patients option[value="selectedPatient"]').text(patName);
//$("#patients").append('<option value="'+patientName+'">'+patientName+'</option>');
$("#patients").prop("selectedIndex", 3); 
$('#patImage').show();
$('#patsImages').hide();
$("#patients").show();



	 }
	 else
	 {
		//$('#allPats').show();
		//$('#selectedPat').hide();
		$('#patImage').hide();
		$('#patsImages').show();

	 }
 }
function deletePatient(patientId)
{
	$("#patient-delete-button").attr('delete-id',patientId)
	//$('#patientDeleteModal').modal();
}


function getChar(ele)
{
	var char = $(ele).val();
	openPageWithAjax('../../dashboard/pages/portal_patientList.php','checkChar='+char,'menu-content',event,this);
}
</script>
<style>
.activePage
{
font-weight:bold;
}

.PatientList_part_bg:hover {
    opacity: 1;
    background-color: #f5f5f5;
}
.edit_sub_button{ 
display: none;
}
.PatientList_part_bg:hover .edit_sub_button{
display : block;
}

</style>
<div class="col-md-8 padd-top20">
    <div class="dashboard_patient_rightpart card-container">
      <div class="dashboard_patient_rightpart_bg">
        <div class="learn_patient_content_align">

	 <?php // if($selectPatient === TRUE){?>
			
	 <?php//}
	// ?>




           <span class=" custom-dropdown custom-dropdown--white" ></span>
        </div>
      </div>

<div class="compare_models mCustomScrollbar _mCS_1">
     <div class="mCustomScrollBox mCS-light-thin mCS-mouse-over" id="mCSB_1" style="position:relative; height:100%; max-width:100%;">

		      <div class="dashboard_box_bg">

		<?php if($selectPatient === TRUE){?>
			<div class="dashboard_box_bg_text" style="font-size:24pt;padding-top:20px;padding-left:20px;"><?php echo constantAppResource::$DASHBOARD_TEXT_PORTAL_SELECT_PATIENT;?></div>
		<?php }else{?>
			<div class="dashboard_box_bg_text">
				<span class="number-of-listing"><?php echo count($entityDetailInfos); ?> Patients</span>				
			</div>
		<?php }?>

      </div>
         <div class="patientList_parent_bg" id="PatientList_part_bg_all">
            <?php  echo addPatientsCards($entityDetailInfos, "ALL", $selectPatient); ?>
        </div>
      </div>
	  </div>
    </div>


  <div class="clear"></div>

   <!-- Confirm Delete patient Modal --->
<div class="modal" id="patientDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog pat_lis_model">
    <div class="modal-content modal-cont">
      <div class="modal-header modal-head">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Patient</h4>
      </div>
      <div class="modal-body pat-body">
        Are you sure you want to delete this patient?
      </div>
      <div class="modal-footer modal-foot">
        <button type="button" class="btn btn-default btnpatlist" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnpatlist1" delete-id="0" id="patient-delete-button">Delete</button>
      </div>
    </div>
  </div>
</div>
</div>

<div class="col-md-4 padd-top50">
	<div class="sidebar-filter p-md">
			 <div class="form-group serch_patlist" style="float: left;">
				<input type="hidden" value="<?php echo $selectPatient;?>" id="currentPage" />
				<input type="hidden" value="<?php echo $page;?>" id="Page" />
				<label class="item-input serch-input"> 
					<input type="text" class="form-control" value="<?php echo $_REQUEST['searchStr']?>" id="searchInput" placeholder="Search by name, DOB, phone..." name="q"/>
				</label>
				<div class="input-group-btn search_but">
					<button class="btn btn-disabled btn-block" id="patientSearch" type="button">Search</button>
				</div>
			</div>
			<div class="btn-sorting text-center">
				<span class="searchLetters"><button value="a" onclick="getChar(this);">A</button></span>
				<span class="searchLetters"><button value="b" onclick="getChar(this);">B</button></span>
				<span class="searchLetters"><button value="c" onclick="getChar(this);">C</button></span>
				<span class="searchLetters"><button value="d" onclick="getChar(this);">D</button></span>
				<span class="searchLetters"><button value="e" onclick="getChar(this);">E</button></span>
				<span class="searchLetters"><button value="f" onclick="getChar(this);">F</button></span>
				<span class="searchLetters"><button value="g" onclick="getChar(this);">G</button></span>
				<span class="searchLetters"><button value="h" onclick="getChar(this);">H</button></span>
				<span class="searchLetters"><button value="i" onclick="getChar(this);">I</button></span>
				<span class="searchLetters"><button value="j" onclick="getChar(this);">J</button></span>
				<span class="searchLetters"><button value="k" onclick="getChar(this);">K</button></span>
				<span class="searchLetters"><button value="l" onclick="getChar(this);">L</button></span>
				<span class="searchLetters"><button value="m" onclick="getChar(this);">M</button></span>
				<span class="searchLetters"><button value="n" onclick="getChar(this);">N</button></span>
				<span class="searchLetters"><button value="o" onclick="getChar(this);">O</button></span>
				<span class="searchLetters"><button value="p" onclick="getChar(this);">P</button></span>
				<span class="searchLetters"><button value="q" onclick="getChar(this);">Q</button></span>
				<span class="searchLetters"><button value="r" onclick="getChar(this);">R</button></span>
				<span class="searchLetters"><button value="s" onclick="getChar(this);">S</button></span>
				<span class="searchLetters"><button value="t" onclick="getChar(this);">T</button></span>
				<span class="searchLetters"><button value="u" onclick="getChar(this);">U</button></span>
				<span class="searchLetters"><button value="v" onclick="getChar(this);">V</button></span>
				<span class="searchLetters"><button value="w" onclick="getChar(this);">W</button></span>
				<span class="searchLetters"><button value="x" onclick="getChar(this);">X</button></span>
				<span class="searchLetters"><button value="y" onclick="getChar(this);">Y</button></span>
				<span class="searchLetters"><button value="z" onclick="getChar(this);">Z</button></span>
			</div>
			
			<button class="btn btn-secondary btn-block" type="button"onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php','','menu-content',event)" ><?php echo constantAppResource::$DASHBOARD_TEXT_PORTAL_ADD_PATIENT;?></button>
	</div>
</div>
<?php include 'popup/CientSiderror_popup.php';
?>
<!--start footer -->
<!--end footer -->

