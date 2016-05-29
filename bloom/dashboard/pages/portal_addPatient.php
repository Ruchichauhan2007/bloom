<?php
  $institutionName = explode(":", $_SERVER['HTTP_HOST']);
  $userType = strtoupper($_COOKIE['type']); 
  include 'controller/portal_addPatient_controller.php';
  include 'popup/CientSiderror_popup.php';
  include '../../common/util/Constants.php';
  $entityUtil = new EntityUtil();
  $onsubmit = "";
  
  try 
  {
	  $statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);

	  $statusOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$PATIENT_STATUS);

	  $programTypeOptions= $entityUtil->callDropdownControls(VMCPortalConstants::$PROGRAM_TYPE);
	  
	  $timeZoneOptions=$entityUtil->callDropdownControls(VMCPortalConstants::$TIME_ZONE);
	 //var_dump($statusOptions);
	 
	  $paramArray = array() ;
	  $paramArray[0] = VMCPortalConstants::$PHP_EMPTY;
	  $paramArray[1] = "";
	  $providerList=$entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
	 
	  if (isset ( $_REQUEST['edit'] ) or $userType == "PATIENT")
      {
			
			if($userType == "PATIENT")
			{
			$patientId = $_COOKIE['id'];
			}
			else{
			$patientId = $_REQUEST['patientId'];
			}
			$findPatient = array() ;
			$findPatient[0] = $patientId;
			$patientInfos = $entityUtil->getObjectFromServer($findPatient, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
			$patientProviderInfos = $patientInfos->{patientProviderInfos};
			// Get existing credentials
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$credentialsInfo = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
			// Format Date as per MM/DD/YYYY format
			$dateUtil = new DateUtil();
			$dateOdBirthStr = $dateUtil->formatDatetoStr($patientInfos->{dateOfBirth});
			foreach($patientProviderInfos AS $patientProviderInfo)
			{
				$no = $patientProviderInfo->{priorityNo};
				if($no == 1)
				{
					$primaryProvider = $patientProviderInfo->{providerId};
				}
				else if($no == 2)
				{
					$secondaryProvider = $patientProviderInfo->{providerId};
				}
				else if($no == 3)
				{
					$tertiaryProvider = $patientProviderInfo->{providerId};
				}
			}
			
			$addressInfo = null;
			$phoneInfo = null;
			$emailInfo = null;
			if(!is_null($patientInfos))
			{
				$addressInfo = null;
				$phoneInfo = null;
				$emailInfo = null;
			
			
				$addressInfo = $patientInfos->{addressInfo};
				
				if(count($addressInfo) == 1)
				{
					if($addressInfo[0]->{addressType} == "DELIVERY")
					{	
						
						$addressInfo[0] = $addressInfo[0];
					}
				}
				else if(count($addressInfo) == 2)
				{
					if($addressInfo[0]->{addressType} == "BILLING")
					{	
						
						$addressInfo[0] = $addressInfo[1];
					}
					
				}
				$phoneInfos = $patientInfos->{phoneInfo};
				$phoneHome = "";
				$typeHome = "";
				$phoneCell = "";
				$typeCell = "";
				$phoneWork = "";
				$typeWork = "";
				
				foreach($phoneInfos as $phoneInfo)
				{
					if($phoneInfo->{phoneType} == "HOME")
					{
						$phoneHome = $phoneInfo->{phoneNumber};
						$typeHome = $phoneInfo->{preferred};
					}
					else if($phoneInfo->{phoneType} == "CELLPHONE")
					{
						$phoneCell = $phoneInfo->{phoneNumber};
						$typeCell = $phoneInfo->{preferred};
					}
					else if($phoneInfo->{phoneType} == "WORK")
					{
						$phoneWork = $phoneInfo->{phoneNumber};
						$typeWork = $phoneInfo->{preferred};
					}
				}
				$emailaddressinfos = $patientInfos->{emailAddressInfo};
				$primaryEmail = "";
				$secondaryEmail = "";	
					foreach($emailaddressinfos as $emailaddressinfo)
					{
						if($emailaddressinfo->{emailType} == "PRIMARY")
						{
							$primaryEmail = $emailaddressinfo->{emailAddress};
						}
						else if($emailaddressinfo->{emailType} == "SECONDARY")
						{
							$secondaryEmail = $emailaddressinfo->{emailAddress};
						}
					}
			}
		}
	}
	catch ( Exception $e )
	{
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}
   if($patientInfos->{patientId})
  {
  $onsubmit = "postForm('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php?edit=true&patientId=".$patientInfos->{patientId}."&type=EDIT','add-profile-form','menu-content',event)";
  }
  else
  {
	$onsubmit = "postForm('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php','add-profile-form','menu-content',event)";
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
$("#menu-content").unbind('scroll');
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
  <?php
if (isset ( $_REQUEST['edit']) or $userType == "PATIENT") {
?>
  <ul class="nav nav-tabs" id="addPatientMenu" role="tablist">
    <li role="presentation" class="active" id="profile"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfos->{patientId} ;?>&type=EDIT','','menu-content',event,this)"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfos->{patientId}; ?>&type=EDIT','','menu-content',event,this)">Profile</a></li>
    <li role="presentation" id="more"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" 
    onClick="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfos->{patientId}; ?>&type=EDIT&edit=true','','menu-content',event,this)"
     data="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfos->{patientId} ;?>&type=EDIT&edit=true','','menu-content',event,this)">Support</a></li>
    <li role="presentation" id="prescription"><a onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfos->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfos->{patientId} ?>&type=EDIT','','menu-content',event,this)">Prescription</a></li>
      <li role="presentation" id="tab_supplies">
        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"  
          onClick="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfos->{patientId} ?>&patientLastName=<?php echo $patientInfos->{lastName} ?>&patientFirstName=<?php echo $patientInfos->{firstName} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php.php?patientId=<?php echo $patientInfos->{patientId} ?>&patientLastName=<?php echo $patientInfos->{lastName} ?>&patientFirstName=<?php echo $patientInfos->{firstName} ?>&type=EDIT','','menu-content',event,this)">
          Supplies
        </a>
      </li>
    <li role="presentation" id="device"><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfos->{patientId} ?>&patientLastName=<?php echo $patientInfos->{lastName} ?>&patientFirstName=<?php echo $patientInfos->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfos->{patientId} ?>&patientLastName=<?php echo $patientInfos->{lastName} ?>&patientFirstName=<?php echo $patientInfos->{firstName} ?>&type=EDIT','','menu-content',event,this)">Devices</a></li>
    <li role="presentation" id="device_schedule"><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfos->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfos->{patientId} ?>&type=EDIT','','menu-content',event,this)">Device Schedule</a></li>
   <li  id="careManagement" role="presentation"><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfos->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfos->{patientId} ?>&type=EDIT','','menu-content',event,this)">Care Management</a></li>
  </ul>
  <?php
  }
  else
  {
  ?>
  <ul class="nav nav-tabs" role="tablist" id="addPatientMenu">
    <li role="presentation" class="active"><a href="#">Profile</a></li>
    <li role="presentation"><a href="#">Support</a></li>
    <li role="presentation"><a href="#">Prescription</a></li>
    <li role="presentation"><a href="#">Supplies</a></li>
   <!-- <li role="presentation"><a href="#">Notes/History</a></li>-->
    <li role="presentation"><a href="#">Devices</a></li>
    <li role="presentation"><a href="#">Device Schedule</a></li>
	<li  id="careManagement"  role="CareManagement"><a href="#">Care Management</a></li>
  </ul>
  <?php
  }
  ?>
  <div class="pDet">
   <a href="#" id="showNotesBtn">Notes</a> 
    <div class="pName spanHide">
	<?php 
	$patName =  $patientInfos->{lastName}." ".$patientInfos->{firstName};
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
     <div class="pDate spanHide">
     	
    <?php
	if($dateOdBirthStr!= "")
	{
	$dateOfB = "DOB";
	echo $dateOfB." ".$dateOdBirthStr;
	}
	?>
	</div>
 
  </div>
  <!-- Tab panes -->
  <div class="tab-content col-md-12">
    <div role="tabpanel" class="tab-pane active" id="tab1">
   <form class="form-horizontal" id="add-profile-form" onSubmit="<?php echo $onsubmit; ?>" autocomplete="off">
          <fieldset>
            
            <!-- Form Name -->
            <legend>Patient Details</legend>
            
            <!-- Text input-->
            <div class="form-group">
              <div class="col-md-2">
                <label for="ex1">NAME<span style="color:red;">*</span></label>
                <input id="firstName" name="firstName" placeholder="First" class="form-control input-md" type="text" value="<?php echo $patientInfos->{firstName} ?>" maxlength="50">
              </div>
              <div class="col-md-1 pc0">
                <div class="e_x">
                  <label for="ex3">&nbsp;</label>
                </div>
                <input id="initName" name="initName" placeholder="Initial" class="form-control input-md" type="text" value="<?php echo $patientInfos->{middleInitial} ?>" maxlength="10">
              </div>
              <div class="col-md-2">
                <div class="e_x">
                  <label for="ex2"> &nbsp;</label>
                </div>
                <input id="lastName" name="lastName" placeholder="Last" class="form-control input-md"  type="text" value="<?php echo $patientInfos->{lastName} ?>" maxlength="50">
              </div>
              <div class="col-md-3 pc0">
                <div>
                  <label for="ex3">PREFERRED NAME</label>
                </div>
                <input id="prefName" name="prefName" placeholder=" Preferred" class="form-control input-md"  type="text" value="<?php echo $patientInfos->{preferredName} ?>" maxlength="50">
              </div>
            </div>
            <div class="form-group">
            <div>
              <div class="col-md-3" >
                <div>
                  <label for="ex1">DATE OF BIRTH<span style="color:red;">*</span></label>
                </div>
 <input name="dob" placeholder="MM/DD/YYYY" class="form-control input-md" value="<?php echo $dateOdBirthStr; ?>" type="text" id="dob" value="<?php echo $dateOdBirthStr; ?>" >
              </div>
             <!-- <div class="col-md-1 pc0">
                  <img  src="<?php //
				  $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/celender-icon.png" style="margin-left: -13px; padding-top: 32px;" />
              </div>-->
              </div>
              <div class="col-md-4">
                <label class="col-md-8 control-label" for="radios">GENDER<span style="color:red;">*</span></label>
                <div class="col-md-12" id="divGender">
                  <label class="radio-inline">
                    <input name="gender" id="radios-0" value="M" <?php if($patientInfos->{genderCode} == "M"){ echo "checked='checked'";} ?>  type="radio">
                    Male </label>
                  <label class="radio-inline">
                    <input name="gender" id="radios-1" value="F" <?php	if($patientInfos->{genderCode} == "F"){ echo "checked='checked'";} ?> type="radio">
                    Female </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-3">
                <div class="">
                  <label for="selectbasic" class="">STATUS</label>
                   <select name="isActive" class="form-control" id="isActive">
                   
                     <?php
					 foreach($statusOptions as $statusOption)
					  {
						if(!is_null($patientInfos))
						{
							if($statusOption->{optionValue} == $patientInfos->{isActive})
							{
						?>
            <option selected="selected" value="<?php	echo $statusOption->{optionValue};?>">
            <?php	echo ucfirst(strtolower($statusOption->{optionValue}));?>
            </option>
            <?php
							}
							else{
							
						?>
			<option  value="<?php	echo $statusOption->{optionValue};?>">
			<?php	echo ucfirst(strtolower($statusOption->{optionValue}));?>
			</option>
			<?php
							}
						}
						else
						{
						?>

            <option  value="<?php	echo $statusOption->{optionValue};?>">
            <?php	echo ucfirst(strtolower($statusOption->{optionValue}));?>
            </option>
            <?php
							}
					  }
					  ?>
                      
                    </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="">
                  <label for="selectbasic" class="">PROGRAM TYPE</label>
                  <select id="programType" name="programType" class="form-control">
                 
                         <?php
					 foreach($programTypeOptions as $programTypeOption)
					  {
						if(!is_null($patientInfos))
						{
							if($programTypeOption->{optionValue} == $patientInfos->{programType})
							{
						?>
                            <option selected="selected" value="<?php	echo $programTypeOption->{optionValue};?>">
                            <?php	echo $programTypeOption->{optionValue};?>
                            </option>
                            <?php
							}
							else{
							
						?>
                            <option  value="<?php	echo $programTypeOption->{optionValue};?>">
                            <?php	echo $programTypeOption->{optionValue};?>
                            </option>
                            <?php
							}
						}
						else
						{
						?>

                            <option  value="<?php	echo $programTypeOption->{optionValue};?>">
                            <?php	echo $programTypeOption->{optionValue};?>
                            </option>
                            <?php
							}
					  }
					  ?>
                     
                    </select>
                </div>
              </div>
              <div class="col-md-6">
  <div class="clearfix"><label> &nbsp;</label></div>
                <!--<div class="pull-right">
                  <button id="singlebutton" name="singlebutton" class="btn btn-default btn-linktype">cancel</button>
                   <button type="submit" class="btn btn-success">Save</button>
             		 <input type="hidden" name="saveProfile" />
                </div>-->
              </div>
            </div>
          </fieldset>
      
          <fieldset>
            
            <!-- Form Name -->
            <legend>Shipping &amp; Location</legend>
            
            <!-- Text input-->
            <div class="form-group">
              <div class="col-md-5">
                  <label for="textinput" class="">SHIPPING ADDRESS<span style="color:red;">*</span></label>
            <input name="addressLine" id="addressLine" placeholder="Address Line1" class="form-control input-md" value="<?php echo $addressInfo[0]->{addressLine1};?>" type="text" maxlength="50">
              </div>
              <div class="col-md-2">
                  <label for="selectbasic" class="">TIME ZONE</label>
                     <select id="timeZone" name="timeZone" class="form-control">
                        <?php
					 foreach($timeZoneOptions as $timeZoneOption)
					  {
						if(!is_null($patientInfos))
						{
							if($timeZoneOption->{optionValue} == $patientInfos->{userTimeZone})
							{
						?>
                            <option selected="selected" value="<?php	echo $timeZoneOption->{optionValue};?>">
                            <?php	echo $timeZoneOption->{optionValue};?>
                            </option>
                            <?php
							}
							else{
							
						?>
                            <option  value="<?php	echo $timeZoneOption->{optionValue};?>">
                            <?php	echo $timeZoneOption->{optionValue};?>
                            </option>
                            <?php
							}
						}
						else
						{
						?>

                            <option  value="<?php	echo $timeZoneOption->{optionValue};?>">
                            <?php	echo $timeZoneOption->{optionValue};?>
                            </option>
                            <?php
							}
					  }
					  ?>
					</select>	
                </div>
                </div>
              <div class="form-group">
                
  
              <div class="col-md-5">
            
            <input name="addressLine2" id="addressLine2" placeholder="Address Line2" class="form-control input-md" value="<?php echo $addressInfo[0]->{addressLine2};?>" type="text"maxlength="50">
              </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-2">
            <input type="text" name="city" id="city" placeholder="City or Town" class="form-control input-md" maxlength="50" value="<?php echo $addressInfo[0]->{city};?>" maxlength="50">
                </div>
                <div class="col-md-1 pc0">
                  <select id="state" name="state" class="form-control pc0 p0">
              <?php
					 foreach($statesInfo as $state)
					  {
						if(!is_null($addressInfo[0]))
						{
							if($state->{stateId} == $addressInfo[0]->{stateId})
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
            		<input type="text" name="zip" id="zip" placeholder="Zip code" class="form-control input-md" value="<?php echo $addressInfo[0]->{postalCode};?>" onkeypress="return isNumberKey(event)" maxlength="5"  maxlength="5" />
                </div>
                <div class="col-md-7">
                 <!-- <div class="pull-right">
                    <button id="singlebutton" name="singlebutton" class="btn btn-default btn-linktype">cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
              		<input type="hidden" name="saveShipping" />
                  </div>-->
                </div>
              </div>
        
            
            <!-- Select Basic -->
            
          </fieldset>
       
          <fieldset>
            
            <!-- Form Name -->
            <legend>Contact</legend>
            
            <!-- Text input--> 
            
            <!-- Multiple Radios (inline) -->
            <div class="form-group">
              <div class="col-md-6">
                <label for="ex1">PREFERRED METHOD</label>
               <?php
			   if(!$patientInfos)
			   {
			   ?> 
                <div>
                <label class="radio-inline">
                  <input name="preferredContactType" id="-0" value="phone"  type="radio">
                  Phone </label>
                <label class="radio-inline">
                  <input name="preferredContactType" id="-1" value="email" type="radio" checked="checked">
                  Email </label>
               </div>
               <?php
			   }
			   else
			   {
			   ?>
               <div>
                <label class="radio-inline">
                  <input name="preferredContactType" id="-0" value="phone"  type="radio" <?php if(strtoupper($patientInfos->{preferredContactType}) == "PHONE"){ echo "checked='checked'";} ?>>
                  Phone </label>
                <label class="radio-inline">
                  <input name="preferredContactType" id="-1" value="email" type="radio"  <?php if(strtoupper($patientInfos->{preferredContactType} )== "EMAIL"){ echo "checked='checked'";} ?>>
                  Email </label>
               </div>
               <?php
			   }
			
		   ?>
              </div>
            </div>
            <div class="form-group radioButttonDiv">
              <div class="col-md-3">
                <label for="ex1">HOME PHONE</label>
            	<input type="text" placeholder="###-###-####" name="phone[0][phoneNumber]" id="hPhone" class="form-control" value="<?php echo $phoneHome; ?>" minlength="10" maxlength="15">
                <input type="hidden" name="phone[0][type]" value="HOME" />
                <label class="radio-inline selectPre">
          		<input type="radio"  value="hPhone" name="phone[0][phonePrimary]" id="phonePrimary" <?php if($typeHome == true){ echo "checked='checked'";} ?>>
                  Primary </label>
              </div>
              <div class="col-md-3">
                <label for="ex1">CELL PHONE</label>
              
            	<input type="text" placeholder="###-###-####" name="phone[1][phoneNumber]" id="cPhone" class="form-control" value="<?php echo $phoneCell; ?>" minlength="10" maxlength="15">
                <input type="hidden" name="phone[1][type]" value="CELLPHONE" />

                <label class="radio-inline selectPre">
          			<input type="radio"  value="cPhone" name="phone[1][phonePrimary]" id="phonePrimary1" <?php if($typeCell == true){ echo "checked='checked'";} ?>>
                  Primary </label>
              </div>
              <div class="col-md-3">
                <label for="ex1">WORK PHONE</label>
           		 <input type="text" placeholder="###-###-####" name="phone[2][phoneNumber]" id="wPhone" class="form-control" value="<?php echo $phoneWork; ?>" minlength="10" maxlength="15">
                 <input type="hidden" name="phone[2][type]" value="WORK" />
                <label class="radio-inline selectPre">
                           <input type="radio"  value="wPhone" name="phone[2][phonePrimary]" id="phonePrimary2" <?php if($typeWork == true){ echo "checked='checked'";} ?>>
                  Primary </label>
              </div>
            </div>
            <div class="form-group mlbl">
              <div class="col-md-3">
                <label for="ex1">EMAIL<span style="color:red;">*</span></label>
           		 <input type="text" placeholder="email@address.com" name="email" id="email" class="form-control" value="<?php echo $primaryEmail;?>">
                  <div style="margin-top: 14px;"> 
                <?php
				if (isset ( $_REQUEST['edit']) or $userType == "PATIENT") {
				?> 
               
                <a onClick="openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/authUrl.php','patientId=<?php echo $patientId;?>','authUrl',event,'this')" data-toggle="modal" id="authurl" type="button" name="authurl" data-target="#myModal12" style=" color: #fff;cursor: pointer; text-decoration:none;">
                <span class="spanHide btn-auth">Send Registration Email</span></a>
                <?php
				}
				else
				{
				?>                
                 <span class="spanHide btn-auth">Send Registration Email</span>
                 <?php
				 }
				 ?>
                </div>
              </div>
              <div class="col-md-3">
                <label for="ex1">SECONDARY EMAIL</label>
           		 <input type="text" placeholder="email@address.com" name="sEmail" id="sEmail" class="form-control" value="<?php echo $secondaryEmail;?>">
              </div>
              <div class="col-md-3">
                <label for="ex1">LOGIN PASSWORD<span style="color:red;">*</span></label>
                  <?php
			if(!is_null($credentialsInfo->{password}))
			{
		?>
		
         <input type="hidden"  value="<?php echo $credentialsInfo->{password}; ?>" class="form-control col-sm-4" id="oldpassword" name="oldpassword"/>
         <input type="text" class="form-control" name="password" id="password" placeholder="******" value="*********" maxlength="15">
                 <?php
        }
		else
		{
		?>
		  <input type="text" placeholder="Password"  id="password" name="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" maxlength="15"  class="form-control"/>
		   <?php
        }
		?>
              </div>
              <div class="col-md-3">
  <div class="clearfix"><label>&nbsp;</label></div>
               <!-- <div class="pull-right">
                  <button id="singlebutton" name="singlebutton" class="btn btn-default btn-linktype">cancel</button>
                   <button type="submit" class="btn btn-success">Save</button>
              <input type="hidden" name="saveContact" />
                </div>-->
              </div>
            </div>
          </fieldset>
       
          <fieldset>
            <legend class="spanHide">Providers &amp; Escalation</legend>
            <div class="form-group">
              <div class="col-md-3"> 
                <label for="selectbasic" class="spanHide">PRIMARY<span style="color:red;">*</span></label>
               <select class="form-control spanHide" name="primaryProv" id="primaryProv">
               <option  selected="selected" value=""></option>

           <?php
				foreach($providerList as $prov)
				{
				if($prov->{deleted} == 0)
				{
					if($primaryProvider == $prov->{entityId})
					{
		  ?>
            <option selected = "selected" value="<?php	echo $prov->{entityId}; ?>">
            <?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
            </option>
            <?php
			}else{
			?>
            <option value="<?php	echo $prov->{entityId}; ?>">
            <?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
            </option>
            <?php
					}
				}	

				}
				  ?>
            </select>
              </div>
              <div class="col-md-3">
                <label for="selectbasic" class="spanHide">SECONDARY<span style="color:red;">*</span></label>
                 <select class="form-control spanHide" name="secondaryProv" id="secondaryProv">
                 <option  selected="selected" value=""></option>
                <?php
				foreach($providerList as $prov)
				{
				  if($prov->{deleted} == 0)
				 {
					if($secondaryProvider == $prov->{entityId})
					{
				  ?>
					<option selected = "selected" value="<?php	echo $prov->{entityId}; ?>">
					<?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
					</option>
					<?php
					}else{
					?>
					<option value="<?php	echo $prov->{entityId}; ?>">
					<?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
					</option>
					<?php
					}
				 }
				}
				  ?>
            </select>
              </div>
              <div class="col-md-3">
                <label for="selectbasic" class="spanHide">TERTIARY</label>
                 <select name="tertiaryProv" id="tertiaryProv" class="form-control spanHide">
                 <option  selected="selected" value=""></option>

               <?php
				foreach($providerList as $prov)
				{
				  if($prov->{deleted} == 0)
				 {	
					if($tertiaryProvider == $prov->{entityId})
					{
					  ?>
						<option selected = "selected" value="<?php	echo $prov->{entityId}; ?>">
						<?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
						</option>
						<?php
						}else{
						?>
						<option value="<?php	echo $prov->{entityId}; ?>">
						<?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
						</option>
						<?php
					}
				   }	
				}
				  ?>
            </select>
              </div>
              <div class="col-md-3">
                <div class="clearfix"><label>&nbsp;</label></div>
                <div class="pull-right">
                  <?php

					if(!$patientInfos->{patientId})
						{
						?>
                  <button  type="reset" name="btnCancel" id="btnCancel" class="btn btn-default btn-linktype">Cancel</button>
                   <button type="submit" name="btnSave" id="btnSave" class="btn btn-success">Save</button>
                   
					  <input type="hidden" name="submit" id="submit" />
					  <input type="hidden" name="patientId" id="patientId"/>
					 <?php 
					 }
					 else
					 {
					  ?>
                        <button type="reset" name="btnCanceledit" id="btnCanceledit" class="btn btn-default btn-linktype">Cancel</button>
                   		<button type="submit" name="btnSave" id="btnSave" class="btn btn-success">Save</button>
					  <input type="hidden" name="update" value="<?php echo constantAppResource::$COMMON_BUTTON_SAVE;?>" id="page"/>
                    <input type="hidden" name="patientId" value="<?php echo $patientInfos->{patientId};?>" id="patientId"/>
                    <?php
					}
					?>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab2">...</div>
    <div role="tabpanel" class="tab-pane" id="tab3">...</div>
    <div role="tabpanel" class="tab-pane" id="tab4">...</div>
    <div role="tabpanel" class="tab-pane" id="tab5">...</div>
    <div role="tabpanel" class="tab-pane" id="tab6">...</div>
    <div role="tabpanel" class="tab-pane" id="tab7">...</div>
  </div>
</div>
<div class="modal fade" id="myModal12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img class="close" align="right" src="../images/close.jpg"></span></button>
        <h4 class="modal-title" id="myModalLabel">Registration Email</h4>
      </div>
      <div class="modal-body" id="authUrl">
       
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-primary" style="  background-color: #03aeff;
  border-bottom: solid 5px #0395d1;
  border-radius: 7px;
  color: #fff;
  font-size: 19px;
  border-left: none;
  border-top: none;
  border-right: none;
  cursor: pointer;
  padding: 10px 20px;
  margin: 5px;" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Notes & History : START -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/notes-history.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var patId = '<?php echo $patientInfos->{ patientId }; ?>';
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
if($("#okay").hasClass("localStorage"))
{
var first_name = localStorage["first_name"];
 $("#firstName").val(first_name);
var middle_name = localStorage["middle_name"];
 $("#initName").val(middle_name);
var last_name = localStorage["last_name"];
 $("#lastName").val(last_name);
var dob = localStorage["dob"];
 $("#dob").val(dob);
 var prefName = localStorage["prefName"];
 $("#prefName").val(prefName);
var gander = localStorage["gander"];
if(gander=="M")
{
document.getElementById('radios-0').checked = true;
 }
 else{
document.getElementById('radios-1').checked = true; 
 }
 var preferredContactType = localStorage["preferredContactType"];
if(preferredContactType =="phone")
{
document.getElementById('-0').checked = true;
 }
 else{
document.getElementById('-1').checked = true; 
 }
 
 var phonePrimary = localStorage["phonePrimary"];
if(phonePrimary =="hPhone")
{
document.getElementById('phonePrimary').checked = true;
 }
 else if(phonePrimary =="cPhone"){
document.getElementById('phonePrimary1').checked = true; 
 }
 else if(phonePrimary =="wPhone")
 {
document.getElementById('phonePrimary2').checked = true; 
 }
 
var username = localStorage["username"];
 $("#username").val(username);
var password = localStorage["password"];
 $("#password").val(password);

var status = localStorage["status"];
 $("#status").val(status);
 
 
 var isActive = localStorage["isActive"];
 $("#isActive").val(isActive);

var programType = localStorage["programType"];
 $("#programType").val(programType);

var timeZone = localStorage["timeZone"];
 $("#timeZone").val(timeZone);
 
 
 

var primaryProvider = localStorage["primaryProvider"];
 $("#primaryProv").val(primaryProvider);

var secondaryProvider = localStorage["secondaryProvider"];
 $("#secondaryProv").val(secondaryProvider);

var territoryProvider = localStorage["territoryProvider"];
 $("#tertiaryProv").val(territoryProvider);
 
 var page = localStorage["page"];
  $("#page").attr('name',page);
  
  
  var patientId = localStorage["patientId"];
  $("#patientId").val(patientId);
 var Daddress1 = localStorage["Daddress1"];
 $("#addressLine").val(Daddress1);
var Daddress2 = localStorage["Daddress2"];
 $("#addressLine2").val(Daddress2);
var Dcity = localStorage["Dcity"];
 $("#city").val(Dcity);
var Dstate = localStorage["Dstate"];
 $("#state").val(Dstate);
var Dzip = localStorage["Dzip"];
 $("#zip").val(Dzip);
var email = localStorage["email"];
 $("#email").val(email);
 
 var Semail = localStorage["sEmail"];
 $("#sEmail").val(Semail);
 
var Dphone = localStorage["hPhone"];
 $("#hPhone").val(Dphone);
 
 var Cphone = localStorage["cPhone"];
 $("#cPhone").val(Cphone);
 
 var Wphone = localStorage["wPhone"];
 $("#wPhone").val(Wphone);
 
var username = localStorage["username"];
 $("#username").val(username);
var editType = localStorage["editType"];
 $("#editType").val(editType);
 if(editType =="editType")
 {
 	$("#authurl").show();
 }
 
}
$(document).ready(function(){
var userType='<?php echo $userType;?>';
	if(userType != "PATIENT")
	{
	$("#dob").datepicker({
		showOn: "button",
		buttonImage:
		"<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/celender-icon.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		maxDate: new Date(),
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+0"
});	
}
	/*var timeZone = '<?php //echo $timeZone;?>';
if(timeZone)
{
$("#timeZone").val(timeZone);
}*/


var userType='<?php echo $userType;?>';
	if(userType == "PATIENT")
	{
		$("#prescription").hide();
		$("#careManagement").hide();
		$("#device").hide();
		$("#more").hide();
		$("#device_schedule").hide();
		$("#tab_supplies").hide();
		
		$("#firstName").attr("readonly","readonly");
		$("#initName").attr("readonly","readonly");
		$("#lastName").attr("readonly","readonly");
		$("#dob").attr("readonly","readonly");
		$("#email").attr("readonly","readonly");
		
		$("#prefName").attr("readonly","readonly");
		$("#radios-0").attr('disabled','disabled');
		$("#radios-1").attr('disabled','disabled');
		$("#isActive").attr('disabled','disabled');
		$("#programType").attr('disabled','disabled');
		$("#addressLine").attr("readonly","readonly");
		
		$("#timeZone").attr('disabled','disabled');
		$("#addressLine2").attr("readonly","readonly");
		$("#city").attr("readonly","readonly");
		$("#state").attr('disabled','disabled');
		$("#zip").attr("readonly","readonly");
		$("#-0").attr('disabled','disabled');
		
		$("#-1").attr('disabled','disabled');
		$("#hPhone").attr("readonly","readonly");
		$("#cPhone").attr("readonly","readonly");
		$("#wPhone").attr("readonly","readonly");
		$("#phonePrimary").attr('disabled','disabled');
		$("#phonePrimary1").attr('disabled','disabled');
		
		$("#phonePrimary2").attr('disabled','disabled');
		$("#sEmail").attr("readonly","readonly");
		$("#password").attr("readonly","readonly");
				
		 $("#btnCancel").attr('disabled','disabled');
		 $("#btnCanceledit").attr('disabled','disabled');
		 
		 $("#btnSave").attr('disabled','disabled');
		 $("#btnSave").css("opacity","0.33");
		 $("#btnCancel").css("opacity","0.33");
		$(".spanHide").hide();
		//alert();
	}


});


$(document).ready(function () {
	  if($("#prefName").val() == "")
	  {
	  	$("#prefName").addClass("doChange");
	  }
    $(".radioButttonDiv input[type=radio]").click(function () {
        var $this = $(this);
        $this.parents(".radioButttonDiv:first").find("input[type=radio]").not($this).prop("checked", false);
    });
	
	
	/* $("#btnCancel").click(function (e) {
       openPageWithAj
	   ax('../../dashboard/pages/portal_addPatient.php','','menu-content',e);
    });*/
	$("#btnCanceledit").click(function (e
	) {
       openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientInfos->{patientId}; ?>&type=EDIT','','menu-content',e);
    });
	
});
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
	  $("#firstName").on('click keyup change focusout',function(){
	   if($("#prefName").val() == "")
	  {
	  	$("#prefName").addClass("doChange");
	  }
	   $(".doChange").val($("#firstName").val());
	  });
</script>

