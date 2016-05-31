<?php
include('controller/portal_providerList_controller.php');
?>
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/script/css/dashboard.css">
<script>
function getChar(ele)
{
	var char = $(ele).val();
	openPageWithAjax('../../provider/pages/portal_providerList.php','filter=true&checkChar='+char,'menu-content',event,this);
}
</script>
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
 
  <div class="col-md-4 padd-top50">
   <div class="sidebar-filter p-md">
		 <div class="form-group serch_patlist">
				<input type="hidden" value="<?php echo $selectPatient;?>" id="currentPage" />
				<input type="hidden" value="<?php echo $page;?>" id="Page" />
				<label class="item-input serch-input"> 
					<input type="text" class="form-control" value="<?php echo $_REQUEST['searchStr']?>" id="searchInput" placeholder="Search by name, DOB, phone..." name="q"/>
				</label>
				<div class="input-group-btn search_but">
					<button class="btn btn-disabled btn-block" id="patientSearch" type="button">Search</button>
				</div>
			</div>
	<div class="btn-sorting text-center">
		<span class="searchLetters"><button value="a" onclick="getChar(this);">A</button></span>
		<span class="searchLetters"><button value="b" onclick="getChar(this);">B</button></span>
		<span class="searchLetters"><button value="c" onclick="getChar(this);">C</button></span>
		<span class="searchLetters"><button value="d" onclick="getChar(this);">D</button></span>
		<span class="searchLetters"><button value="e" onclick="getChar(this);">E</button></span>
		<span class="searchLetters"><button value="f" onclick="getChar(this);">F</button></span>
		<span class="searchLetters"><button value="g" onclick="getChar(this);">G</button></span>
		<span class="searchLetters"><button value="h" onclick="getChar(this);">H</button></span>
		<span class="searchLetters"><button value="i" onclick="getChar(this);">I</button></span>
		<span class="searchLetters"><button value="j" onclick="getChar(this);">J</button></span>
		<span class="searchLetters"><button value="k" onclick="getChar(this);">K</button></span>
		<span class="searchLetters"><button value="l" onclick="getChar(this);">L</button></span>
		<span class="searchLetters"><button value="m" onclick="getChar(this);">M</button></span>
		<span class="searchLetters"><button value="n" onclick="getChar(this);">N</button></span>
		<span class="searchLetters"><button value="o" onclick="getChar(this);">O</button></span>
		<span class="searchLetters"><button value="p" onclick="getChar(this);">P</button></span>
		<span class="searchLetters"><button value="q" onclick="getChar(this);">Q</button></span>
		<span class="searchLetters"><button value="r" onclick="getChar(this);">R</button></span>
		<span class="searchLetters"><button value="s" onclick="getChar(this);">S</button></span>
		<span class="searchLetters"><button value="t" onclick="getChar(this);">T</button></span>
		<span class="searchLetters"><button value="u" onclick="getChar(this);">U</button></span>
		<span class="searchLetters"><button value="v" onclick="getChar(this);">V</button></span>
		<span class="searchLetters"><button value="w" onclick="getChar(this);">W</button></span>
		<span class="searchLetters"><button value="x" onclick="getChar(this);">X</button></span>
		<span class="searchLetters"><button value="y" onclick="getChar(this);">Y</button></span>
		<span class="searchLetters"><button value="z" onclick="getChar(this);">Z</button></span>
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
