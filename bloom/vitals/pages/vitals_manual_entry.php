<?php 
  include '../../common/util/VMCPortalConstants.php';
  include 'popup/CientSiderror_popup.php';
?>
<?php
if(isset($_GET['inputType']))
{
    $inputType=$_GET['inputType'];
}
else
{
    $inputType="GLUCOSE";
}
?>
<script>
var inputType = "<?php echo $inputType; ?>";
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_manual_entry.js"></script>

<link rel="stylesheet" type="text/css" href="/gladstone/portal/bloom/vitals/scripts/css/vitals.css">
<link rel="stylesheet" type="text/css" media="screen" href="/gladstone/portal/bloom/vitals/scripts/css/bootstrap-datetimepicker.min.css">

<div id="type-row" style="padding: 3px 0 4px 24px;">
<span class="custom-dropdown custom-dropdown--white" style="margin:0px; padding:0px; width:215px">
    <select id="type-select" class="custom-dropdown__select custom-dropdown__select--white" style="width:215px;">
        <option value="GLUCOSE">Glucose</option>
        <!-- <option value="BLOODPRESSURE">Blood Pressure</option>
        <option value="WEIGHT">Weight</option> -->
    </select>
    </span>
</div>
<div class="vitals-content">
    <form action="javascript:callFunction()" class="manual-form">
        <div class="main-content">
            <div class="left-content">
                <div id="device-picture">
                    <img src="/gladstone/portal/bloom/vitals/images/glucometer.png" style="width:103px;height:215px;margin-left:-53px;margin-top:-115px;"/>
                </div>
                <div class="vitalInputContainer">
                    <h2>Enter
                        <br>Glucose</h2>
                    <input id="vitalValInput" class="vitalInput line input-large" type="text" min="1" max="999" name="manualEntry">
                    <h2>mg/dL</h2>
                </div>
            </div>
            <div class="right-content">

                <div class="dateInputContainer">

                    <div class="form-group">
					<span class="custom-dropdown custom-dropdown--white unspeceFide_121" style="margin:0px; padding:0px; width:215px">
    					<select id="segmentSelect" class="custom-dropdown__select custom-dropdown__select--white" style="width:215px;">
        					<option selected="selected" value="<?php echo VMCPortalConstants::$UNSPECIFIED; ?>">Unspecified</option>
                            <option value="<?php echo VMCPortalConstants::$PRE; ?>">Pre-meal</option>
                            <option value="<?php echo VMCPortalConstants::$POST; ?>">Post-meal</option>
    					</select>
    				</span>
                        <!--<select id="segmentSelect">
                            <option selected="selected" value="NA">Unspecified</option>
                            <option value="PRE">Pre-meal</option>
                            <option value="POST">Post-meal</option>
                        </select>-->
                        <div class="separater"></div>
                        <div class='input-group date' id='datetimepicker1'>
                            <input id="vitalDateInput" type='text' class="form-control"  maxlength="10" />
                            <span class="input-group-addon">
                                <img src="/gladstone/portal/bloom/vitals/images/celender1221.png" />
                            </span>

                        </div>
                        <div class="separater"></div>
                        <div class='input-group date' id='datetimepicker2'>
                            <span class="input-group-addon">
							<input id="vitalTimeInput" type='text' class="form-control" />
                            <!--<span class="glyphicon glyphicon-clock"></span>-->
                            </span>

                        </div>
					<!--	<span class="custom-dropdown custom-dropdown--white timeZoneControl">
    					<select id="timeZone" class="custom-dropdown__select custom-dropdown__select--white" style="width: 85px;">
        					<option selected="selected" value="AM">AM</option>
                            <option value="PM">PM</option>
    					</select>
    				</span> -->
                    </div>
                </div>
            </div>

            <div class="button-content">
                <!--<input class="cancelButton" type="button" value="Cancel">-->

                    <input class="cancelButton" type="reset" class="reset" name="C" value="Cancel">
                    <input class="nextButton" type="submit" class="submit" id="vitalSave" name="S" value="Save" data-toggle='modal' data-target="#confirmModal"/>
            </div>
    </form>
    </div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmTitle"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:0px;">
                <div class="modal-body">
                    <P>Saving Measurement...</P>
                </div>
            </div>
        </div>
    </div>