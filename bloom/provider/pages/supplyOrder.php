<?php
include('controller/supplyOrder_controller.php');
include '../../common/util/Constants.php';
$institutionName = explode(":", $_SERVER['HTTP_HOST']);
$userName = $_COOKIE['user'];
$password = $_COOKIE['password'];
$authType = $_COOKIE['authType'];
$clientId = $_COOKIE['id'];
$imageName = $_COOKIE['imageLoginName'];
?>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/configuration.css">
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<div class="col-md-8 padd-top20">
<div class="GlucoseAcceptable">
<div class="supplyOrder">
  <h2>Upload Inventory</h2>
  <form enctype="multipart/form-data" onSubmit="return validateForm(this,event)" id="uploadData" name="uploadData">
    <div class="row">
      <div class="col-sm-6 col-sm-right-right-offset-6">
        <div class="form-group">
          <label for="fileType">SELECT FILE TYPE:</label>
          <select class="form-control"  name="uploadType" id="uploadType">
            <option value="CREATE_PATIENT_LAB_MATRIX">Patient lab Matrix</option>
            <option value="CREATE_PATIENT_INVENTORY">Patient Inventory and Supplies</option>
            <option value="CREATE_PATIENT_SCHEDULE">Patient vital schedule</option>
            <option value="CREATE_PATIENT_ORDER_RETURN" selected="selected">Order Return</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="selectFile">SELECT FILE:</label>
          <input type="file" class="" name="selectFile" id="selectFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
        </div>
      </div>
      <div class="col-sm-6 padright">
        <div class="form-group right">
            <input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
            <input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
            <input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"/>
            <input type="hidden" name="imageName" value="<?php echo $_COOKIE['imageLoginName'];?>"/>
            <input type="hidden" value="submit" name="submit">
          <input type="reset" class="btn btn-default btn-linktype" name="reset" id="reset" value="Cancel" />
          <input type="submit" class="btn btn-success" name="submit" id="submit" value="SUBMIT" disabled="disabled" />
        </div>
      </div>
    </div>
  </form>
</div>
<div  style="clear:both"></div>
<div class="supplyOrderHeading">
  <h2>Pending Orders</h2>
</div>
<div class="row">
  <div class="col-sm-6 padright col-sm-offset-6">
    <div class="form-group right">
      <input type="submit" class="btn btn-success orderBtn" name="submitorder" id="submitorder"  <?php if(count($getAllPendingOrders) == 0){?>disabled="disabled" <?php }?> value="SUBMIT ORDERS" />
    </div>
  </div>
</div>
</div>
<div  style="clear:both"></div>
    <div class="row">
    <?php
	if(count($getAllPendingOrders) > 0)
	  {
	?>
      <div id="loadOrders" class="table-responsive">
        <table id="tableId" class="table bgWhite">
          <thead>
            <tr>
              <th>DATE</th>
              <th>ID</th>
              <th>PATIENT</th>
              <th>NOTE</th>
              <th>SHIPPING</th>
              <th>STATUS</th>
               <th>TRACKING</th>
            </tr>
          </thead>
          <tbody>
          <?php
		  foreach($getAllPendingOrders as $pendingOrder)
		  {
		  $dateUtil = new DateUtil();
		  $orderDate = $dateUtil->formatDatetoStr($pendingOrder->{OrderDate});
		  ?>
              <tr id="<?php echo $pendingOrder->{shipmentHeaderId}; ?>" <?php if($pendingOrder->{shipmentHeaderId}){?>class="EDITTR" <?php } ?> >
	              <td><?php echo $orderDate;?></td>
	              <td><?php echo $pendingOrder->{shipmentHeaderId};?></td>
	              <td><?php echo $pendingOrder->{firstName}." ".$pendingOrder->{lastName};?></td>
	              <td><?php if ($pendingOrder->{orderNote}){ echo $pendingOrder->{orderNote};}else{echo "-";}?></td>
	              <td><?php if ($pendingOrder->{carrier}){  echo $pendingOrder->{carrier};}else{echo "-";}?></td>
	              <td align="center"><?php  if ($pendingOrder->{orderStatus}){ echo $pendingOrder->{orderStatus} ;} else { echo "-";}?></td>
	              <td align="center"><?php  if ($pendingOrder->{trackingNumber}){ echo $pendingOrder->{trackingNumber} ;} else { echo "-";}?></td>           
               </tr>
           <?php
		   }
		  ?>
          </tbody>
        </table>
      </div>
       <?php
      }
      else
	   {
	   ?>
	   <div style="text-align:center; font-weight:bold;">No Pending Orders</div>
	   <?php
	   }
	   ?>
      <div id="orderDetail">
      
      </div>
	 
      <div class="content_lib_button"></div>
    </div>
</div>
<style>
.bgWhite
{
background-color:#FFFFFF !important;
}
.GlucoseAcceptable {
    padding: 10px;
}
.supplyOrder {
    border-top: 2px solid #999;
    border-bottom: 2px solid #999;
}
.supplyOrder > h2,.supplyOrderHeading > h2{
    font-size: 20px;
    padding: 8px 0px;
}
.form-group.right {
    text-align: right;
}
.col-sm-6.padright {
    padding-right: 4px;
}
.btn.btn-success {
    background-color: #93c47d;
    border: medium none;
    border-radius: 2px;
    font-size: 14px !important;
    font-weight: bold;
    height: auto;
    padding: 7px 0;
    text-transform: uppercase;
}
.btn.btn-default.btn-linktype {
    background-color: transparent;
    border: medium none;
    color: #666;
}
.btn.btn-success.orderBtn
{width:44%}
#loadFaxes {
    padding: 15px;
}
#tableId > thead {
    border: 2px solid #ccc;
}
tbody tr.selected
{
	background-color:#6699FF !important;
}

input[type=submit][disabled=disabled] {
    background-color: #ccc;
}
</style>
<script>
$(document).ready(function(){
$("#selectFile").change(function()
{
$("#submit").removeAttr("disabled");
});

$("#reset").click(function()
{
$("#submit").attr("disabled","disabled");
});

$("#orderDetail").hide();
});
$("#tableId tbody tr.EDITTR").mouseenter(function(event)
	{
		if($(this).hasClass("selected"))
		{
			$("#tableId tbody tr").removeClass("selected");
			$("#orderDetail").hide();
		}
		
			var shipmentHeaderId = $(this).attr("id");
			$("#tableId tbody tr").removeClass("selected");
			$(this).addClass("selected");
			$("#orderDetail").show();
			openPageWithAjax('../../provider/pages/orderDetail.php','shipmentHeaderId='+shipmentHeaderId,'orderDetail',event,this);
	
	
	});

 $("#selectFile").change(function(){
		var fileExtension = ['xlsx']
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		$(".cart_page").html("Order Returns");
		$(".txt_div").html("Application supports .xlsx files only");
		$("#aboutPopup").show();
		$("#submit").attr("disabled","disabled");
		//	$("#fileBrowser").html("Application supports PDF, MOV and MP4 files only");
			//alert(1);
		}
	});	
function validateForm(ele,e)
{

	postContentMultipartForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/dataUpload',ele, e);
}
function postContentMultipartForm(action, ele, e) {
    if (typeof e != undefined) {
        e.preventDefault();
    }
	var formData = new FormData($(ele)[0]);
    $.ajax({
        url: action,
        type: 'POST',
        data: formData,//$('#' + formId).serialize(),
        crossDomain: true,
		 // async: false,
           cache: false,
		   //dataType:json,
           contentType: false,
           processData: false,
		 beforeSend: function(){showLoading()},
        success: function(result) {
		  var text = '{ "OrderData" : ' + result + '}'; 
		  var jsonData = JSON.parse(text);		 
		  var objData = jsonData.OrderData[0];
		  console.log(objData.message);
		  if(objData.message == "ORDERS_ALREADY_PROCESSED")	
		  {
		  	$(".cart_page").html("Message");
		  	$(".txt_div").html("The order already processed.");
		  }
		  else if(objData.message == "ORDER_PROCESSED_WITH_WARNING")	
		  {
		  	$(".cart_page").html("Message");
		  	$(".txt_div").html("Supply uploaded with some error. Please look into Shipment Report Error sheet for more details.");
		  }		
		  else
		  {
		  	$(".cart_page").html("Success");
		  	$(".txt_div").html("File uploaded successfully");
		  }  
		  
		  $("#aboutPopup").show();
		  $("#About_fadediv").show();
		  
	
        },
        error: function( request, textStatus, errorThrown) {
       	 request.getResponseHeader('VMCErrorCode')
           	$(".cart_page").html("System Error");
			$(".txt_div").html("File upload failed, Please try again.");
			$("#aboutPopup").show();
			$("#About_fadediv").show();
		   	$("#submit").attr("disabled","disabled");
        },
        complete: function() {
			hideLoading();
			console.log('completed')
			openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/supplyOrder.php','','menu-content',e,this)
		 }
    });
}
$("#submitorder").click(function(){
	$(this).attr('disabled', 'disabled');
	 var shipmentHeaderInfo;
	 var arr = new Array();
	 var dataVal = JSON.stringify(arr);
	 var retVal = postDataToServer(dataVal, EMR, 'getPendingShipment', processResponse);
	 function processResponse(result) {
	///console.log(result);
		if (result != null && result.message != null && result.success == true) 
		{
			var shipmentHeaderInfo = new Array();
			shipmentHeaderInfo = JSON.parse(result.message);	
			var authorizationToken = '';
			createShipmentOrder(shipmentHeaderInfo);
		}
	}
			var newArray = [];
/*function myDateFormatter (dob) {
			//var d = new Date(dob);
			var d = dob;
			var day = d.getDate();
			var month = d.getMonth()+1;
			var year = d.getFullYear();
			var date =  month +"/"+ day + "/" + year;
			console.log(date);
			return date;
		};*/
	function createShipmentOrder(shipmentHeaderInfo)
	{
		//console.log(shipmentHeaderInfo);
		shipmentHeaderInfo.forEach(function(d, i){
				/*var getdate = new Date(d.OrderDate);
				var orderDate = myDateFormatter(getdate);
				d.state = 2;
				d.orderStatus = 'SUBMITTED';
				d.OrderDate = orderDate;*/
				d.orderStatus = 'SUBMITTED';
				d.state = 2;
				newArray[i] = d;
			});
		 var datavalue = new Array();
		  datavalue = newArray;
		console.log(JSON.stringify(datavalue));
		$.ajax({
		    type: 'POST',
			url: window.location.origin + "/gladstone/rest/google/createShipmentOrderReport",
		    data: JSON.stringify(datavalue),
			contentType:"application/json; charset=utf-8",
    		dataType:"json",
		    beforeSend: function (request) {
			showLoading();
		    request.setRequestHeader("Authorization", authorizationToken);
		    },
		   
		    statusCode: {
		      401: function () {
		        console.log("Invalid Token createShipmentOrder");
		        refreshAuthToken(function (token) {
		          authorizationToken = token;
		          createShipmentOrder(shipmentHeaderInfo);
		        });
		      },
		      200: function (data) {
			  hideLoading();
			  	$(".cart_page").html("Success");
   				$(".txt_div").html("Order submitted successfully");
			  	$("#aboutPopup").show();
				$("#About_fadediv").show();
		        openPageWithAjax('../../provider/pages/supplyOrder.php','','menu-content','',this);
		      }
			 
		    }
		  });
	}	

});
	</script>