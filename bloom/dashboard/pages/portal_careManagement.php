<?php
  $userType = strtoupper($_COOKIE['type']);
  $updateCommunicationid = $_REQUEST["careCommHeaderId"];
  $dashcard = $_REQUEST["dashcard"];
  include 'controller/patient_careManagement_controller.php';
  $entityUtil = new EntityUtil();
	 try
	 {
		   
		if (isset ( $_REQUEST['type'] or $userType==="PATIENT"))
		{
	
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
			$phoneInfo = $patientInfo->{phoneInfo};
			$emailaddressinfo = $patientInfo->{emailAddressInfo};
			$dateUtil = new DateUtil();
			$dateOfBirthStr = $dateUtil->formatDatetoStr($patientInfo->{dateOfBirth});
			
			$paramArray = array() ;
			$paramArray[0] = $_COOKIE['id'];
			$loggedInProviderInfo = $entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);
			
			$paramArray = array() ;
			$paramArray[0] = true;
			$paramArray[1] = "";
			$providerList=$entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
			
			$paramArray =array();
			$paramArray[0] = VMCPortalConstants::$ONCALL_PROVIDER_ID;
			$getDefaultInfo = $entityUtil->getObjectFromServer($paramArray, "getDefaultInfo", VMCPortalConstants::$API_ADMIN);
			
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$careCommData = $entityUtil->getObjectFromServer($paramArray, "findCareCommunicationByPatientId", VMCPortalConstants::$API_EMR);
			
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$oldActionPlan = $entityUtil->getObjectFromServer($paramArray, "findPatientActionPlanByPatientId", VMCPortalConstants::$API_EMR);
			
			if($oldActionPlan)
			{
			$paramArray = array() ;
			$paramArray[0] = $oldActionPlan->{providerId};
			$providerInfo=$entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);
			$dateUtil = new DateUtil();
			$updatedTime = $oldActionPlan->{updateTimeStamp};
			$comma = ", ";
			}
			
			
			
			
			$entityUtil = new EntityUtil();
			$paramArray = array() ;
			$paramArray[0] = $patientId;
			$getRiskEscalation = $entityUtil->getObjectFromServer($paramArray, "getRiskEscalationByPatientId", VMCPortalConstants::$API_EMR);
			//var_dump($getRiskEscalation);
			if($getRiskEscalation)
			{
			$updatedTimeRisk =  $getRiskEscalation->{updateTimeStamp} ;
				$comma1 = ", ";
			
			} 
		}
}catch ( Exception $e ) {
	//echo 'we are in patient exception';
	$msg = $e->getMessage();
}
	
 ?>
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboardNew.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/js/pwdvalidation.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/dashboard/script/js/jquery.canvasjs.min.js"></script>
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
controlMenu();
</script>
<script type="text/javascript">
$(document).ready(function()
{
	
var userType='<?php echo $userType;?>';
 if(userType == "PATIENT")
 {
  $("#patIdGraph").val("<?php echo $_COOKIE["id"] ?>");
 }
 else
 {
$("#patIdGraph").val("<?php echo $patientInfo->{patientId}; ?>");
}
/*$(function(){
	 if ($("#menu-content").attr('class') =='col-md-12')
		$("#menu-content").attr('class','col-md-9');

	$('#portal-menu').hide("0",function(){
			 if ($('#portal-menu').is(':hidden'))
			{
				$("#menu-content").attr('class','col-md-12');
			}
		});
	});*/

	
	});
</script>
<script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/js/portal_careManagement_graph.js"></script>

<div class="mytab">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="addPatientMenu">
    <li role="presentation" ><a data="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)"  onClick="openPageWithAjax('../../dashboard/pages/portal_addPatient.php?edit=true&patientId=<?php echo $patientId; ?>&type=EDIT','','menu-content',event,this)" aria-controls="tab1" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)"
     data="openPageWithAjax('../../dashboard/pages/patient_moreDetails.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT&edit=true','','menu-content',event,this)">Support</a></li>
    <li role="presentation"  class="active"><a onClick="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Prescription</a></li>
 <li role="presentation" id="tab_supplies">
        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab"  
          onClick="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" 
          data="openPageWithAjax('../../dashboard/pages/portal_addSupplies.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">
          Supplies
        </a>
      </li>
    <li role="presentation"><a href="#tab6" aria-controls="tab6" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDevices.php?patientId=<?php echo $patientInfo->{patientId} ?>&patientLastName=<?php echo $patientInfo->{lastName} ?>&patientFirstName=<?php echo $patientInfo->{firstName} ?>&type=EDIT','','menu-content',event,this)">Devices</a></li>
    <li role="presentation"><a href="#tab7" aria-controls="tab7" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_addDeviceSchedule.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Device Schedule</a></li>
<li role="management"><a href="#tab8" aria-controls="tab8" role="tab" data-toggle="tab" onClick="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)" data="openPageWithAjax('../../dashboard/pages/portal_careManagement.php?patientId=<?php echo $patientInfo->{patientId} ?>&type=EDIT','','menu-content',event,this)">Care Management</a></li>
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
	if($dateOfsBirthStr!= "")
	{
	$dateOfB = "DOB";
	echo $dateOfB." ". $dateOfsBirthStr;
	}
	?>

	</div>
 
  </div>
  <input type="hidden" name="patIdGraph" id="patIdGraph"  />
   <input type="hidden" name="updateCommunicationid" id="updateCommunicationid"  value="<?php echo $updateCommunicationid; ?>"/>
    <input type="hidden" name="dashcard" id="dashcard"  value="<?php echo $dashcard; ?>"/>
    <?php
	if($dashcard)
	{
	?>
    <input type="button" class="showHide<?php echo $updateCommunicationid;  ?>" id="dashcardLink" value="SHOW.."  style="display:none;"/>
    <?php
	}
	?>
   
<div class="col-md-8 padd-top20">

  <!-- Tab panes -->
  <div class="container-fluid">
	<div role="tabpanel" class="tab-pane active" id="tab1">
		<fieldset>		
			<legend>Multi-vector Assessment</legend>
		</fieldset>
		<div class="assesments clearfix" id="assesments">
			<div class="chart_asses clearfix">
			<div class="row">
					<div class="col-md-6" id="chartContainerKnow" style="height: 100px; width: 50%;">
				</div>
					<div class="col-md-6 question">
				<div id="showQuestion">
				</div>	
				</div>
		    </div>
		   </div>
		   <div class="row">
				<div class="col-md-6" id="chartContainerSelf" style="height: 100px; width: 50%;">
				</div>
				<div class="col-md-6">&nbsp;</div>
		   </div>
		   <div class="row">
				<div class="col-md-6" id="chartContainerPsy" style="height: 120px; width: 50%;">
				</div>
				<div class="col-md-6">&nbsp;</div>
		   </div>
		   <div class="row">
				<div class="col-md-6" id="chartContainerSocial" style="height: 105px; width: 50%;">
				</div>
				<div class="col-md-6">&nbsp;</div>
		   </div>
		   <div class="row">
				<div class="col-md-5" id="chartContainerLearn" style="height: 45px;">
                       
				</div>
				<div class="col-md-7">
				<div class="row">
					<div class="col-md-6" id="completedDate"> </div>
					<div class="col-md-6">
                    <a onclick="viewSurvey(event);" class="ViewAssessment">
                    <div class="btn btn-success btn-block" style="margin-right:6%;">View Assessment...</div>
                    </a>
                    </div>
                </div>				
			</div>
		   </div>
				
			</div>
			
			
		</div>
	
<form class="form-horizontal" id="viewSurveys">        

                <p class="bPad">No Assessment Completed. <a   onclick="assignSurvey(event);" class="plink">View Surveys..</a></p>
  </form>
<form class="form-horizontal" id="add-risk-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php','add-risk-form','menu-content',event)">
  <fieldset>
    <!-- Form Name -->
    <legend class="lbold">Risk &amp; Escalation</legend>
    <div class="form-group">
      <div class="clearfix">
        <div class="col-md-2">
          <label for="ex1">RISK</label>
          <input type="text" class="form-control" placeholder="Risk" id="risk" name="risk" value="<?php echo $getRiskEscalation->{risk}; ?>" onkeypress="return isNumberKey(event)">
        </div>
        <div class="col-md-2">
          <label for="ex3">ATI</label>
          <input type="text" class="form-control" placeholder="ATI" id="ati" name="ati" value="<?php echo $getRiskEscalation->{aTI}; ?>" onkeypress="return isNumberKey(event)">
        </div>
        <div class="col-md-2 pc0">
          <label for="ex2">ESCALATED</label>
          <div class="clearfix">

<label class="radio-inline pb-5" for="radios2">
  <input type="radio" name="escalated" id="radios2" value="false" <?php if($getRiskEscalation->{escalated} == false){ echo "checked='checked'";} ?>>
  No
</label>
<label class="radio-inline pb-5" for="radios1">
  <input type="radio" name="escalated" id="radios1" value="true" <?php if($getRiskEscalation->{escalated} == true){ echo "checked='checked'";} ?>>
  Yes
</label> 
</div>
        </div>
      </div>
      <div class="clearfix">
        <div class="col-md-9">
          <div class="clearfix wRightLbl">
            <label for="ex1">Edited by: <?php echo $getRiskEscalation->{provLastName}." ".$getRiskEscalation->{provFirstName}.$comma1.$getRiskEscalation->{credential};?> </label>
            <?php if($updatedTimeRisk)
			{
			?>
            <span  class="updateDate"><?php echo $updatedTimeRisk?></span> 
            <?php
			}
			?>
            </div>
          <textarea class="form-control" name="comment" id="comment" placeholder="Removed from Escalation"><?php echo $getRiskEscalation->{comment} ;?></textarea>
        </div>
        <div class="col-md-3">
          <div class="clearfix">
            <label>&nbsp;</label>
          </div>
          <div class="clearfix">
            <label>&nbsp;</label>
          </div>
          <div class="pull-right">
            <button type="reset" name="statusCancel" id="statusCancel" class="btn btn-default btn-linktype">Cancel</button>
            <!-- <button type="submit" name="statusSave" id="statusSave" class="btn btn-success">SAVE</button>-->
            <input type="submit" name="riskSave" value="Save" id="riskSave" class="btn btn-success">
            <input type="hidden" name="saveRisk" id="saveRisk">
            <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>">
            <input type="hidden" name="type" value="EDIT">
          </div>
        </div>
      </div>
    </div>
  </fieldset>
</form>
<form class="form-horizontal" id="add-care-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_careManagement.php','add-care-form','menu-content',event)">
  <fieldset>
    <!-- Form Name -->
    <legend class="lbold">Care Plan</legend>
    <div class="form-group">
      
        <div class="col-md-9">
          <div class="clearfix wRightLbl">
          <input type="hidden" id="createdBy" value="<?php echo " ".$oldActionPlan->{editedProvLastName}.", ".$oldActionPlan->{editedProvFirstName};?>" >
        <input type="hidden" id="createdDate" value="<?php echo $oldActionPlan->{updateTimeStamp}; ?>" >
            <label for="ex1">Edited by: <?php echo $providerInfo->{lastName}." ".$providerInfo->{firstName}.$comma.$providerInfo->{credentials};?> </label>
             <?php if($oldActionPlan->{updateTimeStamp})
			{
			?>
            <span class="updateDate"><?php echo $oldActionPlan->{updateTimeStamp};?></span>
             <?php
			}
			?>
             </div>
           
          <textarea class="form-control" rows="3" name="carePlan" id="carePlan"><?php echo $oldActionPlan->{goals}; ?> </textarea>
        </div>
        <div class="col-md-3">
          <div class="clearfix">
            <label <?php if(strtoupper($userType) != "PATIENT") {?> onclick="javascript:exportToPDF()"<?php }?> name="btnExportPDF" id="btnExportPDF" >
            <a class="pdfLink">&nbsp;&nbsp;<img src="/gladstone/portal/bloom/dashboard/images/PDF.png"> &nbsp;Create PDF..</a>
            </label>
          </div>
          <div class="clearfix">
            <label>&nbsp;</label>
          </div>
          <div class="clearfix">
            <label>&nbsp;</label>
          </div>
          <div class="pull-right">
            <button type="reset" name="statusCancel" id="statusCancel" class="btn btn-default btn-linktype">Cancel</button>
            <!-- <button type="submit" name="statusSave" id="statusSave" class="btn btn-success">SAVE</button>-->
            <input type="submit" name="careSave" value="Save" id="careSave" class="btn btn-success">
            <input type="hidden" name="saveCare" id="saveCare">
            <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>">
            <input type="hidden" name="type" value="EDIT">
          </div>
        </div>
      </div>
  </fieldset>
</form>
<!--Start care communication -->
<fieldset>
 <legend class="lbold">Care Communication</legend>
<div class="col-lg-12 col-md-12 card_create_report">
            <div class="" onclick="createNewCommunication()" id="createReportDiv">
                <div class="col-lg-2 col-md-2 card_create_report_img">
                    <a href="#">
                        <img src="../../reports/images/create-report.png" class="left-align-image">
                    </a>
                </div>
                <div class="col-lg-9 col-md-9 card_create_report_link">
                    <a class="linkCreate" href="#">Click to add new communication</a>
                </div>
            </div>
        </div>
</fieldset>
<div class="col-lg-12 card_create_report_1" id="reportCardDiv">
    <div class="" style="padding:10px 15px; width:100%;">
    	<form class="form-horizontal" id="add-care-form" action="javascript:createCommunication()">
          <fieldset>
            <!-- Form Name -->
             <div class="form-group">
              
                <div class="col-md-12">
                  <div class="clearfix wRightLbl">
                   <label for="inputText" class="label-color">New Care Communication</label><span class="pull-right">
                   <input name="cancelComm" id="cancelComm" class="btn btn-default btn-linktype newText btn-up" value="CANCEL" type="reset"> </span>
                   </div>
                </div>
                </div>
             <div class="form-group">
              
                <div class="col-md-8">
                  <div class="clearfix wRightLbl">
                   <label for="inputText" class="label-align">REASON</label>
				   <!--<span id="charCount" class="pull-right"></span>-->
                   <input name="reason" id="reason" placeholder="Reason" class="form-control input-md" value="" type="text"maxlength="80"> 
                   </div>
                </div>
                </div>
            <div class="form-group">
              
                <div class="col-md-8">
                  <div class="clearfix wRightLbl">
                   <label for="selectbasic" class="">ASSIGN TO</label>
                    <select id="provider" name="provider" class="form-control" style="border:1px solid #333333;">
                    <?php
                    foreach($providerList as $prov)
					{
						$phoneInfo = $prov->{phoneInfo};
						if($getDefaultInfo->defaultValue == $prov->{entityId})
						{
                     ?>
					     <option value="<?php echo $prov->{providerId}; ?>" selected="selected" firstName="<?php echo $prov->{firstName}; ?>" lastName="<?php echo $prov->{lastName}; ?>" credentials="<?php echo $prov->{credentials}; ?>">On-call-<?php echo $prov->{firstName}." ".$prov->{lastName}.", ".$prov->{credentials}." ".$phoneInfo[0]->{phoneNumber}; ?></option> 
                         
                      <?php
					    }
						else
						{
							?>
                            <option value="<?php echo $prov->{providerId}; ?>" firstName="<?php echo $prov->{firstName}; ?>" lastName="<?php echo $prov->{lastName}; ?>" credentials="<?php echo $prov->{credentials}; ?>"><?php echo $prov->{firstName}." ".$prov->{lastName}.", ".$prov->{credentials}." ".$phoneInfo[0]->{phoneNumber}; ?></option>
                            <?php
							
						}
                     } 
					 ?>   
                    </select>	
                   </div>
                </div>
                    <div class="col-md-3">
                          <div class="clearfix" style="display:none;">
                            <label for="selectbasic" class="">Status</label>
                                     <select id="status" name="status" class="form-control">
                                     <?php
									 $statusOptions = $entityUtil->callDropdownControls(VMCPortalConstants::$CARE_COMMUNICATION_STATUS);
									 foreach($statusOptions as $statusOption)
									 {
									 ?>
                                         <option value="<?php echo $statusOption->{optionValue}; ?>"><?php echo $statusOption->{optionValue}; ?></option> 
                                      <?php
									  }
									  ?>  
                                    </select>	
                          </div>
                      </div>
                  </div>                         
           
            <div class="col-md-8">
                   <div class="form-group">
                   <label for="inputText" class="">COMMUNICATION</label>
                    <div class="pull-right right-radio">
					 <label class="radio-inline radio-image">
                    <input name="urgentRadio" id="notUrgent" value="N" type="radio"><img src="/gladstone/portal/bloom/dashboard/images/radio-1.png" class="img-circle" width="15px" height="15px">&nbsp;<span class="radio-align">Not Urgent</span></label>
					 <label class="radio-inline radio-image left-radio">
                    <input name="urgentRadio" id="urgent" value="Y" type="radio"><img src="/gladstone/portal/bloom/dashboard/images/radio-1.png" class="img-circle" width="15px" height="15px">&nbsp;<span class="radio-align">Urgent</span></label>			
                     </div>        
                    <textarea class="form-control" rows="3" name="communication" id="communication"></textarea>
                   </div>
                   </div>           
                  <div class="col-md-4">
				   <div class="clearfix">
                    <label>&nbsp;</label>
                  </div>
                  <div class="clearfix">
                    <label>&nbsp;</label>
                  </div>
                  <div class="clearfix">
                    <label>&nbsp;</label>
                  </div>
				   <div class="pull-right">            
                    				
                    &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <input type="submit" name="saveMsg" value="SEND" id="saveMsg" class="btn btn-success colorSend increase-size">
                    <input type="hidden" name="saveMsg" id="saveMsg">
					</div>
				   </div>
                  </div>
               
          </fieldset>
            <div id="editProvider" style="display:none;"> 
                    <input type="hidden" name="editProviderId" id="editProviderId" value="<?php echo $loggedInProviderInfo->{providerId}; ?>">
                    <input type="hidden" name="editProvFirstName" id="editProvFirstName" value="<?php echo $loggedInProviderInfo->{firstName}; ?>">
                    <input type="hidden" name="editProvLastName" id="editProvLastName" value="<?php echo $loggedInProviderInfo->{lastName}; ?>">
                    <input type="hidden" name="editProvCredentials" id="editProvCredentials" value="<?php echo $loggedInProviderInfo->{credentials}; ?>">
                    </div>
        </form>
    </div>  
  </div> 
  
	<?php echo getAllCareMessage(array_reverse($careCommData)); ?>
     

<!--end care communication -->
  </div>
</div>


<!-- Notes & History : START -->
<link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/css/notes-history.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var patId = '<?php echo $patientInfo->{ patientId }; ?>';
var CURRENT_TIME = '<?php echo date('d M h: i A'); ?>';
$(".sidebarBox").toggle("slide", { direction: 'right' });
if (authorizationToken == '') {
	refreshAuthToken(function (token) {
	authorizationToken = token;
	populateStikyNotes(endPageNo, true);
	});
	} else {
	populateStikyNotes(endPageNo, true);
	}
	    firstTimeNotes = false;

		</script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/notes-history.js"></script>
</div>
<div class="col-md-4 padd-top50">
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
</div>
</div>
<!-- Notes & History : END -->
<script>

var userType='<?php echo $userType;?>';
 if(userType == "PATIENT")
 {
  $("#prescription").hide();
  $("#device").hide();
  $("#more").hide();
  $("#device_schedule").hide();
  $(".spanHide").hide();
   $("#add-risk-form input,textarea,button").attr("disabled","disabled");
  $("#careSave").attr("disabled","disabled");
  
 }
 
 function exportToPDF() {
	
	var doc = new jsPDF();
	var xCord = 10; //x coordinate set to 10px
	var yCord = 30; //y coordinate set to 10px
	var filePdf = moment().format('lll');
	
	var fileName = $('#contextPatientName').val();
	if ( fileName.length == 0 ) fileName = 'Admin';
	doc.text(15,7,'Logged In As:');
	
	var userName = getCookie("userName") ;
	userName = userName.replace('+', ' ');
	doc.text(52,7,userName);      //userName
	
	doc.text(7,14,'Generated Time:');
	
	//alert(moment().format('lll'));
	
	doc.text(52,14,moment().format('lll'));
	doc.text(18,21,'Created For:');
	doc.text(52,21,fileName);

	doc.setLineWidth(0.5);
	doc.line(5, 23, 200, 23);

	doc.text(15,30,'Edited By:'+" "+$('#createdBy').val());
	var timeEdit = $('#createdDate').val();
	doc.text(120,30,timeEdit.substring(5,7)+"/"+timeEdit.substring(8,10)+"/"+timeEdit.substring(2,4)+" "+timeEdit.substring(11,16));

	
	//doc.setFontSize(12);
	var textToPrint = $('#carePlan').html();
	lines = doc.splitTextToSize(textToPrint,180);
	doc.text(15,45,lines);
	doc.save('Action Plan_'+filePdf+'.pdf');	 

		
}

function isNumberKey(evt)
  {
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	 return true;
  }
function createNewCommunication() {
    $("div.card_create_report_1").css("display", "block");
    $("div.card_create_report").css("display", "none");
	$('#reportCardDiv1').remove();
	$('.saveButton').find(':button').val("SHOW..");
}
</script>






<!-- start popup code  -->


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-mg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to make this communication active/addressed?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="Submit" class="btn  btn-success" data-dismiss="modal" id="updateCareCommStatusPopup">Okay</button>
        </div>
      </div>
    </div>
  </div>


