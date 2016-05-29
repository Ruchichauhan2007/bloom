<?php 
$contextPId = $_REQUEST['contextPId'];
include('controller/survey_controller.php');
?>
<style>
.Survey_Card {
    background: none repeat scroll 0 0 #fff;
    margin: 10px;
    padding: 8px 7px;
	border-radius: 5px;
}
.surveyImg h1 {
    font-size: 24px;
}
.surveyImg p {
    padding-top: 34px;
    text-align: right;
	color:#939393;
}
</style>
<script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/js/moment.js"></script>
<script>

$(document).ready(function()
{
$("p.date" ).each(function( index ) {
	var utcTime=$( this ).text();
    var divLocal = $('#divLocal');  
    //put UTC time into divUTC  
    $(this).text(moment.utc().format('YYYY-MM-DD HH:mm:ss'));      
    //get text from divUTC and conver to local timezone  
    var localTime  = moment.utc(utcTime).toDate();
    localTime = moment(localTime).format('MMMDD hh:mm A');
    $(this).text(localTime);    
});
});
</script>
<?php
echo createSurveyCard($survey);
?>
