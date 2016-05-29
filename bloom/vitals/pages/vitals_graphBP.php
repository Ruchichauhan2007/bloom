<?php
	$data = explode("-",$_REQUEST["vitalType"]);
		$vitalType = implode(" ",$data);
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
	if($patientId)	
	{
		$paramArray[0] = $patientId;
		$devicelist = $entityUtil->getObjectFromServer($paramArray, "getDevicesByPatientId", VMCPortalConstants::$API_EMR);
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
var deviceConfigId="<?php echo $_POST["deviceConfigId"]; ?>";
if(deviceConfigId)
{
$("#deviceConfigID").val(deviceConfigId);
}
});
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_graphBP.js"></script>
<link type="text/css" rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/vitals/scripts/css/bloodPressure.css" />
<div class="col-md-8 padd-top20">
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
      </div>

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
						<div class="padd-15 days_GBW">
							<button class="btn btn-default days selectedDate active">7 Days</button>
							<button class="btn btn-neutral days">14 Days</button>
							<button class="btn btn-neutral days ">30 Days</button>
						
						</div>
				</div>
			</div>
</div>



