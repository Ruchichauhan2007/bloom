<?php include 'controller/portal_dashboard_controller.php'; ?>
<div id="scriptData">
<script>
$(document).ready(function() {
//changeCards('');
	$("h5.time_date").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM D h:mm A');
	$(element).html(localTime);
	$(element).removeClass("time_date");
});
});
var taHTML = $('#menu-content').html();
var showScroll = $("#getScroll").val();
var counter = 0;
$('#menu-content').bind('scroll', function(e)
{
		var action = $("a.nextPage").attr("action");
		var params = $("a.nextPage").attr("params");
		var resultingDivId = $("a.nextPage").attr("resultingDivId");
if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)
{
		if(showScroll)
		 {
		 		if(counter == 0)
				{	
				openPagewithScroll(action,params,resultingDivId,e,"a.nextPage");
				}
				counter++;
				
		 }		
}
});

$(document).ready(function ()
{
setTimeout(function(){ 
var windowHeight= $(window).height();
var cardLength =  $("#menu-content .patientreview_ALL").find('.dashboardCards').length;
	if(windowHeight>700 && cardLength == 5)
	{
			var action = $("a.nextPage").attr("action");
			var params = $("a.nextPage").attr("params");
			var resultingDivId = $("a.nextPage").attr("resultingDivId");
			openPagewithScroll(action,params,resultingDivId,'',"a.nextPage");
		//	alert(menuHeight);
	
	}
	}, 100);
});

        </script>
</div>
			<div class="scrollbar1 scroll-outer">
        <div class="content scroll-inner" id="outerDashcard">
				<div id="patientreview_ALL" class="patientreview_ALL">

<?php
if(isset($_GET['selectedPatientTrue'] == true))
{?><script>
$(document).ready(function()
{
		var contextPrientId=$("#contextPatientId").val();
		if(contextPrientId)
		{		
		$("#review_new").click(function(e){
				$("#patientreviewedcard_ALL").hide();
				$(".patientreviewedcard_ALL").hide();
				$("#patientreview_ALL").show();
				$("#review_new").addClass("active")
				$("#reviewedList").removeClass("active");
				//changeCards(e);
				//alert(1);
		});
		}
});
</script>
<?php
echo addDashboardCards($dashboardCards,0);

}
else
{
?>
<script>

 /* function checkCards(ele,cardType)
  {
	var params = 'cardType='+cardType+'&currentPage=1';
	var purl = '../../login/pages/portal_dashCard.php';
	openPageWithAjax(purl,params,'ack-dashboard', e);
  }*/

</script>
<?php
echo addDashboardCards($dashboardCards,$_COOKIE['type']);
}
?>
</div></div></div>