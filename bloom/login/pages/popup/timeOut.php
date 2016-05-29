<script type="text/javascript">
	var timeoutID = "" ;
	var counter = 0;
	var idleTime = 0;
$(document).ready(function() {
	  $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
	
	delayedAlert();
 });
	function timerIncrement() {
    idleTime = idleTime + 1;
	if(idleTime > 6 )
	{
	//jQuery.noConflict();
	}

    if (idleTime > 5) { // 20 minutes
        slowAlert();
    }
}
	function delayedAlert() {
      	
	  var idleInterval = setInterval(timerIncrement, 180000);
	  
	 
	}

	function slowAlert() {
		if(counter == 0)
		{	
		  $('#timeout').modal();
		  counter++;
		  
		  setTimeout(redirect, (10000));
		}
	}
	function redirect() {
		if(counter != 0)
		{
		  window.location = '../../login/pages/logout.php';
		}
	  
	}  
	

	function clearAlert() {
	  window.clearTimeout(idleInterval);
	  counter = 0;	  
	  idleTime = 0;
	   var idleInterval = setInterval(timerIncrement, 180000);
	}

	$(function(){
	 $("#yes").click(function(e){
		window.location = '../../login/pages/logout.php';
	  });
	});
	$(function(){
	 $("#no").click(function(e){
		clearAlert();
	  });
	});
</script>

<div class="modal" id="timeout">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>-->
        <h4 class="modal-title">Warning</h4>
      </div>
      <div class="modal-body">
        <p>Session time out</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default noExit" data-dismiss="modal" id="no">No</button>
        <button type="button" class="btn btn-primary noEntry" id="yes">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</script>
  
	<div id="aboutPopup" class="white_content aboutPopup" style="height:auto;" ><p class="cart" style="padding:0px;"><b><span  id="cart_page" class="cart_page">About</span></b><a href = "javascript:void(0)" class="aboutHref" onclick ="document.getElementById('aboutPopup').style.display='none';document.getElementById('About_fadediv').style.display='none';"><img src="../images/close.jpg" align="right" class="close"></a></p> 
	<div class="alert"><img src="../images/alert.jpg" align="left">   <div id="txt_div" class="txt_div">Version :<?php echo  getVersion();?></div>
    <br>
    <a href = "javascript:void(0)" class="aboutHref" id="okay" onclick = "document.getElementById('aboutPopup').style.display='none';document.getElementById('About_fadediv').style.display='none'"><?php echo constantAppResource::$COMMON_BUTTON_OKEY;?></a></div>
	</div>
	<div id="About_fadediv" class="black_overlay"  onclick = "document.getElementById('aboutPopup').style.display='none';document.getElementById('About_fadediv').style.display='none'"></div>
 

<style>
.cart span#cart_page {
    float: left;
    padding: 9px 10px;
}
.marginAbout{
margin:0px 0px 0px 106px;
}
.black_overlay {
position: absolute !important;
top: 0%!important;
left: 0%!important;
width: 100%!important;
background-color:#e8e8e8!important;
opacity: 0.5;
height:100%;
z-index: 1001!important;
display:none;
}
.white_content {
position: absolute !important;
top: 30% !important;
left: 35% !important;
width: 410px !important;
background-color:#e8e8e8!important;
box-shadow: 0px 2px 6px #999!important;
z-index: 1002!important;
overflow: auto!important;

}
.cart {
    background: linear-gradient(to bottom, #F7F7F7 0%, #F5F5F7 6%, #E4E3E8 32%, #E4E3E9 35%, #BAB9C7 100%) repeat scroll 0px 0px transparent;
    height: 40px;
    margin: 0px;
}
.alert {
    line-height: 30px;
    font-size: 18px;
    color: #000;
}
.alert a {
    background-color: #9C0;
    text-decoration: none;
    color: #FFF;
    padding: 5px 25px;
    float: right;
    margin-bottom: 20px;
    box-shadow: 0px 2px 6px #999;
}
@media (max-width:767px) {
.white_content.lightClassBox{
    left: 20px !important;
    top: 72px !important;
    width: 280px !important;
}
}
</style>
<style>

.modal-header
{
padding: 2px 0 0 10px;
background: linear-gradient(to bottom, #f7f7f9 0%,#f6f6f8 6%,#e4e3e8 31%,#e2e1e7 37%,#d9dadf 49%,#ceceda 66%,#cbcbd5 69%,#c7c7d3 77%,#c2c1cf 83%,#b9b8c6 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f7f7f9', endColorstr='#b9b8c6',GradientType=0 );
height: 37px;
}
.modal-content
{
	background-color:#e8e8e8;
}
.close {

opacity: inherit;
}

.modal-body
{
	font-size:20px;
	padding-top:25px;
}
.modal-footer
{
	margin-top:30px;
}
.noExit {
    background-color: #04aefc;
    border-bottom: 5px solid #0492d4;
    border-radius: 5px;
    color: #fff;
    height: 44px;
    margin-right: 5px;
    width: 100px;
	font-size: 22px;
}
.noEntry {
    background-color: #1adb82;
    border-color: -moz-use-text-color -moz-use-text-color #18ab67;
    border-radius: 5px;
    border-style: none none solid;
    border-width: medium medium 5px;
    color: #fff;
    cursor: pointer;
    font-size: 22px;
    height: 44px;
    padding: 3px;
    text-align: center;
    width: 100px;
}
.aboutPopup
{
display:none;

}
</style>