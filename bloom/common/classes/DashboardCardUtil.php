<?php
import com.vmc.core.info.DashboardAcknowledgeInfo;
import com.vmc.core.api.AdminPortalWrapper;

class DashboardCardUtil {
 
    function acknowledgeDashboard($id) {
	  $data = explode("_",$id);
	  $apw = new AdminPortalWrapper ();
	   $vmcService = getVMCServiceInfo();
	   
	   $ackInfo[0] = new DashboardAcknowledgeInfo();
	   $ackInfo[0]->setDashboardDetailId($data[0]);
	   $ackInfo[0]->setReviewNotes($data[1]);
	   $ackInfo[0]->setViewed(1);
       
	   $dashboardPatientCardInfo = $apw->acknowledgeDashboardNotification($vmcService, $ackInfo);
	   
	   if($dashboardPatientCardInfo )
	   {
			return TRUE;
	   }
	   else
	   {
			return TRUE;
	   }
	}
	
}

?>
