<?php
/*$msg = "";

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
   
	   if($providerInfo)
	   {
			return $providerInfo;
	   }
	   else
	   {
			return NULL;
	   }
 
	}
}
*/
?>
