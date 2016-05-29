<?php
include('controller/alert_controller.php');
//var_dump($providerList);

?>
<div class="col-md-8 padd-top20">
<h1 class="heading-alert">On-call Alerts</h1>
<form method="post"  id="add-form" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/onCallAlert.php','add-form','menu-content',event)">
<label for="primaryProvider" class="col-sm-6 oncall_alert" style="font-size: 16px;padding-top: 8px;">Send <strong>On-call Alerts</strong> for all patients to:</label>
       <span class="col-sm-6">
          <select id="OnCallProviderId" name="OnCallProviderId" class="form-control">
            <option  selected="selected" value="0">None</option>
            <?php
				foreach($providerList as $prov)
				{
				if($prov->{deleted} == 0)
				{
					if($getDefaultInfo->defaultValue == $prov->{entityId})
					{
		  ?>
            <option selected = "selected" value="<?php	echo $prov->{entityId}; ?>">
            <?php	echo   $prov->{lastName}." ".$prov->{firstName}.", ".$prov->{credentials};?>
            </option>
            <?php
			}else{
			?>
            <option value="<?php	echo $prov->{entityId}; ?>">
            <?php	echo $prov->{lastName}."  ".$prov->{firstName}.", ".$prov->{credentials};?>
            </option>
            <?php
					}
				}	

				}
				  ?>
          </select>
        </span>

<div class="btngrp" align="right">
<button class="btn btn-green" type="submit" name="update">Save</button>
</div>
<input type="hidden" name="update" />
<input type="hidden" name="defaultId" value="<?php echo $getDefaultInfo->defaultId ; ?>" />
<input type="hidden" name="updateCounter" value="<?php echo $getDefaultInfo->updateCounter ; ?>" />
</form>
<div id="success_msg"></div>
</div>
<style>
h1.heading-alert {
    font-size: 25px;
    padding: 5px 13px 20px;
}
.btngrp {
    float: left;
    width: 100%;
    padding: 10px 15px;
}
.btngrp button.btn.btn-green {
    border: none;
    background-color: #1AC778;
}
.oncall_alert{
	font-weight:normal;
}
.oncall_alert strong{
	font-weight:bold;
}
</style>