<?php
$name = $_POST["memberName"];
$phoneNumber = $_POST["mobileNumber"];
$patientFamilyId = $_POST["patientFamilyId"];
$patientId = $_POST["patientId"];
 ?>
 <div id="<?php echo $patientFamilyId; ?>">
 <h1>Remove <?php echo $name; ?> ?</h1>
 <p><?php echo $phoneNumber; ?> will no longer receive text notifications for out of range readings.</p>
  <input type="hidden" name="patientFamilyId" id="patientFamilyId" value="<?php echo $patientFamilyId; ?>" />
        <input type="hidden" name="mobileNumber" value="<?php echo $phoneNumber; ?>" />
        <input type="hidden" name="memberName" value="<?php echo $name; ?>" />
        <input type="hidden" name="patientId" id="patientId" value="<?php echo $patientId; ?>" />
 </div>
	
	