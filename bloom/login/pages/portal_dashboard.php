<?php
   $addPatient = $_REQUEST["addPatient"];
   $patientDetail =  $_REQUEST["patientId"];
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
<div class="wrapper2">
   <?php
   if($_COOKIE['type'] == "Patient" or $_COOKIE['type'] == "PATIENT")
   {
      include('../../common/pages/dashboard_header_patient.php');
   }
   else{
	   include('../../common/pages/dashboard_header.php');
   }
         include 'controller/portal_dashboard_controller.php';
      $type = strtoupper($_COOKIE['type']);
      if($_COOKIE['type'] == "Patient" or $_COOKIE['type'] == "PATIENT") $hideFilter = TRUE;
      
      ?>
	  <link rel='stylesheet prefetch' href='/gladstone/portal/bloom/app/assets/css/ionic.min.css'>
	  <link rel="stylesheet" type="text/css" href="/gladstone/portal/bloom/app/assets/css/intile.css">
	<link href='../../common/script/css/custom-fonts.css' rel='stylesheet' type='text/css'>
	<script src='/gladstone/portal/bloom/app/views/scripts/lib/ionic.bundle.js'></script>
   <script src="../../common/script/js/jquery.cookie.js"> </script>
   <script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
   <script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
   <script type="text/javascript" src="../../common/script/js/auth-helper.js"> </script>
   <!-- Vendor: Angular, followed by our custom Javascripts -->
   <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-route.min.js"></script>
   <script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>   

<script type="text/javascript">
    /*$(function(){
		$('.login-nav-container').slimScroll({
			height: '100%',
			size: '5px',
			wheelStep: 50,
		});
    });*/
</script>

<style>
.slimScrollBar {
	height: 150px !important;
}

#menu-content.login_patient_list-1{
	overflow: inherit !important;
	height: inherit !important;
}
</style>

   <script type="text/javascript">
      function  Cards(carttype)
      {
      	$("#menu-content").unbind('scroll');
      	var patient_id = carttype.split('_');
      	patient_id=patient_id[0];
      	var cartTypes = $("#"+carttype).attr('class');
      	var cardType = $("#"+carttype).attr('cardType');
      	var deviceId = $("#"+carttype).attr('deviceId');
      	var careCommHeaderId  = $("#"+carttype).attr('careCommHeaderId');
      	if(cartTypes=="notes")
      	{
      	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/messages/pages/messages.html?patientId='+patient_id);
      	}
      	else if(cartTypes =="pdf_video")
      	{
      	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/portalLearn/pages/portal_learn.php');
      
      	}
      	else if(cartTypes =="vitals")
      	{
      		if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$GLUCOSE; ?>")
      		{
      			$("#deviceConfigID").val(deviceId);
      			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBG.php?vitalType=Blood-Glucose');			
      		}
      		else if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$OXYGEN; ?>")
      		{
      			$("#deviceConfigID").val(deviceId);
      			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBP.php?vitalType=Blood-Oxygen');			
      		}
      		else if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$WEIGHT; ?>")
      		{
      			$("#deviceConfigID").val(deviceId);
      			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBP.php?vitalType=Body-Weight');			
      		}
      		else if(cardType.toUpperCase() == "<?php echo VMCPortalConstants::$DIASTOLIC; ?>" || cardType.toUpperCase() == "<?php echo VMCPortalConstants::$SYSTOLIC; ?>")
      		{
      			$("#deviceConfigID").val(deviceId);
      			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphBP.php?vitalType=Blood-Pressure');			
      		}
      		else if(cardType.toUpperCase() == "PEAKFLOW")
      		{
      			$("#deviceConfigID").val(deviceId);
      			setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/vitals/pages/vitals_graphPF.php?vitalType=Peak-Flow');			
      		}
      
      	}
      	else if(cartTypes =="survey" && "PATIENT" == "<?php echo $type;?>")
      	{
      	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/survey/pages/survey.php');
      
      	}
      	else if(cartTypes =="care")
      	{
      	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php?careCommHeaderId='+careCommHeaderId+'&patientId='+patient_id+'&type=EDIT&dashcard=dashcard');
      
      	}
      	else if(cartTypes =="patient" || cartTypes =="PATIENT")
      	{
      	var userType = "<?php echo $type;?>";
      	if(userType == "PATIENT")
      	{
      		setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/patientcare/pages/patient_care.php');
      	}
      	else
      	{
      		setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php?patientId='+patient_id+'&type=EDIT');
      	}
      
      	}
      
      	var image = $("#"+carttype).attr('name');
      	var name = $("#"+carttype).attr('alt');
      	var id = patient_id ;
      	$('#contextPatientName').val(name);
      	var patName ;
      	if(name.length > 11)
      	{
      	 patName = name.substring(0,11)+"..";
      	}
      	 else
      	 {
      		patName = name;
      	 }
      	$('#contextPatientId').val(id);
      	$('#contextPatientImage').val(image);
      	
      	$('#patients option[value="selectedPatient"]').show();
      	$('#patients option[value="selectedPatient"]').text(patName);
      	//$("#patients").append('<option value="'+patientName+'">'+patientName+'</option>');
      	$("#patients").prop("selectedIndex", 3); 
      	$('#patImage').show();
      	$('#patsImages').hide();
      	$("#patients").show();
      	$("#headerMenu li").attr("ref",id);
      
      }
      // alert cards
      function  alertCards(cardId)
      {
      	$("#menu-content").unbind('scroll');
      	var card_id = cardId.split('_');
      	patient_id=card_id[0];
      	var reviewId = $("#"+cardId).attr('reviewId');
      	var cardTypes ;
      	var careCommHeaderId  = $("#"+cardId).attr('careCommHeaderId');
      	if($("#"+cardId).hasClass("btn_vitals") || $("#"+cardId).hasClass("btn_notes"))
      	{
      	  cardTypes = "notes";
      	  
      	  
      	}
      	else if($("#"+cardId).hasClass("btn_care"))
      	{
      		cardTypes = "care";
      		
      	}
      	else
      	{
      	cardTypes = $("#"+cardId).attr('class');
      	}
      	if(cardTypes=="notes" || cardTypes=="vitals")
      	{
      	setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/patientcare/pages/reviewAlert.php?patientId='+patient_id+'&reviewId='+reviewId);
      	}
      	else if(cardTypes=="care")
      	{
      		setPatientValue(patient_id,'<?php $_SERVER['SERVER_NAME'];?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php?careCommHeaderId='+careCommHeaderId+'&patientId='+patient_id);
      	}
      	
      	if($("#"+cardId).hasClass("btn-green"))
      	{
      	  var ele = $("#"+cardId).parent().parent();
      		var image = $(ele).find("img").attr('name');
      		var name = $(ele).find("img").attr('alt');
      	}
      	else
      	{
      	var image = $("#"+cardId).attr('name');
      	var name = $("#"+cardId).attr('alt');
      	}
      	var id = patient_id ;
      	$('#contextPatientName').val(name);
      	var patName ;
      	if(name.length > 11)
      	{
      	 patName = name.substring(0,11)+"..";
      	}
      	 else
      	 {
      		patName = name;
      	 }
      	$('#contextPatientId').val(id);
      	$('#contextPatientImage').val(image);
      	
      	$('#patients option[value="selectedPatient"]').show();
      	$('#patients option[value="selectedPatient"]').text(patName);
      	//$("#patients").append('<option value="'+patientName+'">'+patientName+'</option>');
      	$("#patients").prop("selectedIndex", 3); 
      	$('#patImage').show();
      	$('#patsImages').hide();
      	$("#patients").show();
      	$("#headerMenu li").attr("ref",id);
      
      }
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
console.log(availableMenus);
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
		  
      	$('#portal-menu').find('a').each(function(){
      			var html = $.trim($(this).text());
			//	console.log(html);
      			if(!availableMenu.contains(html))
      			{	
			
      				var resClass = html.split(" ");
      				//$(this).parents('li').hide();
      			}
      		});
			
      	$('#navbar').find('a').each(function(){
      			var html = $.trim($(this).text());
				console.log(html);
      			if(!availableMenu.contains(html))
      			{	
			
      				var resClass = html.split(" ");
      			//	$(this).parents('li').hide();
      				
      			}
      		});
	}
      
        $(function(){
      		controlMenu();
      		$("#patients,#cards").change(function(e){console.log('clicked');
      			changeCards(e)
      		});
      
      			changeCards('');
      
      			$("#review_new").click(function(e){
      				$("#patientreviewedcard_ALL").hide();
      				$("#patientreview_ALL").show();
      				$("#review_new").addClass("active")
      				$("#reviewedList").removeClass("active");
      				changeCards('');
      				// $("h5.time_date").each(function( index, element) {
      	// var time = moment($(element).html());
      	// //time.subtract(time.zone(), 'minutes');
      	// var localTime  = moment.utc($(element).text()).toDate();
          // localTime = moment(localTime).format('MMM D h:mm A');
      	// $(element).html(localTime);
      // });
      			});
      
      			$("#reviewedList").click(function(e){console.log('clicked')
      					var patientsValue = $("#patients").val();
        	  				var cardsVal = $('#cards').val();
						//var cardsVal = $("#cardTypeList ul li.active").attr('value');
      					//openPageWithAjax('portal_dashboard_reviewed.php','categoryFilter='+patientsValue,'dashbaord-cards-container',e);
      				$("#patientreviewedcard_ALL").show();
      				$("#patientreview_ALL").hide();
      				$("#reviewedList").addClass("active");
      				$("#review_new").removeClass("active");
      				changeCards(e);
      			});
      		});
      
        function checkPatient(activeDiv,cardType,patientsValue)
        {
      	  	if(patientsValue === "All Patients")
      	   	{
      	  		$('#'+activeDiv+' .dashboardCards').each(function(index){
      	  				checkCards(this,cardType);
      	  		});
      	   	}
      	  	else
      	  	{
      	  		 // my patients
      	  		 $('#'+activeDiv+' .dashboardCards').each(function(index){
      	  			 <?php if($hideFilter != TRUE)
         {
         ?>
      	  			 	if($(this).hasClass('providerFilterClass0'))
      	  			 	{
      	  			 		$(this).hide();
      	  			 	}
      	  			 	else
      	  			 	{
      	  			 		checkCards(this,cardType);
      	  			 	}
      				<?php }else{	 ?>
      						checkCards(this,cardType);
      				<?php }?>
      
      	  		 });
      	  	}
      	  	if(activeDiv === "patientreview_ALL")
      	  		$('#patientreview_ALL .isReviewed').hide();
        }
      
        function checkCards(ele,cardType)
        {
        	
         		var params = 'reviewed=false&cardType='+cardType+'&currentPage=1';
      		//alert(params);
      		var purl = '../../login/pages/portal_dashCard.php';
      		openPageWithAjax(purl,params,'dashCard', '');
      
        }
		
	function   patientCardFiter(ele)
	{
		$("#providerActivity ul li").removeClass('active');
		$(ele).addClass('active');
		changeCards('');
	}
	
	
	function  CardFiter(ele)
	{
		$("#cardTypeList ul li").removeClass('active');
		$(ele).addClass('active');
		changeCards('');
	}
		
        function changeCards(e)
        {
        	  var patientsValue = $("#providerActivity ul li.active a").attr('value');
        	  var cardsVal = $("#cards").val()
      	  $('#cardType').val(cardsVal);
      	  $('#categoryFilter').val(patientsValue);
        	  var activeTabId= $('button.active').attr('id');
        	  var dashboardCards = $('div.dashboardCards');
      	  var activeDiv = "patientreview_ALL";
      
        	  if(activeTabId === "reviewedList")
        	  {
        		activeDiv = "patientreviewedcard_ALL";
      		$('#reviewed').val("true");
      
        	  }
        	  else
        	  {
        		activeDiv = "patientreview_ALL";
      		$('#reviewed').val("false");
      
        	  }
      
        	  // hide all cards
        	 	// $(dashboardCards).hide();
      
      
        	 	  if(patientsValue === "Select a Patient")
        			{
        	 		openPageWithAjax('../../dashboard/pages/portal_patientList.php','selectPatient=true&currentPage=1','menu-content',e);
        			}
        	 	 else
        	 	 {
      			//checkPatient(activeDiv,cardsVal,patientsValue);
      			
      						if(activeTabId === "reviewedList")
      						  {
      		   						 openPageWithAjax('../../login/pages/portal_dashboard_reviewed.php','reviewed=true&currentPage=1&categoryFilter='+patientsValue+'&cardType='+cardsVal,'dashCard',e);
      					
      						  }
      						  else
      						  {
      		   						 openPageWithAjax('../../login/pages/portal_dashCard.php','reviewed=false&currentPage=1&categoryFilter='+patientsValue+'&cardType='+cardsVal,'dashCard',e);
      						  }
      					
      			
        	 	 }
        }
        
        
         function dateSearch(e)
        {
        	  var patientsValue = $("#providerActivity ul li.active a").attr('value');
        	  var cardsVal = $("#cards").val();
      	  $('#cardType').val(cardsVal);
      	  $('#categoryFilter').val(patientsValue);
        	  var activeTabId= $('button.active').attr('id');
        	  var dashboardCards = $('div.dashboardCards');
      	  var activeDiv = "patientreview_ALL";
      
        	  if(activeTabId === "reviewedList")
        	  {
        		activeDiv = "patientreviewedcard_ALL";
      		$('#reviewed').val("true");
      
        	  }
        	  else
        	  {
        		activeDiv = "patientreview_ALL";
      		$('#reviewed').val("false");
      
        	  }
      
        	  // hide all cards
        	 	// $(dashboardCards).hide();
      
      		//checkPatient(activeDiv,cardsVal,patientsValue);
      			
      						if(activeTabId === "reviewedList")
      						  {
      		   						 postFormWithPagination('../../login/pages/portal_dashboard_reviewed.php','search-form','dashCard',e)
      					
      						  }
      						  else
      						  {
      		   						 postFormWithPagination('../../login/pages/portal_dashCard.php','search-form','dashCard',e)
      						  }
      					
      			
        }
      
      
      
      
      
      
      		// set container height
      		//$('#menu-content').height($('#menu-content-container').height());
      		//$("#patients").change();
        //});
      
      function reviewedDashboardCards(dashboardId, e){
      
      	var params = 'id='+dashboardId;
      	var purl = '../../login/pages/portal_acknowledgeDashboard.php';
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
      
      function openPopupForAlert(cardId)
      {
      $("#survletModalNPI").modal('show');
      $("#confirmCareComm").attr("data",cardId);
      
      }
      
      function confirmCareComm(ele)
      {
      var cardId = $(ele).attr('data');
      alertCards(cardId);
      
      }
      
      
      
      $(document).ready(function() {
      	$("h5.time_date").each(function( index, element) {
      	var time = moment($(element).html());
      	//time.subtract(time.zone(), 'minutes');
      	var localTime  = moment.utc($(element).text()).toDate();
          localTime = moment(localTime).format('MMM D h:mm A');
      	$(element).html(localTime);
      });
      });
      // $(document).ready(function() {
      	// $("h5.leftTime").each(function( index, element) {
      	// var time = moment($(element).html());
      	// alert(time);
      	// //time.subtract(time.zone(), 'minutes');
      	// var localTime  = moment.utc($(element).text()).toDate();
          // localTime = moment(localTime).format('MMM D h:mm A');
      	// $(element).html(localTime);
      // });
      // });
      
      // $(function(){
        // setInterval(function(){
          // var divUtc = $('#divUTC').val();
          // var divLocal = $('#divLocal');
          // //put UTC time into divUTC
          // divUtc.text(moment.utc().format('YYYY-MM-DD HH:mm:ss'));
      
          // //get text from divUTC and conver to local timezone
          // var localTime  = moment.utc(divUtc.text()).toDate();
          // localTime = moment(localTime).format('YYYY-MM-DD HH:mm:ss');
          // divLocal.text(localTime);
        // },1000);
      // });
      
      $(document).ready(function()
      {
       var userType='<?php echo $type?>';
       if(userType =="PATIENT")
       {
       $("#patientreview_ALL div.AdminImg img").hide();
      $("#cards #all_cards_alert").remove();
      $("#cards #ALL").attr("selected","selected");
      changeCards('');
       }
       var PendingPatientTrue = localStorage["PendingPatientTrue"];
       var peddingPatientId = localStorage["peddingPatientId"];
       if(PendingPatientTrue == "PendingPatientTrue" && peddingPatientId !="")
       {	localStorage["PendingPatientTrue"]="PendingPatientFalse";
      	openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId='+peddingPatientId,'','menu-content','');
       }
      
      	$("#aboutPage").click(function()
      	{
      
      	$(".cart_page").html("About");
         	$(".txt_div").html("Kannact Bloom <br> Version :<?php echo  getVersion();?><br><span id='abtCpoyRight'></span>");
      	$("#aboutPopup").show();
      	$("#About_fadediv").show();
      	$("#txt_div").css({"margin":"0px 0px 0px 106px"});
      	var d = new Date();
      	var n = d.getFullYear();
      	document.getElementById("abtCpoyRight").innerHTML ='<?php echo constantAppResource::$LOGIN_FOOTER_TEXT_COPYRIGHT;?> '+n;
      	});
      });
      
      
      
   </script>
   <div class="row" id="menu-content-container">
      <div id="portal-menu" class="sidebar">
         <aside>
            <?php
               $entityUtil = new EntityUtil();
               $entityType = $entityUtil->getEntityTypeFromContext();
               
               if(strtoupper($entityType) == VMCPortalConstants::$ENTITYTYPE_PATIENT)
               {
               	include('../../common/pages/dashboard_patient_commonMenu.php');
               	echo '<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/setImgRef.js"></script>';
               }
               else
               {
               	include('../../common/pages/dashboard_commonMenu.php');
               
               }
               ?>
         </aside>
      </div>
      <!-- New div for AngularJS content ng-view -->
      
      <div class="page-content" id="page-content">
         <!--endt leftnav -->
		 <div class="col-xs-12 col-md-7 ng-scope padd-top20" ng-app="mainApp" when-scrolled="" id="menu-content-aj" ng-view></div>
		 
            <div  id="menu-content" class="login_patient_list-1">
			         <div class="col-md-8 padd-top20">

			<?php /*
               <div class="top-search-bar">
                  <div class="col-md-6 Bttn_group_review" style="padding-right:0;">
                 <!--      <button type="button" id="review_new" onClick="openPageWithAjax('../../portalLearn/pages/portal_providerList.php','','menu-content',event)" class="btn btn-gray col-md-6 active"><?php echo constantAppResource::$PORTAL_DASHBOARD_NEW;?></button> -->
                     
                     
                     <div class="col-md-6" style="padding:0;">
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
                        <div style="clear: both"></div>
                     </div>
                  </div>
                  <div class="col-md-6" style="padding: 0px;">
                     <!-- Inserted old search component-->
                  </div>
               </div>
			   */?>
			    <div class="clear"></div>
            <div id="dashbaord-cards-container">
               <div class="scrollbar1 scroll-outer">
                  <div class="content scroll-inner" id="dashCard">
                     <div id="patientreview_ALL">
                        <?php
                           echo addDashboardCards($dashboardCards,$_COOKIE['type']);
                           ?>
                        <!--<div class="col-lg-12 pagination">
                           <ul>
                           <li><a href="#">Prev</a></li>
                           <li><a href="#">1</a></li>
                           <li><a href="#">2</a></li>
                           <li><a href="#">...</a></li>
                           <li><a href="#">Next</a></li>
                           </ul>
                           </div>-->
                     </div>
                     <!-- Added reviewed cards -->
                     <!-- <div id="patientreviewedcard_ALL" style="display:none;">
                        <?php
                           echo addReviewedDashboardCards($dashboardCards, $_COOKIE['type']);
                           ?>
                        </div> -->
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
						<button class="btn-neutral-default" type="submit">Filter by Date</button>
						</div>
 </form>						
					</div>
				</div>
			</div>
		 </div>
		 		 </div>

         </div>
		 
		 
      </div>
   </div>
   <div class="push"></div>
</div>
<?php include '../../common/pages/dashboard_footer.php';
   include 'popup/timeOut.php';
   ?>
<!--end footer -->
<script type="text/javascript">
   // app is global var!
   app = angular.module('mainApp', ['ngRoute']);
   
   app.config(['$routeProvider', function ($routeProvider) {
   $routeProvider
   	.when("/patient_list_aj/:actionId", {templateUrl: "../../app/views/patient_list.html", controller: "PatientListCtrl"})
   	.when("/patient_list_aj/:actionId/:filter", {templateUrl: "../../app/views/patient_list.html", controller: "PatientListCtrl"})
   	.when("/provider_list_aj/", {templateUrl: "../../app/views/provider_list.html", controller: "ProviderListCtrl"})
   }]);
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/app/views/controllers/patientListCtrl.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/app/views/controllers/providerListCtrl.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
   	$(document).on('click','.moredetail', function(){
   		var idServlent = $(this).attr("id");
   		idServlent = idServlent.split("_");
   		idServlent = idServlent[1];
   	  $(".NPI_CardDetails").slideUp();
   	  $(".lessDetail").css("display","none");
   	  $(".moredetail").css("display","block");
   	  $("#NPI_CardDetails_"+idServlent).slideDown();
   	  $("#moredetail_"+idServlent).css("display","none");
   	  $("#lessDetail_"+idServlent).css("display","block");
   	}); 
   	
   	 $(document).on('click','.lessDetail', function(){
   		var idServlent = $(this).attr("id");
   		idServlent = idServlent.split("_");
   		idServlent = idServlent[1];
   	  $("#NPI_CardDetails_"+idServlent).slideUp();
   	  $("#moredetail_"+idServlent).css("display","block");
   	  $("#lessDetail_"+idServlent).css("display","none");
   	}); 
   });
</script>
<div class="modal fade" id="survletModalNPI" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content modelContent">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Cross_Modal.png" /></span></button>
            <h4 class="modal-title" id="myModalLabel">Urgent Care Communication</h4>
         </div>
         <div class="modal-body">
            <div class="form-group">
               <div class="col-md-12" id="searchResult">    
                  Are you sure you want to view this communication?
               </div>
            </div>
         </div>
         <div class="modal-footer modal-foot">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary " data-dismiss="modal" id="confirmCareComm" onclick="confirmCareComm(this)" >Yes</button>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function () {
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
   
   // Excel Link: - START
   function getQueryParams(qs) {
   qs = qs.split('+').join(' ');
   
   var params = {},
       tokens,
       re = /[?&]?([^=]+)=([^&]*)/g;
   
   while (tokens = re.exec(qs)) {
       params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
   }
   
   return params;
   }
   function isEmpty(obj) {
   if(obj == undefined) 
       return true;
   for(var prop in obj) {
       if(obj.hasOwnProperty(prop))
               return false;
   }
   
   return true;
   }
   // Open edit patient: 
   var params = getQueryParams(document.location.search);
   if (!isEmpty(params)) {
   var patId = params.editPatient;
   if (patId != undefined && patId != '') {
       openPageWithAjax('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php', 'edit=true&patientId='+patId, 'menu-content', event, this)
   }
   }
   
   // Excel Link: - END			
</script>
<script>
$(window, document, undefined).ready(function() {

  $('input').blur(function() {
    var $this = $(this);
    if ($this.val())
      $this.addClass('used');
    else
      $this.removeClass('used');
  });

  var $ripples = $('.ripples');

  $ripples.on('click.Ripples', function(e) {

    var $this = $(this);
    var $offset = $this.parent().offset();
    var $circle = $this.find('.ripplesCircle');

    var x = e.pageX - $offset.left;
    var y = e.pageY - $offset.top;

    $circle.css({
      top: y + 'px',
      left: x + 'px'
    });

    $this.addClass('is-active');

  });

  $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
  	$(this).removeClass('is-active');
  });

});
</script>