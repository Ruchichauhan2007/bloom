<?php
include ('controller/dashboard_controller.php'); 
include ('portal_profileHeader.php');
?>
<script type="text/javascript">
$(document).ready(function(){	
controlMenu();
	$("#tab_supplies").attr("class", "active");
});
</script>

<link rel="stylesheet" href="../../dashboard/script/css/add_supplies.css" />
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<div class="col-md-8 padd-top20">
<div style="padding-left: 20px; margin-top: 22px;" class="mytab">
	<form id="supplyForm" class="form-horizontal">
    <input type="hidden" name="SUP_CFG_ID_STRIPS" id="SUP_CFG_ID_STRIPS" />
    <input type="hidden" name="SUP_CFG_ID_SOLNAFTER" id="SUP_CFG_ID_SOLNAFTER" />
    <input type="hidden" name="SUP_CFG_ID_LANCETS" id="SUP_CFG_ID_LANCETS" />
    <input type="hidden" name="SUP_CFG_ID_GLUCOID" id="SUP_CFG_ID_GLUCOID" />
		<fieldset>
		<!-- <hr/> -->
		<legend>Supply Levels</legend>
		
		<div class="form-group" style="padding-left: 0px;">
			<div class="col-md-7 mcol12" style="margin-left: 0px; padding-left: 0px;">
				<div class="col-md-2">
					<label for="ex1">STRIPS</label>
					<input id="strips" name="strips" placeholder="43" class="form-control input-md" type="text">
				</div>
				<div class="col-md-2">
					<label for="ex3">LANCETS</label>
					<input id="lancets" name="lancets" placeholder="  43" class="form-control input-md" type="text">
				</div>
				<!--<div class="col-md-4">
					<label for="ex2">SOLUTION AFTER</label>
					input id="solutionAfter" name="solutionAfter" class="form-control input-md hasDatepicker" type="text" placeholder="MM/DD/YYYY"><img class="ui-datepicker-trigger" src="/gladstone/portal/bloom/dashboard/images/celender-icon.png" alt="Select date" title="Select date"
					<input id="solutionAfter" name = "solutionAfter" class="form-control input-md" type="text" name="textinput" placeholder="MM/DD/YYYY" >
					
				</div>-->
				
				<div class="col-md-4">
					<label for="ex3">GLUCOMETER ID</label>
					<input id="glucoId" name="glucoId" placeholder=" 00001891874719" class="form-control input-md" type="text">
				</div>
                <div class="col-md-4">
					<label for="selectbasic" class="">TYPE</label><br />
					<label class="control-label Bval" for="textinput" id="glucoType"></label>
				</div>
			</div>
			
			<div class="col-md-5 mcol12">
				
				<div class="col-md-6 pull-right" style="margin-top: 20px; text-align: right">
					<button type="button" class="btn btn-default btn-linktype" id="cancelSupply">cancel</button>
					<button type="submit" id="supplySave" class="btn btn-success">Save</button> 
				</div>
			</div>
		</div>
		</fieldset>
	</form>
</div>

<div style="padding-left: 20px; margin-top: 22px;" class="mytab">
	<form id="orderNewForm" class="form-horizontal">
		<fieldset>
		<!-- <hr/> -->
		<legend>Order New Supplies</legend>
		
		<div class="form-group">
			<div class="col-md-9 mcol12" style="padding-right: 10px; padding-left: 0px;">
				<div class="col-md-2">
					<div><label for="ex2">FREQUENCY</label></div>
					<div><label class="col-md-2 control-label Bval" for="textinput" id="freq"></label></div>
				</div>
				<div class="col-md-3">
					<div>
					<label for="ex2">ASSIGNED COACH</label>
					</div>
					<div>
					<label class="control-label Bval" for="textinput" id="coach"><?php echo $providInfo->{lastName}." ".$providInfo->{firstName}.", ".$providInfo->{credentials}; ?></label>
					</div>
				</div>
				<div class="col-md-3">
					<div>
					<label for="orderNote">ORDER NOTE</label>
					</div>
					<div>
					<input class="form-control" id="orderNote" name="orderNote" type="text">
					</div>
				</div>
				<div class="col-md-4">
					<div>
					<label for="shipMethod">SHIPPING METHOD</label>
					</div>
					<select id="shipMethod" name="shipMethod" class="form-control pt5">
					<option value="">Select Method</option>
					<option value="Next Day Air">Next Day Air</option>
					<option value="Next Day Air Sat">Next Day Air Sat</option>
					<option value="USPS Express">USPS Express</option>
					<option value="UPS Ground">UPS Ground</option>
					<option value="USPS Priority">USPS Priority</option>
					</select>
				</div>
				<div class="orderTble col-md-12" style="margin-top: 10px;">
					<table class="table my-style whitebg" id="orderTable">
						<thead>
							<tr>
								<th width="10%">
									<!-- <input type="checkbox" /> 
									div class="checkbox" style="display: none;">
										<label><input type="checkbox" value=""></label>
									</div -->
								</th>
								<th>CODE</th>
								<th>DESCRIPTION</th>
								<th width="15%">AMOUNT</th>
							</tr>
						</thead>
						<tbody class="two">
								
						</tbody>
					</table>
				</div>
			</div>
			<div class="orderBtn col-md-push-9 col-md-3 pull-right" style="position: absolute; bottom: 0px; right: 0; text-align: right">
				<button type="reset" class="btn btn-default btn-linktype" id="resetBtn">cancel</button>
				<button type="button" id="createOrder" class="btn btn-success" disabled="">ORDER</button>
			</div>
		</div>
		</fieldset>
	</form>
</div>
	
<div style="padding-left: 20px; margin-top: 22px;" class="mytab">	
	<div class="histTable col-md-9 mcol12" style="padding-left: 0px;">
		<legend>Order History</legend>
		<table class="my-style table whitebg"  id = "histTable">
		<thead>
			<tr>
			<th>DATE</th>
			<th>ID</th>
			<th>NOTE</th>
			<th>SHIPPING</th>
			<th>STATUS</th>
			<th>TRACKING</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
		
		<table class="my-style table myLtable" id = "orderDetailsTable" style="display: none;">
		<thead>
			<tr>
			<th>CODE</th>
			<th>DESCRIPTION</th>
			<th width="15%">AMOUNT</th>
			</tr>
		</thead>
		<tbody class="two">
			
		</tbody>
		</table>
	</div>
</div>
</div>
</div>

<div class="modal" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>-->
        <h4 class="modal-title">Confirm</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure want to create order?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default noExit" data-dismiss="modal" id="no">No</button>
        <button type="button" class="btn btn-primary noEntry" id="yes">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="../../dashboard/script/js/add_supplies.js"></script>
<script>
$(document).ready(function()
{
	$("#resetBtn").click(function()
	{
		//$(".suppRow").click();
		var chk = $(".suppRow").find("input[type='checkbox']");
		var txt = $(".suppRow").find("input[type='text']");
		var isChecked = chk.attr("checked");
		
		
		chk.prop("checked", false)
		chk.attr("checked", false)
		txt.css('display', 'none');	
		
		checkandEnableCreateOrderBtn();
			
	});
});
</script>
</body>
</html>
