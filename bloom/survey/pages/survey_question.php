<?php 
include('controller/survey_question_controller.php');
	$contextPId = $_REQUEST['contextPId'];
	$surveyHeaderId=$_REQUEST['surveyHeaderId'];
	//$surveyConfigHeaderId=$_REQUEST['surveyConfigHeaderId'];
	//var_dump($survey);
?>
<style>
.Survey_QueHeading li {
    display: inline;
    list-style: outside none none;
    margin: 0 5px;
}
.Survey_QueHeading > ul {
    padding: 50px 0;
    text-align: center;
}
.Survey_QueHeading h2 {
    font-family: arial;
    font-size: 24px;
    font-weight: normal;
    padding: 45px 80px 0;
    text-align: center;
}
.Survey_QueHeading h1 {
    background: none repeat scroll 0 0 #778898;
    border-bottom: 3px solid #777777;
    border-radius: 5px;
    font-size: 27px;
    margin: 15px 15px 0;
    padding: 8px 0;
    text-align: center;
	color: #fff;
}
.que {
    float: left;
    margin: 45px 0;
    text-align: center;
    width: 100%;
}
.Survey_QueHeading li a{ color:#fff;}
.Survey_QueHeading li {
    background: none repeat scroll 0 0 #04aefc;
    border-bottom: 7px solid #0492d4;
    border-radius: 5px;
    color: #fff;
    display: inline;
    font-size: 20px;
    list-style: outside none none;
    margin: 0 5px;
    padding: 11px 22px;
}

.Survey_QueHeading li:hover, .Survey_QueHeading li.active {
    background: none repeat scroll 0 0 #ff8900;
    border-bottom: 7px solid #c85c03;
}
.nextButton{
	background: none repeat scroll 0 0 #1adb82 !important;
    border-bottom: 4px solid #18ab67 !important;
    border-radius: 5px !important;
    color: #fff !important;
    display: inline !important;
    font-size: 20px !important;
    margin: 0 5px !important;
    padding: 7px 33px !important;
}
.cancelButton{
	background: none repeat scroll 0 0 #04aefc !important;
    border-bottom: 4px solid #0492d4 !important;
    border-radius: 5px !important;
    color: #fff !important;
    display: inline !important;
    font-size: 20px !important;
    margin: 0 5px !important;
    padding: 7px 19px !important;
}
.Finish {
  padding: 0px 0 !important;
  width: 117px !important;
  height: 41px !important;
}
</style>


<div class="Survey_Que">
<div class="row">
<form id="questionForm" method="post" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/survey/pages/survey_question.php','questionForm','menu-content',event)">

<div class="col-md-12 Survey_QueHeading">

<?php 
$end="";
foreach($survey as $surveyHeader)
{

	if($surveyHeader->{surveyHeaderId} == $surveyHeaderId)
	{
		?>
		<h1><?php echo $surveyHeader->{surveyDescription};?></h1>
		<?php		
		$surveyDetailsArray = $surveyHeader->{surveyDetailsInfo};
		$count=0;
		$end = count($surveyDetailsArray);
		foreach($surveyDetailsArray as $surveyDetail)
	    {
     		$surveyConfigDetailInfo = $surveyDetail->{surveyConfigDetailInfo};
			if($count==0)
			{
				$mainDiv= "<div  style='display:block;' class='main  mainDivClass_".$count."'>";
				$preButtion="";
			}
			else
			{
				$mainDiv = "<div  style='display:none;' class='main mainDivClass_".$count."'>";
				$preButtion="<input type='button' value='Previous'  class='cancelButton' data='".$count."'>";
			}
				echo $mainDiv;
				
			?>
           
				<h2><?php echo $surveyConfigDetailInfo->{surveyQuestion};?></h2>
                  <?php				 
				 if(strtoupper($surveyConfigDetailInfo->{answerType}) == constantAppResource::$ANSWER_TYPE_RANGE)
				 {
				 ?>
				<ul class="que currentUl_<?php echo $count;?>" data="<?php echo $count;?>">
              
				<li><a href="#"><?php echo constantAppResource::$RESPONSE1; ?></a></li>
				<li><a href="#"><?php echo constantAppResource::$RESPONSE2; ?></a></li>
				<li><a href="#"><?php echo constantAppResource::$RESPONSE3; ?></a></li>
				<li><a href="#"><?php echo constantAppResource::$RESPONSE4; ?></a></li>
				<li><a href="#"><?php echo constantAppResource::$RESPONSE5; ?></a></li>
                </ul>
				<p class="col-md-6">( <?php echo $surveyConfigDetailInfo->{answerTypeLowerRange}; ?> )</p>
				<p class="col-md-6"  style="text-align: right;">( <?php echo $surveyConfigDetailInfo->{answerTypeHigherRange}; ?> )</p>
                <?php 
				 }
				 else
				 {
				 ?>
                 <ul class="que currentUl_<?php echo $count;?>" data="<?php echo $count;?>">
                 <li><a href="#"><?php echo constantAppResource::$RESPONSE_YES; ?></a></li>
				 <li><a href="#"><?php echo constantAppResource::$RESPONSE_NO; ?></a></li>
                 </ul>
				 <?php
				 }
				 ?>
                 
				
				<div class="button-content" style="float: right; padding-top: 180px; margin-right:8px;">
				<?php echo $preButtion;?>
                <input type="hidden" name="question<?php echo $count;?>" data="<?php echo $count;?>" value="" />
				<input type="button" value="Next" class="nextButton" data="<?php echo $count;?>" />
				</div></div>
				<?php
				$count++;
			}
		}
}
?>

<div  style="display:none;" class="main  mainDivClass_<?php echo $end;?>">
<h2><?php echo constantAppResource::$ADDITIONAL_COMMENTS ;?></h2>
<textarea class="form-control" placeholder="Comment" id="textarea" rows="6" name="comment" style="width: 95%; border-radius: 5px; margin: 27px 15px 10px;"></textarea>
<input type="hidden" name="finish" />
<input type="hidden" value="<?php echo $surveyHeaderId; ?>" name="surveyHeaderId"/>
<div class="button-content" style="text-align: right; padding-top: 75px; margin-right:8px;">
<input type="button" value="Previous"  class="cancelButton" data="<?php echo $count;?>" />
<input type="submit" value="Finish" class="nextButton Finish" id="finish" name="finish">
</div>
</form>
</div>


</div>
</div>

<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/moment.js"></script>

<script>

$(document).ready(function()
{
$("span.learnTime" ).each(function( index ) {
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

<script>
$(function(){
	$('#selectedPatient').find('img').attr('src',$('#contextPatientImage').val());
	$('#selectedPatient').next().html($('#contextPatientName').val());
	
	$(".nextButton").click(function()
	{
		var getId=$(this).attr("data");
		getId=parseInt(getId)+1;
		$(".main").hide();
		$(".mainDivClass_"+getId).show();
	});
	
	$(".cancelButton").click(function()
	{
		var getId=$(this).attr("data");
		getId=parseInt(getId)-1;
		$(".main").hide();
		$(".mainDivClass_"+getId).show();
	});
	
	$("ul.que li").click(function()
	{	var currentUl = $(this).parent('ul').attr('data');
		if($('.currentUl_'+currentUl+' li').hasClass("active"))
		{
			$('.currentUl_'+currentUl+' li').removeClass("active");
			var valueOfcart = $(this).children('a').text();
			$(this).addClass("active");
			$("#questionForm input[name='question"+currentUl+"']").val(valueOfcart);
		}
		else
		{
			var valueOfcart = $(this).children('a').text();
			$(this).addClass("active");
			$("#questionForm input[name='question"+currentUl+"']").val(valueOfcart);

			
		}
	});
	
	
	
});
</script>