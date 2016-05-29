<?php 
  include 'popup/CientSiderror_popup.php';
?>
<?php
include '../../common/util/APIUtil.php';
include '../../common/classes/EntityUtil.php';
if (isset($_GET['vitalId'])) {
    $vitalId = $_GET['vitalId'];
} else {
    $vitalId = 0;
}
if (isset($_GET['loggingPage'])) {
    $loggingPage = $_GET['loggingPage'];
} else {
    $loggingPage = 1;
}

if (isset($_GET['vitalVal'])) {
    $vitalVal = $_GET['vitalVal'];
} else {
    $vitalVal = 0;
}

if (isset($_GET['vitalTime'])) {
    $vitalTime = $_GET['vitalTime'];
} else {
    $vitalTime = "";
}

$entityUtil = new EntityUtil();
$entityType = $entityUtil->getEntityTypeFromContext();
?>

<link rel="stylesheet" type="text/css" href="/gladstone/portal/bloom/vitals/scripts/css/vitals.css">
<link rel="stylesheet" type="text/css" href="/gladstone/portal/bloom/common/script/css/bootstrap.min.css">
<script>
    var vitalId = <?php
echo $vitalId ?>;
    var loggingPage = <?php
echo $loggingPage ?>;
    var entityType = "<?php
echo $entityType ?>";
    var vitalVal = <?php
echo $vitalVal ?>;
    var vitalTime = "<?php
echo $vitalTime ?>";
</script>
<script src="/gladstone/portal/bloom/vitals/scripts/js/vitals_logging.js"></script>

<div class="main-content" style="width:100%;">
    <div class="row" style="margin: 0px; ">
        <div class="col-md-12">
            <div id="topbar">
            </div>
        </div>
    </div>

    <div class="row" style="margin: 10px; background-color: #fff;border-radius: 5px 5px 0px 0px;" id="whiteDiv">

        <div class="col-md-4">
            <div class="section" id="section-one" style="border:none;">
                <div class="header">
                    <img class="header-img" />
                    <div class="header-label">
                        <h1 class="header-text"></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="section" id="section-two">
                <div class="header">
                    <img class="header-img" />
                    <div class="header-label">
                        <h1 class="header-text"></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="section" id="section-three"  style="border:none;">
                <div class="header">
                    <img class="header-img" />
                    <div class="header-label">
                        <h1 class="header-text"></h1>
                    </div>
                </div>
            </div>
        </div>
   <!--     <div class="push" style="background-color:#fff; height:100%;"></div>-->
    </div>
    
</div>
<style>

@media (min-width: 1200px) {
  .container {
    width: 1000px;
  }
}

</style>