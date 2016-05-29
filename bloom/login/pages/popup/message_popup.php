  <?php
	include '../../common/util/VMCErrorMessage.php'; 
	if($information)
	{
		$VMCMessage=new  VMCErrorMessage();
		
 ?>   
	<div id="light" class="white_content" style="display:block;" ><p class="cart"><?php echo $page_error; ?> <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';"><img src="../images/close.jpg" align="right" class="close"></a></p>
	<div class="alert"><img src="../images/alert.jpg" align="left">   <div id="txt"><?php echo $information;?></div>
    <br>
	<?php
	 if($page=="loginUserName")
		{
	 ?>
    <a href = "login_userName.php" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a>
	<?php
		}
	 else if($page=="loginPassword")
		{?>
     <a href = "login_userName.php" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a>

	<?php	}

	?>
	</div>
	</div>
	<div id="fade" class="black_overlay"  onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"></div>
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
width: 450px !important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002!important;
overflow: auto!important;
height:250px;
}
</style>