<?php 
 include 'controller/portal_addProvider_controller.php';
 include 'popup/CientSiderror_popup.php';
 include '../../common/util/Constants.php';
 $institutionName = explode(":", $_SERVER['HTTP_HOST']);
	$serverimgpath = constants::$WEB_ROOT;
	$imgKey =  constants::$IMAGE_KEY;
   $providInfo = NULL;
  $entityUtil = new EntityUtil();
  
  if (isset ( $_REQUEST['edit'] )) {
	$providerId = $_REQUEST['providerId'];
	$paramArray[0] = $providerId ;
	$providInfo = $entityUtil->getObjectFromServer($paramArray, "findProviderById", VMCPortalConstants::$API_EMR);
	$patientProviderInfos = $providInfo->{patientProviderInfos};
	// Get existing credentials	
	$paramArray = array() ;
	$paramArray[0] = $providerId;
	$credentialsInfo = $entityUtil->getObjectFromServer($paramArray, "getCredentialInfoByEntityId", VMCPortalConstants::$API_ADMIN);
	// Format Date as per MM/DD/YYYY format
	$dateUtil = new DateUtil();
	$dateOdBirthStr = $dateUtil->formatDatetoStr($providInfo->{dateOfBirth});
	$phoneInfo = null;
	$emailInfo = null;
    $avatar = $providInfo->{avatar};
	$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
	if(!is_null($providInfo))
	{
		$phoneInfo = $providInfo->{phoneInfo};
		$emailaddressinfo = $providInfo->{emailAddressInfo};
	}
	
}
//var_dump($phoneInfo);
//var_dump($credentialsInfo);
//var_dump($emailaddressinfo);
//var_dump($providInfo);
?>

<!--Including css files used in all the html pages -->
<link rel="stylesheet" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/dashboard.css">
<style>
.col-sm-3 {
	width: 23%;
}
.form-group{ 
	float:left; 
	width:100%;
	margin-bottom: 7px;
}
label.col-md-4 {
    font-size: 16px !important;
    padding: 10px 0 10px 8px !important;
    text-align: left !important;
}
.ascalate {
text-align: right;
float: right;
margin-right: 0;
}

/*.dashboard_patient_status_img img{
    width: 200px; !important;
	width:100%;
	padding: 5px 10px;
}*/

.dashboard_patient_status_img img {
  width: 100%;
  padding: 5px 10px 5px 5px;
  max-height: 120px;
  /*max-width: 120px;*/
  min-height: 120px;
  min-width: 120px;
}
.pat_but_bg11
{
min-height: 16.43px; */
padding: 2px 0 0 10px;
border-bottom: 1px solid #e5e5e5;
background: #f7f7f9;
background: -moz-linear-gradient(top, #f7f7f9 0%, #f6f6f8 6%, #e4e3e8 31%, #e2e1e7 37%, #d9dadf 49%, #ceceda 66%, #cbcbd5 69%, #c7c7d3 77%, #c2c1cf 83%, #b9b8c6 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f7f7f9), color-stop(6%,#f6f6f8), color-stop(31%,#e4e3e8), color-stop(37%,#e2e1e7), color-stop(49%,#d9dadf), color-stop(66%,#ceceda), color-stop(69%,#cbcbd5), color-stop(77%,#c7c7d3), color-stop(83%,#c2c1cf), color-stop(100%,#b9b8c6));
background: -webkit-linear-gradient(top, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
background: -o-linear-gradient(top, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
background: -ms-linear-gradient(top, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
background: linear-gradient(to bottom, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f9', endColorstr='#b9b8c6',GradientType=0 ) !important;
height: 37px;
padding:2px 0;
}
.but_cancel_bg
{
background-color: rgb(4,174,252);
width: 100px;
-moz-border-radius: 5px;
border-radius: 5px;
border-bottom: solid 5px #0492d4;
-ms-filter: "progid:DXImageTransform.Microsoft.dropshadow(OffX=0,OffY=5,Color=#ff0492d4,Positive=true)";
filter: progid:DXImageTransform.Microsoft.dropshadow(OffX=0,OffY=5,Color=#ff0492d4,Positive=true);
/* font-size: 22pt; */
color: #fff;
margin-right: 5px;
height: 44px;

}
.pat-body {
font-size: 20px;
padding-top: 25px;
}
select:focus
{
    border-color:#66afe9;
    box-shadow: 0 0 10px #66afe9;
}

</style>
<!--start wapper -->
<!--start dashboard_header -->
<div class="col-md-8 padd-top20">
 <div class="card">
<div class="card-header">
  <div class="row">
	<div class="col-md-6 page-title"><a href=""><i class="back-icon"><img src="/gladstone/portal/bloom/common/images/back.svg"></i></a> Provider Detail</div>
	<div class="col-md-6 text-right secondary-title">Chance Diemer, DDS</div>
  </div>
</div>
<!--end dashboard_header -->
<div style="clear:both"></div>
<div class="card-body">
<div class="row">
  <form id="addprovideform" method="post" onSubmit="postPatientForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_addProvider.php','addprovideform','menu-content',event)">

<div class="form-layout">
<div class="col-lg-6 leftPartForm">
<div class="form-group">
	<!--First Name-->
	<label class="item-input item-floating-label">
		<span class="input-label">First Name*</span>
		<?php
		  if($providInfo->{firstName})
		  {
		  ?>
		  <input  name="first_name" id="first_name" placeholder="First" class="form-control" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First'"  maxlength="50"  value="<?php echo $providInfo->{firstName} ?>" /> 
		  <?php
		  }
		  else
		  {?>
		  <input  name="first_name" id="first_name" placeholder="First" class="form-control" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'First'"  maxlength="50"   /> 
		  <?php
		  }
		 ?>
	</label>
	<!--Last Name-->
	<label class="item-input item-floating-label">
		<span class="input-label">Last Name*</span>
		<?php
		  if($providInfo->{lastName})
		  {?>
		  <input  name="last_name" id="last_name" placeholder="Last" class="form-control" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last'"  maxlength="50"/ value="<?php echo $providInfo->{lastName} ?>"  /> 
		  <?php}
		  else{?>
			<input  name="last_name" id="last_name" placeholder="Last" class="form-control" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last'"  maxlength="50"/   /> 
			<?php
			}
		?>
	</label>
	<!-- Date of Birth-->
	<label class="item-input item-floating-label jq-datepicker"> 
		<span class="input-label">Date Of Birth*</span>
		 <?php
		  if($dateOdBirthStr )
		  {?>
			<input type="text" class="form-control" name="dob"  id="dob" placeholder="Date Of Birth"   value="<?php echo $dateOdBirthStr ; ?>"  maxlength="10" />
		<?php
		}
		else{?>
			<input type="text" class="form-control" name="dob"  id="dob" placeholder="Date Of Birth"  maxlength="10" />
		<?php
		}
		?>
	</label>
	<!--Email -->
	<label class="item-input item-floating-label">
		<span class="input-label">Email*</span>
		<?php
			if($emailaddressinfo[0]->{emailAddress})
			{?>
			<input  name="email" id="providerEmail" placeholder="User@host.com" class="form-control" type="text" value="<?php echo $emailaddressinfo[0]->{emailAddress} ?>"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'User@host.com'"  maxlength="50" />
			<?php
			}
			else
			{?>
			<input  name="email" id="providerEmail" placeholder="User@host.com" class="form-control" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'User@host.com'"  maxlength="50" />
			<?php
			}
			?>
			<?php
			if($credentialsInfo->{userName})
			{?>
			<input  name="username" id="username" placeholder="User Name" class="form-control" type="hidden" readonly="readonly" value="<?php echo $credentialsInfo->{userName} ?>"   />
			<?php
			}
			else
			{?>
				<input  name="username" id="username" placeholder="User Name" class="form-control" type="hidden" onfocus="this.placeholder = ''" onblur="this.placeholder = 'User Name'"  maxlength="15"  />
			<?php
			}
			?>
	</label>
	<!--Password -->
	<label class="item-input item-floating-label">
		<span class="input-label" for="passwordinput">Password*</span>
		<?php
			if($credentialsInfo->{password})
			{
		  ?>
			<input  name="password" id="password" placeholder="Password" class="form-control" type="text" value="********"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'"  maxlength="15"  />
			<?php
			}
			else
			{?>
			<input  name="password" id="password" placeholder="Password" class="form-control" type="text" value=""  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'"  maxlength="15" />
			<?php
			}
			?>
	</label>
	<!--Retype Password -->
	<label class="item-input item-floating-label">
		<span class="input-label" for="passwordinput">Re-type password*</span>
		<?php
		  if($credentialsInfo->{password})
		  {?>
			<input  name="retypepassword" id="retypepassword" placeholder="Retype Password" class="form-control input-md" type="text" value="********"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Retype Password'"  maxlength="15"  />
			<?php
			}
			else
			{
			?>
			<input  name="retypepassword" id="retypepassword" placeholder="Retype Password" class="form-control input-md" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Retype Password'"  maxlength="15" />	
			<?php
			}
			?>
	</label>
	<!--Phone-->
	<label class="item-input item-floating-label">
		<span class="input-label" for="textinput">Phone*</span>
		<?php
	if($providInfo->phoneInfo[0]->{phoneNumber})
	{
	?>
    <input  name="phone" id="providerPhone" placeholder="0123456789" class="form-control input-md" type="text" value="<?php echo $providInfo->phoneInfo[0]->{phoneNumber}; ?>"  onfocus="this.placeholder = ''" onblur="this.placeholder = '0123456789'"  maxlength="15"/>
	<?php}
	else{?>
    <input  name="phone" id="providerPhone" placeholder="0123456789" class="form-control input-md" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = '0123456789'"  maxlength="15" />
	<?php
	}
	?>
	</label>
  <!--<div class="col-md-1" style="padding: 0px;">
  <?php
  if($providInfo->{middleInitial})
  {?>
  <input  name="middle_name" id="middle_name" placeholder="M" class="form-control input-md captial" type="text"  value="<?php echo $providInfo->{middleInitial} ?>"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'M'"  maxlength="50"//> 
  <?php
  }
  else{?>
  <input  name="middle_name" id="middle_name" placeholder="M" class="form-control input-md captial" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'M'"  maxlength="50" value="<?php echo $providInfo->{middleInitial} ?>" /> 
  <?php  
  }
  ?>
  </div>-->
</div>


<!--Avatar-->
<!--<div class="form-group">
  <label class="col-md-4"></label>
<div class="col-sm-6">
          <div class="dashboard_patient_status_img">
		  <?php
		if(isset($_REQUEST["edit"]))
		{
		 if($avatar === "DEFAULT.PNG" OR $avatar === "")
		{
		?>
		<img id="blah" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/dashboard_profile_img.png" alt="">
		<?php	
		}
		else
		{
		
		?>
			<img id="blah" src="<?php echo $imgPath ;?>" alt="">
		<?php
		}
		}
		else{
		?>
				<img id="blah" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/dashboard/images/dashboard_profile_img.png" alt="">
		<?php
		}
		?> 	
           	<input type="hidden" name="hasImage" value="false"/>
            <div class="dashboard_patient_status_replace">
				<span id="repaceImg"><?php echo constantAppResource::$DASHBOARD_TEXT_REPLACE_PICTURE;?></span>
			</div>
          </div>
		  </div>

</div>-->
</div>

<div class="col-lg-6 rightPartForm">
<div class="form-group">
	<!--Gender-->
	<div class="form-group">
		<label class="control-label">Gender*</label>
		<select name="gender" id="gander" class="form-control select-icon">
				<?php
				if($providInfo->{genderCode} =="M")
				{
				?>
					  <option value="M" id="male" selected="selected">Male </option>
					  <option value="F" id="female">Female </option>
					  <option value="UN" id="unspecified">Unspecified </option>
				<?php
				}
				else if($providInfo->{genderCode} =="F")
				{?>
					  <option value="M" id="male">Male </option>
					  <option value="F" id="female" selected="selected">Female </option>
					  <option value="UN" id="unspecified">Unspecified </option>
				<?php
				}
				else if($providInfo->{genderCode} =="UN")
				{?>
					  <option value="M" id="male">Male </option>
					  <option value="F" id="female">Female </option>
					  <option value="UN" id="unspecified" selected="selected">Unspecified </option>
				<?php
				}
				else{?>
					  <option value="" id=""selected="selected"> </option>
					  <option value="M" id="male">Male </option>
					  <option value="F" id="female">Female </option>
					  <option value="UN" id="unspecified" >Unspecified </option>
				<?php
				}
				?>

            </select>
	</div>
	<!--Credentials-->
	<label class="item-input item-floating-label">
		<span class="input-label" for="textinput">Credentials*</span>
		<?php
		  if($providInfo->{credentials})
		  {?>
			<input  name="credentials" id="credentials" placeholder="RN" class="form-control" type="text"  value="<?php echo $providInfo->{credentials} ?>"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'RN'"  maxlength="20" />
			<?php
			}
			else
			{?>
			<input  name="credentials" id="credentials" placeholder="RN" class="form-control" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'RN'"  maxlength="20"  />
			<?php
			}
			?>
	</label>
	<!--Speciality-->
	<label class="item-input item-floating-label">
		<span class="input-label" for="textinput">Speciality*</span>
		<?php 
	if($providInfo->{specialityCode})
	{?>
    <input  name="speciality" id="speciality" placeholder="Hospice" class="form-control" type="text"   value="<?php echo $providInfo->{specialityCode} ?>"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Hospice'"  maxlength="20"/>
	<?php
	}
	else{
	?>
	    <input  name="speciality" id="speciality" placeholder="Hospice" class="form-control" type="text"   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Hospice'"  maxlength="20" />
	<?php
	}?>
	</label>
	<!--Provider Type-->
	<div class="form-group">
		<label class="control-label">Provider Type*</label>
		<select name="providertype" id="providertype" class="form-control select-icon">
			<?php if($providInfo->{providerType}=="Nurse")
			{?>
              <option value="Nurse" selected="selected">Nurse </option>
			  <option value="Doctor" >Doctor </option>
			  <option value="Others" >Others </option>
			 <?php
			 }
			 else if($providInfo->{providerType}=="Doctor")
			 {?>
              <option value="Nurse" >Nurse </option>
			  <option value="Doctor" selected="selected">Doctor </option>
			  <option value="Others">Others </option>
			 <?php
			 }
			 else
			 {
			 ?>
              <option value="Nurse">Nurse </option>
			  <option value="Doctor" >Doctor </option>
			  <option value="Others" selected="selected">Others </option>
			 <?php
			 }
			?>
            </select>
	</div>
	<!--Assign Role-->
	<div class="form-group">
		<label class="control-label">Provider Type*</label>
		<select name="assignrole" id="assignrole" class="form-control select-icon" style="width:100%;">
				<?php
				if($providInfo->{entityType} =="PROVIDER" or $providInfo->{entityType} =="Provider")
				{
				?>
					<option value="Provider" id="my_patient" selected="selected">Provider</option>
					<option value="Provider_Admin" id="all_patient">Administrator</option>
			 <?php
			 }
			 else{
			 ?>
					<option value="Provider" id="my_patient">Provider</option>
					<option value="Provider_Admin" id="all_patient" selected="selected">Administrator</option>
			<?php
			 }
			 ?>
            </select>
	</div>
<!--Google Mail-->
	<label class="item-input item-floating-label">
		<span class="input-label" for="textinput">Google Mail*</span>
		<?php 
	if($providInfo->{googleMail})
	{?>
    <input  name="googleMail" id="googleMail" placeholder="Google Mail" class="form-control" type="text"   value="<?php echo $providInfo->{googleMail} ?>"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Hospice'"  maxlength="20"/>
	<?php
	}
	else{
	?>
	    <input  name="googleMail" id="googleMail" placeholder="Google Mail" class="form-control" type="text"   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Hospice'"  maxlength="20" />
	<?php
	}?>
	</label>
</div>
</div>
</div>
<!-- Cancel Popup  -->
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:458px; margin:15% auto">
    <div class="modal-content" style="background-color: #e8e8e8; height:220px;">
      <div class="modal-header pat_but_bg11">

        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><img src="/gladstone/portal/bloom/common/images/close_but.jpg" alt=""></span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel" style="padding:6px;">Cancel</h4>
      </div>
      <div class="modal-body pat-body">
       Are you sure you want to Cancel? All changes will be lost.
      </div>
      <div class="modal-footer" style="padding:15px;margin-top:0px;">
		<input type="reset"  value="Yes" id="cancel"  data-dismiss="modal"  />
		 <input type="submit"  class="btn btn-default" data-dismiss="modal" value="No" style="margin:0px;"/>		  
      </div>
    </div>
  </div>
</div>
<!-- Cancel popup end  -->
</form>
</div>
</div>
<div class="card-footer">
        <div class="ascalate">
          <div class="pull-left">
            <input type="button" value="<?php echo constantAppResource::$COMMON_BUTTON_CANCEL;?>"  id="pageCancel"  class="btn-neutral" style=" margin:0px;" data="openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php','currentPage=1','menu-content',event,'this')"  onClick="openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php','currentPage=1','menu-content',event,'this')">
          </div>
          <div class="pull-left">
            <input type="submit" value="<?php echo constantAppResource::$COMMON_BUTTON_SAVE;?>" class="btn-neutral" name="save" id="submit" />
			<?php 
			if(is_null($providInfo))
			{
				?>
				<input type="hidden" name="submit" value="submit" id="page" class="btn-neutral"/>			
				<input type="hidden" name="providerId" value="" id="providerId" class="btn-neutral"/>
			<?php
			}
			else
			{
			?>
				<input type="hidden" name="providerId" value="<?php echo $providInfo->{providerId}?>" id="providerId" />
				<input type="hidden" name="update" value="update" id="page"/>
			<?php}?>
          </div>
        </div>
      </div>
</div>
</div>

<!-- Hidden start form  -->
			      <form  enctype="multipart/form-data" id="hidden-image-form" style="display:none" onSubmit="postMultipartForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/content',this,'',event)">
			      <div class="modal-body pat-body">
				       <div id="profileImgDiv1">
							<input type="file" name="patientProfileImage"  id="patientProfileImage" accept="image/jpg,image/png,image/jpeg,image/gif"  />
						</div>
			      </div>
			      <div class="modal-footer" style="margin-top:30px; padding:15px;">
			        <input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
					  <input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
					  <input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"/>
					   <input type="hidden" name="imageName" value="<?php echo $_COOKIE['imageLoginName'];?>"/>
					   <input type="hidden" name="contentType" value="avatar"/>
					   <input type="hidden" name="entityId" value="<?php echo $providerId ?>"/>
				        <input type="reset" class="btn btn-default" data-dismiss="modal" value="Close" />
			  			<input type="submit" class="btn btn-primary btnpatlist1" name="Save" value="Save" />
			      </div>
			       </form>
<!-- Hidden form end  -->


<!-- Confirm Delete Provider Modal --->
<div class="modal fade" id="providerDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Alert</h4>
      </div>
      <div class="modal-body"> Are you sure you want to delete it. </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" delete-id="0"  id="provider">Delete</button>
      </div>
    </div>
  </div>
  
</div>

<!--end wapper --> 

<script>
	window.location.hash = '/provider';
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
		buttonImage: "<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/date-range.svg",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		maxDate: new Date(),
		changeMonth:true,
		changeYear:true,
		yearRange: "-114:+0"
	});
	
	$('.dashboard_patient_status_img').click(function(){
			$('#patientProfileImage').click();
		});

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#patientProfileImage").change(function(){
		var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
		$("#lightbox").show();
		$("#fadediv").show();
		$("#cart_page").text("Image");
		$("#txt_div").text(" Please upload valid image.");

		}
		else{
        readURL(this);
        $('input[name="hasImage"]').val('true');
		}
    });
//add form start
	
	
	
});
	function postPatientForm(action, formId, resultingDivId, e) {
	     if (typeof e != undefined) {
	         e.preventDefault();
	     }

	     $.ajax({
	         url: action,
	         type: 'POST',
	         data: $('#' + formId).serialize(),
	         crossDomain: true,
	         beforeSend: function() {
	             showLoading()
	         },
	         success: function(result, textStatus, request) {
		         var headerVal = request.getResponseHeader('providerId');
				if(headerVal > 0)
				{
					$('input[name="entityId"]').val(headerVal);
					$('#hidden-image-form').submit();
					console.log('error:'+headerVal);
				}
				else
	             $("#" + resultingDivId).html(result);
	         },
	         error: function() {
	             console.log('error');
	         },
	         complete: function() {
	             hideLoading();
	         }
	     });
	 }

	 
	function postMultipartForm(action, ele, resultingDivId, e) {
	     if (typeof e != undefined) {
	         e.preventDefault();
	     }
		var formData = new FormData($(ele)[0]);
	     $.ajax({
	         url: action,
	         type: 'POST',
	         data: formData,//$('#' + formId).serialize(),
	         crossDomain: true,
			  async: false,
	            cache: false,
	            contentType: false,
	            processData: false,
			 beforeSend: function(){showLoading()},
	         success: function(result) {
	        openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_providerList.php','currentPage=1', 'menu-content', e, ele)
	         },
	         error: function( request, textStatus, errorThrown) {
	        	 //request.getResponseHeader('VMCErrorCode')
	            // console.log('jqXHR'+formData.elements['title'].value);
	         },
	         complete: function() {
				hideLoading();
			 }
	     });
	 }
$(".captial").focusout(function(){
 var arr = $(this).val().split(' ');
 var result = "";
 for (var x=0; x<arr.length; x++)
 result+=arr[x].substring(0,1).toUpperCase()+arr[x].substring(1)+' ';
 $(this).val(result.substring(0, result.length-1));
 }); 
/*
$(function() {
	
$('#cancel').click(function(e){
postFormAndHideAlert('../../provider/pages/portal_providerList.php','','menu-content',event,'myModal');
});
});  
*/


$("#addprovideform input,select,radio").on('change', function()
{
	if(!$("#addprovideform").hasClass("change"))
	{
		$("#addprovideform").addClass("change");
		$("#pageCancel").removeAttr("onClick");
	}
});


$("#pageCancel").click(function()
{
	if($("#addprovideform").hasClass("change"))
	{
		$('#myModal').modal();
		
	}
});
$("#cancel").click(function()
{
	$("#addprovideform")[0].reset();
	$("#addprovideform").removeClass("change");
	var cancelData=$("#pageCancel").attr('data');
	$("#pageCancel").attr("onClick",cancelData);

});
</script> 
<script>
if($("#okay").hasClass("localStorage"))
{
var first_name = localStorage["first_name"];
 $("#first_name").val(first_name);
var middle_name = localStorage["middle_name"];
 $("#middle_name").val(middle_name);
var last_name = localStorage["last_name"];
 $("#last_name").val(last_name);
var dob = localStorage["dob"];
 $("#dob").val(dob);
var email = localStorage["email"];
 $("#email").val(email);
var providerPhone = localStorage["providerPhone"];
 $("#providerPhone").val(providerPhone);
var username = localStorage["username"];
 $("#username").val(username);
var password = localStorage["password"];
 $("#password").val(password);
 $("#retypepassword").val(password);

var credentials = localStorage["credentials"];
 $("#credentials").val(credentials);
 
var gander = localStorage["gander"];
 $("#gander").val(gander);

var speciality = localStorage["speciality"];
 $("#speciality").val(speciality);

var providertype = localStorage["providertype"];
 $("#providertype").val(providertype);
 
var assignrole = localStorage["assignrole"];
 $("#assignrole").val(assignrole);
 
 var page = localStorage["page"];
  $("#page").attr('name',page);
  
  var providerId = localStorage["providerId"];
  $("#providerId").val(providerId);

}


function showPopLogout() {
   $(".cart_page").html("Message");
   $(".txt_div").html("Your credential has been changed successfully. ");
   $(".aboutHref").attr("href","../../login/pages/logout.php");
   $("#aboutPopup").show();
   $("#About_fadediv").show();
   $("#About_fadediv").attr("onclick","../../login/pages/logout.php");

   
}
</script>

