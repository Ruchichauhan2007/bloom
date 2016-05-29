<?php
include 'controller/portal_dashboard_controller.php';
include 'popup/timeOut.php';
?>
<style>
#review_new, 
#reviewedList,
#review_new.active, 
#reviewedList.active {
    background: transparent none repeat scroll 0 0;
    border: medium none;
    font-size: 16px;
    font-weight: normal;
    outline: 0 none;
}
#review_new.active span, 
#reviewedList.active span{
	border-bottom:2px solid #41ABFE;
	color:#41ABFE;
}
.top-search-bar {
    background: #fff none repeat scroll 0 0;
    border-bottom: 5px solid #ccc;
    float: left;
    width: 100%;
	padding: 9px 0;
}
select#patients{
	background: rgba(0, 0, 0, 0) url("../images/dd-icon.png") no-repeat scroll 151px center;
    border: 0 none;
	width: 175px;
	appearance:none;
    -moz-appearance:none; 
    -webkit-appearance:none;
	box-shadow:0 0 0;
}
#patients option {
    background: #fff none repeat scroll 0 0;
    color: #000;
}
select#cards{
	background: rgba(0, 0, 0, 0) url("../images/d-icon.png") no-repeat scroll 145px center;
    border: 0 none;
    color: #41abfe;
    font-weight: bold;
    height: 42px;
    position: relative;
    z-index: 9;
	appearance:none;
    -moz-appearance:none; 
    -webkit-appearance:none;
	box-shadow:0 0 0;
}
select#cards:focus{
	box-shadow:0 0 0;
}
#cleanderDiv .glyphicon-calendar.glyphicon {
    font-size: 18px;
}
#cleanderDiv .input-group-addon{
    padding:0;
}
select#cards, #startDate, #endDate{
	font-size:16px;
	font-weight:normal!important;
}
</style>
<script type="text/javascript">
  $(document).ready(function(){
	  changeCards('');
	$("h5.time_date").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM D h:mm A');
	$(element).html(localTime);
});

		var contextPrientId=$("#contextPatientId").val();

		$("#cards").change(function(e){console.log('clicked');
			changeCards(e)
		});

		$("#review_new").click(function(e){
				$("#patientreviewedcard_ALL").hide();
				$("#patientreview_ALL").show();
				$("#review_new").addClass("active")
				$("#reviewedList").removeClass("active");
				changeCards(e);
		});

		$("#reviewedList").click(function(e){
		//	var cardsVal = $("#cardTypeList ul li.active").attr('value');
		var cardsVal = $('#cards').val();
			$("#patientreviewedcard_ALL").show();
			$("#patientreview_ALL").hide();
			$("#reviewedList").addClass("active");
			$("#review_new").removeClass("active");
			openPageWithAjax('portal_dashboard_reviewed.php','categoryFilter=Select a Patient&reviewed=true&currentPage=1&cardType='+cardsVal+'&contextPId=<?php echo $_REQUEST['contextPId'];?>','dashbaord-cards-container',e);
			//changeCards(e);
		});
  });

  function checkPatient(activeDiv,cardType,patientsValue)
  {
	  	if(patientsValue === "all_patient")
	   	{
	  		$('#'+activeDiv+' .dashboardCards').each(function(index){
	  				checkCards(this,cardType);
	  		});
	   	}
	  	else
	  	{
	  		 // my patients
	  		 $('#'+activeDiv+' .dashboardCards').each(function(index){
				  		var patClass = 'providerFilterClass'+$("#contextPatientId").val();
				  		console.log('patClass : '+patClass);
			  			if($(this).attr('ref') == $("#contextPatientId").val())
			  			{
			  				checkCards(this,cardType);
			  			}
	  		 });
	  	}
	  	if(activeDiv === "patientreview_ALL")
	  		$('#patientreview_ALL .isReviewed').hide();
  }

  function checkCards(ele,cardType)
  {

  	var params = 'reviewed=false&cardType='+cardType+'&currentPage=1&categoryFilter=Select a Patient&contextPId=<?php echo $_REQUEST['contextPId'];?>';
		var purl = '../../login/pages/portal_dashCard.php';
		openPageWithAjax(purl,params,'dashCard', '');
  }
  function changeCards(e)
  {
	  console.log('in changeCards')
  	  var patientsValue = $("#patients").val();
  	 // var cardsVal = $("#cardTypeList ul li.active").attr('value');
	 var cardsVal = $('#cards').val();
	 
	   var activeTabId= $('button.active').attr('id');
  	  var dashboardCards = $('div.dashboardCards');
	  var activeDiv = "patientreview_ALL";

  	  if(activeTabId === "reviewedList")
  	  {
  		activeDiv = "patientreviewedcard_ALL";

  	  }
  	  else
  	  {
  		activeDiv = "patientreview_ALL";
  	  }
	  //checkCards(activeDiv,cardsVal);

  	  // hide all cards
  	 	 //$(dashboardCards).hide();


  	 	  if(patientsValue === "select_patient")
  			{
  	 		openPageWithAjax('../../dashboard/pages/portal_patientList.php','selectPatient=true','menu-content',e);
  			}
			
			if(activeTabId === "reviewedList")
						  {
		   						 openPageWithAjax('../../login/pages/portal_dashboard_reviewed.php','categoryFilter=Select a Patient&reviewed=true&currentPage=1&cardType='+cardsVal+'&contextPId=<?php echo $_REQUEST['contextPId'];?>','dashCard',e);
					
						  }
						  else
						  {
		   						 openPageWithAjax('../../login/pages/portal_dashCard.php','categoryFilter=Select a Patient&reviewed=false&currentPage=1&cardType='+cardsVal+'&contextPId=<?php echo $_REQUEST['contextPId'];?>','dashCard',e);
						  }
  	 	/* else
  	 	 {
			checkPatient(activeDiv,cardsVal,patientsValue);
  	 	 }*/
  }

function reviewedDashboardCards(dashboardId, e){
	var params = 'id='+dashboardId;
	var purl = '../../login/pages/portal_acknowledgeDashboard.php?selectedPatientTrue=true';
	openPageWithAjax(purl,params,'ack-dashboard', e);
	$("#STICKY_NOTE_"+dashboardId).fadeOut('slow');
	$("#PDF_NEW_"+dashboardId).fadeOut('slow');
	$("#VIDEO_NEW_"+dashboardId).fadeOut('slow');
	$("#CALL_MISSED_INCOMING_"+dashboardId).fadeOut('slow');
	$("#CALL_MISSED_OUTGOING_"+dashboardId).fadeOut('slow');
	$("#CALL_SERVICED_INCOMING_"+dashboardId).fadeOut('slow');
	$("#CALL_SERVICED_OUTGOING_"+dashboardId).fadeOut('slow');
	$("#VITALS_MISSED_"+dashboardId).fadeOut('slow');
	$("#VITALS_OUT_OF_RANGE_"+dashboardId).fadeOut('slow');
	$("#VITALS_ACCEPTABLE_"+dashboardId).fadeOut('slow');
	$("#VIDEO_VIEWED_"+dashboardId).fadeOut('slow');
	$("#PDF_VIEWED_"+dashboardId).fadeOut('slow');
	$("#SURVEY_NEW_"+dashboardId).fadeOut('slow');
	$("#SURVEY_COMPLETED_"+dashboardId).fadeOut('slow');
	$("#ADD_PATIENT_"+dashboardId).fadeOut('slow');
	$("#EDIT_PATIENT_"+dashboardId).fadeOut('slow');
	$("#ADD_PROVIDER_"+dashboardId).fadeOut('slow');
	$("#EDIT_PROVIDER_"+dashboardId).fadeOut('slow');
	$("#ACTION_PLAN_"+dashboardId).fadeOut('slow');
	$("#ACTION_PLAN_VIEWED_"+dashboardId).fadeOut('slow');
	$("#CARE_COMMUNICATION_"+dashboardId).fadeOut('slow');

}
</script>
			         <div class="col-md-8 padd-top20">

		<div class="login_patient_list-1">

			<div class="clear"></div>
			<div class="row" id="dashbaord-cards-container">
			<div class="scrollbar1 scroll-outer" style="overflow:auto;">
        <div class="content scroll-inner"  id="dashCard">
				<div id="patientreviewedcard_ALL" style="display:none;">

				<?php
					echo addReviewedDashboardCards($dashboardCards,0);
				?>
				</div>
				<div id="patientreview_ALL"style="display:none;">
				<?php
					echo addDashboardCards($dashboardCards,0);
				?>
				</div>
				</div>
			</div>
			</div>
			</div>
			</div>
			<div class="col-md-4 padd-top50">
			<div class="sidebar-filter">
				<div class="card">
					<div class="card-header">
						<button class="btn btn-default active" id="review_new"><?php echo constantAppResource::$PORTAL_DASHBOARD_NEW;?></button>
						<button class="btn btn-neutral" id="reviewedList"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_REVIEWED;?></button>
						</ul>
					</div>
					<div class="card-content" id="cardTypeList">
                    <select name="all_cards" id="cards" class="form-control" style="border: 0 none;color: #41abfe;font-weight: bold; height: 42px;">
							<option value="All" id="ALL" name="all_cards_option"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_ALLTYPES;?></option>
                            <option  id="all_cards_alert" value="Alert"  selected="selected"  name="all_cards_alert"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_ALERT;?></option>
							<option  id="BIOMETRICS" value="Biometrics"  name="all_cards_biometrics"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_BIOMETRICS;?></option>
							<option  id="STICKY_NOTE" value="Messages"  name="all_cards_sticky"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_STICKY;?></option>
							<option  id="all_cards_content" value="Educational"  name="all_cards_content"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_CONTENT;?></option>
							<option  id="all_cards_call" value="Patient Care"  name="all_cards_call"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_PATIENT_CARE;?></option>
							
							<option  id="all_cards_call" value="Surveys"  name="all_cards_call"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_SURVEYS;?></option> 
                            <?php 
							if(strtoupper($type) == "PROVIDER")
							{
							?>
                            <option  id="all_cards_call" value="Care"  name="all_cards_call"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_CARE;?></option>
                            <?php
							}
							?> 

						</select>

                        <form action="" name="search-form" id="search-form" onSubmit="dateSearch(event);" method="post">

<div class="serchByDate">
                           <div id="cleanderDiv" class="row">
							<div class="col-md-12">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                       <input type='text' placeholder="From" class="form-control" id="startDate" name="startDate"/>
                                       <span class="input-group-addon" style="border-radius:0;background: #fff; border: 0px none; box-shadow: 0px 0px 0px;">
                                          <!-- <span class="glyphicon glyphicon-calendar"></span>-->
                                          <img src="/gladstone/portal/bloom/login/images/date-range.svg">
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <div class='input-group date group float-input' id='datetimepicker2'>
                                       <input type='text' placeholder="To" class="form-control" id="endDate" name="endDate"/>
                                       <span class="input-group-addon" style="border-radius:0;background: #fff;border: 0px none; box-shadow: 0px 0px 0px;">
                                          <!-- <span class="glyphicon glyphicon-calendar"></span>-->
                                          <img src="/gladstone/portal/bloom/login/images/date-range.svg">
                                       </span>
                                    </div>
                                 </div>
                              </div>
							  </div>
                           </div>
                           <input type="hidden" name="searchCard" />
                           <input type="hidden" name="currentPage"  value="1" />
                           <input type="hidden" name="categoryFilter" id="categoryFilter"/>
                           <input type="hidden" name="cardType" id="cardType"/>
                           <input type="hidden" name="reviewed" id="reviewed"/>
                       
                     </div>
						<!-- Filter by Date-->
						<div class="filter-bydate">
						<button class="btn-neutral-default" type="submit">Filter by Date</button>
						</div>
 </form>						
					</div>
				</div>
			</div>
		 </div>
            <script type="text/javascript">
            $(document).ready(function () {
			
			 $(document).on('change',"#patients", function(e) {
			 var patientsValue = $("#patients").val();
			 if(patientsValue == "All Patients")
			 {
				/* patientsValue = $("#patients").val();
				openPageWithAjax('../../login/pages/portal_dashCard.php','reviewed=false&currentPage=1&categoryFilter=All Patients&cardType=Alert','dashCard',e);
				$('#patients option[value="Select a Patient"]').text("Select Patient");
				$("#cards").prop("selectedIndex", 1); 
				$("#review_new").addClass("active");
				$("#reviewedList").removeClass("active");*/
				window.location.reload();
				$('#patImage').hide();
				$('#patsImages').show();
			 }
			 else if(patientsValue == "My Patients")
			 {
				/* patientsValue = $("#patients").val();
				openPageWithAjax('../../login/pages/portal_dashCard.php','reviewed=false&currentPage=1&categoryFilter='+patientsValue+'&cardType=Alert','dashCard',e);
				$('#patients option[value="Select a Patient"]').text("Select Patient");
				$("#cards").prop("selectedIndex", 1); 
				$("#review_new").addClass("active");
				$("#reviewedList").removeClass("active");*/
				window.location.reload();
				$('#patImage').hide();
				$('#patsImages').show();
			
			 }
			 else
			 {
			 	 patientsValue = $("#patients").val();
				openPageWithAjax('../../dashboard/pages/portal_patientList.php','selectPatient=true&currentPage=1','menu-content',e);
			 }


			});

			
			$("img.searchButtons").click(function(event)
			{
			if($(this).hasClass("activeButton"))
			{
			 dateSearch(event);
			$("img.searchButtons").attr("src","/gladstone/portal/bloom/login/images/closeBlue.png");
			$("img.activeButton").addClass("glyphicon-remove");
			$("img.activeButton").removeClass("glyphicon-ok");
			$("img.activeButton").removeClass("activeButton");
			
			}
			else if($(this).hasClass("glyphicon-remove"))
			{
			$("img.searchButtons").attr("src","/gladstone/portal/bloom/login/images/checkGray.png");
			$("img.glyphicon-remove").addClass("glyphicon-ok");
			$("img.glyphicon-remove").removeClass("glyphicon-remove");
			$("img.glyphicon-remove").removeClass("activeButton");
			$("#startDate").val('');
			$("#endDate").val('');
			}
			else
			{
			$("img.searchButtons").attr("src","/gladstone/portal/bloom/login/images/checkGray.png");
			$("img.glyphicon-search").addClass("glyphicon-ok");
			$("img.glyphicon-search").removeClass("glyphicon-search");
			
			$("#cleanderDiv").show();
			}			
			});
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
				$('#startDate').on('change', function(){
					$('#datetimepicker1').hide();
				});
				$('#endDate').on('change', function(){
					$('#datetimepicker2').hide();
				});
            });
			
			function checkValue()
			{
					if($("#startDate").val() !="" && $("#endDate").val() != "")
					{
						$("img.searchButtons").attr("src","/gladstone/portal/bloom/login/images/checkBlue.png");
						$(".glyphicon-remove").addClass("glyphicon-ok");
						$(".glyphicon-ok").addClass("activeButton");
						$(".glyphicon-remove").removeClass("glyphicon-remove");
					}
					else
					{
						$("img.searchButtons").attr("src","/gladstone/portal/bloom/login/images/checkGray.png");
						$(".glyphicon-remove").addClass("glyphicon-ok");
						$(".glyphicon-ok").removeClass("activeButton");
						$(".glyphicon-remove").removeClass("glyphicon-remove");
					}			
			}
				$(".glyphicon-calendar").click(function()
				{
					setTimeout(checkValue, 5);
								
				});	
			$("#searchSpanIcon.activeButton").click(function(){
				alert();
			});
        </script>
