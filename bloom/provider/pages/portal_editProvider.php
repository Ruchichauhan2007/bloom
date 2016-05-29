<?php 
  include 'controller/portal_addProvider_controller.php';
  
  $providerId =  $_REQUEST ["id"];

  $providerUtil = new ProviderUtil();
  $entityUtil = new EntityUtil();

  $providerInfo = $providerUtil->getProviderByid($providerId);

  $emails = $providerInfo->getEmailAddressInfo();
  $phone = $providerInfo->getPhoneInfo();
  $credential = $entityUtil->getCredentialInfoByEntityId($providerInfo->getProviderId());
  $roles = $entityUtil->getAllRoles();
  
?> 
<!--Including css files used in all the html pages -->
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/dashboard.css">
<style>
.col-xs-2 {
    width: 14%;
margin-left: 15px;
margin-right: 12px;
}
.col-xs-1 {
    width: 10%;
}
</style>
  <!--start wapper --> 
  <!--start dashboard_header -->
  <div class="dashboard_top_nav">
    <ul>
      <li><a href="#" class="active">Provider Detail</a></li>
    </ul>
  </div>
  <!--end dashboard_header -->
  <div style="clear:both"></div>
  <div class="row">
	<form class="form-horizontal" id="addprovideform" method="post" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_addProvider.php','providerForm','menu-content',event)" id="providerForm">
	<div class="col-xs-6"> 
		<div class="form-group">
			<label for="providerName" class="col-sm-5">Name*</label>
				<div class="row">
					<div class="col-xs-2" style="padding: 0px;">
						<input type="text" name="first_name" class="form-control" value="<?php echo $providerInfo->getFirstName(); ?>" placeholder="First">
					</div>
				<div class="col-xs-1" style="padding: 0px;">
					<input type="text" name="middle_name" class="form-control" value="<?php echo $providerInfo->getMiddleInitial(); ?>" placeholder="M">
				</div>
				<div class="col-xs-2" style="padding: 0px;">
					<input type="text" name="last_name" class="form-control" value="<?php echo $providerInfo->getLastName(); ?>" placeholder="Last">
				</div>
			</div>
	</div>
	
	<div class="form-group">
    <label for="dob" class="col-md-5">Date Of Birth*</label>
    <div class="col-md-7">
      <input type="text" class="form-control" name="dob" value="<?php echo $providerInfo->getDateOfBirth(); ?>" id="dob" placeholder="Date Of Birth">
    </div>
	
  </div>
  
  <div class="form-group">
    <label for="userName" class="col-sm-5">User Name*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="username" value="<?php echo $credential->getUserName(); ?>" id="userName" placeholder="User Name">
    </div>
  </div>
  
   <div class="form-group">
    <label for="password" class="col-sm-5">Password*</label>
    <div class="col-sm-7">
      <input type="password" class="form-control" value="<?php echo $credential->getPassword(); ?>" name="password" id="password" placeholder="Password">
    </div>
  </div>
  
   <div class="form-group">
    <label for="retypePassword" style="padding-right: 0px" class="col-sm-5">Retype Password*</label>
    <div class="col-sm-7">
      <input type="password" class="form-control" value="<?php echo $credential->getPassword(); ?>"  name="retypepassword" id="retypePassword" placeholder="Retype Password">
    </div>
  </div>
  
   <div class="form-group">
    <label for="providerPhone" class="col-sm-5">Phone</label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="phone" value="<?php echo $phone[0]->getPhoneNumber(); ?>" id="providerPhone" placeholder="Phone">
    </div>
  </div>
  
  <div class="form-group">
    <label for="providerEmail" class="col-sm-5">Email*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="email" value="<?php echo $emails->getEmailAddress(); ?>" id="providerEmail" placeholder="Email">
    </div>
    </div>
  </div>
  <div class="row">
  <div class="col-xs-6"></div>
  <div class="col-xs-6">
  <div class="dashboard_patient_status_img"> <img alt="" src="/gladstone/portal/bloom/dashboard/images/dashboard_profile_img.png">
        <div class="dashboard_patient_status_replace">Replace picture </div>
      </div>
	  </div>
  </div>
  
  </div>
  <div class="col-xs-6">
  <div class="form-group">
    <label for="dob" class="col-md-5">Gender*</label>
    <div class="col-md-7 bloom-select-bg">
      <select name="gender">
		<?php if($providerInfo->getGenderCode() == "M") {?>
		<option value="M" id="my_patient" selected="selected">Male </option>
		<option value="F" id="all_patient">Female </option>
		<option value="UN" id="all_patient">Unspecified </option>
		<?php} else {?>
			<option value="M" id="my_patient" >Male </option>
			<option value="F" id="all_patient" selected="selected">Female </option>
			<option value="UN" id="all_patient">Unspecified </option>
		<?php } ?>
	</select>
    </div>
	
  </div>
  
  <div class="form-group">
    <label for="credentials" class="col-md-5">Credentials*</label>
    <div class="col-md-7">
      <input type="text" class="form-control" value="<?php echo $providerInfo->getCredentials(); ?>" name="credentials" id="credentials" placeholder="RN">
    </div>
	
  </div>
  
  <div class="form-group">
    <label for="speciality" class="col-md-5">Speciality*</label>
    <div class="col-md-7">
      <input type="text" class="form-control" value="<?php echo $providerInfo->getSpecialityCode(); ?>" name="speciality" id="speciality" placeholder="Hospice">
    </div>
	
  </div>
  
  <div class="form-group">
    <label for="speciality" class="col-md-5">Provider Type*</label>
    <div class="col-md-7 bloom-select-bg">
      <select name="providertype">
		<?php if($providerInfo->getProviderType() == "Nurse"){?>
			<option value="Nurse" id="my_patient" selected="selected">Nurse </option>
			<option value="Doctor" id="my_patient" >Doctor </option>
			<option value="Others" id="all_patient">Others </option>
		<?php }else if($providerInfo->getProviderType() == "Doctor"){?>
			<option value="Nurse" id="my_patient" >Nurse </option>
			<option value="Doctor" id="my_patient" selected="selected" >Doctor </option>
			<option value="Others" id="all_patient">Others </option>
		<?php } else if($providerInfo->getProviderType() == "Others"){?>
			<option value="Nurse" id="my_patient" >Nurse </option>
			<option value="Doctor" id="my_patient" >Doctor </option>
			<option value="Others" id="all_patient" selected="selected">Others </option>
		<?php } ?>
			
	</select>
    </div>
	
  </div>
  
  <div class="form-group">
    <label for="speciality" class="col-md-5">Assign Role*</label>
    <div class="col-md-7 bloom-select-bg">
      <select name="assignrole">
	  
		<?php
		foreach($roles AS $role)
		{
			if($role->getDescription() == "Provider"){?>
				<option value="Provider" id="my_patient" selected="selected">Provider</option>
				<option value="Provider_Admin" id="all_patient">Administrator</option>
			<?php } else if($role->getDescription() == "Provider_Admin"){?>
				<option value="Provider" id="my_patient" >Provider</option>
				<option value="Provider_Admin" id="all_patient" selected="selected">Administrator</option>
		<?php	}
		} ?>
	</select>
    </div>
	
  </div>
  
  </div>
    <div class="row">
  <div class="col-md-12">
	<div class="pull-right">
        <input type="reset" value="Cancel"/>
        <input type="submit"  name="submit" class="submit" value="Save "/>
		<input type="hidden" name="submit" value="Save"/>
      </div>
  </div>
  </div>
     </form>
  </div>
 <!-- Confirm Delete Provider Modal ---> 
<div class="modal fade" id="providerDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Alert</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to delete it.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" delete-id="0"  id="provider">Delete</button>
      </div>
    </div>
  </div>
</div>


<!--end wapper -->

<script>

sub=function deleteProvider()
{
	 $('#providerDeleteModal').modal();
	return false; 
 }
 
 
 
 $("#provider").click(function(){
 
 });

$(function(){
	 $( "#dob" ).datepicker({
		showOn: "button",
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy"
		});
	});
</script>

