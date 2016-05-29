  <?php
	include '../../common/util/VMCErrorMessage.php'; 
	if($msg)
	{
		$VMCMessage=new  VMCErrorMessage();
		
 ?>   
 <script>
	$("#errorMsg").text('<?php echo $msg; ?>');
	$("#errorMsgDivd").show();
 </script>
 <?php
 }
 elseif($information)
 {
		$VMCMessage=new  VMCErrorMessage();
 ?>   
 <script>
	$("#errorMsg").text('<?php echo $information; ?>');
	$("#errorMsgDivd").show();
	$("#errorMsgDivd img").hide();
 </script>
 <?php
 }
 ?>  

<style>
.black_overlay {
position: absolute !important;
top: 0%!important;
left: 0%!important;
width: 100%!important;
background-color:#e8e8e8!important;
opacity: 0.5;
height:100%;
z-index: 1001!important;
}
.white_content {
position: absolute !important;
top: 37%!important;
left: 25%!important;
width: 35%!important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002!important;
overflow: auto!important;
}
</style>