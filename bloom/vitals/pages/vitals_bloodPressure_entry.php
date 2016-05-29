<?php 
  include 'popup/CientSiderror_popup.php';
?>
<?php
if(isset($_GET['inputType']))
{
    $inputType=$_GET['inputType'];
}
else
{
    $inputType="BLOOD_PRESSURE";
}
?>
<link rel="stylesheet" type="text/css" media="screen" href="/gladstone/portal/bloom/vitals/scripts/css/bootstrap-datetimepicker.min.css">
<script>
var inputType = "<?php echo $inputType; ?>";
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_manual_entryBP.js"></script>

<link type="text/css" rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/vitals/scripts/css/bloodPressure.css" />
<div class="col-md-8 padd-top20">
  <div class="col-lg-12 assessments">
    <div class="row">
      <div class="col-md-6">
        <h3>
         <?php
		if($_COOKIE['type'] == 'Patient' or $_COOKIE['type'] == 'PATIENT' or $_COOKIE['type'] == 'patient')
		{
		?>
        <a class="BP_Detail" href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_graphBP.php','deviceConfigId=<?php echo $_REQUEST["deviceConfigID"];?>&vitalType=Blood-Pressure','menu-content',event,this)" ><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Blood Pressure</a>
        <?php
		}
		else
		{?>
		<a class="BP_Detail" href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_graphBP.php','deviceConfigId=<?php echo $_REQUEST["deviceConfigID"];?>&vitalType=Blood-Pressure&contextPId=<?php echo $_REQUEST["contextPId"];?>','menu-content',event,this)" ><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Blood Pressure</a>
		<?php
		}
		?>
               
        </h3>
      </div>
      <div class="col-md-6">
        
      </div>
    </div>
    </div>
 <form action="javascript:callFunctionBP()" id="bp-form" class="manual-form" auctcomplete="off">
  <div class="col-lg-12 Blood_Pressure">
    <h1>Manual Reading</h1>
    <div class="table-responsive">
    <table class="table">
      
      <tbody>
        <tr>
          <th style="border-top:0px;" scope="row" class="col-md-6">Date & Time</th>
          <td style="border-top:0px;" align="right" class="col-md-6">
                         <div class='input-group date' id='datetimepicker1'>
                            <input id="vitalDateInput" type='text' class="form-control req entry"  maxlength="10" style="width: 150px; float: right; border-radius: 5px; box-shadow: 0px 1px 2px rgb(204, 204, 204) inset;" />
                            <span class="input-group-addon" style="background: transparent; border: medium none; padding-left: 8px;">
                  <img style="width: 30px; margin-top: -4px;" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/vitals/images/calender.png" />
                            </span>
                        </div></td>
<!--<span class="coloredTable">Tue Nov 3, </span> 2015 10:02PM</td>-->
        </tr>
        <tr>
          <th scope="row">Systolic</th>
          <td align="right"><span class="BigFont coloredTable"><input type="text" class="lbsText  req entry" name="systolic" id="systolic"/></span> <span class="UnitTable">mm Hg</span></td>
        </tr>
        <tr>
          <th scope="row">Diastolic</th>
          <td align="right"><span class="BigFont"><input type="text" class="lbsText  req entry" name="diastolic" id="diastolic" /></span> <span class="UnitTable">mm Hg</span></td>
        </tr>
      </tbody>
    </table>
    </div>
    <div class="form_bp">
    <div class="form-group row">
  <label class="col-md-12 control-label" for="textarea">Notes</label>
  <div class="col-md-12">                     
    <textarea class="form-control" id="notes" name="notes" placeholder="Type your note here"></textarea>
  </div>
</div>

<div class="bpBtnGroup" align="right">
<button class="btn btn-default btn-grey disabled" id="addBP" type="submit"  disabled="disabled">Add</button>
</div>
    
    </div>
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
<div class="col-md-4 padd-top50">
			<div class="sidebar-filter">
				<div class="card">
					<div class="filter-tabs">
						
						
					</div>
				</div>
			</div>
</div>
<script>
    $('#datetimepicker1').datetimepicker({
        pickTime: true,
        maxDate: moment(),
		
    });
$(function() {
  $('#bp-form').on('keydown', '#systolic,#diastolic', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
})
</script>