<?php
	$data = "";
	$deviceId = "";
	$glucoseId = "";
	$entityUtil = new EntityUtil();
	$paramArray = array();
	$paramArray[0] = $_COOKIE["id"];
	$devicelist = $entityUtil->getObjectFromServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
	$assignedDevices = $devicelist; 
	$count = count($assignedDevices);
	$paramArray = array();
	$allDevices = $entityUtil->postObjectToServer($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
	foreach($allDevices as $eachDevice)
	{	
		$device = $eachDevice->{deviceConfigId};
		
		foreach($assignedDevices as $devicedata)
		{

			if($device == $devicedata->{fkdeviceConfigId})
			{
				
				$measurementName1 = $devicedata->{measurementName1};
				$deviceName = strtoupper($measurementName1);
				if($deviceName == VMCPortalConstants::$PULSE)
				{
					 $deviceId = $eachDevice->{deviceConfigId};
					 $onClick4 = 'openPageWithAjax("../../vitals/pages/vitals_graphBP.php","deviceConfigId='.$deviceId.'&vitalType=Blood-Oxygen","menu-content",event,this)';
					 $data = $data."<li class='bio_4'><a href='#' onClick=$onClick4>Blood Oxygen</a></li>";
				}
				else if($deviceName == VMCPortalConstants::$DIASTOLIC)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$onClick2 = 'openPageWithAjax("../../vitals/pages/vitals_graphBP.php","deviceConfigId='.$deviceId.'&vitalType=Blood-Pressure","menu-content",event,this)';
					$data = $data." <li class ='bio_2'><a href='#' onClick=$onClick2>Blood Pressure</a></li>";
				}
				else if($deviceName == VMCPortalConstants::$WEIGHT)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$onClick3 = 'openPageWithAjax("../../vitals/pages/vitals_graphBP.php","deviceConfigId='.$deviceId.'&vitalType=Body-Weight","menu-content",event,this)';
					$data = $data." <li class='bio_3'><a href='#' onClick=$onClick3>Body Weight</a></li>";
				}
				else if($deviceName == VMCPortalConstants::$PEAKFLOW)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$onClick3 = 'openPageWithAjax("../../vitals/pages/vitals_graphPF.php","deviceConfigId='.$deviceId.'&vitalType=Peak-Flow","menu-content",event,this)';
					$data = $data." <li class='bio_3'><a href='#' onClick=$onClick3>Peak Flow Meter</a></li>";
				}
				
				else if($deviceName == VMCPortalConstants::$GLUCOSE)
				{
					$deviceId = $eachDevice->{deviceConfigId};
					$glucoseId = $deviceId;
					$onClick = 'openPageWithAjax("../../vitals/pages/vitals_graphBG.php","deviceConfigId='.$deviceId.'&vitalType=Blood-Glucose","menu-content",event,this)';
					$data = $data." <li class='bio_1'><a href='#' onClick=$onClick>Glucometer</a></li>";
				}
				
			}
		}
	}

?>
<style>
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
/*Sub_Menu*/
 a {
	text-decoration: none !important;
	/*height: 100%; */
	color: #000;
	font-weight: bold;
	/*font-size: 22px; */
	font-weight: normal;
}
a:hover {
	color: #000;
}
.alert > a {
    height: 38px;
}
#submenu1 li {
	padding-left:94px;
	padding-top:10px;
	font-size: 22px;
}
 #submenu 1li a {
 padding-top: 12px;
 float: left;
}
#submenu1 li a:hover {
	color:#000;
}
#submenu1 li a.active {
	color:#000;
}
#submenu1 span img {
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
.DropDownMainLi1 {
	background : url('../../login/images/Dropdown.png') right no-repeat !important;
}
li .col-md-10 > p {
	float: left;
	color: #000;
	
	font-size: 21px;
	font-weight: normal;
	padding: 0 0 0 4px;
}
#portal-menu .nav img {
	width: 48px;
}

.img_msg img
{
width:40px;
}
ul.leftnav li.active a
{
	 font-weight: bold !important;
    text-decoration: underline !important;
}
</style>
<div class="login-nav-container">
<?php /*
  <ul class="nav">
  
    <li ref="0"> <a href="">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_home.png" alt="" /> </div>
      <div class="col-md-10">
        <p style="margin-top: 13px"> <?php echo constantAppResource::$COMMON_MENU_TEXT_HOME;?> </p>
      </div>
      </a> </li>

          <?php
		 echo $data;
		 ?>
  
 
    <li ref="0"> <a href="#" onClick="openPageWithAjax('../../portalLearn/pages/portal_learn.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_learn.png" alt="" /> </div>
      <div class="col-md-10">
        <p style="margin-top: 13px"> <?php echo constantAppResource::$COMMON_MENU_TEXT_LEARN;?> </p>
      </div>
      </a> </li>
    <li ref="0"> <a href="#" paginate="true" onClick="openPageWithAjax('../../messages/pages/messages.html','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_massage.png" alt="<?php echo constantAppResource::$COMMON_MENU_TEXT_MESSAGES;?>" /> </div>
      <div class="col-md-10" style="padding-ri: 0px">
        <p style="margin-top: 13px"> <?php echo constantAppResource::$COMMON_MENU_TEXT_MESSAGES;?> </p>
      </div>
      </a> </li>
    <li ref="0"> <a href="#" onClick="openPageWithAjax('../../patientcare/pages/patient_care.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_patient.png" alt="" /> </div>
      <div class="col-md-10">
        <p style="margin-top: 13px"> <?php echo constantAppResource::$COMMON_MENU_TEXT_PATIENTCARE;?> </p>
      </div>
      </a> </li>
    <li ref="0"> <a href="#" onClick="openPageWithAjax('../../labMetrics/pages/labmetrics_graph.html','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/drawer_metrics.png" alt="<?php echo constantAppResource::$COMMON_MENU_TEXT_MESSAGES;?>" /> </div>
      <div class="col-md-10" style="padding-ri: 0px">
        <p style="margin-top: 13px">Lab Metrics</p>
      </div>
      </a> </li>
    <li ref="0"> <a href="#" onClick="openPageWithAjax('../../reports/pages/report_weekly_dashboard.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_reports.png" alt=""> </div>
      <div class="col-md-10">
       
        <p style="margin-top: 5px">Reports</p>
        
      </div>
      </a> </li>
       <li ref="0"> <a href="#" onClick="openPageWithAjax('../../survey/pages/showSurvey.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_reports.png" alt=""> </div>
      <div class="col-md-10">
       
        <p style="margin-top: 5px">Survey</p>
        
      </div>
      </a> </li>
  <!--  <li ref="0"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_supplies.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"><img
                                src="../../login/images/Box.png" alt="Supplies" /></div>
      <div class="col-md-10" >
        <p style="margin-top: 9px">Supplies</p>
      </div>
      </a></li>-->
      
      <li ref="0"><a href="#" onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php','','menu-content',event,this)">
      <div class="col-md-2" style="padding:  2px 0 0 0"><img
      src="../../login/images/Box.png" alt="Supplies" /></div>
      <div class="col-md-10" >
        <p style="margin-top: 9px">Patient Profile</p>
      </div>
      </a></li>
    <li> <a href="../../login/pages/logout.php">
      <div class="col-md-2" style="padding:  2px 0 0 0"> <img src="../../login/images/nav_logout.png" alt="" /> </div>
      <div class="col-md-10">
        <p style="margin-top: 13px"> <?php echo constantAppResource::$COMMON_MENU_TEXT_LOGOUT;?> </p>
      </div>
      </a> </li>
	  */?>
		<div class="nav Activity">
			<div class="page-header">
				<span class="title">Activity</span>
				<span class="sub-title">Tap cards to mark them as reviewed.</span>
			</div>
			
			<ul class="nav Activity leftnav">  
				 <li ><a href="#">Feed</a></li> 
				 <li><a href="#" onClick="openPageWithAjax('../../portalLearn/pages/portal_learn.php','','menu-content',event,this)">Learn</a></li> 
				 <li><a  href="#" paginate="true" onClick="openPageWithAjax('../../messages/pages/messages.html','','menu-content',event,this)">Messages</a></li> 
				 <li><a href="#" onClick="openPageWithAjax('../../patientcare/pages/patient_care.php','','menu-content',event,this)">Patient Care</a></li> 
				 <li><a href="#" onClick="openPageWithAjax('../../reports/pages/report_weekly_dashboard.php','','menu-content',event,this)">Reports</a></li> 
				 <li><a href="#" onClick="openPageWithAjax('../../survey/pages/showSurvey.php','','menu-content',event,this)">Survey</a></li> 
			</ul>
		</div>
		
		<div class="nav Biometrics" style='display:none'>
			<div class="page-header">
				<span class="title">Biometrics</span>
			</div>
			<ul class="nav Biometrics leftnav">
				<?php echo $data;?>
			</ul>
		</div>
		<div class="nav Profile" style='display:none'>
			<div class="page-header">
				<span class="title">Profile</span>
			</div>
		</div>
		<div class="nav Support" style='display:none'>
			<div class="page-header">
				<span class="title">Support</span>
			</div>
			<ul class="nav Support">  
				<li><a href="#" id="aboutPage">About</a></li> 
			</ul>
		</div>
		
		</div>
<script>
$(function() {
    $('.withoutPatient').click(function() {
        $('#menu-content-container li').removeAttr('ref');
    });
})
</script>
<script>
		$(document).ready(function(){
		$('.leftnav li:first-child').addClass('active');
		$('.leftnav').on('click', 'li', function() {
		$('.leftnav li.active').removeClass('active');
		$(this).addClass('active');
});

});
			</script>
<script type="text/javascript">
function filterMenu(currentMenu)
{
	$(".login-nav-container	.nav").hide();
	$("#navbar li").removeClass('active');
	$(currentMenu).addClass('active');
	var activeMenu = $(currentMenu).find('a').text();
	$("."+activeMenu).show();

}

	$( document ).ready(function() {
	$(".login-nav-container	.nav").hide();
	var activeMenu = $("#navbar li.active").text();
	$("."+activeMenu).show();
	
	
		
    	$("#mainli").click(function(){
			$("#submenu").slideToggle(500);
			$("#mainli .DropDownMainLi").toggleClass("DropDownMainLi1");
		});
		$("#mainli1").click(function(){
			$("#submenu1").slideToggle(500);
			$("#mainli1 .DropDownMainLi").toggleClass("DropDownMainLi1");

		});
		$("#mainli2").click(function(){
			$("#submenu2").slideToggle(500);
		});
	/*
	$("#mainli").click(function() {
	});
	
	$("#mainli1").click(function() {
	});
	
*/
	
	});
	
</script>
