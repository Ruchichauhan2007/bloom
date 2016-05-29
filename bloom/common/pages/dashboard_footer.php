
</div>
</div>
<script>
$(document).ready(function() {
var d = new Date();
var n = d.getFullYear();
document.getElementById("copyRight").innerHTML ='<?php echo constantAppResource::$LOGIN_FOOTER_TEXT_COPYRIGHT;?> '+n;
});
</script>

<footer style="height: 0px; display: none;">
	<div class="container" style="padding-right: 5px; background: none repeat scroll 0 0 #04aefc; padding-bottom: 7px;" >
	<ul>
		<li class="footerlink_left"><a href="#"></a></li>
		<li class="footerlink_right"><a href="#" id="copyRight"></a></li>
	</ul>
	</div>
</footer>
<!--end header -->

<div class="ajax-loading" style="position:absolute;display:none">
	<img style="height:65px" src="/gladstone/portal/bloom/common/images/ajax_loader.gif"/>
</div>


</body>
</html>