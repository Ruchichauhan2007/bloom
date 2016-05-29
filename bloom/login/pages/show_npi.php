<?php
  include '../../dashboard/pages/controller/portal_prescribingProvider_controller.php';
  include '../../common/util/CardFactory.php';
  
  	$entityUtil = new EntityUtil();
	if(isset($_POST['appendedtext']))
{
	try
	{
		
		foreach ($_POST[appendedtext] as $key => $value)
		{
			if (empty($value))
			{
				unset($_POST[textinput][$key]);
			}
		}
		
    	$npiId = $_POST[appendedtext];
		$setNPI = array_values($npiId);
	$paramArray[0] = json_encode($setNPI) ;
	$paramArray[1] = true ;
	$NPIDetails = $entityUtil->getObjectFromServer($paramArray, "getNpiInfo", VMCPortalConstants::$API_EMR);
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
if(isset($_POST['NpiId']))
{
	try
	{
		
		foreach ($_POST[NpiId] as $key => $value)
		{
			if (empty($value))
			{
				unset($_POST[NpiId][$key]);
			}
		}
		
    	$npiId[0] = $_REQUEST["NpiId"];
		//$setNPI = array_values($npiId);
	$paramArray[0] = json_encode($npiId) ;
	$paramArray[1] = false ;
	$NPIDetails = $entityUtil->getObjectFromServer($paramArray, "getNpiInfo", VMCPortalConstants::$API_EMR);
	}
	catch(Exception $e)
	{
		$msg = $e->getMessage();
	}
}
	
	 echo showNPIDetail($NPIDetails); 
 ?>
 <script type="text/javascript">
	$(document).ready(function(){
		$(".modal-body .moredetail").click(function(){
		$(".modal-body .lessDetail").click();
			var id =$(this).attr("id");
			id=id.split("_");
		 	id = id[1];
		  $(".modal-body #NPI_CardDetails_"+id).slideDown();
		   $(".modal-body #lessDetail_"+id).show();
		  $(".modal-body #moredetail_"+id).hide();
		}); 
		
		$(".modal-body .lessDetail").click(function(){
			var id =$(this).attr("id");
			id=id.split("_");
		 	id = id[1];
		  	$(".modal-body #NPI_CardDetails_"+id).slideUp();
		    $(".modal-body #lessDetail_"+id).hide();
		  	$(".modal-body #moredetail_"+id).show();
		}); 
	});
</script>
 <script type="text/javascript">
	$(document).ready(function(){
	/*
	
		$(".modal-body #moredetail").click(function(){
		  $(".modal-body #NPI_CardDetails").slideDown();
		  $(".modal-body #moredetail").css("display","none");
		}); 
		
		$(".modal-body #lessDetail").click(function(){
		  $(".modal-body #NPI_CardDetails").slideUp();
		  $(".modal-body #moredetail").css("display","block");
		}); */
		
$("#attach").click(function()
{
var npiId = $(".modal-body .detailinfo p.npiid").text();
var name = $(".modal-body .detailinfo .name").text();
var city = $(".modal-body .addressinfo p.city").text();
var state = $(".modal-body .addressinfo p.state").text();
var phone = $(".modal-body .addressinfo p.phone").text();
var fax = $(".modal-body .addressinfo p.fax").text();
var taxonomy = $(".modal-body div.Taxonomy p.taxonomy").text();

npiId =npiId.split(":");
npiId = npiId[1];

phone =phone.split(":");
phone = phone[1];

fax =fax.split(":");
fax = fax[1];

/*taxonomy =taxonomy.split(":");
taxonomy = taxonomy[1];

*/
$("#npi_number").val(npiId);
$("#name").val(name);
$("#address1").val(city);
$("#address2").val(state);
$("#phone").val(phone);
$("#fax").val(fax);
$("#fax").val(fax);
$("#taxonomy").val(taxonomy);

});	
		
		
		
		
	});
</script>
<style>
.moredetail {
    cursor: pointer;
}
.lessDetail {
    cursor: pointer;
}
.ADD_Detail_NPI.table-responsive {
  min-height: 93px;
}
.ADD_Detail_NPI h2.col-lg-12 {
  font-size: 18px;
  padding-bottom: 10px;
  padding-top: 10px;
}
.col-md-3.taxonomy h3 {
  border-bottom: 1px solid #ccc;
  font-size: 15px;
  margin-bottom: 10px;
  padding-bottom: 7px;
  min-height: 40px;
}
.ADD_Detail_NPIMain {
  float: left;
  min-height: 80px;
  width: 100%;
}
.col-md-4.taxonomy h3 {
  border-bottom: 1px solid #ccc;
  font-size: 15px;
  margin-bottom: 5px;
  padding-bottom: 5px;
}
</style>