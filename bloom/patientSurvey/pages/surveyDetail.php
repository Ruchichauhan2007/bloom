<script type="text/javascript">

if(typeof jQuery == 'undefined'){
        document.write('<script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/script/js/query.min_1.7.1.js"></'+'script>');
  }

</script>
<script>
$(function(){
 if ($("#menu-content").attr('class') =='col-md-12')
	$("#menu-content").attr('class','col-md-9');

$('#portal-menu').hide("0",function(){
		 if ($('#portal-menu').is(':hidden'))
		{
			$("#menu-content").attr('class','col-md-12');
		}
	});
});

</script>
<?php
$instruction = "";
$quesNo = "";
$surveyId = $_POST['surveyId'];
$pageId =   $_POST['pageId'];
$patientId =   $_POST['patientId'];
$surveyStatus =   $_POST['surveyStatus'];
$uniqueSurveyId =   $_POST['uniqueSurveyId'];
$quesNumber = 0;
$surveyName1 = str_replace("_", '&rsquo;',$_POST["surveyName"]);
 include('controller/surveyDetail_controller.php');
 $userTYPE = $_COOKIE['type'];
$metaDataInfo = $surveyPage->{metaInfo};
$accessList = $metaDataInfo->{accessList}; 
foreach($accessList as $access)
{
	if(strtoupper($access->{roleName}) == strtoupper($userTYPE))
	{
		$accessLevel = $access->{accessLevel};
	}
}
//echo $accessLevel;
 $count = count($surveyPage->{questions});

 $countDescriptive = 0;
 $countNone = 0;
 $arrayCount = 0;
 $countActionTaken = 0;
 $cntActionAns = 0;
 $surveyQuestions = $surveyPage->{questions};
 $quesRespArray = array();
 $showIfRespArray = array();
 $mandatoryQuesCnt = 0;
 foreach($surveyQuestions as $surveyQuestion)
 {
 	 $surveyQuesId = $surveyQuestion->{question_id};
     $surveyResp = $surveyQuestion->{responses};
	 $countAgain = 0;
	 $tempStore = array();
		foreach($surveyResp as $surveyRe)
		{
			$tempStore[$countAgain] = $surveyQuesId."_".$surveyRe->{answer_id};
			$countAgain++;
		}
	//$quesRespArray[$arrayCount] = $surveyQuesId."_".$surveyResp[0]->{answer_id};
	$quesRespArray = array_merge($quesRespArray,$tempStore);
	
	if($surveyQuestion->{type}->{subtype} == "descriptive_text")
	{
		$countDescriptive ++;
		$instruction = "instruction-lines";
	}
	if($surveyQuestion->{heading} == "Describe the situation" || $surveyQuestion->{heading} == "Action taken" && strtoupper($questionAccess) != "NONE")
	{
		$countActionTaken++;
		if($surveyQuestion->{responses})
		{
			$cntActionAns++;
		}
	}
	else if(strtoupper($questionAccess) == "NONE" &&($surveyQuestion->{heading} == "Describe the situation" || $surveyQuestion->{heading} == "Action taken"))
	  {
	  	$countNone++;
	  }
	  $arrayCount++;
	  $questionAccess = "";
	  $questionMeta = $surveyQuestion->{metaInfo};
	   $explodeIntoArray = explode(",",$questionMeta->{showIfResponse});
	  	$showIfRespArray = array_merge($showIfRespArray,$explodeIntoArray);

	  $questionAccess = $questionMeta->{accessList};
	   $mandatoryQues = $questionMeta->{mandatory}; 
	   if($mandatoryQues)
	   {
	   		$mandatoryQuesCnt++;
	   }
	  foreach($questionAccess as $questionlevel)
	  {
			if(strtoupper($questionlevel->{roleName}) == strtoupper($userTYPE))
			{
				$questionAccess = $questionlevel->{accessLevel};
			}
	  }
	  
 }
$count = $count - $countDescriptive;
$count = $count - $countNone;
$count = $count - $countActionTaken;
$mandatoryQuesCnt;

?>
    <script>
    var showIfArray = new Array();
	var i = 0;
    </script>
    <?php
	$i= 0;
	
for($i;$i<count($showIfRespArray); $i++)
{
if($showIfRespArray[$i] != "")
{
//echo $showIfRespArray;
	?>
    <script>
     showIfArray[i] = "<?php echo $showIfRespArray[$i] ;?>";
	i++;
    </script>
    <?php
}
}

?>
<link rel="stylesheet" type="text/css" media="screen" href="/gladstone/portal/bloom/vitals/scripts/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientSurvey/script/css/Survey.css">

<script type="text/javascript" src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
<script>
console.log(showIfArray);
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}
function getAllShowIf(html)
{
	if(showIfArray.contains(html))
	{	
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<div class="col-md-8 padd-top20">
<div class="col-lg-12 assessments">
    <div class="row">
      <div class="col-md-6">
        <?php if($surveyStatus == "Reviewed" || strtoupper($accessLevel) == "READ_ONLY")
		{
		?>
        	<h3><a class="completed" href="#" onClick="openPageWithAjax('../../patientSurvey/pages/survey.php','surveyId=<?php echo $surveyId; ?>&pageId=<?php echo $pageId; ?>&patientId=<?php echo $patientId; ?>&uniqueSurveyId=<?php echo $uniqueSurveyId; ?>','menu-content',event,this)"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><?php echo $surveyName1;?></a></h3>
        <?php 
		}
		else
		{
		?>
         	<h3><a class="inComplete" id="inComplete"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><?php echo $surveyName1;?></a></h3>	
        <?php
		}
		?>
      </div>
      <div class="col-md-6">
        <h4>Questions:<?php echo $count; ?></h4>
      </div>
    </div>
   
  </div>
  <div class="col-lg-12 questionSurveyHeading ">
  <h4><?php echo $surveyPage->{heading};?></h4>
  </div>
  <form method="post" id="detail-form" >
     <input type="hidden" value="<?php echo $surveyId; ?>" name="surveyId"/>
     <input type="hidden" value="<?php echo $pageId ; ?>" name="pageId" />
     <input type="hidden" value="<?php echo $patientId ; ?>" name="patientId" />  
     <input type="hidden" value="<?php echo $uniqueSurveyId ; ?>" name="uniqueSurveyId" /> 
     <input type="hidden" value="<?php echo $_POST["surveyName"] ; ?>" name="surveyName" /> 
	<?php
	  $answerNumber = 0;
	  $countResp = 0;
	 
	  foreach($surveyQuestions as $surveyQuestion)
      {
		$showIfResp = "";
		$showQues = "";
		$showAns = "";
		$confirm = "";
		$confirmation = "";
	  $confirmationInfo = new stdClass;
	  $questionAccessLevel = "";
	  $questionShowIfResp = "";
	  $mandatory = "";
	  $questionMetaInfo = $surveyQuestion->{metaInfo};
	  $isMandatory = $questionMetaInfo->{mandatory};
	  if($isMandatory)
	  {
	  	$mandatory = "mandatory";
	  }
	  else
	  {
	  	$mandatory = "";
	  }
	  $confirmationInfo = $surveyQuestion->{confirmationInfo};
	  
	  $confirmation = $confirmationInfo->{response};
	  if($confirmation != "")
	  {
		  if(($confirmation == "Incorrect" || $confirmation == "Not Sure") && (strtoupper($userTYPE) == "PROVIDER"))
		  {
			$confirm = "style='color:red;'";
		  }
		  else
		  {
			$confirm = "";
		  }
	  }
	  else
	  {
	  	$confirm = "";
	  }
	  
	 // $questionShowIfResp = explode(" ",$questionMetaInfo->{showIfResponse});

	  $questionAccessList = $questionMetaInfo->{accessList}; 
	  foreach($questionAccessList as $questionAccess)
	  {
			if(strtoupper($questionAccess->{roleName}) == strtoupper($userTYPE))
			{
				$questionAccessLevel = $questionAccess->{accessLevel};
			}
	  }
	  $surveyQuestionId = $surveyQuestion->{question_id};
      $surveyresponses = $surveyQuestion->{responses};
	  
	  	if($surveyQuestion->{type}->{subtype} != "descriptive_text" && strtoupper($questionAccessLevel) != "NONE")
		{
			$quesNumber ++;
			//$quesNo = "<span >".$quesNumber.". </span>";
			$quesNo = "";
			
		}
		else
		{
			
			$quesNo = "<span style='display:none;'>".$surveyQuestion->{questionNumber}."</span>";
		}
		
	  //var_dump($surveyresponses);
	  $qusActive = ""; 
	  if($surveyresponses)
	  {
	  	$answerNumber ++;
		$qusActive = "qusActive"; 
	  }
	  
		$showIfDiplay = ""; 
		$displayTrue = false;
		 if($questionMetaInfo->{showIfResponse} != NULL || $questionMetaInfo->{showIfResponse} != "")
		 {	
		 	
			$questionShowIfResp = explode(",",$questionMetaInfo->{showIfResponse});
			if(count($questionShowIfResp) > 1)
			{
				foreach($questionShowIfResp as $questionShow)
				{
					$explodeShowIf = explode("_",$questionShow);
					for($i = 0;$i< count($quesRespArray);$i++)
					{
						$countArrayEle = 0;
						$explodeData = explode("_",$quesRespArray[$i]);
						if(count($explodeData) == 3)
						{
							$countArrayEle = 2;
						}
						else
						{
							$countArrayEle = 1;
						}
						$surveyQuesId = $explodeData[0];
						$surveyresp = $explodeData[$countArrayEle];
						
						if($surveyQuesId == $explodeShowIf[0] && $surveyresp == $explodeShowIf[1])
						{				
							
							$displayTrue = true;
							
						}			
						
					}
				if($displayTrue){$showIfDiplay= "" ;}else {$showIfDiplay= "HideQuestion";}
					
				}
			}
			else
			{
				$explodeShowIf = explode("_",$questionShowIfResp[0]);
				
				for($i = 0;$i< count($quesRespArray);$i++)
				{
					$countArrayEle = 0;
					$explodeData = explode("_",$quesRespArray[$i]);
					
					if(count($explodeData) == 3)
					{
						$countArrayEle = 2;
					}
					else
					{
					 
						$countArrayEle = 1;
					}
					
					$surveyQuesId = $explodeData[0];
					$surveyresp = $explodeData[$countArrayEle];
					
					if($surveyQuesId == $explodeShowIf[0] && $surveyresp == $explodeShowIf[1])
					{				
						
						$displayTrue = true;
						
					}			
					
				}
				if($displayTrue){$showIfDiplay= "" ;}else {$showIfDiplay= "HideQuestion";}
			}
			
		}
		$questionShowIfResp = explode(",",$questionMetaInfo->{showIfResponse});
		
		if(count($questionShowIfResp)>1)
		{
			
			$explodeShowIf = explode("_",$questionShowIfResp[0]);
			$showIfResp = $questionShowIfResp[0];
			$showQues = $explodeShowIf[0];
			$showAns = $explodeShowIf[1];
		}
		else
		{
			$explodeShowIf = explode("_",$questionShowIfResp[0]);
			$showIfResp = $questionShowIfResp[0];
			$showQues = $explodeShowIf[0];
			$showAns = $explodeShowIf[1];
		}
    ?>
    
       <div class="col-lg-12 questionSurvey <?php echo $qusActive." ".$instruction." ".$showIfDiplay." ".$mandatory;?>" showIfResp="<?php echo $showIfResp; ?>" showQues="<?php echo $showQues; ?>" showAns="<?php echo $showAns; ?>"> 
      <span><?php echo $questionAccessLevel;?></span>
       <?php
			if(strtoupper($questionAccessLevel) != "NONE")
			{
				if(($surveyQuestion->{type}->{family} == "presentation") && ($_POST["surveyName"] == "Kannact_s Multivector Assessment"))
				{  
				?> 
					<h1 style="display:none;"></h1>
				<?php
				}
				else
				{
				?>
					<h1 <?php echo $confirm; ?> ><?php echo $quesNo; ?><?php echo $surveyQuestion->{heading}; ?></h1>
		
				<?php
				}
				?>
				<?php echo surveyAnswer($surveyQuestion,$surveyQuestionId, $surveyresponses,$confirmationInfo);
			}
			if($surveyQuestion->{confirmationInfo} != "" && strtoupper($userTYPE) == "PATIENT" && strtoupper($_POST["surveyName"]) == "ANNUAL WELLNESS VISIT")
			{
				
				echo "<div class='question8 confirmationDiv'>".confirmationBox($surveyQuestionId,$confirmation)."</div>";
				
			}
		?>
      </div>
     <?php 
	
	
     }
     ?>
      <div class="col-lg-12 questionSurvey">
       
       
        <div class="row">
        <div class="col-md-8 answered">
		<?php $answerNumber = $answerNumber - $cntActionAns; ?>
        <p>You answered <strong id="answerNumber"><?php echo $answerNumber;?></strong> of <span  id="questionNumber"><?php echo $count; ?></span> questions.</p>
        </div>
        <div class="col-md-4 Confirm" align="right">
        <?php if($surveyStatus == "Reviewed")
			{
			?>
            	<button class="btn btn-default btn-lg btn-confirm" type="submit" disabled="disabled">Submit</button>
			<?php	
			}
			else
			{
			 ?>         
      		 	 <button class="btn btn-default btn-lg btn-confirm" type="submit" id="completeBtn">Submit</button>
			<?php
            }
            ?>
		
        <input type="hidden" name="complete" id="complete" />
        </div>
        </div>
      </div>
  </form>
  </div>
<div class="col-md-4 padd-top50">
  <div class="sidebar-filter">
	<div class="card">
		<div class="filter-tabs">
        </div>
    </div>
   </div>
</div>
  <script>
  setTimeout(function(){loadData(); },1000);
  function loadData() {
   var maxHeight = -1;
	//$questionId = $('.question_id').val();
	
	var divSingle_choice = $("div.single_choice").length;
	var divMultiple_choice = $("div.multiple_choice").length;
	for(var i=0 ;i<divSingle_choice; i++)
	{	 
		//console.log("single_choice:"+divSingle_choice);
	//	$('div.single_choice').eq(i).find(".features").each(function() {
	//	 maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		 
	//   });
	
		var maxHeight = Math.max.apply(null, $('div.single_choice').eq(i).find(".features").map(function ()
		{
   		 return $(this).height();
		}).get());
	
	   $('div.single_choice').eq(i).find(".features").height(maxHeight);
	   console.log("single_choice:"+maxHeight);
	   maxHeight = -1;
	 }     
   
	for(var i=0 ;i<divMultiple_choice; i++)
	{
		//console.log("multiple_choice:"+divMultiple_choice);
	//	$('div.multiple_choice').eq(i).find(".features").each(function() {
	//	 maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
	//   });
	
	var maxHeights = Math.max.apply(null, $('div.multiple_choice').eq(i).find(".features").map(function ()
	{
    return $(this).height();
	}).get());
	
	   $('div.multiple_choice').eq(i).find(".features").height(maxHeights);
	   console.log("multiple_choices:"+maxHeights);
	   maxHeights = -1;
	 }  
  } 
  $(document).ready(function() {
//$(".extraComment").hide();
$('.error').hide();
	//scroll_top = window.localStorage.getItem("scroll_t");
 	//$('#menu-content').animate({scrollTop: scroll_top},"slow");

$(".numerical").keydown(function(event)
{ 	
	if ((event.which != 8) && (event.keyCode < 96 || event.keyCode > 105) && (event.keyCode < 46 || event.keyCode > 57))
	{
		return false;
	}

});
 
          <?php
		     if(strtoupper($accessLevel) == "READ_ONLY")
			{
			?>
                $("#detail-form input,#detail-form textarea,#detail-form select,#detail-form button,#detail-form submit").attr("disabled","disabled");
				$("#detail-form input,#detail-form textarea,#detail-form select,#detail-form button,#detail-form submit").addClass("isDisabled");
				$('.features').addClass("isDisabled");
				$('.confirmation').addClass("isDisabled");
				
				
			<?php	
			}
		   if($surveyStatus == "Reviewed")
			{
			?>
                $("#detail-form input,#detail-form textarea,#detail-form select,#detail-form button,#detail-form submit").attr("disabled","disabled");
				$("#detail-form input,#detail-form textarea,#detail-form select,#detail-form button,#detail-form submit").addClass("isDisabled");
				$('.features').addClass("isDisabled");
				$('.confirmation').addClass("isDisabled");
			<?php	
			}			
			else{?>
   
  		/*$( ".date_only" ).datepicker({
		showOn: "button",
		buttonImage: "<?php //$_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/common/images/calender.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		dateFormat: "mm/dd/yy",
		maxDate: new Date(),
		changeMonth: true,
		changeYear: true,
		yearRange: "-114:+0"
});*/

        $(".date_only").datetimepicker({
		pickTime: false,
		 
    	}).on('click', function() {
		var id = $(this).attr("id");
         $("#"+id+"_dateInput").focus();
		});
		

   $('.features').click(function() { 
  
   var valueOfHidden = $(this).attr('data');  
     if($(this).parent().hasClass("single_choice"))
	 {
	 	if($(this).hasClass("active"))
		{
			$(this).removeClass("active");
			var ansVal = $(this).siblings('input').val("");
			$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
			

		}
		else
		{
			$(this).siblings().removeClass("active");
			$(this).addClass("active");
			var ansVal = $(this).attr('id');
			$(this).siblings('input').val(ansVal);
			 if($(this).hasClass("mandatoryResp"))
			{
				
				
				$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
					
				var mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>"); 
				$("#detail-form").append(mandatoryField);
			}
		}
		
	 }
    else if($(this).parent().hasClass("multiple_choice"))
	 {
	 	if($(this).hasClass("active"))
		{
			$(this).removeClass("active");
			var valueOfcart = $(this).attr('id');
			$('input[value='+valueOfcart+']').remove();
			if(!$(this).siblings().hasClass("active"))
			{
			$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
			}


		}
		else
		{
			$(this).addClass("active");
			var valueOfcart = $(this).attr('id');
		var hiddenField = $("<input type='hidden' name='options[]' value='"+valueOfcart+"'/>"); 
		$("#detail-form").append(hiddenField);
		 if($(this).hasClass("mandatoryResp"))
		{
			
			
			$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
				
			var mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>"); 
		    $("#detail-form").append(mandatoryField);
		}
			
		}
	 }
	
	 
			   if($(this).siblings().hasClass('active') || $(this).hasClass('active'))
			   {
			   		
					var elementDiv = $(this).parents().parents("div.questionSurvey");
					if(!$(elementDiv).hasClass('qusActive'))
					{
						$(elementDiv).addClass('qusActive');
						var answerNumber = parseInt($("#answerNumber").text());
						answerNumber = answerNumber+1;
						$("#answerNumber").text(answerNumber);
					}
			   }
			   else
			   {
					var elementDiv = $(this).parents().parents("div.questionSurvey");
						$(elementDiv).removeClass('qusActive');
						var answerNumber = parseInt($("#answerNumber").text());
						answerNumber = answerNumber-1;
						$("#answerNumber").text(answerNumber);
					
			   }
			   
		submitForm();
			   
   });
$(".dateFocus").on('keyup focusout',function(){
	var dtVal=$(this).val();
	var questionId = $(this).attr("answerId");
  if(dtVal != "")
  {
	   if(!ValidateDate(dtVal))
	   {
		 $('.err_'+questionId).show();
		 $('.err_'+questionId).addClass("returnFalse");     
		
	   }
	   else
	   {
	   		$('.err_'+questionId).hide();
		 	$('.err_'+questionId).removeClass("returnFalse"); 
	   }
   }
   
   else
   {
   		 $('.err_'+questionId).hide();
		 $('.err_'+questionId).removeClass("returnFalse"); 
   }
   
   
});  
   
$(".txt").on('click keyup change focusout',function(){
if($(this).hasClass('confirmClass'))
{
	var valueOfconfirm = $(this).attr('data');
	
	var hiddenbox = $("<input type='hidden' name='confirmationHidden[]' value='"+valueOfconfirm+"'/>"); 
	$("#detail-form").append(hiddenbox);
}
var mandatoryField;
var data = $(this).attr("data");
var filledTextBox = $('.txt[data='+data+']').filter(function(){
		return $(this).val();
	}).length;
	
if($(this).hasClass("mandatoryResp"))
{
	var valueOfHidden = $(this).attr('data');
	
	if($(this).val() == "" && (filledTextBox != ""))
	{
		
		$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
		mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>");
	}
	else if($(this).val() == "" && (filledTextBox == ""))
	{		
		
		$("#detail-form").find("#mandatory_"+valueOfHidden).remove();			    
	}	
	else
	{	
	
	$("#detail-form").find("#mandatory_"+valueOfHidden).remove();	
		
	 mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>");
	} 
	$("#detail-form").append(mandatoryField);
}

if(!$(this).hasClass('skipCount'))
{

	var data = $(this).attr("data");
	var elementDiv = $(this).parents().parents().parents("div.questionSurvey");
	var vEmptyTextBox = $('.txt[data='+data+']').filter(function(){
		return $.trim($(this).val()) == '';
	}).length;
	var allTextBox = $('.txt[data='+data+']').length;
	var checkDiff = allTextBox-vEmptyTextBox;
	//console.log("vEmptyTextBox"+vEmptyTextBox);
	
	if(checkDiff > 0 )
	{
		if(!$(elementDiv).hasClass('qusActive'))
		{
		$(elementDiv).addClass('qusActive');
		var answerNumber = parseInt($("#answerNumber").text());
		answerNumber = answerNumber+1;
		$("#answerNumber").text(answerNumber);
		}
	}
	else if(allTextBox == vEmptyTextBox)
	{
		if($(elementDiv).hasClass('qusActive'))
		{
		$(elementDiv).removeClass('qusActive');
		var answerNumber = parseInt($("#answerNumber").text());
		answerNumber = answerNumber-1;
		$("#answerNumber").text(answerNumber);
		}
	}
}
submitForm();
}); 
$(".txt[type='radio']").on('click',function(){

var valueOfcart = $(this).attr('id');
 var checkRadioBtn = $(this).parent().parent();
 var hiddenBoxLength = $(checkRadioBtn).find("input.hiddenBoxRadio").length;
	if(hiddenBoxLength >0 )
	{
	//$(checkRadioBtn).find("input.hiddenBoxRadio").remove();
	
	}
	else
	{
	 var check = $("<input name='options[]' value='"+valueOfcart+"' class='form-control input-md hiddenBoxRadio' type='hidden'>");
	 $(checkRadioBtn).append(check);
	 }
		submitForm();
if($(this).attr('questionid'))
{

	var quesAnswerId = $(this).attr('id').split('_');
	var quesColAnswerId = $(this).attr('questionid').split('_');
	quesAnsId = quesAnswerId[1]+"_"+quesColAnswerId[0];
	var showQues = quesAnswerId[1]; 
	var showAns = quesColAnswerId[0]; 
	var quesAttr;
	var ansAttr;
	var ShowIf = $(".questionSurvey[showIfResp='"+quesAnsId+"']").length;

	for(var j=0;j<$(".questionSurvey[showQues='"+showQues+"']").length;j++)
	{
		quesAttr = $(".questionSurvey[showQues='"+showQues+"']").eq(j).attr("showQues");
		ansAttr = $(".questionSurvey[showAns='"+showAns+"']").eq(j).attr("showAns");
		if(quesAttr == showQues && ansAttr != showAns)
		{
			
		//	$(".questionSurvey[showQues='"+showQues+"']").addClass("HideQuestion");
		//					loadAnchorData();
		//alert(quesAnsId);
		var response = getAllShowIf(quesAnsId);
		if(response)
		{
			$(".questionSurvey[showQues='"+showQues+"']").removeClass("HideQuestion");
		   //  loadAnchorData();
		}
		else
		{
			$(".questionSurvey[showQues='"+showQues+"']").addClass("HideQuestion");
		   //  loadAnchorData();
		}

		}
		else if(quesAttr == showQues && ansAttr == showAns)
		{
		
			if(ShowIf > 0)
			{
				if($(".questionSurvey[showIfResp='"+quesAnsId+"']").hasClass("HideQuestion"))
				{
					
					$(".questionSurvey[showIfResp='"+quesAnsId+"']").removeClass("HideQuestion");
					loadAnchorData();
				}
				else
				{
					$(".questionSurvey[showIfResp='"+quesAnsId+"']").addClass("HideQuestion");
				}
			}
		}
	}
}

});
	 
   
$(".txt1[type='checkbox']").on('change',function(){
if($(this).hasClass('confirmClass'))
{
	var valueOfconfirm = $(this).attr('data');
	var hiddenbox = $("<input type='hidden' name='confirmationHidden[]' value='"+valueOfconfirm+"'/>"); 
	$("#detail-form").append(hiddenbox);	
}
var data = $(this).attr("data");
var vfilledCheckBox = $('.txt1[data='+data+']').filter(function(){
		return $(this).is(':checked');
	}).length;
	var mandatoryField;
if($(this).hasClass("mandatoryResp"))
{
	var valueOfHidden = $(this).attr('data');
	if((!this.checked) && (vfilledCheckBox != ""))
	{
		
		$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
		mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>");
	}
	else if((!this.checked) && (vfilledCheckBox == ""))
	{
		
		$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
	    
	}	
	else
	{	
	$("#detail-form").find("#mandatory_"+valueOfHidden).remove();	
		
	 mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>");
	} 
	$("#detail-form").append(mandatoryField);
}

if(!$(this).hasClass('skipCount'))
{
	var data = $(this).attr("data");
	var elementDiv = $(this).parents().parents().parents("div.questionSurvey");
	var vEmptyTextBox = $('.txt1[data='+data+']').filter(function(){
		return !$(this).is(':checked');
	}).length;
	var allTextBox = $('.txt1[data='+data+']').length;
	var checkDiff = allTextBox-vEmptyTextBox;
	
	
	if(checkDiff > 0 )
	{
		if(!$(elementDiv).hasClass('qusActive'))
		{
		$(elementDiv).addClass('qusActive');
		var answerNumber = parseInt($("#answerNumber").text());
		answerNumber = answerNumber+1;
		$("#answerNumber").text(answerNumber);
		}
	}
	else if(allTextBox == vEmptyTextBox)
	{
		if($(elementDiv).hasClass('qusActive'))
		{
		$(elementDiv).removeClass('qusActive');
		var answerNumber = parseInt($("#answerNumber").text());
		answerNumber = answerNumber-1;
		$("#answerNumber").text(answerNumber);
						
		}
	}
}
					
						submitForm();
    }); 
	 
   
   
   
   
   $("a.features").click(function()
 	{
		
		if($(this).hasClass('confirmClass'))
		{
			var valueOfconfirm = $(this).attr('data');
			var hiddenbox = $("<input type='hidden' name='confirmationHidden[]' value='"+valueOfconfirm+"'/>"); 
			$("#detail-form").append(hiddenbox);
		}
		
		if($(this).hasClass('other'))
		{ 
				if($(this).hasClass('active'))
				{ 
					var ele = $(this).siblings("div.row");
					$(ele).find('.extraComment').show();
				}
				else
				{
					var ele = $(this).siblings("div.row");
					//$(ele).find('.extraComment').hide();
					$(ele).find(".extraComment").val('');
				}
		}
		else if ($(this).hasClass('single'))
		{
			var ele = $(this).siblings("div.row");
			$(ele).find(".extraComment").val('');
		}
		var quesAnswerId = $(this).attr('id').split('_');
		 quesAnsId = quesAnswerId[1]+"_"+quesAnswerId[0];
		 var showQues = quesAnswerId[1]; 
		 var showAns = quesAnswerId[0]; 
		 var quesAttr;
		 var ansAttr;
		var ShowIf = $(".questionSurvey[showIfResp='"+quesAnsId+"']").length;
		
			for(var j=0;j<$(".questionSurvey[showQues='"+showQues+"']").length;j++)
			{
				quesAttr = $(".questionSurvey[showQues='"+showQues+"']").eq(j).attr("showQues");
				ansAttr = $(".questionSurvey[showAns='"+showAns+"']").eq(j).attr("showAns");
				if(quesAttr == showQues && ansAttr != showAns)
				{
					var response = getAllShowIf(quesAnsId);
					if(response)
					{
						$(".questionSurvey[showQues='"+showQues+"']").removeClass("HideQuestion");
					   //  loadAnchorData();
					}
					else
					{
						$(".questionSurvey[showQues='"+showQues+"']").addClass("HideQuestion");
					   //  loadAnchorData();
					}

				}
				else if(quesAttr == showQues && ansAttr == showAns)
				{
					if(ShowIf > 0)
					{
						if($(".questionSurvey[showIfResp='"+quesAnsId+"']").hasClass("HideQuestion"))
						{
							$(".questionSurvey[showIfResp='"+quesAnsId+"']").removeClass("HideQuestion");
							loadAnchorData();
						}
						else
						{
							$(".questionSurvey[showIfResp='"+quesAnsId+"']").addClass("HideQuestion");
						}
					}
				}
				 
			}
						
					
					
				
	
			submitForm();
			 
 });
   <?php
   }?>
   
 $("#inComplete").click(function(e)
 {
 	if($(".error").hasClass("returnFalse"))
	{
		event.preventDefault();
		return false;
	}
	else
	{
		var valueOfcart;
		if(answerNumber != questionNumber)
		{
		valueOfcart= "inComplete";
		 var radio = $("<input name='"+valueOfcart+"' value='"+valueOfcart+"' class='form-control input-md' type='hidden'>");
		 $('input[value=Complete').remove();
		}
		else
		{
		valueOfcart= "Complete";
		var radio = $("<input name='"+valueOfcart+"' value='"+valueOfcart+"' class='form-control input-md' type='hidden'>");
		$('input[value=inComplete').remove();
	
	
		}
		$("#detail-form").append(radio);
	 //	$("#detail-form").submit();
		postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientSurvey/pages/surveyDetail.php','detail-form','menu-content',e);
		delete window.localStorage["scroll_t"];
	}

 });
 

 $("#completeBtn").click(function(e)
 {
 	if($(".error").hasClass("returnFalse"))
	{
		event.preventDefault();
		return false;
	}
	else
	{
		var valueOfcart;
		var answerNumber = parseInt($("#answerNumber").text());
		var questionNumber = parseInt($("#questionNumber").text());
		/*if(answerNumber != questionNumber)
		{
		valueOfcart= "inComplete";
		 var radio = $("<input name='"+valueOfcart+"' value='"+valueOfcart+"' class='form-control input-md' type='hidden'>");
			$('input[value=Complete').remove();
	
		}
		else
		{*/
		valueOfcart= "Complete";
		 var radio = $("<input name='"+valueOfcart+"' value='"+valueOfcart+"' class='form-control input-md' type='hidden'>");
			$('input[value=inComplete').remove();
	
		//}
		
		$("#detail-form").append(radio);
		var mandaroryCnt = <?php echo $mandatoryQuesCnt; ?>;
		
		if($(".mandatoryQuestions").length < mandaroryCnt)
		{
			$(".txt_div").html("Please answer all the required questions");
			$(".cart_page").html("Alert");
			$("#aboutPopup").show();
			return false;
		}
		else
		{		
			postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientSurvey/pages/surveyDetail.php','detail-form','menu-content',e);
			delete window.localStorage["scroll_t"];
		}
	}
 });
 //confirmation box click
 $(".confirmationDiv .confirmation").click(function(e)
 {
 	var valueOfcart;
	var confirmId = $(this).attr('id');
 	var confirmText = confirmId.split("_");
	var questionNumber = confirmText[0];
	var ele = $(this).parent();
	$(ele).find(".confirmHidden").remove();
	$(ele).find(".confirmation").removeClass('active');
	$(this).addClass('active');
	 var radio = $("<input name='confirmationBox[]' id='confirmHidden"+questionNumber+"' value='"+confirmId+"' class='form-control input-md confirmHidden' type='hidden'>");
 	$(ele).append(radio);
	submitForm();
 });

   
   
/*$(".radio").click(function() 
 {
 alert();
 var valueOfcart = $(this).attr('id');
 var checkRadioBtn = $(this).parent().parent();
 var hiddenBoxLength = $(checkRadioBtn).find("input.hiddenBoxRadio").length;
	if(hiddenBoxLength >0 )
	{
	//$(checkRadioBtn).find("input.hiddenBoxRadio").remove();
	
	}
	else
	{
	 var check = $("<input name='options[]' value='"+valueOfcart+"' class='form-control input-md hiddenBoxRadio' type='hidden'>");
	 $(checkRadioBtn).append(check);
	 }
		submitForm();

 }); */

 
$("div.matrixComment textarea").keyup(function() 
 {
 var matrixCommentValue = $(this).attr('data');
 var hidden = $(this).parent();
 var parentTbody = $(this).parent().parent().parent().parent().parent();
  var parentDiv = $(parentTbody).parent().parent().parent().parent().parent();

 var radioCheck = $(parentTbody).find('tr').eq(0).find('input:radio:checked').length;
 var hiddenBoxLength = $(hidden).find("input.hiddenBox").length;
 var textLength = $.trim($(this).val()).length;
 
 if(radioCheck == 0)
 {
 	if(textLength > 0)
	{
		if(!$(parentDiv).hasClass('qusActive'))
		{
		$(parentDiv).addClass('qusActive');
		var answerNumber = parseInt($("#answerNumber").text());
		answerNumber = answerNumber+1;
		$("#answerNumber").text(answerNumber);
		}
	}
	else
	{
		$(parentDiv).removeClass('qusActive');
		var answerNumber = parseInt($("#answerNumber").text());
		answerNumber = answerNumber-1;
		$("#answerNumber").text(answerNumber);
	}
 
 }
 
 
	 if(textLength > 0 )
	 {
		if(hiddenBoxLength == 0)
		{
		  var check = $("<input name='options[]' value='"+matrixCommentValue+"' class='form-control input-md hiddenBox' type='hidden'>");
		  $(hidden).append(check);
		}
	 }
	 else
	 {
		  $(hidden).find("input.hiddenBox").remove();
	 }
 });  
 

   $("input[type=text],.extraComment").focusout(function()
   {
	submitForm();
   
   });


 });
 
 function submitForm()
 {
 	if($(".error").hasClass("returnFalse"))
	{
		event.preventDefault();
		return false;
	}
	else
	{
		var answerNumber = parseInt($("#answerNumber").text());
		var questionNumber = parseInt($("#questionNumber").text());
		if(answerNumber != questionNumber)
		{
		var valueOfcart= "inComplete";
		var radio = $("<input name='"+valueOfcart+"' value='"+valueOfcart+"' class='form-control input-md' type='hidden'>");
		$('input[value=Complete').remove();
		}
		else
		{
			valueOfcart= "Complete";
			var radio = $("<input name='"+valueOfcart+"' value='"+valueOfcart+"' class='form-control input-md' type='hidden'>");
			$('input[value=inComplete').remove();
		}
		
		$("#detail-form").append(radio);	
		var redirect = $("<input name='redirect' value='redirect' class='form-control input-md' type='hidden'>");
		$("#detail-form").append(redirect);	
		postFormWithoutLoding('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientSurvey/pages/autoSave.php','detail-form','');
 	}
 }
 $('#menu-content').scroll(function() {
    scroll_t = $('#menu-content').scrollTop();
	window.localStorage.setItem("scroll_t",scroll_t);
});

$(".isDisabled").keypress(function(e) {
    $(this).blur();

});
 $(".sinlge_choiceMenu").change(function(){

 var menuSelection = $(this).val();
 var checkhiddenField = $(this).parent().parent();
 var hiddenBoxLength = $(checkhiddenField).find("input.hiddenBoxSelect").length;
 if($(this).hasClass("mandatoryResp"))
		{
			var valueOfHidden = $(this).attr('data');
			
			$("#detail-form").find("#mandatory_"+valueOfHidden).remove();
				
			var mandatoryField = $("<input type='hidden' name='mandatory[]' value='"+valueOfHidden+"' id='mandatory_"+valueOfHidden+"' class='mandatoryQuestions'/>"); 
		    $("#detail-form").append(mandatoryField);
		}
	if(hiddenBoxLength >0 )
	{
		$(checkhiddenField).find("input.hiddenBoxSelect").remove();
		if(menuSelection !="")
		{
			 var check = $("<input name='options[]' value='"+menuSelection+"' class='form-control input-md hiddenBoxSelect' type='hidden'>");
			 $(checkhiddenField).append(check);
		}	
	}
	else
	{
		if(menuSelection !="")
		{
			 var check = $("<input name='options[]' value='"+menuSelection+"' class='form-control input-md hiddenBoxSelect' type='hidden'>");
			 $(checkhiddenField).append(check);
		}
	 }
		submitForm();
 });
 
 function ValidateDate(dtValue)
{
var dtRegex = new RegExp(/\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/);
return dtRegex.test(dtValue);
}
  </script>
<style>
.confirmationDiv {
    float: left;
    width: 100%;
	padding-top:5px;
}
.question8.confirmationDiv a {
    float: none;
}
.question8 a:hover {
    background: #2db0f6 none repeat scroll 0 0;
    color: #fff;
}
.error
{
    color: red;
    font-family : Verdana;
    font-size : 8pt;
}
</style>