<?php 
$contextPId = $_REQUEST['contextPId'];
include('controller/allSurveys_controller.php');
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
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/survey/script/css/Survey.css">
<div class="col-md-12 survey-history">
<h1>All Survey</h1>


<div class="col-md-8 surveyTitle">
<h2>Title</h2>
</div>
<div class="col-md-4 modified">
<h2>Modified</h2>
</div>

<!--<div class="surveyCard active">
<div class="col-md-8 CreateDate">
<h3>The standard Lorem Ipsum passage</h3>
<p>Created : 10 July, 2015</p>
</div>
<div class="col-md-4 modifiedDate">
<p>13 July, 2015</p>
</div>
</div>-->
<?php echo showAllSurveys($survey); ?>

</div>

