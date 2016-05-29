<?php
include('../../common/util/CardFactory.php');
include('helper/portal_dashboard_helper.php');

$cardType = $_POST["cardtype"];
$retVal =  addDashboardCards($portalcards, $cardType);
echo $retVal;
?>
