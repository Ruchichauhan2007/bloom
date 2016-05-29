<?php
  	$userType = strtoupper($_COOKIE['type']);
  	include 'controller/patient_moreDetail_controller.php';
  	include 'popup/CientSiderror_popup_insurance.php';
 	$entityUtil = new EntityUtil();
	 try 
	 {
			$statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);
			
			$stageOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$STAGE);
			$patientTypeOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$PATIENT_TYPE);
			$thisMonthOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$THIS_MONTH);
			$thisQuarterOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$THIS_QUARTER);
			$previousQuarterTypeOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$PREVIOUS_QUARTER);
			$goalsOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$GOALS);
			
		    $paramArray = array() ;
		    if (isset ( $_REQUEST['type'] or $userType==="PATIENT")) {
		
			if($userType === "PATIENT")
			{
			$patientId = $_COOKIE['id'];
			}
			else{
			$patientId = $_REQUEST['patientId'];
			}
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
			$addressInfo = $patientInfo->{addressInfo};
			$patientMoniker = $patientInfo->{patientMoniker};
			$phoneInfo = $patientInfo->{phoneInfo};
			$emailaddressinfo = $patientInfo->{emailAddressInfo};
			$dateUtil = new DateUtil();
			$dateOfBirthStr = $dateUtil->formatDatetoStr($patientInfo->{dateOfBirth});
			$dateOfCreate = $dateUtil->formatDatetoStr($patientInfo->{createTimeStamp});
			$dateOfUpdate = $dateUtil->formatDatetoStr($patientInfo->{lastStageModified});
			
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$patientInsuranceInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientInsuranceByPatientId", VMCPortalConstants::$API_EMR);
			
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$getPatientGoals = $entityUtil->getObjectFromServer($paramArray, "getPatientGoalsByPatientId", VMCPortalConstants::$API_EMR);
			$goal1 = "";
			$goal2 = "";
			$goal3 = "";
			$target1 = "";
			$target2 = "";
			$target3 = "";
			$progress1 = "";
			$progress2 = "";
			$progress3 = "";
			
			foreach($getPatientGoals as $getPatientGoal)
			{
				if($getPatientGoal->{goalTypeId} == 1)
				{
					$goal1 = $getPatientGoal->{goal};
					$target1 = $getPatientGoal->{target};
					$progress1 = $getPatientGoal->{progress};
				}
				else if($getPatientGoal->{goalTypeId} == 2)
				{
					$goal2 = $getPatientGoal->{goal};
					$target2 = $getPatientGoal->{target};
					$progress2 = $getPatientGoal->{progress};
				}
				else if($getPatientGoal->{goalTypeId} == 3)
				{
					$goal3 = $getPatientGoal->{goal};
					$target3 = $getPatientGoal->{target};
					$progress3 = $getPatientGoal->{progress};
				}
			}
			
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$getPatientMisc = $entityUtil->getObjectFromServer($paramArray, "getPatientMiscByPatientId", VMCPortalConstants::$API_EMR);
			
			
			$dateUtil = new DateUtil();
			$employeeDateofBirth = $dateUtil->formatDatetoStr($patientInsuranceInfo->{employeeDateofBirth});
			
			$paramArray = array();
			$patientFamilyInfo = new stdClass;
			$patientFamilyInfo->patientId = $patientId;
			$patientFamilyInfo->patientFamilyId = 1;
			$patientFamilyInfo->name = "";
			$patientFamilyInfo->phoneNumber = "";
			$patientFamilyInfo->state  = VMCPortalConstants::$NO_UPDATE;
			$paramArray[0] = json_encode($patientFamilyInfo);
			$showFamilyText = $entityUtil->postObjectToServer($paramArray, "createUpdatePatientFamily", VMCPortalConstants::$API_EMR);
			
			
			if(!is_null($patientInfo))
			{
				$addressInfo = $patientInfo->{addressInfo};
				
				if($addressInfo[0]->{addressType} == "BILLING")
				{
					
					$addressInfo[1] = $addressInfo[0];
				}
				
				$phoneInfo = $patientInfo->{phoneInfo};
				if($phoneInfo[0]->{phoneType} == "BILLING")
				{
					$phoneInfo[1] = $phoneInfo[0];
				}
				
				$emailaddressinfo = $patientInfo->{emailAddressInfo};
		
			}
		}
 	}
	catch ( Exception $e ) {
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}


 ?>
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboardNew.css" rel="stylesheet" type="text/css">
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/js/pwdvalidation.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>

<script>
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
				//console.log(key);
				availableMenus.push($.trim(key));
			}
			hideMenu(availableMenus);
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
	$('ul#addPatientMenu li').find('a').each(function(){
			var html = $.trim($(this).html());
			if(!availableMenu.contains(html))
			{	
				var resClass = html.split(" ");
				$(this).parents('li').hide();
			}
		});
}

</script>
<script type="text/javascript">
$(document).ready(function()
{
controlMenu();
	$(".captial").focusout(function(){
		var arr = $(this).val().split(' ');
		var result = "";
		for (var x=0; x<arr.length; x++)
			result+=arr[x].substring(0,1).toUpperCase()+arr[x].substring(1)+' ';
		$(this).val(result.substring(0, result.length-1));
	}); 
	
	});
</script>
<div class="mytab">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="addPatientMenu">
    <li role="presentation" ><a data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)" aria-controls="tab1" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation" class="active"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)"
     data="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)">Support</a></li>
    <li role="presentation"><a onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Prescription</a></li>
      <li role="presentation" id="tab_supplies">
        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"  
          onClick="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">
          Supplies
        </a>
      </li>
    <li role="presentation"><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">Devices</a></li>
    <li role="presentation"><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Device Schedule</a></li>
	<li role="presentation"><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Care Management</a></li>
  </ul>

  <div class="pDet">
	<a href="#" id="showNotesBtn">Notes</a>
    <div class="pName">
   <?php 
	$patName =  $patientInfo->{lastName}." ".$patientInfo->{firstName};
	$patDisplayName = "";
	 if(strlen($patName) > 23) 
	{
	 $patDisplayName = substr($patName,0,23).'...' ;
	 echo $patDisplayName;
	 }
	 else
	 {
	 	echo $patName;
	 }
	
	 ?>
    </div>
     <div class="pDate">
    <?php
	if($dateOfBirthStr!= "")
	{
	$dateOfB = "DOB";
	echo $dateOfB." ".$dateOfBirthStr;
	}
	?>
       
	</div>
 
  </div>
  <!-- Tab panes -->
 <div class="col-md-8 padd-top20"> 
  <div class="tab-content col-md-12">
    <div role="tabpanel" class="tab-pane active" id="tab1">
      <form class="form-horizontal" id="add-status-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-status-form','menu-content',event)">
        <fieldset>
        <!-- Form Name -->
        <legend>Status</legend>
        <div class="form-group">
          <div class="col-md-3">
            <label for="ex1">STAGE</label>
            
    <select id="stage" name="stage" class="form-control">
		 <?php
					 foreach($stageOptions as $stageOption)
					  {
						if(!is_null($patientInfo))
						{
							if($stageOption->{optionValue} == $patientInfo->{stage})
							{
						?>
            <option selected="selected" value="<?php	echo $stageOption->{optionValue};?>">
            <?php	echo $stageOption->{optionValue};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $stageOption->{optionValue};?>">
			<?php	echo $stageOption->{optionValue};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $stageOption->{optionValue};?>">
            <?php	echo $stageOption->{optionValue};?>
            </option>
            <?php
							}
					  }
					  ?>
                      
	</select>
  </div>
          <div class="col-md-3">
            <label for="ex3">PATIENT TYPE</label>
       
    <select id="patientType" name="patientType" class="form-control">

		<?php
					 foreach($patientTypeOptions as $patientTypeOption)
					  {
						if(!is_null($patientInfo))
						{
							if($patientTypeOption->{optionValue} == $patientInfo->{patientType})
							{
						?>
            <option selected="selected" value="<?php	echo $patientTypeOption->{optionValue};?>">
            <?php	echo $patientTypeOption->{optionValue};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $patientTypeOption->{optionValue};?>">
			<?php	echo $patientTypeOption->{optionValue};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $patientTypeOptions->{optionValue};?>">
            <?php	echo $patientTypeOptions->{optionValue};?>
            </option>
            <?php
							}
					  }
					  ?>
                      
	</select>
 </div>
          <div class="col-md-2 pc0">
   
            <label for="ex2">COACHING</label>
  
            <div class="clearfix">
                <label class="radio-inline pb-5">
                  <input name="coaching" id="radios1" value="true" type="radio"  <?php if($patientInfo->{coaching} == true){ echo "checked='checked'";} ?>>
                  Yes
                </label> 
                <label class="radio-inline pb-5">
                  <input name="coaching" id="radios2" value="false" type="radio"  <?php if($patientInfo->{coaching} == false){ echo "checked='checked'";} ?>>
                  No
                </label>
</div>

  </div>
          <div class="col-md-2 mcol3">
            <label for="ex3">Update:<?php echo $dateOfUpdate; ?></label>
            <label for="ex3" class="pb-20">Created:<?php echo $dateOfCreate; ?></label></div>
  

          <div class="col-md-2 mcol3">
      
            <div class="pull-right pt10">
              <button type="reset" name="statusCancel" id="statusCancel" class="btn btn-default btn-linktype">Cancel</button>
             <!-- <button type="submit" name="statusSave" id="statusSave" class="btn btn-success">SAVE</button>-->
             <input type="submit" name="statusSave" value="Save"  id="statusSave"class="btn btn-success"/>
              <input type="hidden" name="saveStatus" id="saveStatus" />
              <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
              <input type="hidden" name="type" value="EDIT"  />
            </div>
          </div>
        </div>
        </fieldset>
      </form>
  	  <form class="form-horizontal" id="add-Tickets-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-Tickets-form','menu-content',event)">
        <fieldset>
        <!-- Form Name -->
        <legend> Tickets</legend>
        <div class="form-group">
          <div class="col-md-5">
            <label for="ex1">OPEN</label>
            <div class="form-group">
  <label class="col-md-0 control-label" for="textinput"></label>  
  <div class="col-md-12">
  <input name="openTicket" id="openTicket" placeholder="#9990111,9990102" class="form-control input-md" type="text" value="<?php echo $getPatientMisc->{openTicket}; ?>">
    
  </div>
</div>
          </div>
          <div class="col-md-5">
            <label for="ex3">CLOSED</label>
           <div class="form-group">
  <label class="col-md-0 control-label" for="textinput"></label>  
  <div class="col-md-12">
  <input name="closedTicket" id="closedTicket" placeholder="#9878979" class="form-control input-md" type="text" value="<?php echo $getPatientMisc->{closedTicket}; ?>">
    
  </div>
</div>
 </div>

         <div class="col-md-2 mcol12">
  <div class="e_x1"><label for="ex3">&nbsp;</label></div>
<div class="pull-right">
              <button name="ticketCancel" id="ticketCancel" class="btn btn-default btn-linktype" type="reset">cancel</button>
              <input type="submit" name="statusSave" value="Save" name="ticketSave" id="ticketSave" class="btn btn-success"/>
               <input type="hidden" name="saveTicket" id="saveTicket" />
              <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
              <input type="hidden" name="type" value="EDIT"  />

            </div>
</div>
          
        </div>
      </fieldset>
      </form>
      <form class="form-horizontal" id="add-engagement-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-engagement-form','menu-content',event)">
        <fieldset>
        <!-- Form Name -->
        <legend>Engagement</legend>
        <div class="form-group">
          <div class="col-md-3 mcol4">
            <label for="ex1">THIS MONTH</label>
           <select class="form-control" name="month" id="month">
           <?php
					 foreach($thisMonthOptions as $thisMonthOption)
					  {
						if(!is_null($getPatientMisc))
						{
							if($thisMonthOption->{optionValue} == $getPatientMisc->{currentEngagement})
							{
						?>
            <option selected="selected" value="<?php	echo $thisMonthOption->{optionValue};?>">
            <?php	echo $thisMonthOption->{optionValue};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $thisMonthOption->{optionValue};?>">
			<?php	echo $thisMonthOption->{optionValue};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $thisMonthOption->{optionValue};?>">
            <?php	echo $thisMonthOption->{optionValue};?>
            </option>
            <?php
							}
					  }
					  ?>
                      
             </select>
          </div>
          <div class="col-md-3 mcol4">
            <label for="ex1">THIS QUARTER</label>
           <select class="form-control" name="quarter" id="quarter">
           <?php 
			$plusIcon1 = "";
			?>
             <?php
					 foreach($thisQuarterOptions as $thisQuarterOption)
					  {
					  if($thisQuarterOption->{optionValue} == 3)
							{
							$plusIcon1 = "+";
							}
						if(!is_null($getPatientMisc))
						{
							if($thisQuarterOption->{optionValue} == $getPatientMisc->{quarterEngagement})
							{
						?>
            <option selected="selected" value="<?php	echo $thisQuarterOption->{optionValue};?>">
            <?php	echo $thisQuarterOption->{optionValue}.$plusIcon1;?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $thisQuarterOption->{optionValue};?>">
			<?php	echo $thisQuarterOption->{optionValue}.$plusIcon1;?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $thisQuarterOption->{optionValue};?>">
            <?php	echo $thisQuarterOption->{optionValue}.$plusIcon1;?>
            </option>
            <?php
							}
					  }
					  ?>
         
            </select>
          </div>
        <div class="col-md-3 mcol4">
            <label for="ex1">PREVIOUS QUARTER</label>
            <?php 
			$plusIcon = "";
			?>
           <select class="form-control" name="prequarter" id="prequarter">
                 <?php
					 foreach($previousQuarterTypeOptions as $previousQuarterTypeOption)
					  {
					  if($previousQuarterTypeOption->{optionValue} == 3)
							{
							$plusIcon = "+";
							}
						if(!is_null($getPatientMisc))
						{
							if($previousQuarterTypeOption->{optionValue} == $getPatientMisc->{prevQuarterEngagement})
							{
							
						?>
            <option selected="selected" value="<?php	echo $previousQuarterTypeOption->{optionValue};?>">
            <?php	echo $previousQuarterTypeOption->{optionValue}.$plusIcon;?>
            </option>
            <?php
							
							}
							else{
							
						?>
			<option  value="<?php	echo $previousQuarterTypeOption->{optionValue};?>">
			<?php	echo $previousQuarterTypeOption->{optionValue}.$plusIcon;?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $previousQuarterTypeOption->{optionValue};?>">
            <?php	echo $previousQuarterTypeOption->{optionValue}.$plusIcon;?>
            </option>
            <?php
							}
					  }
					  ?>

            </select>
          </div>
         
 <div class="col-md-3 mcol12">
  <div class="e_x1"><label for="ex3">&nbsp;</label></div>
<div class="pull-right">
              <button name="engagementCancel" id="engagementCancel" class="btn btn-default btn-linktype" type="reset">cancel</button>
              <input type="submit" name="engagementSave" id="engagementSave" class="btn btn-success" value="SAVE"/>
              <input type="hidden" name="saveEngagement" id="saveEngagement" />
              <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
              <input type="hidden" name="type" value="EDIT"  />
            </div>
</div>

    </div>
            </fieldset>
      </form>
      <form class="form-horizontal" id="add-adherence-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-adherence-form','menu-content',event)">
      <fieldset>
      <!-- Form Name -->
      <legend> Adherence</legend>
      <div class="form-group ">
      <div class="col-md-3 mcol4">
        <div>
          <label for="ex2">VARIANCE</label>
        </div>
        <div class="col-md-12"> 
    <label class="radio-inline">
      <input name="variance" id="radios-0"  type="radio" value="true"  <?php if($patientInfo->{adherenceVariance} == true){ echo "checked='checked'";} ?>>
      Yes
    </label>
    <label class="radio-inline">
      <input name="variance" id="radios-1"  type="radio" value="false"  <?php if($patientInfo->{adherenceVariance} == false){ echo "checked='checked'";} ?>>
      No
    </label> 
        </div></div>
      <div class="col-md-3 mcol4">
        <div>
          <label for="ex2">THIS QUARTER</label>
        </div>
        <div>
          <label class="col-md-2 control-label" for="textinput"><?php
		   $prevFourMonthAdherencePercentage = explode(",",$patientInfo->{prevFourMonthAdherencePercentage}) ;
		  $countPercentageMonth = count($prevFourMonthAdherencePercentage);
		  echo $prevFourMonthAdherencePercentage[$countPercentageMonth-1];
		   ?>%</label>
        </div>
      </div>
      <div class="col-md-3 mcol4">
        <div>
          <label for="ex2">PREVIOUS QUARTER</label>
        </div>
        <div>
          <label class="col-md-2 control-label" for="textinput">
		  <?php 
		  $prevFourQuarterlyAdherencePercentage = explode(",",$patientInfo->{prevFourQuarterlyAdherencePercentage}) ;
		  $countPercentage = count($prevFourQuarterlyAdherencePercentage);
		  echo $prevFourQuarterlyAdherencePercentage[$countPercentage-1];
		  ?>
          %</label>
        </div>
        
      </div>
       <div class="col-md-3 mcol12">
  <div class="e_x1"><label for="ex3">&nbsp;</label></div>
<div class="pull-right">
              <button name="adherenceCancel" id="adherenceCancel" class="btn btn-default btn-linktype" type="reset">cancel</button>
             <input type="submit" name="adherenceSave" id="adherenceSave" class="btn btn-success" value="SAVE"/>
             <input type="hidden" name="saveAdherence" id="saveAdherence" />
              <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
              <input type="hidden" name="type" value="EDIT"  />

            </div>
</div>
      </div>
      </fieldset>
</form>
	  <form class="form-horizontal" id="add-goals-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-goals-form','menu-content',event)">
    <fieldset>
     <legend>Goals</legend>
      <div class="form-group ">
          <div class="col-md-2">
            <label for="ex1">GOAL 1</label>
           <select class="form-control"  id="goal1" name="goals[0][goal]">
            <?php
					 foreach($goalsOptions as $goalsOption)
					  {
						if(!is_null($getPatientGoals))
						{
						
							if($goalsOption->{optionValue} == $goal1)
							{
						?>
            <option selected="selected" value="<?php	echo $goalsOption->{optionValue};?>">
            <?php	echo $goalsOption->{optionValue};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $goalsOption->{optionValue};?>">
			<?php	echo $goalsOption->{optionValue};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $goalsOption->{optionValue};?>">
            <?php	echo $goalsOption->{optionValue};?>
            </option>
            <?php
							}
					  }
					  ?>
         
			</select>
            
          </div>
          <div class="col-md-2">
        <div class="e_x1"><label for="ex3">&nbsp;</label></div>
  <input id="goal1Target" name="goals[0][goalTarget]" placeholder="Target" class="form-control input-md" type="text" value="<?php echo $target1 ?>">
      </div>         
        <div class="col-md-3">
                <div class="e_x1"><label for="ex3">&nbsp;</label></div>
  <input id="goal1Progress" name="goals[0][goalProgress]" placeholder="Progress" class="form-control input-md" type="text" value="<?php echo $progress1 ?>">
	<input  name="goals[0][goalType]" type="hidden" value="1">
        </div>  
              </div>
      <div class="form-group ">
          <div class="col-md-2">
            <label for="ex1">GOAL 2</label>
           <select class="form-control" name="goals[1][goal]" id="goal2">
			<?php
					 foreach($goalsOptions as $goalsOption)
					  {
						if(!is_null($getPatientGoals))
						{
							if($goalsOption->{optionValue} == $goal2)
							{
						?>
            <option selected="selected" value="<?php	echo $goalsOption->{optionValue};?>">
            <?php	echo $goalsOption->{optionValue};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $goalsOption->{optionValue};?>">
			<?php	echo $goalsOption->{optionValue};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $goalsOption->{optionValue};?>">
            <?php	echo $goalsOption->{optionValue};?>
            </option>
            <?php
							}
					  }
					  ?>
         
			</select>
            
          </div>
          <div class="col-md-2">
        <div class="e_x1"><label for="ex3">&nbsp;</label></div>
  <input id="goal2Target" name="goals[1][goalTarget]" placeholder="Target" class="form-control input-md" type="text" value="<?php echo $target2 ?>">
      </div>         
        <div class="col-md-3">
                <div class="e_x1"><label for="ex3">&nbsp;</label></div>
  <input id="goal2Progress" name="goals[1][goalProgress]" placeholder="Progress" class="form-control input-md" type="text" value="<?php echo $progress2 ?>">
<input  name="goals[1][goalType]" type="hidden" value="2">
        </div>  
              </div>
      <div class="form-group ">
          <div class="col-md-2">
            <label for="ex1">GOAL 3</label>
           <select class="form-control" name="goals[2][goal]" id="goal3">
           <?php
					 foreach($goalsOptions as $goalsOption)
					  {
						if(!is_null($getPatientGoals))
						{
							if($goalsOption->{optionValue} == $goal3)
							{
						?>
            <option selected="selected" value="<?php	echo $goalsOption->{optionValue};?>">
            <?php	echo $goalsOption->{optionValue};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $goalsOption->{optionValue};?>">
			<?php	echo $goalsOption->{optionValue};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $goalsOption->{optionValue};?>">
            <?php	echo $goalsOption->{optionValue};?>
            </option>
            <?php
							}
					  }
					  ?>
         
			</select>
            
          </div>
          <div class="col-md-2">
        <div class="e_x1"><label for="ex3">&nbsp;</label></div>
  <input id="goal3Target" name="goals[2][goalTarget]" placeholder="Target" class="form-control input-md" type="text" value="<?php echo $target3 ?>">
      </div>         
        <div class="col-md-3">
                <div class="e_x1"><label for="ex3">&nbsp;</label></div>
  <input id="goal3Progress" name="goals[2][goalProgress]" placeholder="Progress" class="form-control input-md" type="text" value="<?php echo $progress3 ?>">
<input  name="goals[2][goalType]" type="hidden" value="3">
        </div> 
         <div class="col-md-5">
  <div class="e_x1"><label for="ex3">&nbsp;</label></div>
<div class="pull-right">
              <button name="goalsCancel" id="goalsCancel" class="btn btn-default btn-linktype" type="reset">cancel</button>
              <input type="submit" name="goalsSave" id="goalsSave" class="btn btn-success"  value="SAVE"/>
              <?php
			  if(!$getPatientGoals)
			  {
			  ?>
              <input type="hidden" name="saveGoal" id="saveGoal" />
              <?php
			  }
			  else
			  {
			  ?>
               <input type="hidden" name="editGoal" id="editGoal" />
               <?php
			   }
			   ?>
              <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
              <input type="hidden" name="type" value="EDIT"  />

            </div></div>
</div>             
      <!-- Text input-->
      
      
    </fieldset>
  </form>
  
      <form class="form-horizontal pb20" id="add-insurance-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-insurance-form','menu-content',event)">
        <fieldset>
        <!-- Form Name -->
        <legend>Insurance</legend>
        <div class="form-group">
          <div class="col-md-2 mcol3">
            <label for="ex1">INSURED NAME<span style="color:red;">*</span></label>
            <input id="insuredFirstName" name="insuredFirstName" placeholder="First" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{employeeFirstName}?>" maxlength="50" >
          </div>
          
          <div class="col-md-1 mcol3">
            <label for="ex3 ">&nbsp;</label>
            <input id="insuredInitial" name="insuredInitial" placeholder="Initial" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{employeeMiddleInitial}?>" >
          </div>
          <div class="col-md-2 mcol3">
            <label for="ex3">&nbsp;</label>
            <input id="insuredLastName" name="insuredLastName" placeholder="Last" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{employeeLastName}?>" maxlength="50" >
          </div>
          <div id='datetimepicker1' class="col-md-3 p0 mcol4 pc0">
          <div class="col-md-9 mcol10 pctlbl">
           
            <label for="ex3">DATE OF BIRTH</label>
             <?php 
			  if(!$patientInsuranceInfo->{employeeDateofBirth})
			  {
			 
			  ?>
            <input id="insuredDob" name="insuredDob" placeholder="MM/DD/YYYY" class="form-control input-md" type="text">
             <?php 
			  }
			  else
			  {
			  
			  ?>
           <input id="insuredDob" name="insuredDob"  type="text" placeholder="MM/DD/YYYY" class="form-control input-md"  value="<?php echo $employeeDateofBirth ;?>"/>
          <?php 
          }
          ?>
          </div>
         
     <div class="col-md-2 text-left pctlbl">
  <img  src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/celender-icon.png" style="padding-top: 35px;margin-left: -26px;" />
  </div>
  </div>

<div class="col-md-2 mcol3 pctlbl">
            <label for="ex3">PHONE NUMBER<span style="color:red;">*</span></label>
            <input id="insuredPhone" name="insuredPhone" placeholder="###-###-####" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{employeePhoneNumber}?>">
          </div>
          
          
                    
          
    
        </div>
        </fieldset>
        <fieldset>
        <!-- Form Name -->
        
        <div class="form-group">
          <div class="col-md-5">
            <label for="ex1">BILLING ADDRESS<span style="color:red;">*</span></label>
            <input id="address1" name="address1" placeholder="Address line 1" class="form-control input-md" type="text" value="<?php echo $addressInfo[1]->{addressLine1}?>">
          </div>
          <div class="row">
          
          
          <div class="col-md-2">
            <label for="ex3">GROUP ID<span style="color:red;">*</span></label>
            <input id="groupId" name="groupId" placeholder="878789" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{groupId}?>">
          </div>
<div class="col-md-2">
            <label for="ex3">MEMBER ID<span style="color:red;">*</span></label>
            <input id="memberId" name="memberId" placeholder="1233400739" class="form-control input-md" type="text" value="<?php echo $patientInsuranceInfo ->{memberId}?>">
          </div>
      </div>
      </div>
        </fieldset>
  
        <fieldset>
        <!-- Form Name -->
        <div class="form-group">
          <div class="col-md-5">
            <input id="address2" name="address2" placeholder="Address line 2" class="form-control input-md" type="text" value="<?php echo $addressInfo[1]->{addressLine2}?>">
          </div>
          </div>
        
              <div class="row">
              <div class="col-md-2 citytown ">
                <input type="text" name="city" id="city" placeholder="City or Town" class="form-control input-md" value="<?php echo $addressInfo[1]->{city}?>">
              </div>
              
              <div class="col-md-1 pc0">
                <select id="state" name="state" class="form-control pc0 p0">
                  <?php
					 foreach($statesInfo as $state)
					  {
						if(!is_null($addressInfo[1]))
						{
							if($state->{stateId} == $addressInfo[1]->{stateId})
							{
						?>
            <option selected="selected" value="<?php	echo $state->{stateId};?>">
            <?php	echo $state->{stateCode};?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $state->{stateId};?>">
			<?php	echo $state->{stateCode};?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $state->{stateId};?>">
            <?php	echo $state->{stateCode};?>
            </option>
            <?php
							}
					  }
					  ?>
                </select>
              </div>
              <div class="col-md-2">
                <input type="text" name="zip" id="zip" placeholder="Zip code" class="form-control input-md" value="<?php echo $addressInfo[1]->{postalCode}?>">
              </div>
              <div class="col-md-7">
                <div class="pull-right">
                  <button id="insuranceCancel" name="insuranceCancel" class="btn btn-default btn-linktype">cancel</button>
                  <input type="submit" id="insuranceSave" name="insuranceSave" class="btn btn-success" value="SAVE" />
                  <input type="hidden" name="saveInsurance" id="saveInsurance" />
                  <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
                  <input type="hidden" name="type" value="EDIT"  />
                  <input id="patientInsuranceId" name="patientInsuranceId" type="hidden" value="<?php echo $patientInsuranceInfo ->{patientInsuranceId}?>" class="form-control input-md">
                </div>
              </div>
            </div>
            </fieldset>
      </form>
     
        <fieldset>
        <!-- Form Name -->
        
        <legend>Family & Friends Text Notifications</legend>
        <form class="form-horizontal pb20" id="add-moniker-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-moniker-form','menu-content',event)">
    
        <div class="form-group same-gap">
          <div class="col-md-3">
            <label for="ex1">PATIENT MONIKER</label>
            <input id="patientMoniker" name="patientMoniker" placeholder="Patient Moniker" class="form-control input-md" type="text" maxlength="50" value="<?php echo $patientMoniker; ?>">
          </div>          
        
          <div class="col-md-5 pt35">
           <h5>Never use real names or nicknames.</h5>
          </div>
          

			<div class="col-md-2 pt23">         
            <input type="submit" id="monikerAdd" name="monikerAdd" class="btn btn-success btnAdd btnAddDisabled" value="SAVE" disabled/>
            <input type="hidden" name="addMoniker" id="addMoniker" />
            <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />

          </div>
           </div>
           </form>
         <form class="form-horizontal pb20" id="add-family-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','add-family-form','menu-content',event)">
        <h5>Out of range readings are sent by text message to the people in this list.</h5><br />
        
        <div class="form-group same-gap">
          <div class="col-md-3">
            <label for="ex1">FAMILY OR FRIEND NAME</label>
            <input id="memberName" name="memberName" placeholder="Name" class="form-control input-md" type="text" >
          </div>          
        
          <div class="col-md-2">
            <label for="ex3">MOBILE NUMBER</label><span style="color:#FF0000">*</span>
            <input id="mobileNumber" name="mobileNumber" placeholder="(###) ###-####" class="form-control input-md" type="text" >
          </div>
           <div class="col-md-3">
            <label for="ex3">EMAIL</label><span style="color:#FF0000">*</span>
            <input id="familyEmail" name="familyEmail" placeholder="address@email.com" class="form-control input-md" type="text" >
           </div>
          

			<div class="col-md-2 pt23">         
            <input type="submit" id="familyAdd" name="familyAdd" class="btn btn-success btnAdd btnAddDisabled" value="ADD" disabled/>
            <input type="hidden" name="addfamily" id="addfamily" />
            <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />

          </div>
           </div>
           </form>
        </fieldset>
        <?php
		if($showFamilyText)
		{
			foreach($showFamilyText as $showText)
			{
			?>
			<fieldset>
			
			<div class="form-group">
			  <div class="col-md-3">
				<span><?php echo $showText->{name}; ?></span>
			   
			  </div>          
			
			  <div class="col-md-2">
				<span><?php echo $showText->{phoneNumber}; ?></span>
				
			  </div>
              <div class="col-md-3">
              <span><?php echo $showText->{emailAddress}; ?></span>
              </div>
				<div class="col-md-2">         
				<a data-toggle="modal"  data-target="#showTextConfirm" class="btnRemove" id="<?php echo $showText->{patientFamilyId}; ?>"  onclick="openPageWithAjax('../../dashboard/pages/deleteText.php?patientFamilyId=<?php echo $showText->{patientFamilyId}; ?>&memberName=<?php echo $showText->{name}; ?>&mobileNumber=<?php echo $showText->{phoneNumber}; ?>&patientId=<?php echo $showText->{patientId}; ?>','','showTextConfirmBody',event,this)">REMOVE...</a> 
			  </div>
			   </div>
			   <div>&nbsp;</div>
			</fieldset>
			<?php
			}
		}
		?>
       <!-- <fieldset>
         <form class="form-horizontal pb20" id="family-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/patient_moreDetails.php','family-form','menu-content',event)">
        <div class="form-group">
                <div class="col-md-12">
                <div class="pull-right">
                  <button id="familyCancel" name="familyCancel" class="btn btn-default btn-linktype">cancel</button>
                  <input type="submit" id="familySave" name="familySave" class="btn btn-success" value="SAVE" />
                                    
                </div>
              </div>
        </div>
        </form>
        </fieldset>-->
           
     </div>
     <div class="modal fade" id="showTextConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modelContent">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Cross_Modal.png" /></span></button>
        <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
      </div>
       <form  method="post" id="attach-form1">
      <div class="modal-body">
     
       <div class="form-group">
 
    
    <div class="col-md-12" id="showTextConfirmBody">    
 	
    </div>
    
    
      </div>
      </div>
<div class="modal-footer modal-foot">
        
        <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
       
        <input type="hidden" name="confirmRemove" />
        <button type="submit" class="btn btn-primary " data-dismiss="modal" id="confirmRemove"  name="confirmRemove">CONFIRM</button>
       
</div>
   </form>          
 </div>
  </div>
</div>
    <div role="tabpanel" class="tab-pane" id="tab2">...</div>
    <div role="tabpanel" class="tab-pane" id="tab3">...</div>
    <div role="tabpanel" class="tab-pane" id="tab4">...</div>
    <div role="tabpanel" class="tab-pane" id="tab5">...</div>
    <div role="tabpanel" class="tab-pane" id="tab6">...</div>
    <div role="tabpanel" class="tab-pane" id="tab7">...</div>
  </div>
</div>
</div>
<!-- Notes & History : START -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/notes-history.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var patId = '<?php echo $patientInfo->{ patientId }; ?>';
var CURRENT_TIME = '<?php echo date('d M h: i A'); ?>';
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/notes-history.js"></script>

<div class="sidebarBox">
  <div class="scrollingBox" style="overflow-y: scroll; height:1000px;">
    <ul class="notesList">
      <li class="active" id="NH_allTab"><a href="#">All</a></li>
      <li id="NH_notesTab"><a href="#">Notes</a></li>
      <li id="NH_histTab"><a href="#">History</a></li>
    </ul>
    
    <div class="addCmtBox">
      <textarea id="cmtTextArea"></textarea>
      <div>
        <button id="addCmtBtnIcon" class="addCmtBtn" disabled="true" /> 
        <button class="addCmtBtn" style="font-size: 15px; display: inline-block; vertical-align: top; margin-top: 10px;background:none;border:none; color:rgb(203,203,203)" disabled="true">ADD COMMENT</button>
        
        <input class="pinInput1" type="checkbox" id='pinNewCmt' />
        <label for="pinNewCmt" style="width: 25px; height: 25px; margin-top: 5px;" />
      </div>
    </div>
    <div class="pinnedNotes">
	  </div>
    <div class="notesBox"> 
    </div>
  </div>
</div>
<!-- Notes & History : END -->
<script>
$(document).ready(function(){

 $('#datetimepicker1').datetimepicker({
        pickTime: false,
        maxDate: moment(),
		
    });
	
var stage = '<?php echo $stage;?>';
if(stage)
{
$("#stage").val(stage);
}
var patientType = '<?php echo $patientType;?>';
if(patientType)
{
$("#patientType").val(patientType);
}

var currentEngagement = '<?php echo $currentEngagement;?>';
if(currentEngagement)
{
$("#month").val(currentEngagement);
}

var quarterEngagement = '<?php echo $quarterEngagement;?>';
if(quarterEngagement)
{
$("#quarter").val(quarterEngagement);
}

var prevQuarterEngagement = '<?php echo $prevQuarterEngagement;?>';
if(prevQuarterEngagement)
{
$("#prequarter").val(prevQuarterEngagement);
}


var goalTypeId1 = '<?php echo $goalTypeId1;?>';
if(goalTypeId1)
{
$("#goal1").val(goalTypeId1);
}
var goalTypeId2 = '<?php echo $goalTypeId2;?>';
if(goalTypeId2)
{
$("#goal2").val(goalTypeId2);
}
var goalTypeId3 = '<?php echo $goalTypeId3;?>';
if(goalTypeId3)
{
$("#goal3").val(goalTypeId3);
}


	
});
if($("#okay").hasClass("localStorage"))
{
 var patientId = localStorage["patientId"];
  $("#patientId").val(patientId);
 var address1 = localStorage["address1"];
 $("#address1").val(address1);
var city = localStorage["city"];
 $("#city").val(city);
var state = localStorage["state"];
 $("#state").val(state);
var zip = localStorage["zip"];
 $("#zip").val(zip);

var phone = localStorage["phone"];
 $("#phone").val(phone);

var editType = localStorage["editType"];
 $("#editType").val(editType);
 }
 
 
 $(document).ready(function () {
 
	$("#statusCancel,#ticketCancel,#engagementCancel,#adherenceCancel,#goalsCancel,#insuranceCancel").click(function (e) {
       openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT&edit=true','','menu-content',e);
    });
	
});
$("#confirmRemove").click(function(event)
	{
	var patientFamilyId = $("#patientFamilyId").val();
	var patientId = $("#patientId").val();
	openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT&edit=true','patientFamilyId='+patientFamilyId+'&patientId='+patientId+'&confirmRemove=confirmRemove','menu-content',event);
	});
 
 $("#mobileNumber,#memberName, #familyEmail").on('click keyup change focusout input',function() {
var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
 var mobileNumber = $("#mobileNumber").val();
 var name = $("#memberName").val();
 var familyEmail = $("#familyEmail").val();
 if(mobileNumber != "" && name != "" && familyEmail!="" && filter.test(familyEmail))
 {
 	$("#familyAdd").removeClass("btnAddDisabled");
	$("#familyAdd").removeAttr("disabled");
 }
 else
 {
 	$("#familyAdd").addClass("btnAddDisabled");
	$("#familyAdd").attr("disabled","disabled");
 }
 });
 
 $("#patientMoniker").on('click keyup change focusout input',function() {

 var name = $("#patientMoniker").val();
 if(name != "")
 {
 	$("#monikerAdd").removeClass("btnAddDisabled");
	$("#monikerAdd").removeAttr("disabled");
 }
 else
 {
 	$("#monikerAdd").addClass("btnAddDisabled");
	$("#monikerAdd").attr("disabled","disabled");
 }
 });
</script>