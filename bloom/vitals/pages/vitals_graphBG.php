<?php
	$data = explode("-",$_REQUEST["vitalType"]);
		$vitalType = implode(" ",$data);
		  $userType = strtoupper($_COOKIE['type']);

  include 'popup/CientSiderror_popup.php';
  include '../../common/util/VMCPortalConstants.php';
  include '../../common/util/APIUtil.php';
  include '../../common/classes/EntityUtil.php';

	$entityUtil = new EntityUtil();
	
	$paramArray = array();
	if($_COOKIE['type'] == 'Provider' or $_COOKIE['type'] == 'provider' or $_COOKIE['type'] == 'PROVIDER')
		{
			if(!is_null($_REQUEST['contextPId']))
			{
				$patientId = $_REQUEST['contextPId']; 
			}
		}
		else if($_COOKIE['type'] == 'Patient' or $_COOKIE['type'] == 'PATIENT' or $_COOKIE['type'] == 'patient')
		{
			$patientId = $entityUtil->getLoggedInEntityId();
			
		}
	$paramArray[0] = $patientId;
	$devicelist = $entityUtil->getObjectFromServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
	
	$assignedDevices = $devicelist; 
	$count = count($assignedDevices);
	$deviceConfigId = "";
	$paramArray = array();
	$allDevices = $entityUtil->postObjectToServer($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
	foreach($allDevices as $eachDevice)
	{	
		$devicesId = $eachDevice->{deviceConfigId};
		
		foreach($assignedDevices as $devicedata)
		{

			if($devicesId == $devicedata->{fkdeviceConfigId})
			{
				
				$measurementName1 = $devicedata->{measurementName1};
				$deviceName = strtoupper($measurementName1);
	
				 if($deviceName == VMCPortalConstants::$GLUCOSE)
				{
					$deviceConfigId = $eachDevice->{deviceConfigId};
					break;
				}
				
			}
		}
	}
	
	//var_dump($devicelist);
?>
<link rel="stylesheet" type="text/css" media="screen" href="/gladstone/portal/bloom/vitals/scripts/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/jquery.canvasjs.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.body-Weight-Table tr').on('click', function(e){
    e.preventDefault();
    $('.body-Weight-Table tr.selected-Weight').removeClass('selected-Weight');
    $(this).addClass('selected-Weight');
});
$("#vitaUserType").val("<?php echo $userType; ?>");
var deviceConfigId="<?php echo $deviceConfigId; ?>";
if(deviceConfigId)
{
$("#deviceConfigID").val(deviceConfigId);
}
});
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_graphBG.js"></script>
<link type="text/css" rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/vitals/scripts/css/bloodPressure.css" />
<div class="col-md-8 padd-top20">
<input type="hidden" name="vitaUserType" id="vitaUserType" />
			
	<div class="card-container">
	  <div class="col-lg-12 assessments">
		  <div class="pull-left">
			<h3 class="page-title"><select name="vitalName" id="vitalName">
			<?php
			 foreach($devicelist as $device)
			 {
				$measurementName = $device->{measurementName1};
				if($measurementName == "Diastolic")
				{
				$measurementName = "Blood Pressure" ;
				}
				else if($measurementName == "Pulse")
				{
				$measurementName = "Blood Oxygen" ;
				}
			
				 if($device->{fkdeviceConfigId} == $_POST["deviceConfigId"])
				{
				?>
					<option value="<?php echo $device->{fkdeviceConfigId}; ?>" selected="selected"><?php echo $measurementName;?></option>
				  
					<?php
				} 
				else
				{
				  ?>
					<option value="<?php echo $device->{fkdeviceConfigId}; ?>"><?php echo $measurementName;?></option>
				  
					<?php
				}  
			}
			 ?>
			   </select></h3>
		  </div>
		  <?php
		/*  $userType = strtoupper($_COOKIE['type']); 
		  if($userType == "PATIENT")
		  {*/
		  ?>
		  
		  <div>
		  <?php
		  if($vitalType == "Blood Pressure")
		  {
		  ?>
		   <h3 class="neutral-text"><a href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_bloodPressure_entry.php?inputType=BLOOD_PRESSURE','deviceConfigID=<?php echo $_POST["deviceConfigId"];?>&contextPId=<?php echo $patientId; ?>','menu-content',event,this)">Add Manual Reading</a></h3>
		  <?php
		  }
		  else if($vitalType == "Body Weight")
		  {
		  ?>
		   <h3 class="neutral-text"><a href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_bodyWeight_entry.php?inputType=WEIGHT_SCALE','deviceConfigID=<?php echo $_POST["deviceConfigId"];?>&contextPId=<?php echo $patientId; ?>','menu-content',event,this)">Add Manual Reading</a></h3>
		  <?php
		  }
		  else if($vitalType == "Blood Oxygen")
		  {
		  ?>
		   <h3 class="neutral-text"><a href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_bloodOxygen_entry.php?inputType=PULSE_OXIMETER','deviceConfigID=<?php echo $_POST["deviceConfigId"];?>&contextPId=<?php echo $patientId; ?>','menu-content',event,this)">Add Manual Reading</a></h3>
		  <?php
		  }
			else if($vitalType == "Peak Flow")
		  {
		  ?>
		   <h3 class="neutral-text"><a href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_peakFlow_entry.php?inputType=PEAK_FLOW_METER','deviceConfigID=<?php echo $_POST["deviceConfigId"];?>&contextPId=<?php echo $patientId; ?>','menu-content',event,this)">Add Manual Reading</a></h3>
		  <?php
		  }  
		  else if($vitalType == "Blood Glucose")
		  {
		  ?>
		   <h3 class="neutral-text"><a href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_glucose_entry.php?inputType=GLUCOSE','deviceConfigID=<?php echo $_POST["deviceConfigId"];?>&contextPId=<?php echo $patientId; ?>','menu-content',event,this)">Add Manual Reading</a></h3>
		  <?php
		  }  
		  ?>
		   
		  </div>
		  <?PHP
		 // }
		  ?>
	  </div>
	  <div class="col-lg-12 Blood_Pressure_Inner1">
		<div class="row Graph_Body_Weight">
		  <div class="col-md-6">
			<ul class="days_GBW">
			  <li class="days selectedDate"><a href="#">7 Days</a></li>
			  <li class=" days"><a href="#">30 Days</a></li>
			  <li class="days"><a href="#">90 Days</a></li>
			</ul>
		  </div>
		  <?php
		  if($vitalType == "Blood Glucose")
		  {
		  ?>
		<div align="right" class="pre-post-meal Blood-Glucose-Graph"><a  style="cursor:pointer"><span data="ALL" class="active">All</span></a><a style="cursor:pointer"><span data="PRE">Pre-Meal</span></a><a  style="cursor:pointer"><span data="POST">Post-Meal</span></a> </div>
		<input type="hidden" id="meal-type" />
		  <?php
		  }
		  ?>
		</div>
		
	 
	 
		<div id="chartContainer" style="height: 300px; width: 100%;" class="graph_Image">
		</div>

	  </div>
	  
	  <div class="col-lg-12 body-Weight-Table" style="padding: 0px;">
	  <div class="table-responsive">
	  <table class="table">
		  <tbody id="tbodyId">
		   
		   </tbody>
		</table>
	  </div>
	  </div>
	  
	</div>
</div>

<div class="col-md-4 padd-top50">
			<div class="sidebar-filter">
				<div class="card">
					<div class="filter-tabs">
					<?php
		  if($vitalType == "Blood Glucose")
		  {
		  ?>
						<div class="padd-15 pre-post-meal ">
							<button class="btn btn-neutral" data="ALL">All</button>
							<button class="btn btn-default active" data="PRE">Pre Meal</button>
							<button class="btn btn-neutral" data="POST">Post Meal</button>
						</div> 
						<input type="hidden" id="meal-type" />
		  <?php
		  }
		  ?>
						
						<div class="divider"></div>
						<div class="padd-15 days_GBW">
							<button class="btn btn-default active">7 Days</button>
							<button class="btn btn-neutral">14 Days</button>
							<button class="btn btn-neutral">30 Days</button>
						
						</div>

					</div>
				</div>
			</div>
		 </div>
<style>
.pre-post-meal.Blood-Glucose-Graph span {
    background: transparent none repeat scroll 0 0;
    border: 0 none;
    color: #3c3c3c;
    font-size: 16px;
    font-weight: normal;
	padding: 4px 5px;
}
.pre-post-meal.Blood-Glucose-Graph {
    margin-right: 18%;
}
.pre-post-meal.Blood-Glucose-Graph .active {
    background: transparent none repeat scroll 0 0;
    border: 0 none;
    color: #1faff9;
    font-size: 16px;
    font-weight: normal;
    text-decoration: underline !important;
}

</style>