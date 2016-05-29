<?php
  include '../../common/util/VMCPortalConstants.php';
  include '../../common/util/APIUtil.php';
  include '../../common/classes/EntityUtil.php';
  $entityUtil = new EntityUtil();
	try
	{
		$paramArray = array();
		$getAllPendingOrders = $entityUtil->getObjectFromServer($paramArray, "getPendingShipment", VMCPortalConstants::$API_EMR);
		
	}
	catch ( Exception $e ) {
		
		$msg = $e->getMessage();
	}
		


 foreach($getAllPendingOrders as $pendingOrder)
  {
	  if($pendingOrder->{shipmentHeaderId} == $_REQUEST["shipmentHeaderId"])
	  {
		  $address = $pendingOrder->{addressLine1}." ".$pendingOrder->{addressLine2}.", ".$pendingOrder->{city}.", ".$pendingOrder->{shipmentState}." ".$pendingOrder->{zipCode};
		  $shipmentDetails =$pendingOrder->{shipmentDetails}; 
		  ?>
			<div class="table-responsive">
			<h3 style="padding-left:10px;"><?php echo $pendingOrder->{firstName}." ".$pendingOrder->{lastName}." ".$address; ?></h3>
			  <table id="tableId" class="table">
				  <thead>
					<tr>
					  <th>CODE</th>
					  <th>DESCRIPTION</th>
					  <th>AMOUNT</th>
					</tr>
				  </thead>
				  <tbody>
                  <?php
				  foreach($shipmentDetails as $shipmentDetail)
				  {
				  ?>
                      <tr id="<?php echo $shipmentDetail->{shipmentDetailId};?>">
                          <td><?php echo $shipmentDetail->{itemName};?></td>
                          <td><?php echo $shipmentDetail->{supplyDescription};?></td>
                          <td><?php echo $shipmentDetail->{quantity};?></td>
                      </tr>
				  <?php
                  }
                  ?>
				   </tbody>
				</table>
			
			</div>
			<?php 
		}
	}
	?>
	