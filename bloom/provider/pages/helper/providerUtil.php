<?php
/*$vmcService = getVMCServiceInfo();
$credential = new CredentialInfo ();
$admin = new AdminPortalWrapper();
$emr = new EMRPortalWrapper ();
$providerInfo = new ProviderInfo();
$emailaddressinfo = new EmailAddressInfo ();
$phoneInfo = array (
		new PhoneInfo (),
		new PhoneInfo (),
		new PhoneInfo () 
);

$msg = "";

class ProviderUtil {
 
    function deleteProvider($id) {
	   $emr = new EMRPortalWrapper ();
	   $vmcService = getVMCServiceInfo();
       $reassignPatientInfo = $emr->getProviderReassignmentByProviderId($vmcService, $id);
	   $ret = FALSE;
	   
	   
	   foreach($reassignPatientInfo as $info)
	   {
	   //var_dump($info);
			foreach($info->getPatientProviderInfos() as $patientProvider)
		    {
				if($patientProvider->getProviderId() == $id)
				{
					$patientProvider->setProviderId(6);
					$patientProvider->setAction(2);
				}
		    }
	   }
	   
	   $portalResponseInfo = $emr->deleteProvider($vmcService, $reassignPatientInfo, $id);
	   
	   if($portalResponseInfo->getPortalError() != "")
	   {
			$ret = FALSE;
	   }
	   else
	   {
			$ret = TRUE;
	   }
	   
	   return $ret;
	}
	
	function getProviderByid($id) {

	   $emr = new EMRPortalWrapper ();
	   $vmcService = getVMCServiceInfo();
       $providerInfo = $emr->findProviderById($vmcService, $id);

	   if(isset($providerInfo) and !empty($providerInfo))
	   {
		return $providerInfo;
	   }
	   else
	   {
		  return NULL;
	   }
 
	}
}*/

?>
