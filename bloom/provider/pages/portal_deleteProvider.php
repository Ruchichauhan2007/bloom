<?php 

  include 'controller/portal_deleteProvider_controller.php';
  
  $ProviderUtil = new ProviderUtil();
  
  $providerId = $_POST ["id"];
  $isDeleted = $ProviderUtil->deleteProvider($providerId);
  
	header("Location:portal_providerList.php");
?>


