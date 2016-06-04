<?php
include('controller/portal_providerList_controller.php');
 echo addProviderCards($providerList, VMCPortalConstants::$PHP_EMPTY);
 ?>
 <script>
 var taHTML = $('#PatientList_part_bg').html();
var showScroll = $("#getScroll").val();
var counter = 0;

 </script>