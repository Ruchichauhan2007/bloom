<?php
	$deviceId = "";
	$glucoseId = "";
	$bpId = "";
	$weightId = "";
	$oxygenId = "";
	$peakId = "";
	$entityUtil = new EntityUtil();
	$paramArray = array();
	$allDevices = $entityUtil->postObjectToServer($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
	foreach($allDevices as $eachDevice)
	{	
	
		$measurementName1 = $eachDevice->{measurementName1};
		$deviceName = strtoupper($measurementName1);
		 if($deviceName == VMCPortalConstants::$GLUCOSE)
		{
			$deviceId = $eachDevice->{deviceConfigId};
			$glucoseId = $eachDevice->{deviceConfigId};
		}
		else if($deviceName == VMCPortalConstants::$DIASTOLIC)
		{
			$bpId = $eachDevice->{deviceConfigId};
		}
		else if($deviceName == VMCPortalConstants::$WEIGHT)
		{
			$weightId = $eachDevice->{deviceConfigId};
		}
		else if($deviceName == VMCPortalConstants::$PULSE)
		{
			$oxygenId = $eachDevice->{deviceConfigId};
		}
		else if($deviceName == VMCPortalConstants::$PEAKFLOW)
		{
			$peakId = $eachDevice->{deviceConfigId};
		}
	}

?>
<style>
/*Sub_Menu*/
#portal-menu .nav img {
    width: 48px;
}
#submenu li p {
float: left;
color: #000;
font-weight: bold;
font-size: 14x;
font-weight: normal;
padding: 0;
}
li .col-md-10 > p {
float: left;
color: #000;
font-size: 14px;
font-weight: normal;
padding: 0 0 0 4px;
}
#submenu li {
    height: 48px;
    overflow: hidden;
    padding-left: 40px;
    padding-top: 0px;
}
#submenu1 li {
    height: 48px;
    overflow: hidden;
    padding-left: 40px;
    padding-top: 0px;
}

#submenu2 li {
    height: 48px;
    overflow: hidden;
    padding-left: 40px;
    padding-top: 0px;
}

#submenu3 li {
    height: 48px;
    overflow: hidden;
    padding-left: 40px;
    padding-top: 0;
}

#submenu li a, #submenu1 li a, #submenu2 li a, #submenu3 li a{
	color: #000;
}

#submenu span img {
    float: left;
}
.nav > li#mainli a {
    background : url('../../login/images/Dropdown1.png') right no-repeat;
    margin-right: 26px;
}

.nav > li#mainli1 a {
    background : url('../../login/images/Dropdown1.png') right no-repeat;
    margin-right: 26px;
}

.nav > li#mainli2 a {
    background : url('../../login/images/Dropdown1.png') right no-repeat;
    margin-right: 26px;
}

.nav > li#mainli3 a {
    background : url('../../login/images/Dropdown1.png') right no-repeat;
    margin-right: 26px;
}

.DropDownMainLi1{
    background : url('../../login/images/Dropdown.png') right no-repeat !important;
}

.col-md-6.Admin {
    padding: 0;
}
.col-md-1.AdminImg {
    padding: 0;
}
.col-md-3.ActionPlan {
    padding: 0 4px;
    text-align: right;
}
.col-md-4.PatCardTime {
    margin-top: 30px;
	float: right;
}

</style>
<?php
/* special logic for Menu show/hide - Later we will change with different approach*/
	$entityUtil = new EntityUtil;
	//$VMCMenuItem = $entityUtil->getMenuBasedOnEntity();

	//valer_dump($VMCMenuArray);

?>

<div class="login-nav-container">
<?php /*
  <ul class="nav">
	<li><a class="withoutPatient" href="#" id="homeLink"><?php echo constantAppResource::$COMMON_MENU_TEXT_HOME;?></a></li>
	<li><a href="#/patient_list_aj/list" paginate="true" class="withoutPatient"> <!-- onClick="openPageInIframe('../../app/views/patientlist.html')" -->
      <?php echo constantAppResource::$COMMON_MENU_TEXT_PATIENT_LIST;?></a></li>

        <li ref="0" id="mainli" class="dropdown1"> <a href="#" class="DropDownMainLi"><p>Patient</p></a> </li>
    <ul id="submenu" style="display:none">
     
         <li class="patMenu"> <a href="#" onClick="openPageWithAjax('../../vitals/pages/setPath.php','','menu-content',event,this)"> 
     <!-- <a class="patAction" id="bio" href="#">-->
          <p><?php echo constantAppResource::$COMMON_MENU_TEXT_TRACK_BIOMETRICES;?></p>
        
        </a></li>
      <li class="patMenu"><a href="#" paginate="true" onClick="openPageWithAjax('../../portalLearn/pages/portal_learn.php','','menu-content',event,this)"> 
      <!--<a class="patAction" id="learn" href="#">-->
        <?php echo constantAppResource::$COMMON_MENU_TEXT_LEARN;?></a></li>
		<?php //if($VMCMenuItem["Sticky Notes"] == "True")
		//{
		?>
		<li class="patMenu"><a href="" paginate="true" onClick="openPageWithAjax('../../messages/pages/messages.html','','menu-content',event,this)"> 
     <!--  <a class="patAction" id="messages" href="#">-->
        <?php echo constantAppResource::$COMMON_MENU_TEXT_MESSAGES;?></a></li>
		<?php
		//}
		?>
		<li class="patMenu"><a href="#" class="" onClick="openPageWithAjax('../../survey/pages/labmetrics_graph.html','','menu-content',event,this)">
		Lab Metrics</a></li>
      <li class="patMenu"><a href=" " onClick="openPageWithAjax('../../patientcare/pages/patient_care.php','','menu-content',event,this)">
      <p><?php echo constantAppResource::$COMMON_MENU_TEXT_PATIENTCARE;?></p></a></li>
		<!--<li class="patMenu"><a href="#"  onClick="openPageWithAjax('../../dashboard/pages/portal_supplies.php','','menu-content',event,this)">
    
      <div class="col-md-2" style="padding:  0px 0 0 0px"></div>
      <div class="col-md-10" style="padding: 0px">
        <p style="margin-top: 9px">Supplies</p>
      </div>
      </a></li>-->
      <li class="patMenu"><a href="#" paginate="true" onClick="openPageWithAjax('../../reports/pages/report_weekly_dashboard.php','','menu-content',event,this)">
     <!-- <a class="patAction" id="reports" href="#">-->
        <?php echo constantAppResource::$COMMON_MENU_TEXT_REPORTS;?></a></li>
        
         <li class="patMenu"><a href="#" paginate="true" onClick="openPageWithAjax('../../survey/pages/showSurvey.php','','menu-content',event,this)">
      <!--<a class="patAction" id="survey" href="#">-->
        Survey</a></li>

    </ul>

	<li ref="0" id="mainli1" class="dropdown1"> <a href="#" class="DropDownMainLi">Patient Information</a> </li>
    <ul id="submenu1" style="display:none">
	<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../common/pages/portal_providerList.php','','menu-content',event,this)">
    Profile</a></li>

      <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../contentlibrary/pages/contentLibrary.php','','menu-content',event,this)">
      Devices</a></li>

     <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/configuration.php','','menu-content',event,this)">
     Scheduling</a></li>

       <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/configuration.php','','menu-content',event,this)">
      Supplies</a></li>

    </ul>
     <li ref="0" id="mainli2" class="dropdown1"> <a href="#" class="DropDownMainLi">
      Provider</a> </li>
    <ul id="submenu2" style="display:none">
	<li><a href="#/provider_list_aj" class="withoutPatient" paginate="true" <!--onClick="openPageInIframe('../../app/views/providerlist.html')"-->
      <?php echo constantAppResource::$COMMON_MENU_TEXT_PROVIDER_LIST;?></a></li>
	  
      <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../contentlibrary/pages/contentLibrary.php','','menu-content',event,this)">
      <?php echo constantAppResource::$COMMON_MENU_TEXT_CONTENT_LIBRARY;?></a></li>
	  
     <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/onCallAlert.php','','menu-content',event,this)">
      On-call Alerts</a></li>
     
	 <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/npi_detail.php','','menu-content',event,this)">
     NPI Detail</a></li>

     <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/pending_fax.php','currentPage=1','menu-content',event,this)">
     Faxes</a></li>

     <li><a href="#" class="withoutPatient" onClick="openExcel('Patients')">Patient Info</a></li>

     <li><a href="#" class="withoutPatient" onClick="openExcel('SignUpSheet')">Help Requests</a></li>

    <!-- <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/uploded_patient.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  0px 0 0 0px;"></div>
      <div class="col-md-10" style="padding:0px;">
        <p style="margin-top: 9px">Uploded Patient</p>
      </div>
      </a></li>-->

     <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/portal_bulkUploadPatient.php','','menu-content',event,this)">
     Upload Patient</a></li>

     <li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/supplyOrder.php','','menu-content',event,this)">
      Supply Orders</a></li>
<!--<li><a href="#" paginate="false" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/pendingRegistration.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  0px 0 0 0px;"></div>
      <div class="col-md-10" style="padding:0px;">
        <p style="margin-top: 9px">Pending Registration</p>
      </div>
      </a></li>-->
       
      <li><a href="#" paginate="false" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/dropdownConfiguration.php','','menu-content',event,this)">
        Control Configuration</a></li>
    </ul>


	<li ref="0" id="mainli3" class="dropdown1"> <a href="#" class="DropDownMainLi">Adherence Report</a> </li>
	
    <ul id="submenu3" style="display:none">
	<li><a href="#" class="withoutPatient" paginate="true" onClick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','extractType=WEEKLY','menu-content',event,this)">
      Weekly</a></li>
		<li><a href="#" class="withoutPatient" paginate="true" onClick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','extractType=MONTHLY','menu-content',event,this)">
      Monthly</a></li>
	<li><a href="#" class="withoutPatient" paginate="true" onClick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','extractType=QUARTERLY','menu-content',event,this)">
    Quarterly</a></li>	
    </ul>
    
    <!--<li><a href="#" paginate="true" class="withoutPatient" onClick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','currentPage=1','menu-content',event,this)">
      <div class="col-md-2" style="padding:0"><img src="../../login/images/nav_reports.png" alt="" /></div>
      <div class="col-md-10">
        <p style="margin-top: 13px">Adherence Report</p>
      </div>
      </a></li>-->
    <li><a href="#" id="aboutPage" class="withoutPatient">About</a></li>

    <li><a href="../../login/pages/logout.php"><?php echo constantAppResource::$COMMON_MENU_TEXT_LOGOUT;?></a></li>
  </ul>
  */?>
			<div class="nav Activity">
				<div class="page-header" id="providerActivity">
					<span class="title">Activity</span>
					<!--<span class="sub-title">Tap cards to mark them as reviewed.</span>-->
					<ul class="nav custom-tabs Activity">
						<li onClick="patientCardFiter(this)"><a href="#" value="All Patients"  paginate="true" class="withoutPatient">All</a>
						</li>
						<li onClick="patientCardFiter(this)"class="active"><a href="#" value="My Patients" paginate="true" class="withoutPatient">My Patients</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="nav Patient" style='display:none'>
				<div class="page-header">
					<span class="title">Patients</span>
					<!--<span class="sub-title">Tap cards to mark them as reviewed.</span>-->
				</div>
				<ul class="nav Patient withoutPatient">
					<li><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_patientList.php','','menu-content',event,this);" paginate="true" class="withoutPatient">Patient List</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openExcel('SignUpSheet')">Help Requests</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openExcel('Patients')">Info Sheet</a>
					</li>
				</ul>
				<ul class="nav Patient withPatient">
					<li><a href="#" onClick="openPageWithAjax('../../login/pages/portal_dashbaordWithPatient.php','','menu-content',event,this);">Activity</a>
					</li>
					<li><a href="#" onClick="openPageWithAjax('../../vitals/pages/setPath.php','','menu-content',event,this)">Biometrics</a>
					</li>
					<li><a href="#" paginate="true" onClick="openPageWithAjax('../../portalLearn/pages/portal_learn.php','','menu-content',event,this)">Learn</a>
					</li>
					<li><a href="" paginate="true" onClick="openPageWithAjax('../../messages/pages/messages.html','','menu-content',event,this)">Messages</a>
					</li>
					<li><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?edit=true&patientId=this.id&type=EDIT','','menu-content',event,this)">Patient Care</a>
					</li>
					<li><a href="#" class="patient" onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=this.id&type=EDIT','','menu-content',event,this)">Profile</a>
					</li>
					<li><a href="#" paginate="true"  onClick="openPageWithAjax('../../reports/pages/report_weekly_dashboard.php','','menu-content',event,this)">Reports</a>
					</li>
					<li><a href="#" paginate="true" onClick="openPageWithAjax('../../survey/pages/showSurvey.php','','menu-content',event,this)">Surveys</a>
					</li>
				</ul>
			</div>

			<div class="nav Provider" style='display:none'>
				<div class="page-header">
					<span class="title">Provider</span>
					<!--<span class="sub-title">Tap cards to mark them as reviewed.</span>-->
				</div>
				<ul class="nav Provider">
					<li><a href="#" paginate="true" class="withoutPatient" onClick="openPageWithAjax('../../adherenceReport/pages/adherenceReportList.php','currentPage=1&extractType=WEEKLY','menu-content',event,this)">Adherence Reports</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../contentlibrary/pages/contentLibrary.php','','menu-content',event,this)">Content Library</a>
					</li>
					<li><a href="#" paginate="false" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/dropdownConfiguration.php','','menu-content',event,this)">Control Configuration</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/pending_fax.php','currentPage=1','menu-content',event,this)">Faxes</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/onCallAlert.php','','menu-content',event,this)">On-call Alerts</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/npi_detail.php','','menu-content',event,this)">NPI Detail</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/portal_providerList.php','','menu-content',event,this)" paginate="true">Provider List</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/supplyOrder.php','','menu-content',event,this)">Supply Orders</a>
					</li>
					<li><a href="#" class="withoutPatient" onClick="openPageWithAjax('../../provider/pages/portal_bulkUploadPatient.php','','menu-content',event,this)">Upload Patients</a>
					</li>
				</ul>
			</div>
			
			<div class="nav Support" style='display:none'>
				<div class="page-header">
					<span class="title">Support</span>
					<!--<span class="sub-title">Tap cards to mark them as reviewed.</span>-->
				</div>
				<ul class="nav Support">
					<li><a href="#" id="aboutPage">About</a>
					</li>
				</ul>
			</div>
</div>


<script type="text/javascript">
function filterMenu(currentMenu)
{
	$(".login-nav-container	.nav").hide();
	$("#navbar li").removeClass('active');
	$(currentMenu).addClass('active');
	var activeMenu = $(currentMenu).find('a').text();
	if(activeMenu == "Patient")
	{
		
		$("ul.withoutPatient").show();
		$("div.Patient").show();
		$("div.Patient div span").text('Patient');
		openPageWithAjax('../../dashboard/pages/portal_patientList.php','','menu-content','',currentMenu);
	}
	else{
			$("."+activeMenu).show();
	}
		

}


	


	$( document ).ready(function() {
		
	$(".login-nav-container	.nav").hide();
	var activeMenu = $("#navbar li.active").text();
	$("."+activeMenu).show();
	
    $("#homeLink").click(function(){
      window.location.href =  window.location.origin+"/gladstone/portal/bloom/login/pages/portal_dashboard.php";
    });

    $('.withoutPatient').click(function() {
      $('#menu-content-container li').removeAttr('ref');
    });

    document.cookie="patListOpened=false";
    $(".patAction").click(function(e) {
      var id = $(this).attr("id");
      if(getCookie('patListOpened') == 'true') {
        var patId = getCookie('selectedPat');
        //alert("Directly Open action: "+id+" for pat: "+patId);
        if(id == "bio") {
          openPageWithAjax('/gladstone/portal/bloom/vitals/pages/setPath.php','contextPId='+patId,'menu-content',event,this);
        }
        if(id == "learn") {
          debugger;
          openPageWithAjax('/gladstone/portal/bloom/portalLearn/pages/portal_learn.php','contextPId='+patId,'menu-content',event,this);
        }
        if(id == "messages") {
          openPageWithAjax('/gladstone/portal/bloom/messages/pages/messages.html','contextPId='+patId,'menu-content',event,this);
        }
        if(id == "patientcare") {
          openPageWithAjax('/gladstone/portal/bloom/patientcare/pages/patient_care.php','contextPId='+patId,'menu-content',event,this);
        }
        if(id == "supplies") {
          openPageWithAjax('/gladstone/portal/bloom/dashboard/pages/portal_supplies.php','contextPId='+patId,'menu-content',event,this);
        }
        if(id == "survey") {
          openPageWithAjax('/gladstone/portal/bloom/survey/pages/showSurvey.php','contextPId='+patId,'menu-content',event,this);
        }
        if(id == "reports") {
          openPageWithAjax('/gladstone/portal/bloom/reports/pages/report_weekly_dashboard.php','contextPId='+patId,'menu-content',event,this);
        }
      } else {
        window.location.hash = "/patient_list_aj/"+id;
        
      }
      e.preventDefault();
    });

    $("#headerDeviceId").val("<?php echo $deviceId ;?>");

    $("#mainli").click(function(){
      $("#menu-content").html($("#menu-content-aj").html());
      $("#submenu").slideToggle("slow",function(){
        calculateHeight();
      });
      $("#submenu1").slideUp("slow");
      $("#submenu2").slideUp("slow");
      $("#submenu3").slideUp("slow");
      $("#mainli1 .DropDownMainLi").removeClass("DropDownMainLi1");
      $("#mainli2 .DropDownMainLi").removeClass("DropDownMainLi1");
      $("#mainli3 .DropDownMainLi").removeClass("DropDownMainLi1");
      $("#mainli .DropDownMainLi").toggleClass("DropDownMainLi1");

    });

    $("#mainli1").click(function(){
      $("#menu-content").html($("#menu-content-aj").html());
      $("#submenu1").slideToggle("slow",function(){
        calculateHeight();
      });
      $("#submenu").slideUp("slow");
      $("#submenu2").slideUp("slow");
      $("#submenu3").slideUp("slow");
      $("#mainli .DropDownMainLi").removeClass("DropDownMainLi1");
      $("#mainli2 .DropDownMainLi").removeClass("DropDownMainLi1");
      $("#mainli3 .DropDownMainLi").removeClass("DropDownMainLi1");
      $("#mainli1 .DropDownMainLi").toggleClass("DropDownMainLi1");
    });

    $("#mainli2").click(function(){
     $("#menu-content").html($("#menu-content-aj").html());
     $("#submenu2").slideToggle("slow",function(){
       calculateHeight();
     });
     $("#submenu1").slideUp("slow");
     $("#submenu").slideUp("slow");
     $("#submenu3").slideUp("slow");
     $("#mainli1 .DropDownMainLi").removeClass("DropDownMainLi1");
     $("#mainli .DropDownMainLi").removeClass("DropDownMainLi1");
     $("#mainli3 .DropDownMainLi").removeClass("DropDownMainLi1");
     $("#mainli2 .DropDownMainLi").toggleClass("DropDownMainLi1");
   });

    $("#mainli3").click(function(){
     $("#menu-content").html($("#menu-content-aj").html());
     $("#submenu3").slideToggle("slow",function(){
       calculateHeight();
     });
     $("#submenu1").slideUp("slow");
     $("#submenu").slideUp("slow");
     $("#submenu2").slideUp("slow");
     $("#mainli1 .DropDownMainLi").removeClass("DropDownMainLi1");
     $("#mainli .DropDownMainLi").removeClass("DropDownMainLi1");
     $("#mainli2 .DropDownMainLi").removeClass("DropDownMainLi1");
     $("#mainli3 .DropDownMainLi").toggleClass("DropDownMainLi1");
   });

  $("#portal-menu div ul.nav ul li ").click(function() {
     
      if($(this).hasClass("patMenu"))
	  {
	  	$("#patientName").hide();       
	   $("#patsImages").hide();
	   if($("#contextPatientName").val() == "")
	   {
	   $("#patients").hide();
	   $("#patImage").hide();
	   }
	   else
	   {
	    $("#patients").show();
	    $("#patImage").show();
		
	   }
	  }
	  else
	  {
	   $("#patientName").hide();
	   $("#patientName").html("");
	   $('#patients option[value="selectedPatient"]').text("");
	   $("#patients").prop("selectedIndex", 2); 
       $("#patImage").hide();
	   $("#patsImages").hide();
	   $("#patients").hide();
	   $("#contextPatientName").val("");
	   $("#contextPatientId").val("");
	   $("#headerMenu li").removeAttr("ref");
	   
	   
	   }

   });

  $("#portal-menu div ul.nav li a p").click(function() {
   var currentMenu = $(this).html();
    if(currentMenu == "Patient List")
	  {
		 $("#patsImages").hide();
		 $("#patients").hide();
		 $("#patImage").hide();
		 $("#contextPatientName").val("");
	     $("#contextPatientId").val("");
		 $("#headerMenu li").removeAttr("ref");
	 }
	 
   });
/*
	$("#mainli1").click(function() {
	});

*/
});

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}
function openExcel(docUrlType) {
  console.log("calling REST..") 
  var formData = {
     'docId' : 1,
     'chars' : docUrlType
   };
 $.ajax({
   type        : 'GET',
   beforeSend  : function (request) {
     request.setRequestHeader("Authorization", authorizationToken);
   },
   url         : window.location.origin + "/gladstone/rest/google/docurl",
   data        : formData,
   statusCode  : {
    401: function() {
      console.log( "Invalid Token" );
      refreshAuthToken(function(token) {
       authorizationToken = token;
       openExcel(docUrlType);
     });
    },
    200: function(data) {
      $('#menu-content').html("<iframe src='"+data+"?user=" + getCookie('user') +"' height='680px' width='100%' scrolling='auto'></iframe>");
      $('#menu-content').css("overflow-y", "hidden");
    }
  }


});
}

function openPageInIframe(url) {
  $('#menu-content').html("<iframe src='"+url+"?user=" + getCookie('user') +"' height='680px' width='100%' scrolling='auto'></iframe>");
	$('#menu-content').css("overflow-y", "hidden");
}

</script>

