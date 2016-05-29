<?php
 include('controller/config_controller.php');
?>

<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/configuration.css">
<div class="col-md-8 padd-top20">
<div class="config">
  <h1>Control Configuration</h1>
</div>
<div class="GlucoseAcceptable">
<form id="add-form" action="" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/dropdownConfiguration.php','add-form','menu-content',event)" method="post">
   <!-- <button>Add new category</button>-->
       <label for="primaryProvider" class="col-lg-6 " style="font-size:16px;padding-top: 15px;">Configure new category : </label>
        <span class="col-lg-6" style="font-size:16px;padding-top: 15px;">
        <input type="text" name="fieldName" id="fieldName" class="form-control"/>
        </span> 
      <div class="btngrp" align="right">
        <input type="reset" class="resetButton" value="Cancel" />
        <input type="hidden"  value="Save" name="submitForm"/>
          <input type="submit" value="Save" name="submitForm"/>
      </div>
  
  </form>
</div>
<div  style="clear:both"></div>
<div class="config">
  <h2> Existing Categories </h2>
</div>
<div class="config">
  <a onClick="openPageWithAjax('../../provider/pages/fieldOptions.php','fieldNameId=1','menu-content',event,this)">Gender</a>
 </div>
</div>