<?php 

  include 'popup/CientSiderror_popup.php';
  include '../../common/util/VMCPortalConstants.php';
  include '../../common/util/APIUtil.php';
  include '../../common/classes/EntityUtil.php';
  
  $entityUtil = new EntityUtil();
 $entityType = $entityUtil->getEntityTypeFromContext();
 $patientVitalId = $_REQUEST["patientVitalId"];
 $glucoseStatus = $_REQUEST["glucoseStatus"];

?>
<?php
if(isset($_GET['inputType']))
{
    $inputType=$_GET['inputType'];
}
else
{
    $inputType="Blood-Glucose";
}
?>
<link rel="stylesheet" type="text/css" media="screen" href="/gladstone/portal/bloom/vitals/scripts/css/bootstrap-datetimepicker.min.css">
<script>
var inputType = "<?php echo $inputType; ?>";
 var entityType = "<?php echo $entityType ?>";
 var glucoseStatus = "<?php echo $glucoseStatus ?>";
</script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_manual_entryBG.js"></script>

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
		<a class="BP_Detail" href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_graphBG.php','deviceConfigId=<?php echo $_REQUEST["deviceConfigID"];?>&vitalType=Blood-Glucose','menu-content',event,this)" ><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Blood Glucose</a>
		<?php
		}
		else
		{?>
		<a class="BP_Detail" href="javascript:void(0);" onClick="openPageWithAjax('../../vitals/pages/vitals_graphBG.php','deviceConfigId=<?php echo $_REQUEST["deviceConfigID"];?>&vitalType=Blood-Glucose&contextPId=<?php echo $_REQUEST["contextPId"];?>','menu-content',event,this)" ><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Blood Glucose</a>
		<?php
		}
		?>
		
		
		
		</h3>
      </div>
      <div class="col-md-6">
        
      </div>
    </div>
    </div>
  <form action="javascript:callFunctionBG()" id="bp-form" class="manual-form" auctcomplete="off">

  <div class="col-lg-12 Blood_Pressure">

      <div class="table-responsive">
        <h1>READING DETAILS</h1>

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
        </tr>
        <tr>
          <th scope="row">Blood Glucose</th>
          <td align="right"><span class="BigFont coloredTable">
          <?php if($_REQUEST["glucoseStatus"])
		  {
		   ?>
          <input type="text" class="lbsText  req entry" name="bodyGlucose" id="bodyGlucose" readonly="readonly"/>
          <?php 
		  }
		  else
		  {
		  ?>
          <input type="text" class="lbsText  req entry" name="bodyGlucose" id="bodyGlucose"/>

          <?php 
		  }
		  ?>
          </span><span class="UnitTable">mg/dl</span></td>
        </tr>
        <tr>
          <th scope="row">State</th>
          <td align="right" class="pre-post-meal"><a><span class="PRE" data="PRE" >Pre-Meal</span></a><a><span class="POST" data="POST">Post-Meal</span></a></td>
        </tr>
      </tbody>
    </table>
    </div>

    <div class="newBloodGlucose">
    <h1>WELLNESS</h1>
    <div class="table-responsive">
    <table class="table">
      
      <tbody>
        <tr>
          <th style="border-top:0px;" scope="row" class="col-md-6">Mood</th>
          <td style="border-top:0px;" align="right" class="col-md-6"><span class="col-md-3">Down</span><span class="col-md-6"><input type="range" name="mood" id="mood"/></span><span class="col-md-3">Happy</span></td>
        </tr>
        <tr>
          <th style="border-top:0px;" scope="row" class="col-md-6">Activity</th>
          <td style="border-top:0px;" align="right" class="col-md-6"><span class="col-md-3">Down</span><span class="col-md-6"><input type="range" name="activity" id="activity"/></span><span class="col-md-3">Up</span></td>
        </tr>
        <tr>
          <th style="border-top:0px;" scope="row" class="col-md-6">How do you feel?</th>
          <td style="border-top:0px;" align="right" class="col-md-6"><span class="col-md-3">Sick</span><span class="col-md-6"><input type="range" name="feel" id="feel"/></span><span class="col-md-3">Healthy</span></td>
        </tr>
      </tbody>
    </table>
    </div>
    </div>
    
    <div class="newBloodGlucose">
    <h1>INTAKE</h1>
    <div class="table-responsive">
    <table class="table">
      
      <tbody>
        <tr>
          <th style="border-top:0px;" scope="row">Carbohydrates</th>
          <td style="border-top:0px;" align="right"><span class="BigFont coloredTable"><input type="text" class="lbsText " name="carbs" id="carbs"/></span> <span class="UnitTable">grams</td>
        </tr>
        <tr class="section">
          <th scope="row">Insulin &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-plus" id="add-button" onclick="addInsulinItem(event);"></span></th>
          <!--<td align="right"><span class="BigFont">
          <select name="insulin">
          <option>Novolog</option>
           <option>Novolog</option>
          </select>
          <span aria-hidden="true"></span> &nbsp;</span> <span class="BigFont coloredTable">
          <input type="text" class="lbsText  req entry" name="insulinReading" id="insulinReading" value=""/>
          </span> <span class="UnitTable"> units</span>
          </td>-->
        </tr>
      </tbody>
    </table>
    </div>
    </div>
    
    <div class="newBloodGlucose">
    <h1>KETONES</h1>
    <div class="table-responsive">
    <table class="table">
      
      <tbody>
        <tr>
          <th style="border-top:0px;" scope="row">Urine Ketone</th>
          <td style="border-top:0px;">
          <ul class="Urine-Ketone" style="float:right;">
          <li><a href="#"><span class="color1" data="5"></span></a></li>
          <li><a href="#"><span class="color2" data="15"></span></a></li>
          <li><a href="#"><span class="color3" data="40"></span></a></li>
          <li><a href="#"><span class="color4" data="60"></span></a></li>
          <li><a href="#"><span class="color5" data="180"></span></a></li>
          </ul>
          </td>
          <td style="border-top:0px;" align="right"><span class="BigFont coloredTable"><input type="text" class="lbsText " name="urineKetone" id="urineKetone" readonly="readonly"/></span> <span class="UnitTable">mg/dl</span></td>
        </tr>
        <tr>
          <th scope="row">Blood Ketone</th>
          <td></td>
          <td align="right"><span class="BigFont coloredTable"><input type="text" class="lbsText " name="bKetone" id="bKetone" /></span> <span class="UnitTable">mmol/l</span></td>
        </tr>
      </tbody>
    </table>
    </div>
    </div>
    
    <div class="form_bp">
   
    <div class="form-group row">
  <label for="textarea" class="col-md-12 control-label">NOTES</label>
  <div class="col-md-12">                     
    <textarea placeholder="Type your note here" name="notes" id="notes" class="form-control"></textarea>
  </div>
</div>

<div align="right" class="bpBtnGroup">
<button class="btn btn-default btn-blued btn-active" id="addBG" type="submit"  disabled="disabled">Save</button>
</div>
   
    </div>
    
    
    </div>
    <input type="hidden" id="mealType" name="mealType" />
    <input type="hidden" id="patVitalId" name="patVitalId" value="<?php echo $patientVitalId ?>"/>
    <input type="hidden" id="vitalTime" name="vitalTime" value="<?php echo $_REQUEST["vitalTime"]; ?>"/>

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
$(function() {
  $('#bp-form').on('keydown', '#bodyGlucose,#carbs,#bKetone,.insulin-input', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
});

$(".Urine-Ketone li a span").click(function()
{
//$("#urineKetone").val($(this).attr("data"));
if(!$(this).hasClass('disabled'))
{
$(".Urine-Ketone li a span").removeClass("active");
$(this).addClass("active");
$("#urineKetone").val($(this).attr("data"));
}
});
/*$(document).ready(function()
{
	var glucoseStatus = "<?php //echo $_POST["glucoseStatus"]; ?>";
	if(glucoseStatus == "edit")
	{
		$("#vitalDateInput").attr('disabled','disabled');
		$("#bodyGlucose").attr('disabled','disabled');
		$("#bodyGlucose").val('<?php //echo $_REQUEST["unitValue1"]; ?>');
		
	}
});*/
</script>