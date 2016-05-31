<?php
include 'controller/portal_dashboard_controller.php';
include 'popup/timeOut.php';
?>
<style>
.sidebar{
   width: 240px;
   height: 100%;
   float: none;
   display: block;
   position: fixed !important;
   overflow: hidden;
   z-index: 100;
   }
   .page-content{
   display: block;
   margin-left: 240px;
   }
   .trend .VITALS_TREND {
   text-align: left;
   }
   .serchByDate {
   float: left;
   width: 100%;
   }
   .bttngrp .btn.btn-orange.btn-default {
   background: #ebaf0d none repeat scroll 0 0;
   border-bottom: solid 4px #b08641;
   color: #fff;
   }
   .bttngrp .btn.btn-green1.btn-default {
   background: #57D784 none repeat scroll 0 0;
   border-bottom: solid 4px #439D66;
   color: #fff;
   }
   /*pagination*/
   .pagination {
   text-align: right;
   margin: 12px 0 20px;
   }
   .pagination li {
   background: none repeat scroll 0 0 #1adb82;
   border-radius: 5px;
   display: inline;
   padding: 6px 10px;
   box-shadow: 0 4px 0 0 #18ab67;
   }
   .pagination a {
   color: #fff;
   text-decoration: none;
   }
   select.custom-dropdown__select.custom-dropdown__select--white {
   padding-left: 10px !important;
   }
   h3.VITALS_TREND {
   font-size: 23px !important;
   color: #000 !important;
   text-align: center;
   padding-top: 7px;3e
   }
   h2.VITALS_TREND {
   font-size: 23px !important;
   color: #000 !important;
   text-align: center;
   padding-top: 4px;
   }
   #review_new, 
   #reviewedList,
   #review_new.active, 
   #reviewedList.active {
   border: medium none;
   box-shadow: none;
   padding: 6px 15px;
   color: #7fcebb;
   background: transparent;
   text-transform: uppercase;
   font-weight: 600;
   outline: 0 none;
   }
   #review_new.active, 
   #reviewedList.active{
   background: #e6e6e6;
   color: #666;
   }
   .top-search-bar {
   background: #fff none repeat scroll 0 0;
   border-bottom: 5px solid #ccc;
   float: left;
   width: 100%;
   max-height: 70px;
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
   #cleanderDiv .glyphicon-calendar.glyphicon {
   font-size: 18px;
   }
   #cleanderDiv .input-group-addon{
   padding:0;
   }
   .searchByDate #search-form a.activeButton{
   color:#00affe;
   }
   select#cards, #startDate, #endDate{
   }
   h1.credentials {
   float: left;
   }
   .second-h1{
   margin-top:5px;
   }
   h3.URGENT {
   color: #000 !important;
   }
   h3.URGENTtitle {
   color: #000 !important;
   padding-top: 8px;
   }
   h3.S-urgenttitle{
   padding-top:9px !important;
   -ms-transform: translate(10px,0px); /* IE 9 */
   -webkit-transform: translate(10px,0px); /* Safari */
   transform: translate(10px,0px); /* Standard syntax */
   }
   .yellow-card-h3{
   color:;
   }
   .PatCardTime2{
   position:relative;
   left:50px;
   top:-10px;
   }
   #menu-content.col-md-12 .dashboardCards .PatCardTime2{
   position:relative;
   left:210px;
   top:-10px;
   }
   .second-h2{
   font-size:;
   }
   .card-h5{
   font-size:;
   color:;
   }
   .right-side-h5{
   position:relative;
   right:-19px;
   top:-10px;
   }
   .reviewed-r-img{
   position:relative;
   right:-19px;
   }
   .sidebar-filter{
	   width: 300px;
   }
   .card{
	display: block;
	margin-bottom: 15px;
	background: #fff;
	border-radius: 4px;
	box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.12),0px 2px 2px 0px rgba(0,0,0,0.24);
}
.card-header{
	padding: 15px;
    border-bottom: 1px solid #dcdcdc;
    margin-bottom: 0;
}
.sidebar-filter .nav li{
	height: auto;
}

.sidebar-filter .card-header .btn-default{
	background: transparent;
	color: #666;
}
.sidebar-filter .nav-pills>li>a{
	color: #7acebb;
	text-transform: uppercase;
}
.sidebar-filter .nav-pills>li>a{
	padding: 8px 20px;
}
.sidebar-filter .nav>li>a{
	padding: 12px 20px;
	color: rgba(0,0,0,0.54);
}
.page-header{
	padding: 0 20px !important;
	margin: 0 !important;
	min-height: 118px;
	border-bottom: none !important;
}

.page-header .title{
	font-size: 26px;
	float: left;
	width: 100%;
	color: #7fcebb;
	margin-bottom: 5px;
	margin-top: 20px;
}

.page-header .sub-title{
	font-size: 16px;
	color: #666;
}
.padd-top20{
	padding-top: 20px;
}
.padd-top50{
	padding-top: 50px;
}
.card-content{
	overflow: hidden;
	padding: 15px;
}
.serchByDate{
	margin-bottom: 20px;
	padding-top: 0; 
}
.serchByDate .date input{
	padding:0 10px 0 0;
	border-bottom: 1px solid #e0e0e0;
	border-top: none;
	border-right: none;
	border-left: none;
	box-shadow: none;
	
}
.serchByDate .date .input-group-addon img{
	width: 24px;
	cursor: pointer;
}
.card-content .nav li.active a{
	text-decoration: underline;
}
.filter-bydate{
	padding: 0;
    text-align: right;
    float: left;
    width: 100%;
    display: block;
    text-transform: uppercase;
    margin: 10px 0
}
.filter-bydate a{
	color: rgba(0,0,0,0.3);
	font-size: 14px;
	font-weight: 600;
}

.filter-bydate a:hover{
	color: rgba(0,0,0,0.54);
}
.custom-tabs li{
	float: left !important;
}
.custom-tabs li a{
	padding: 15px 15px !important;
	color: #b4b4b4 !important;
	text-transform: uppercase !important;
}
.custom-tabs li.active{
	border-bottom: 4px solid #6ac5ad !important;
}

.custom-tabs li.active a{
	color: #6d6d6d !important;
	font-weight: 600;
}
.btn-neutral-default{
	background: transparent !important;
    border: none;
    padding: 0;
    text-transform: uppercase;
    color: rgba(0,0,0,0.38) !important;
    font-weight: 600;
    font-size: 14px;
}
.btn-neutral-default:focus, .btn-neutral-default:hover{
	color: #6AC5AD !important;
}
.input-icon{
	position: absolute;
    right: 15px;
	cursor: pointer;
    top: 32px;
    width: 18px;
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
					<!--
						<ul class="nav nav-list"> 
						  <li onClick="CardFiter(this)" value="All"><a href="#">Everything</a></li>
						  <li  onClick="CardFiter(this)"  value="Alert" class="active"><a href="#">Alerts</a></li>
						  <li onClick="CardFiter(this)"  value="Biometrics"><a href="#">Biometrics</a></li>
						  <li onClick="CardFiter(this)"  value="Care Communication"><a href="#">Care Communication</a></li>
						  <li onClick="CardFiter(this)"  value="Educational"><a href="#">Educational</a></li>
						  <li onClick="CardFiter(this)"  value="Messages" ><a href="#">Messages</a></li>
						  <li onClick="CardFiter(this)"  value="Patient Care" ><a href="#">Patient Care</a></li>
						  <li onClick="CardFiter(this)"  value="Surveys" ><a href="#">Surveys</a></li>
						</ul>
					-->
					<div class="form-group">
					<label class="control-label">Type</label>
                    <select name="all_cards" id="cards" class="form-control select-icon">
							<option value="All" id="ALL" name="all_cards_option"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_ALLTYPES;?></option>
                             <?php 
							if(strtoupper($_COOKIE['type']) == "PROVIDER")
							{
							?>
                            <option  id="all_cards_alert" value="Alert"  selected="selected"  name="all_cards_alert"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_ALERT;?></option>
                             <?php
							}
							?> 
							<option  id="BIOMETRICS" value="Biometrics"  name="all_cards_biometrics"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_BIOMETRICS;?></option>
							<option  id="STICKY_NOTE" value="Messages"  name="all_cards_sticky"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_STICKY;?></option>
							<option  id="all_cards_content" value="Educational"  name="all_cards_content"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_CONTENT;?></option>
							<option  id="all_cards_call" value="Patient Care"  name="all_cards_call"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_PATIENT_CARE;?></option>
							
							<option  id="all_cards_call" value="Surveys"  name="all_cards_call"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_SURVEYS;?></option> 
                            <?php 
							if(strtoupper($_COOKIE['type']) == "PROVIDER")
							{
							?>
                            <option  id="all_cards_call" value="Care"  name="all_cards_call"><?php echo constantAppResource::$PORTAL_DASHBOARD_TEXT_CARE;?></option>
                            <?php
							}
							?> 

						</select>
						</div>
						
                        <form action="" name="search-form" id="search-form" onSubmit="dateSearch(event);" method="post">

<div class="serchByDate">
                           <div id="cleanderDiv" class="row">
                              <div class="col-md-6">
								<label id='datetimepicker1' class="item-input item-floating-label"> 
									<span id="startDate" name="startDate" class="input-label">From</span>
									<input class="form-control" type="text" id="startDate" name="startDate" placeholder="From">
									<img src="/gladstone/portal/bloom/login/images/date-range.svg" class="input-icon">
								</label>
                              </div>
                              <div class="col-md-6">
								<label id='datetimepicker2' class="item-input item-floating-label"> 
									<span id="startDate" name="endDate" class="input-label">To</span>
									<input class="form-control" type="text" id="endDate" name="endDate" placeholder="To">
									<img src="/gladstone/portal/bloom/login/images/date-range.svg" class="input-icon">
								</label>
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
						<button class="btn-neutral-default " type="submit">Filter</button>
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
