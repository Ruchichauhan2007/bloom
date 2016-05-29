<?php
$userType = strtoupper($_COOKIE['type']);
$institutionName = explode(":", $_SERVER['HTTP_HOST']);
include 'controller/portal_prescribingProvider_controller.php';
   
	$entityUtil = new EntityUtil();
	
	try 
	{

	    if (isset ($_REQUEST['type'] ) or $userType == "PATIENT")
		{
			if($userType == "PATIENT")
			{
				$patientId = $_COOKIE['id'];
			}
			else{
				$patientId = $_REQUEST['patientId'];
			}
			 $paramArray = array();
			 $entityUtil = new EntityUtil();
			 
			 
			 
			 $statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);
			 
			$paramArray[0] = $patientId;
			$patientInfo = $entityUtil->getObjectFromServer($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
			// Format Date as per MM/DD/YYYY format
			$dateUtil = new DateUtil();
			$dateOfsBirthStr = $dateUtil->formatDatetoStr($patientInfo->{dateOfBirth});
			
			 $paramArray = array() ;
			$paramArray[0] = $patientId;
			$getAllPrescription = $entityUtil->getObjectFromServer($paramArray, "getAllPrescriptionByPatientId", VMCPortalConstants::$API_EMR);
			
			$paramArray[0] = $patientId;
			$getAllPatientFaxes = $entityUtil->getObjectFromServer($paramArray, "getAllPatientFaxes", VMCPortalConstants::$API_EMR);
			
			$paramArray[0] = $patientId;
			$PrescriptionDetails = $entityUtil->getObjectFromServer($paramArray, "findPrescriptionDetailByPatientId", VMCPortalConstants::$API_EMR);
			foreach($PrescriptionDetails as $prescription)
			{
				if($prescription->{prescriberType} == "DOCTOR")
				{
					$DprescriptionDetailId = $prescription->{prescriptionDetailId};
					$DprescriberName = $prescription->{prescriberName};
					$Dtaxonomies = $prescription->{taxonomies};
					$DaddressLine1 = $prescription->{addressLine1};
					$DaddressLine2 = $prescription->{addressLine2};
					$Dcity = $prescription->{city};
					$DstateId = $prescription->{stateId};
					$DpostalCode = $prescription->{postalCode};
					$DphoneNumber = $prescription->{phoneNumber};
					$DfaxNumber = $prescription->{faxNumber};
					$DnPINumber = $prescription->{nPINumber};
				
				}
				if($prescription->{prescriberType} == "PHARMACY")
				{
					$PprescriptionDetailId = $prescription->{prescriptionDetailId};
					$PprescriberName = $prescription->{prescriberName};
					$Ptaxonomies = $prescription->{taxonomies};
					$PaddressLine1 = $prescription->{addressLine1};
					$PaddressLine2 = $prescription->{addressLine2};
					$Pcity = $prescription->{city};
					$PstateId = $prescription->{stateId};
					$PpostalCode = $prescription->{postalCode};
					$PphoneNumber = $prescription->{phoneNumber};
					$PfaxNumber = $prescription->{faxNumber};
					$PnPINumber = $prescription->{nPINumber};
				
				}
				
			}
		}
	}
	catch ( Exception $e ) 
	{
		//echo 'we are in patient exception';
		$msg = $e->getMessage();
	}

?>
 <link href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboardNew.css" rel="stylesheet" type="text/css">
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
     <div class="col-md-8 padd-top20"> 

    <!-- Tab panes -->
    <div class="tab-content col-md-12">
      <div role="tabpanel" class="tab-pane active" id="tab3">
          <fieldset>
            
            <!-- Form Name -->
            <legend>Rx Details</legend>
            <div class="">
             <?php
	    $counter =0;

	   ?>
              <table id="tableId" class="table table-striped table-pris rsTable text-center">
                <thead>
                  <tr>
                    <th width="15%"  data-resizable-column-id="aqDt">Aquired Date</th>
                    <th width="15%" data-resizable-column-id="aqDt1">Expiration Date</th>
                    <th width="10%" data-resizable-column-id="aqDt2">Frequency</th>
                    <th width="10%" data-resizable-column-id="aqDt3">Length</th>
                    <th width="50%" data-resizable-column-id="aqDt4"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/PdfIconBlack.png" /></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
	  		if(count($getAllPrescription) > 0){
		   foreach($getAllPrescription as $getPrescription)
		   {	$counter ++;
				$dateUtil = new DateUtil();
				$prescriptionDate = $dateUtil->formatDatetoStr($getPrescription->{prescriptionDate});
				$renewalDate = $dateUtil->formatDatetoStr($getPrescription->{renewalDate});
		?>
                <tr id="<?php echo $getPrescription->{prescriptionId}; ?>" <?php if($getPrescription->{prescriptionId}){?>class="EDITTR" <?php } ?> acquireDate="<?php echo $prescriptionDate; ?>" renewalDate="<?php echo $renewalDate; ?>" frequency="<?php echo $getPrescription->{frequency}; ?>" length="<?php echo $getPrescription->{length}; ?>">
                  <td scope="row" ><?php echo $prescriptionDate;?></th>
                  <td><?php echo $renewalDate; ?></td>
                  <td><?php echo $getPrescription->{frequency}; ?></td>
                  <td><?php echo $getPrescription->{length}; ?></td>
                
                  <td  style="cursor:pointer" onclick="openRxDetail(<?php echo $getPrescription->{prescriptionId}; ?>);"><a href="javascript:void(0);" ><?php echo $getPrescription->{rxFileName}; ?></a></td>
                  <td  style="display:none;"><?php echo $getPrescription->{refillsAllowed}; ?></td>
                  <td  style="display:none;"><?php echo $getPrescription->{numberOfRefills}; ?></td>
                  
                 <!-- <td><a href="#"  class="edit" id="<?php //echo $getPrescription->{prescriptionId}; ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>-->
                </tr>
		<?php
			}}
			
			$tdc = count($getAllPrescription);
			if($tdc < 5){
			while($tdc < 5){ ?>
				
             <tr>
                  <td><div class="emptyTd"></div></td><td></td><td></td><td></td><td></td>
               
                </tr>   
                
			<?PHP $tdc++; }}
			?>
              
            <?php 
			
		/*}*/
		 ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5" class="text-left"> <a href="#" id="addRxDetail"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/plusRx.png" alt=""></a> <a href="javascript:void(0)"  onclick = "deleteContent()" id="deleteRxDetail"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/minusRx.png" data-toggle="modal" data-target="#myModal" alt="" /></a> </th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div id="rx-form" style="display:none;">
			<div class="Fax-history FormRX">
            <form action="" method="post"  enctype="multipart/form-data" onSubmit="return validateForm(this,event)" id="add-rxDetail-form" autocomplete="off" class="form-horizontal">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Aquired Date<span style="color:red;">*</span></label>
                  <div class="col-md-5 dateCont">
                    <input id="acquiredDate" name="acqDate" placeholder="Aquired Date" class="form-control input-md"  type="text">
                     
                  </div>
                  </div>
                <div class="form-group ">
                  <label class="col-md-4 control-label" for="textinput">Expiration Date<span style="color:red;">*</span></label>
                  <div class="col-md-5 dateCont">
                    <input id="renewalDate" name="renewalDate" placeholder="Expiration Date" class="form-control input-md"  type="text">
                    </div>
                 </div>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Length<span style="color:red;">*</span></label>
                  <div class="col-md-6">
                    <input id="length" name="length" placeholder="Length" class="form-control input-md"  type="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">PDF<span style="color:red;">*</span></label>
                  <div class="col-md-5">
                  
                    <input id="newFileName" name="newFileName" placeholder="Browse File" class="form-control input-md"  type="text" class="filename" />
                  
                  
                </div>
                <div class="fileUploadNew btn btn-primary col-md-2 phc0"> <span>Browse</span>
          <input type="file" id="pdfFile" name="isMultipart" accept="application/pdf" class="uploadFileNew" />
                </div>
              </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Frequency<span style="color:red;">*</span></label>
                  <div class="col-md-8">
                    <input id="frequency" name="frequency" placeholder="Frequency" class="form-control input-md"  type="text" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Filled to Date<span style="color:red;">*</span></label>
                  <div class="col-md-8">
                    <input id="noOfRefills" name="noOfRefills" placeholder="Filled to Date" class="form-control input-md"  type="text" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label" for="textinput">Maximum Allowed<span style="color:red;">*</span></label>
                  <div class="col-md-8">
                    <input id="refillAllowed" name="refillAllowed" placeholder="Maximum Allowed" class="form-control input-md" type="text" />
                  </div>
                  </div>
                  
                  <div class="form-group">
                  <div class="col-md-12">
                    <div class="e_x1">
                      <label for="ex3">&nbsp;</label>
                    </div>
                    <div class="e_x1">
                      <label for="ex3">&nbsp;</label>
                    </div>
                    
                    
                    <div class="pull-right RXFormDetail">
                      <button class="btn btn-default btn-linktype" type="reset" id="rxCancel">cancel</button>
                      <button class="btn btn-success" type="submit" id="submitBtn">SAVE</button>
                      <input  name="insert" id="insert" type="hidden" />

                    <input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
                    <input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
                    <input  name="prescriptionId" id="prescriptionId" type="hidden" value="" />
                    
                    <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
                    <input type="hidden" name="entityId" value="<?php echo $_COOKIE['id'] ?>"  />
                    <input type="hidden" name="imageName" value=""  />
                    <input type="hidden" name="contentType" id="contentType" value="RX_DETAILS"  /> 
                    <input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"  />
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </form>
                    
                    
                    </div>
                    </div>
                
          </fieldset>
           </div>
            </div>
        <form class="form-horizontal col-md-12" id="add-pharmacy-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_prescribingProvider.php','add-pharmacy-form','menu-content',event)">
          <fieldset>
            
            <!-- Form Name -->
            <legend>Pharmacy</legend>
            
            <!-- Text input-->
            <div class="form-group">
              <div class="clearfix">
                <div class="col-md-5">
                  <label for="ex1">NAME</label>
                  <input class="form-control"  placeholder="Pharmacy Name" id="Pname" name="Pname" type="text" value="<?php echo $PprescriberName;?>">
                </div>
                <div class="col-md-2">
                  <label for="ex1">TAXONOMIES</label>
                  <input class="form-control"  placeholder="Texonomies"id="Ptaxonomies" name="Ptaxonomies" type="text" value="<?php echo $Ptaxonomies;?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="clearfix">
                <div class="col-md-5 mcol3">
                  <label for="ex1">ADDRESS</label>
                  <input class="form-control"  placeholder=" Address line 1"id="PaddressLine1" name="PaddressLine1" type="text" value="<?php echo $PaddressLine1;?>">
                </div>
                <div class="col-md-2  mcol3 pc0">
                  <label for="ex1">PHONE NUMBER</label>
                  <input class="form-control"  placeholder="###-###-####"id="PphoneNumber" name="PphoneNumber" type="text" value="<?php echo $PphoneNumber;?>">
                </div>
                <div class="col-md-2 mcol3">
                  <label for="ex1">FAX NUMBER</label>
                  <input class="form-control"  placeholder="###-###-####"id="PfaxNumber" name="PfaxNumber" type="text" value="<?php echo $PfaxNumber;?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="clearfix">
                <div class="col-md-5 mcol3">
                  <input class="form-control"  placeholder=" Address line 2" id="ex1" type="text" name="PaddressLine2" id="PaddressLine2" value="<?php echo $PaddressLine2;?>" >
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-2">
                <input type="text" name="Pcity" id="Pcity" placeholder="City or Town" class="form-control input-md"  value="<?php echo $Pcity;?>">
              </div>
              <div class="col-md-1 pc0">
                <select id="Pstate" name="Pstate" class="form-control pc0 p0">
               <?php
					 foreach($statesInfo as $state)
					  {
					  echo $PstateId;
						if($PstateId == $state->{stateId})
						{
						?>
            <option  selected="selected" value="<?php	echo $state->{stateId};?>">
            <?php	echo $state->{stateCode};?>
            </option>
            <?php
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
                <input type="text" name="PzipCode" id="PzipCode" placeholder="Zip code" class="form-control input-md"  value="<?php echo $PpostalCode;?>">
              </div>
              <div class="col-md-7">
                <div class="pull-right">
                  <button name="singlebutton" class="btn btn-default btn-linktype" id="pharmacyCancel" type="reset">cancel</button>
                 <input name="statusPharmacy" value="Save" class="btn btn-success"   onclick="buttonClick('pharmacySave','add-pharmacy-form');" />
                  <button type="button" class="btn btn-warning" <?php if (!$PprescriptionDetailId){echo "disabled='disabled'";} ?>  onclick="buttonClick('pharmacyFax','add-pharmacy-form');" >SEND FAX</button>
                  
                  <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
                  <input type="hidden" name="type" value="EDIT"  />
                  <input type="hidden" name="pharmacy" value="pharmacy"  />
                   <?php if ($PprescriptionDetailId)
				  {?>
                  <input type="hidden" name="PprescriptionDetailId" value="<?php echo $PprescriptionDetailId ?>"  />
                  <?php
				  }
				  ?>
                </div>
              </div>
            </div>
          </fieldset>
        </form>
 
        <form class="form-horizontal  col-md-12" id="add-doctor-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_prescribingProvider.php','add-doctor-form','menu-content',event)">
          <fieldset>
            <legend>Doctor</legend>
            <div class="form-group">
              <div class="clearfix">
                <div class="col-md-5 mcol3">
                  <label for="ex1">NAME</label>
                  <input class="form-control"  placeholder="Doctor Name" id="name" name="name" type="text" value="<?php echo $DprescriberName;?>">
                </div>
                <div class="col-md-2 mcol3">
                  <label for="ex1">NPI NUMBER</label>
                  <input class="form-control"  placeholder="Search" id="npiNumber" name="npiNumber" type="text" value="<?php echo $DnPINumber; ?>">
                </div>
                <div class="col-md-2 mcol3">
                  <label for="ex1">TAXONOMIES</label>
                  <input class="form-control"  placeholder="Texonomies" id="taxonomies" name="taxonomies" type="text"  value="<?php echo $Dtaxonomies; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="clearfix">
                <div class="col-md-5 mcol3">
                  <label for="ex1">ADDRESS</label>
                  <input class="form-control"  placeholder=" Address line 1" id="address" name="address" type="text"  value="<?php echo $DaddressLine1; ?>">
                </div>
                <div class="col-md-2 mcol3">
                  <label for="ex1">PHONE NUMBER</label>
                  <input class="form-control"  placeholder="###-###-####" id="phoneNumber" name="phoneNumber" type="text"  value="<?php echo $DphoneNumber; ?>">
                </div>
                <div class="col-md-2 mcol3">
                  <label for="ex1">FAX NUMBER</label>
                  <input class="form-control"  placeholder="###-###-####" id="faxNumber" name="faxNumber" type="text"  value="<?php echo $DfaxNumber; ?>">
                </div>
              </div>
            </div>
             <div class="form-group">
              <div class="clearfix">
                <div class="col-md-5 mcol3">
                
                   <input class="form-control"  placeholder=" Address line 2" id="ex1" type="text" name="addressLine2" id="addressLine2" value="<?php echo $DaddressLine2; ?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-2">
                <input type="text" name="city" id="city" placeholder="City or Town" class="form-control input-md"  value="<?php echo $Dcity; ?>">
              </div>
              <div class="col-md-1 pc0">
                <select id="state" name="state" class="form-control">
                    <?php
					 foreach($statesInfo as $state)
					  {
						if($DstateId == $state->{stateId})
						{
						?>
            <option  selected="selected" value="<?php	echo $state->{stateId};?>">
            <?php	echo $state->{stateCode};?>
            </option>
            <?php
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
                <input type="text" name="zip" id="zip" placeholder="Zip code" class="form-control input-md"  value="<?php echo $DpostalCode; ?>">
              </div>
              <div class="col-md-7">
                <div class="pull-right">
                  <button name="singlebutton" class="btn btn-default btn-linktype" id="doctorCancel" type="reset">cancel</button>
                  <input  name="statusDoctor" value="Save" class="btn btn-success"   onclick="buttonClick('doctorSave','add-doctor-form');" />
                  <button type="button" class="btn btn-warning" <?php if (!$DprescriptionDetailId){echo "disabled='disabled'";} ?> onclick="buttonClick('faxDoctor','add-doctor-form');">SEND FAX</button>
                  <input type="hidden" name="statusDoctor" id="statusDoctor" />
                  <input type="hidden" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"  />
                  <?php if ($DprescriptionDetailId)
				  {?>
                  <input type="hidden" name="DprescriptionDetailId" value="<?php echo $DprescriptionDetailId ?>"  />
                  <?php
				  }
				  ?>
                  <input type="hidden" name="type" value="EDIT"  />
                </div>
              </div>
            </div>
          </fieldset>
        </form>
        <form class="form-horizontal  col-md-12">
          <fieldset>
            
            <!-- Form Name -->
            <legend>Fax History</legend>
            <div class="">
              <table class="table table-striped table-pris rsTable text-center" data-resizable-columns-id="fax-history">
                <thead>
                  <tr>
                    <th data-resizable-column-id="aqDtt"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/TopBottomBlack.png"/></th>
                    <th data-resizable-column-id="aqDtt1">Date</th>
                    <th data-resizable-column-id="aqDtt2">Fax</th>
                    <th data-resizable-column-id="aqDtt3">NPI</th>
                    <th data-resizable-column-id="aqDtt4"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/PdfIconBlack.png"/></th>
                    <th data-resizable-column-id="aqDtt5"></th>
                  </tr>
                </thead>
                <tbody>
                 <?php 
      foreach($getAllPatientFaxes as $getPatientFaxes)
			{
			
				$dateUtil = new DateUtil();
				$faxNumber = $getPatientFaxes->{faxNumber};
				$faxId =$getPatientFaxes->{patientFaxId};
				$NPI = $getPatientFaxes->{nPINumber};
				$fileName = $getPatientFaxes->{fileName};
				$inOut = $getPatientFaxes->{inOut};	
				$date = $dateUtil->formatDatetoStr($getPatientFaxes->{createTimeStamp}); ?>			
				
			
                <tr>
                <?php
					if($inOut == "INCOMING")
					{
					?>
                  	<th scope="row"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/BottomArrow.png" /></th>
                  	<?php
					}
					else if ($inOut == "OUTGOING")
					{
					?>
                      <th scope="row"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/TopArrow.png" /></th>
                    <?php					
					}
					else
					{
					?>
						<th scope="row"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/Wrong.png" /></th>
                     <?php
					}
					?>
                  <td><?php echo  $date ;?></td>
                  <td><?php echo  $faxNumber ;?></td>
                  <td style="cursor:pointer"><a onClick="openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/login/pages/show_npi.php?patientId=<?php echo $patientInfo->{patientId}; ?>','NpiId=<?php echo $NPI;?>','showNpi',event,'this')" data-toggle="modal" id="showNPI" name="showNPI" data-target="#myModal12"><?php echo $NPI;?></a></td>
                  <td style="cursor:pointer" onclick="openRxDetail(<?php echo $faxId; ?>);"><a href="javascript:void(0);"><?php echo  $fileName; ?></a></td>
                  <td>
                 <?php /*?> <a href="#" class="deleteFaxID" id="<?php echo $faxId;?>" ><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/CrossNPI.png" data-target="#modalFax" data-toggle="modal" /></a><?php */?>
                  </td>
                </tr>        
		  <?php
          }
          
          
          $tdc = count($getAllPatientFaxes);
			if($tdc < 5){
			while($tdc < 5){ ?>
				
             <tr>
                  <td><div class="emptyTd"></div></td> <td></td><td></td> <td></td><td></td><td></td>
               
                </tr>   
                
			<?PHP $tdc++; }}
			?>
          
          
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="6"><div class="emptyTd"></div></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </fieldset>
        </form>
      </div>
     
    </div>
  </div>
  </div>
  
  
  <script src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/js/jquery.resizableColumns.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/store.js/1.3.14/store.min.js"></script>  
  <div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Rx Detail</h4>
      </div>
      <div class="modal-body pat-body" id="message">
       Are you sure you want to delete it.
      </div>
      <div class="modal-footer" style="margin-top:30px; padding:15px;">
		<form id="deleterx-form"
  onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_prescribingProvider.php','deleterx-form','deleteContent-add',event,'myModal')">
			<input type="hidden" id="patientId" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"/>
            <input type="hidden" id="deleteRxId" name="deleteRxId" />
			<input type="hidden" name="userId" value="<?php echo $_COOKIE['id'];?>" />
	        <input type="reset" class="btn btn-default" data-dismiss="modal" id="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CLOSE;?>" />
  <input type="submit" style="margin:0px;" value="<?php echo constantAppResource::$COMMON_BUTTON_DELETE;?>"  class="btn btn-primary btnpatlist1" id="deleteBtn" onclick="return  deleteContentConfirm();" />
    <input type="hidden" id="Delete" name="Delete" />
  </form>
      </div>
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


<div class="modal fade " id="modalFax" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pending Fax</h4>
      </div>
      <div class="modal-body pat-body" id="message">
       Are you sure you want to delete it.
      </div>
      <div class="modal-footer" style="margin-top:30px; padding:15px;">
		<form id="deletefax-form"
  onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_prescribingProvider.php','deletefax-form','menu-content',event,'modalFax')">
			<input type="hidden" id="patientId" name="patientId" value="<?php echo $patientInfo->{patientId} ?>"/>
            <input type="hidden" id="deleteFaxId" name="deleteFaxId" />
			<input type="hidden" name="userId" value="<?php echo $_COOKIE['id'];?>" />
	        <input type="reset" class="btn btn-default" data-dismiss="modal" id="reset" value="<?php echo constantAppResource::$COMMON_BUTTON_CLOSE;?>" />
  <input type="submit" style="margin:0px;" value="<?php echo constantAppResource::$COMMON_BUTTON_DELETE;?>"  class="btn btn-primary btnpatlist1" id="deleteBtn" />
    <input type="hidden" id="deleteFax" name="deleteFax" />
  </form>
      </div>
    </div>
  </div>
</div>

<!-- Notes & History : END -->
  <script>
function  buttonClick(value,formid)
{
var textbox = "<input type='hidden' name='"+value+"' value='"+value+"' /> " ;
$("#"+formid).append(textbox);
$("#"+formid).submit();
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
				//$("#headerMenu").find("."+resClass[0]).hide();
			}
		});
}
</script>
<script>
$(document).ready(function()
{
controlMenu();
$( "#acquiredDate" ).datepicker({
		showOn: "button",
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		maxDate: new Date(),
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+0"
});	
	
	 	
$( "#renewalDate" ).datepicker({
		showOn: "button",
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		minDate: 0,
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+1"
});	 	
	
 $("#frequency,#length,#noOfRefills,#refillAllowed").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                // Allow: Ctrl+V
                (event.ctrlKey == true && (event.which == '118' || event.which == '86')) ||  
                // Allow: Ctrl+c
                (event.ctrlKey == true && (event.which == '99' || event.which == '67')) || 
                // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
  
	$("#tableId tbody tr.EDITTR").click(function()
	{
		if($(this).hasClass("selected"))
		{
		$("#tableId tbody tr").removeClass("selected");
		$("#rx-form").hide();
		$("#insert").attr("name","insert");
		$("#submitBtn").html("Save");
		
		$("#acquiredDate").val("");
		$("#renewalDate").val("");
		$("#frequency").val("");
		$("#length").val("");
		
		$("#noOfRefills").val("");
		$("#refillAllowed").val("");
		
		//$("#pdfFile").val("");
		$("#prescriptionId").attr("disabled","disabled");
		$("#prescriptionId").val("");
		$("#newFileName").val("");
		}
		else
		{
		$("#tableId tbody tr").removeClass("selected");
		$(this).addClass("selected");
		var eleTd = $(this).children().siblings();
		var acquiredDate = $(eleTd).eq(0).text();
		var renewalDate = $(eleTd).eq(1).text();
		var frequency = $(eleTd).eq(2).text();
		var length = $(eleTd).eq(3).text();
		var fileName = $(eleTd).eq(4).text();
		var refillAllowed = $(eleTd).eq(5).text();
		var noOfRefills = $(eleTd).eq(6).text();
		var prescriptionId = $(this).attr("id");
		$("#prescriptionId").removeAttr("disabled");
		//var pdfFile = $(eleTd).eq(4).text();
		$("#acquiredDate").val(acquiredDate);
		$("#renewalDate").val(renewalDate);
		$("#frequency").val(frequency);
		$("#length").val(length);
		$("#noOfRefills").val(noOfRefills);
		$("#refillAllowed").val(refillAllowed);
		$("#prescriptionId").val(prescriptionId);
		$("#newFileName").val(fileName);
		//$("#pdfFile").val(pdfFile);
		$("#rx-form").show();
		$("#insert").attr("name","update");
		$("#submitBtn").html("Update");

		}
	
	});
	
	$("#addRxDetail").click(function()
	{
		$("#rx-form").show();
		$("#insert").attr("name","insert");
		$("#submitBtn").html("Save");
		
		$("#acquiredDate").val("");
		$("#renewalDate").val("");
		$("#frequency").val("");
		$("#length").val("");
		$("#tableId tbody tr").removeClass("selected");
		$("#noOfRefills").val("");
		$("#refillAllowed").val("");
		
		//$("#pdfFile").val("");
		$("#prescriptionId").attr("disabled","disabled");
		$("#prescriptionId").val("");
		$("#newFileName").val("");
	
	});
	
	
	$(".edit").click(function()
	{
		var eleTd = $(this).parent().siblings();
		var acquiredDate = $(eleTd).eq(0).text();
		var renewalDate = $(eleTd).eq(1).text();
		var frequency = $(eleTd).eq(2).text();
		var length = $(eleTd).eq(3).text();
		var noOfRefills = $(eleTd).eq(4).text();
		var refillAllowed = $(eleTd).eq(5).text();
		var fileName = $(eleTd).eq(6).text();
		var prescriptionId = $(this).attr("id");
		$("#prescriptionId").removeAttr("disabled");
		//var pdfFile = $(eleTd).eq(4).text();
		$("#acquiredDate").val(acquiredDate);
		$("#renewalDate").val(renewalDate);
		$("#frequency").val(frequency);
		$("#length").val(length);
		$("#noOfRefills").val(noOfRefills);
		$("#refillAllowed").val(refillAllowed);
		$("#prescriptionId").val(prescriptionId);
		$("#newFileName").val(fileName);
		//$("#pdfFile").val(pdfFile);
		$("#rx-form").show();
		$("#insert").attr("name","update");
		$("#submitBtn").html("Update");
	
	});
	
 $('#datetimepicker1').datetimepicker({
        pickTime: false,
        maxDate: moment(),
		
    });
	 $('#datetimepicker2').datetimepicker({
        pickTime: false,
        maxDate: moment(),
		
    });
	
});

function deleteContent()
{

	//$('tr.active-row').remove();
	var currentContentId=$('tr.selected').attr('id');
	
	if(currentContentId === undefined  || currentContentId === "")
	{
		$("#message").html("Please select a content to delete.");
		$("#deleteBtn").hide();
	}
	else{
		var acquireDate=$('tr.selected').attr('acquireDate');
		var renewalDate=$('tr.selected').attr('renewalDate');
		var frequency=$('tr.selected').attr('frequency');
		var length = $('tr.selected').attr('length');
		$("#deleteRxId").val(currentContentId);
		$("#acquireDate1").val(acquireDate);
		$("#renewalDate1").val(renewalDate);
		$("#frequency1").val(frequency);
		$("#length1").val(length);
		$("#message").html("Are you sure you want to delete it.");
		$("#deleteBtn").show();
	}
}
function deleteContentConfirm()
{
var rowId=$("#deleteRxId").val();
$("#"+rowId).css('display','none');
$("#rx-form").hide();
return true;
}

$(".aboutHref").click(function()
{
	$(".focus").focus();
});

function validateForm(ele,e)
{
	var acquiredDate=$("#acquiredDate").val();
	var renewalDate = $("#renewalDate").val();
	var length = $('#length').val();
	var frequency = $('#frequency').val();
	var newFileName = $("#newFileName").val();
	var noOfRefills = $('#noOfRefills').val();
	var refillAllowed = $('#refillAllowed').val();
	var pdfFile = $('#pdfFile').val();
	var type = $("#insert").attr("name");
	var msg = "";
	$("form input").removeClass("focus");
	if(acquiredDate == "" || acquiredDate == null)
	{
		msg += "Acquired date is required."
		$("#acquiredDate").addClass("focus");
	}
	else if(renewalDate == "" || renewalDate == null)
	{
		msg += "Expiration Date is required.";
		$("#renewalDate").addClass("focus");
	}

	else if(newFileName == "" || newFileName == null)
	{
		msg += "File is required.";
		$("#newFileName").addClass("focus");
	}
	else if(length == "" || length == null)
	{
		msg += "Length is required.";
		$("#length").addClass("focus");
	}
	else if(pdfFile == "" && type == "insert")
	{
		msg += "File is required.";
		$("#newFileName").addClass("focus");
	}

	

	else if(frequency == "" || frequency == null)
	{
		msg += "Frequency is required.";
		$("#frequency").addClass("focus");
	}

	else if(noOfRefills == "" || noOfRefills == null)
	{
		msg += "Filled to Date  is required.";
		$("#noOfRefills").addClass("focus");
	}

	else if(refillAllowed == "" || refillAllowed == null)
	{
		msg += "Maximum Allowed is required.";
		$("#refillAllowed").addClass("focus");
	}

	if(msg != "")
	{
				 $("#aboutPopup").show();
  				 $("#About_fadediv").show();
				 $(".cart_page").html("Rx Detail");
   				 $(".txt_div").html(msg);
        		$('body').addClass('modal-open');

		return false;
	}
	else
	{
		console.log('in else');

		if(pdfFile == "" && type == "update")
		{
		postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_prescribingProvider.php','add-rxDetail-form','menu-content',e);
		}
		else
		{
		postContentMultipartForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/content',ele, e);
		}
		return false;
	}
}
function postContentMultipartForm(action, ele, e) {
    if (typeof e != undefined) {
        e.preventDefault();
    }
	var formData = new FormData($(ele)[0]);
    $.ajax({
        url: action,
        type: 'POST',
        data:formData ,//$('#add-rxDetail-form').serialize(),
        crossDomain: true,
		 // async: false,
           cache: false,
           contentType: false,
           processData: false,
		 beforeSend: function(){showLoading()},
        success: function(result) {
		 $('.close').click()
          // alert('sent successfully');
		// $("#" + resultingDivId).html(result);
        },
        error: function( request, textStatus, errorThrown) {
		console.log(errorThrown);
       	 //request.getResponseHeader('VMCErrorCode')
           // console.log('jqXHR'+formData.elements['title'].value);
		 //  alert("Incorrect File! Please choose different file or upload file with different name.");
		   		 $("#aboutPopup").show();
  				 $("#About_fadediv").show();
				 $(".cart_page").html("Rx Detail");
   				 $(".txt_div").html("Incorrect File! Please choose different file or upload file with different name.");
        		$('body').removeClass('modal-open');
        		$('.modal-backdrop').remove();
        },
        complete: function() {
			hideLoading();
			console.log('completed')
			openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/pages/portal_prescribingProvider.php','patientId=<?php echo $patientInfo->{patientId} ?>','menu-content',e,this)
		 }
    });
}

 $('#pdfFile').change( function() {
  if ($(this).val() != '') {
    var file = $(this)[0].files[0];
    var fileName = file.name;
    var fileExt = fileName.split('.').pop();
    $("#newFileName").val(fileName);
  }
});


function openRxDetail(contentId)
{
	var contentHref=contentId;
	window.open('show_content.php?rxDetail='+contentHref,'video','top=150, left=352, width=700, height=500, toolbar=no, menubar=no, location=no, scrollbars=no, resizable=no');
	return false;
}
$(".deleteFax").click(function()
{
	var deleteFax = $(this).attr("id");
	$("#deleteRxId").val(deleteFax);

});

	$(".deleteFaxID").click(function()
	{
		var deleteFaxId=$(this).attr("id");
		$("#deleteFaxId").val(deleteFaxId);
	
	}); 
	
$(document).ready(function () {
 
	$("#rxCancel,#pharmacyCancel,#doctorCancel").click(function (e) {
       openPageWithAjax('../../dashboard/pages/portal_prescribingProvider.php?patientId=<?php echo $patientInfo->{patientId}; ?>&type=EDIT','','menu-content',e);
    });
	
});

</script>
