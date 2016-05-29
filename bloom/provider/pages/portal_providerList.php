<?php
include('controller/portal_providerList_controller.php');
?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css">
<style>
div.scrollbar1{height:640px}
.activePage
{
font-weight:bold;
}
</style>

<!--start header -->
  <!--end header -->
  <!--start wapper -->
	<div class="col-md-8 padd-top20">
    <div class="dashboard_patient_rightpart card-container">

     <div class="compare_models mCustomScrollbar _mCS_1">
     <div class="mCustomScrollBox mCS-light-thin mCS-mouse-over" id="mCSB_1" style="position:relative; max-width:100%;">

		<div class="dashboard_box_bg">
			<!--<div class="dashboard_box_bg_img"><a href="#" onClick="openPageWithAjax('../../provider/pages/portal_addProvider.php','','menu-content',event)" ><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/addpatient.png" alt=""></a></div>-->
			<div class="dashboard_box_bg_text"><a href="#" onClick="openPageWithAjax('../../provider/pages/portal_addProvider.php','','menu-content',event)" ><?php echo constantAppResource::$PROVIDER_PORTAL_PROVIDER_TEXT_CLICK_ADD_PROVIDER;?></a></div>
		</div>

          <div id="PatientList_part_bg">

            <?php  echo addProviderCards($providerList, VMCPortalConstants::$PHP_EMPTY) ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="clear"></div>
 <!-- Confirm Delete Provider Modal --->
<div class="modal" id="providerDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header modal-head">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Provider</h4>
      </div>
      <div class="modal-body pat-body">
        Are you sure you want to delete it.
      </div>
      <div class="modal-footer" style="margin-top:30px; padding:15px;">
        <button type="button" class="btn btn-default btnpatlist " data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btnpatlist1" delete-id="0" id="provider-delete-button">Delete</button>
      </div>
    </div>
  </div>
</div>
<!--end wapper -->
<!--start footer -->
<!--end footer -->
<script>
			window.location.hash = '/provider_list';
   function deleteProvider(providerId)
  {
		$("#provider-delete-button").attr('delete-id',providerId);
		$("#providerDeleteModal").modal();
		//alert(providerId);
  }

function openEditProvider(providerId, e)
{
	var params = 'providerId='+providerId+'&edit=edit';
	var purl = '../../provider/pages/portal_addProvider.php';
	openPageWithAjax(purl,params,'menu-content',e);
}


</script>
<script>
$(function(){
 $("#provider-delete-button").click(function(e){
	var providerId = $(this).attr('delete-id');
		openWithAjaxAndClosePopup('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php?Delete=true&providerId='+providerId,'','menu-content',e)
  });
});
</script>
