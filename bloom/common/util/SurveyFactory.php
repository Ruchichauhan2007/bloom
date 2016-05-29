<?php
include 'DateUtil.php';
include 'Constants.php';
function   surveyAnswer($surveyQuestion,$surveyQuestionId,$surveyresponses,$confirmationInfo)
{
	//var_dump($surveyQuestion);
	$surveyAnswerHTML="";
	$skipCount = "";
	if($surveyQuestion->{type}->{family} == "single_choice")
    { 
		$answers = $surveyQuestion->{answers};
		$surveyresponsesId = $surveyresponses[0]->{answer_id};
        $metaDataInfo = $surveyQuestion->{metaInfo};		
		if($surveyQuestion->{type}->{subtype} == "vertical")
		{
			$answerBoxVer = singleChoice_vertical($answers,$surveyresponsesId,$surveyQuestionId,$surveyresponses,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxVer;
		}
		elseif($surveyQuestion->{type}->{subtype} == "menu")
		{
			if($surveyQuestion->{heading} == "Action taken")
			{
				$skipCount = "skipCount";
			}
			$answerBoxMenu = singleChoice_menu($answers,$surveyresponsesId,$surveyQuestionId,$surveyresponses,$metaDataInfo,$confirmationInfo,$skipCount);
			$answerBox = $answerBox.$answerBoxMenu;
		}
		$surveyAnswerHTML = $surveyAnswerHTML."<div class='question8 single_choice'>".$answerBox."</div>";
			
    }
    elseif($surveyQuestion->{type}->{family} == "multiple_choice")
    { 
		$answers = $surveyQuestion->{answers};
		$metaDataInfo = $surveyQuestion->{metaInfo};
		if($surveyQuestion->{type}->{subtype} == "vertical" || $surveyQuestion->{type}->{subtype} == "vertical_two_col" || $surveyQuestion->{type}->{subtype} == "vertical_three_col" )
		{				
			$answerBoxMultiple = multipleChoice($answers,$surveyQuestionId,$surveyresponses,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxMultiple;
		}
		$surveyAnswerHTML = $surveyAnswerHTML."<div class='question8 multiple_choice'>".$answerBox."</div>";
			
    }
	else if($surveyQuestion->{type}->{family} == "open_ended")
	{
		$metaDataInfo = $surveyQuestion->{metaInfo};
		if($surveyQuestion->{type}->{subtype} == "essay")
		{
			if($surveyQuestion->{heading} == "Describe the situation")
			{
				$skipCount = "skipCount";
			}
			$answerBoxeassy = openEnded_eassy($surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo,$skipCount);
			$answerBox = $answerBox.$answerBoxeassy;
		}
		else if($surveyQuestion->{type}->{subtype} == "single")
		{
			$answerBoxSingle = openEnded_single($surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo);
            $answerBox = $answerBox.$answerBoxSingle;			
		}
		else if($surveyQuestion->{type}->{subtype} == "multi")
		{
			$answers = $surveyQuestion->{answers}; 
			$answerBoxOpenended_multi = openEnded_multiple($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxOpenended_multi;
		}
		elseif($surveyQuestion->{type}->{subtype} == "numerical")
		{		
			$answers = $surveyQuestion->{answers}; 
			$answerBoxNumeric = openEnded_numeric($answers,$surveyresponses,$surveyQuestion,$surveyQuestionId,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxNumeric;
		}
		$surveyAnswerHTML = $surveyAnswerHTML.$answerBox;
	}
	else if($surveyQuestion->{type}->{family} == "datetime")
	{
		$metaDataInfo = $surveyQuestion->{metaInfo};
		$answers = $surveyQuestion->{answers};
		if($surveyQuestion->{type}->{subtype} == "date_only")
		{
			$answerBoxDateOnly = dateTime_dateOnly($answers,$surveyresponses,$surveyQuestion,$surveyQuestionId,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxDateOnly;
	    }
		$surveyAnswerHTML = $surveyAnswerHTML.$answerBox;			
	}
	
    elseif($surveyQuestion->{type}->{family} == "demographic")
    { 
		
		$metaDataInfo = $surveyQuestion->{metaInfo};
		$answers = $surveyQuestion->{answers};		
		if($surveyQuestion->{type}->{subtype} == "international")
		{				
			$metaDataInfo = $surveyQuestion->{metaInfo};	
			$answerBoxInternational = demo_international($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo);	
			$answerBox = $answerBox.$answerBoxInternational;
		}
		$surveyAnswerHTML = $surveyAnswerHTML.$answerBox;
			
    }
	elseif($surveyQuestion->{type}->{family} == "matrix")
    { 
		$metaDataInfo = $surveyQuestion->{metaInfo};
		$answers = $surveyQuestion->{answers};
		$surResponses = $surveyQuestion->{responses};
		foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			if($answer->{type} == "col")
			{	
				$th = $th." <th class='matrixRow'>".$answer->{text}."</th>";									
				//$cols++;
			}
		}
	}		
		$openAnswerDiv = "<div class='row'>
					  <div class='col-md-12 familyInformation'>
					  <div class='table-responsive'>
					  <table class='table table-striped'>
					  <thead><tr><th></th>";
						
		$endAnswerDiv =	  "</tr></thead>";
		$closeAnswerDiv = " <tbody>	
					</tbody> </table> </div>
					</div>
				  </div>";
		if($surveyQuestion->{type}->{subtype} == "rating" || $surveyQuestion->{type}->{subtype} == "single")
		{			
			$answerBoxRating = metrix_rating_single($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxRating;	
		}
		else if($surveyQuestion->{type}->{subtype} == "multi")
		{	
			$answerBoxMetMulti = metrixMulti($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo);
			$answerBox = $answerBox.$answerBoxMetMulti;				
		}
		$surveyAnswerHTML = $surveyAnswerHTML.$openAnswerDiv.$th.$endAnswerDiv.$answerBox.$closeAnswerDiv;
			
    }
 return $surveyAnswerHTML;

}
function singleChoice_vertical($answers,$surveyresponsesId,$surveyQuestionId,$surveyresponses,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$accessList = $metaDataInfo->{accessList};
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	$surveyAnswerKey = "";
	$resp = false;
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			$surveyText = "";
			if($surveyresponsesId == $answer->{answer_id})
			{
				$resp = true;				
				$surveyAnswerKey = $answer->{answer_id}."_".$surveyQuestionId;
				if($answer->{type} == "other")
				{
					$surveyText =$surveyresponses[0]->{text};
					$answerBoxVertical= $answerBoxVertical."<a class='padTop10 features active other ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a><input type='hidden' name='options[]' value='".$surveyAnswerKey."' />";
					if( $surveyText != "")
					{
						$answerBoxVertical= $answerBoxVertical." <div class='row form-group'>
						  <div class='col-md-12 CommetBox'>
							<textarea class='form-control extraComment ".$readOnly."' placeholder='Add comments..' rows='2' id='extraComment' name='extraComment_".$answer->{answer_id}."' >".$surveyText."</textarea>
						  </div>
						</div>";
					}
					else
					{
						$answerBoxVertical= $answerBoxVertical." <div class='row form-group'>
						  <div class='col-md-12 CommetBox'>
							<textarea class='form-control extraComment ".$readOnly." ".$confirmClass."' placeholder='Add comments..' rows='2' id='extraComment' name='extraComment_".$answer->{answer_id}."' ></textarea>
						  </div>
						</div>";
					}
				}
				else
				{
					$answerBoxVertical= $answerBoxVertical."<a class='padTop10 features active single ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a><input type='hidden' name='options[]' value='".$surveyAnswerKey."' />";
				}
			}	
			else
			{				
				if($answer->{type} == "other")
				{
					 $answerBoxVertical= $answerBoxVertical."<a class='padTop10 features other ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a>";
					$answerBoxVertical= $answerBoxVertical."<div class='row form-group'>
					  <div class='col-md-12 CommetBox'>
						<textarea class='form-control extraComment ".$readOnly."' placeholder='Add comments..' rows='2' id='extraComment' name='extraComment_".$answer->{answer_id}."'></textarea>
					  </div>
					</div>";
				}
				else
				{
					 $answerBoxVertical= $answerBoxVertical."<a class='padTop10 features single ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a><input type='hidden' name='options[]' value='".$surveyAnswerKey."' />";
				}
			}			
		}
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxVertical=$answerBoxVertical."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxVertical;
}
function singleChoice_menu($answers,$surveyresponsesId,$surveyQuestionId,$surveyresponses,$metaDataInfo,$confirmationInfo,$skipCount)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	$selectOption = "<div class='row Legal-Name'>
					  <div class='col-md-3'>
						<div class='row form-group'>
						 
						  <div class='col-md-12'>
							<select id='sinlge_choiceMenu' name='sinlge_choiceMenu' class='form-control sinlge_choiceMenu txt ".$skipCount." ".$readOnly." ".$confirmClass." ".$mandatoryResp."' data='".$surveyQuestionId."'><option value=''>Select Option</option>";
	$closeSelect = "</select><input type='hidden' name='options[]' value='".$surveyresponsesId."_".$surveyQuestionId."' class='hiddenBoxSelect'/>
	</div>
	</div>
    </div>
    </div>";
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			$resp = true;				
			$surveyAnswerKey = $answer->{answer_id}."_".$surveyQuestionId;
			if($answer->{answer_id} == $surveyresponsesId)
			{
				
				$answerBoxMenu= $answerBoxMenu."<option selected='selected' value='".$answer->{answer_id}."_".$surveyQuestionId."'>".$answer->{text}."</option>";
				
			}
			else
			{
				$answerBoxMenu= $answerBoxMenu."<option value='".$answer->{answer_id}."_".$surveyQuestionId."'>".$answer->{text}."</option>";
			}
			
		}												
				  
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxMenu=$answerBoxMenu."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $selectOption.$answerBoxMenu.$closeSelect;
}

function multipleChoice($answers,$surveyQuestionId,$surveyresponses,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			$surveyText = "";
			
			foreach($surveyresponses as $responseData)
			{
				if($responseData->{answer_id} == $answer->{answer_id})
				{
					$surveyresponsesId  =$responseData->{answer_id};
					$surveyText =$responseData->{text};
				}
				
				
			}
			 if($surveyresponsesId == $answer->{answer_id})
			 {
			  
				 if($answer->{type} == "other")
				 {
					$answerBoxMulti= $answerBoxMulti."<a class='padTop10 active features other ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a><input type='hidden' value='".$answer->{answer_id}."_".$surveyQuestionId."' name='options[]'>";
					$answerBoxMulti= $answerBoxMulti."<div class='row form-group'>
					<div class='col-md-12 CommetBox'>
					<textarea class='form-control extraComment ".$readOnly."' placeholder='Add comments..' rows='2' id='extraComment' name='extraComment_".$answer->{answer_id}."'>".$surveyText."</textarea>
							  </div>
							</div>";
				 }
				 else
			 {
			 $answerBoxMulti= $answerBoxMulti."<a class='padTop10 active features ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a>										<input type='hidden' value='".$answer->{answer_id}."_".$surveyQuestionId."' name='options[]'>";
			 }
			
			 }
			 else
			 {
				
				if($answer->{type} == "other")
				 {
					 $answerBoxMulti= $answerBoxMulti."<a class='padTop10 features other ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a>";
					$answerBoxMulti= $answerBoxMulti."<div class='row form-group'>
							  <div class='col-md-12 CommetBox'>
								<textarea class='form-control extraComment ".$readOnly."' placeholder='Add comments..' rows='2' id='extraComment' name='extraComment_".$answer->{answer_id}."'></textarea>
							  </div>
							</div>";
				 }
				 else
			 {
			 $answerBoxMulti= $answerBoxMulti."<a class='padTop10 features ".$readOnly." ".$confirmClass." ".$mandatoryResp."' id='".$answer->{answer_id}."_".$surveyQuestionId."' href='#' data='".$surveyQuestionId."'>".$answer->{text}."</a>";
				 }
			 }
		}
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxMulti=$answerBoxMulti."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxMulti;
}
function openEnded_eassy($surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo,$skipCount)
{
	
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	if($surveyresponses[0])
	{
		$surveyText = $surveyresponses[0]->{text};
	}
	else
	{
		$surveyText ="";
	}
	$answerBoxEassy =" <div class='row form-group'>
	  <div class='col-md-12 CommetBox'>
	  <input type='hidden' name='essay_questionId[]' value='".$surveyQuestionId."'/>
		<textarea class='form-control txt ".$readOnly." ".$confirmClass." ".$skipCount." ".$mandatoryResp."' placeholder='Add comments or questions here.' rows='2' id='comment' name='".$surveyQuestionId."' data='".$surveyQuestionId."'>".$surveyText."</textarea>
	  </div>
	</div>";
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxEassy=$answerBoxEassy."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxEassy;
}
function openEnded_single($surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	if($surveyresponses[0])
	{
		$surveyText = $surveyresponses[0]->{text};
	}
	else
	{
		$surveyText ="";
	}
	$answerBoxSingle =" <div class='row form-group'>
	<div class='col-md-6'>
	<input type='hidden' name='essay_questionId[]' value='".$surveyQuestionId."'/>
	<input id='textinput' name='".$surveyQuestionId."' placeholder='' class='form-control input-md txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' type='text' value='".$surveyText."' style='margin-top:10px;' data='".$surveyQuestionId."'>
	</div>
	</div>";
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxSingle=$answerBoxSingle."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxSingle;
}
function openEnded_multiple($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	$openDiv = "<div class='row Legal-Name'>";
	$closeDiv = "</div>";
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			$respFound = false;
			foreach($surveyresponses as $responseData)
			{				
				if($responseData->{answer_id} == $answer->{answer_id})
				{
					$respFound = true;
					$surveyresponsesId  =$responseData->{answer_id};			
					$answerBoxDiv = $answerBoxDiv."<div class='col-md-12'>
					<div class='row form-group'>
					  <label class='col-md-2 control-label' for='textinput'>".$answer->{text}."</label>
					  <div class='col-md-8'>
						<input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
						<input id='' name='numericText_".$answer->{answer_id}."'  class='form-control input-md ".$surveyQuestion->{type}->{subtype}." txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' type='text' value='".$responseData->{text}."' data='".$surveyQuestionId."'>
					  </div>
					</div>
				  </div>";			  
					break;
				}					
			}
			if(!$respFound)
			{
			 $answerBoxDiv = $answerBoxDiv."<div class='col-md-12'>
				<div class='row form-group'>
				  <label class='col-md-2 control-label' for='textinput'>".$answer->{text}."</label>
				  <div class='col-md-8'>
					<input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
					<input id='' name='numericText_".$answer->{answer_id}."'  class='form-control input-md ".$surveyQuestion->{type}->{subtype}." txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' type='text' value='' data='".$surveyQuestionId."'>
				  </div>
				</div>
			  </div>";
			}
		}					  
	}
	$answerBoxOpenended_multi = $openDiv.$answerBoxDiv.$closeDiv;
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxOpenended_multi=$answerBoxOpenended_multi."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxOpenended_multi;
}
function openEnded_numeric($answers,$surveyresponses,$surveyQuestion,$surveyQuestionId,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	$openDiv = "<div class='row Legal-Name'>";
	$closeDiv = "</div>";
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			$respFound = false;
			foreach($surveyresponses as $responseData)
			{				
				if($responseData->{answer_id} == $answer->{answer_id})
				{
					$respFound = true;
					$surveyresponsesId  =$responseData->{answer_id};			
					$answerBoxDiv = $answerBoxDiv."<div class='col-md-4'>
					<div class='row form-group'>
					  <label class='col-md-12 control-label' for='textinput'>".$answer->{text}."</label>
					  <div class='col-md-12'>
						<input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
						<input id='' name='position' value='".$answer->{answer_id}."_".$answer->{position}."' class='form-control input-md' type='hidden'>
						<input id='' name='numericText_".$answer->{answer_id}."'  class='form-control input-md ".$surveyQuestion->{type}->{subtype}." txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' type='text' value='".$responseData->{text}."' data='".$surveyQuestionId."'>
					  </div>
					 </div>
					</div>";
					break;
				}					
			}
			if(!$respFound)
			{
				 $answerBoxDiv = $answerBoxDiv."<div class='col-md-4'>
				 <div class='row form-group'>
				  <label class='col-md-12 control-label' for='textinput'>".$answer->{text}."</label>
				  <div class='col-md-12'>
					<input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
					<input id='' name='position' value='".$answer->{answer_id}."_".$answer->{position}."' class='form-control input-md' type='hidden'>
					<input id='' name='numericText_".$answer->{answer_id}."'  class='form-control input-md ".$surveyQuestion->{type}->{subtype}." txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' type='text' value='' data='".$surveyQuestionId."'>
				  </div>
				 </div>
				 </div>";
			}
		}
		  
	}
	$answerBoxNumeric = $openDiv.$answerBoxDiv.$closeDiv;
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxNumeric=$answerBoxNumeric."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxNumeric;
}
function dateTime_dateOnly($answers,$surveyresponses,$surveyQuestion,$surveyQuestionId,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$accessList = $metaDataInfo->{accessList};
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
		
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			$dateResponse = "";
			$respFound = false;
			foreach($surveyresponses as $responseData)
			{				
				if($responseData->{answer_id} == $answer->{answer_id})
				{
					$respFound = true;
					$surveyresponsesId  =$responseData->{answer_id};	
			$answerBoxDateOnly =$answerBoxDateOnly." <div class='row Legal-Name'>
						  <div class='col-md-8'>
							<div class='row form-group'>
							 <label class='col-md-3 control-label label-left-align' for='textinput'>".$answer->{text}."</label>
							  <div class='col-md-6'>
							   
							  <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
							  <div class='a_".$surveyQuestion->{type}->{subtype}." Subsequent-date ".$readOnly."'' id='date_".$answer->{answer_id}."'>
							  <input type='text' id='date_".$answer->{answer_id}."_dateInput' name='date_only_".$answer->{answer_id}."' value='".$responseData->{text}."'  class='form-control input-md  txt dateFocus ".$readOnly." ".$confirmClass." ".$mandatoryResp."' data='".$surveyQuestionId."' placeholder='mm/dd/yyyy' answerId='".$answer->{answer_id}."'/>
							   <span class='input-group-addon txt ".$confirmClass." ".$mandatoryResp."' style='background: transparent; border: medium none; padding-left: 8px;display:none'>
<img style='width: 30px; margin-top: -4px;' src='/gladstone/portal/bloom/vitals/images/calender.png' />
</span>
								</div>
							  </div>
							</div>
						  </div>
						  <span class='span-left-align error err_".$answer->{answer_id}."'> Invalid Date.(mm/dd/yyyy)</span>
						</div>";
						break;
					}
					
			 }
			 if(!$respFound)
			 {
			 	$answerBoxDateOnly =$answerBoxDateOnly." <div class='row Legal-Name'>
						  <div class='col-md-8'>
							<div class='row form-group'>
							 <label class='col-md-3 control-label label-left-align' for='textinput'>".$answer->{text}."</label>
							  <div class='col-md-6'>
							   
							  <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
							  <div class='a_".$surveyQuestion->{type}->{subtype}." Subsequent-date ".$readOnly."'' id='date_".$answer->{answer_id}."'>
							  <input type='text' id='date_".$answer->{answer_id}."_dateInput' name='date_only_".$answer->{answer_id}."'   class='form-control input-md  txt dateFocus ".$readOnly." ".$confirmClass." ".$mandatoryResp."' data='".$surveyQuestionId."' placeholder='mm/dd/yyyy' answerId='".$answer->{answer_id}."'/>
							   <span class='input-group-addon txt ".$confirmClass." ".$mandatoryResp."' style='background: transparent; border: medium none; padding-left: 8px;display:none'>
<img style='width: 30px; margin-top: -4px;' src='/gladstone/portal/bloom/vitals/images/calender.png' />
</span>
								</div>
							  </div>
							</div>
						  </div>
						  <span class='span-left-align error err_".$answer->{answer_id}."'> Invalid Date.(mm/dd/yyyy)</span>
						</div>";
			 }				
		}
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxDateOnly=$answerBoxDateOnly."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxDateOnly;
}
function demo_international($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
			
	$entityUtil = new EntityUtil();
	$statesInfo=$entityUtil->getObjectFromServer("BLANK", "getStateList", VMCPortalConstants::$API_ADMIN);
	$respFound = false;
	$surveyText = "";
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			foreach($surveyresponses as $responseData)
			{
				if($responseData->{answer_id} == $answer->{answer_id})
				{
					$respFound = true;
					$surveyresponsesId  =$responseData->{answer_id};
					$surveyText = $responseData->{text};
					
				}
			}
			if($surveyresponsesId  == $answer->{answer_id})
			{				
				if($answer->{type} == "state")
				{					
				$answerBoxInternational =  $answerBoxInternational." <div class='form-group'>
							  <label class='col-md-3'>".$answer->{text}."</label>
							  <div class='col-md-6'>
								  <select name='numericText_".$answer->{answer_id}."' class='form-control txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' data='".$surveyQuestionId."'>
							  <option value='' selected='selected'> Select State</option>";
							foreach($statesInfo as $state)
							{
							   if($state->{stateCode} == $surveyText)
							   {
									$answerBoxInternational = $answerBoxInternational."<option value='".$state->{stateCode}."' selected='selected'>".$state->{stateCode}."</option>";
							   }
							   else
							   {
									$answerBoxInternational = $answerBoxInternational."<option value='".$state->{stateCode}."' >".$state->{stateCode}."</option>";

							   }
							}																
							  $answerBoxInternational = $answerBoxInternational."</select>
							  <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
							  </div>
							</div>";
				}
				else
				{
				
					$answerBoxInternational =  $answerBoxInternational." <div class='form-group'>
								  <label class='col-md-3'>".$answer->{text}."</label>
								  <div class='col-md-6'>
									  <input type='text' placeholder='".$answer->{text}."' class='form-control txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' value= '".$surveyText."'name='numericText_".$answer->{answer_id}."' data='".$surveyQuestionId."' >
								  <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
								  </div>
								</div>";
				}			
			}
			else
			{			
				if($answer->{type} == "state")
				{
					$answerBoxInternational =  $answerBoxInternational." <div class='form-group'>
								  <label class='col-md-3'>".$answer->{text}."</label>
								  <div class='col-md-6'>
								  <select name='numericText_".$answer->{answer_id}."' class='form-control txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' data='".$surveyQuestionId."'>
								  <option value='' selected='selected'> Select State</option>";
								  foreach($statesInfo as $state)
								  {
										$answerBoxInternational = $answerBoxInternational. "<option value='".$state->{stateCode}."'>".$state->{stateCode}."</option>";
								  }																
								  $answerBoxInternational = $answerBoxInternational."</select>
								  <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
								  </div>
								</div>";
				}
				else
				{ 				
					$answerBoxInternational =  $answerBoxInternational." <div class='form-group'>
								  <label class='col-md-3'>".$answer->{text}."</label>
								  <div class='col-md-6'>
								  <input type='text' placeholder='".$answer->{text}."' class='form-control txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' value= '' name='numericText_".$answer->{answer_id}."' data='".$surveyQuestionId."'>
								  <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
								  </div>
								</div>";
				}
			}
		}
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxInternational=$answerBoxInternational."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxInternational;
}
function metrix_rating_single($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	$cols = 0 ;
	$rows = 0;		
	foreach($answers as $answer)
	{
		if($answer->{visible})
		{
			if($answer->{type} == "col")
			{	
				//$th = $th." <th>".$answer->{text}."</th>";									
				$cols++;
			}
			if($answer->{type} == "row")
			{	
				$rows++;
			}
		}
	}
	$isOther = false;
	foreach($answers as $answer)
	{		
		if($answer->{visible})
		{
			$respFound = false;
			
			if($answer->{type} == "row")
			{ 
				$answerBoxRating = $answerBoxRating."<tr>";
				$answerBoxRating =  $answerBoxRating."<td class='matrixRow'>".$answer->{text}."</td>";
				
				foreach($answers as $col)
				{
					if($col->{type} == "col")
					{ 
						foreach($surveyresponses as $responseData)
						{
							 $splitResp = explode("_",$responseData->{answer_id});
							 // As we are sending ASNWER `in text and selected Answer in another Answer_id so we need AND condition here
							if($splitResp[0] == $answer->{answer_id} 
								AND $splitResp[1] == $col->{answer_id})
							{
								$respAnswerId = $splitResp[0];
								$respColId = $splitResp[1];
																	
							}
						}
						if($respAnswerId == $answer->{answer_id} 
								AND $respColId == $col->{answer_id})
						{
							
							$answerBoxRating = $answerBoxRating."<td><input id='".$answer->{answer_id}."_".$surveyQuestionId."' type='radio' class='radio txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' name='rating_".$answer->{answer_id}."' value='".$col->{answer_id}."_".$answer->{answer_id}."' checked='checked' data='".$surveyQuestionId."' questionId='".$col->{answer_id}."_".$answer->{answer_id}."'/></td>
							<input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md hiddenBoxRadio' type='hidden'>";
						}
						else
						{
							$answerBoxRating = $answerBoxRating."<td><input id='".$answer->{answer_id}."_".$surveyQuestionId."' type='radio' class='radio txt ".$readOnly." ".$confirmClass." ".$mandatoryResp."' name='rating_".$answer->{answer_id}."' value='".$col->{answer_id}."_".$answer->{answer_id}."' data='".$surveyQuestionId."' questionId='".$col->{answer_id}."_".$answer->{answer_id}."'/></td>";
						}
						$respFound = false;
					}				 
				}
				$answerBoxRating = $answerBoxRating."</tr>";				
			}
			else if($answer->{type} == "other")
			{
				$isOther = true;
				$optinOther = "";
				foreach($surveyresponses as $surveyresp)
				{
					 // As we are sending ASNWER `in text and selected Answer in another Answer_id so we need AND condition here
					if($surveyresp->{text} != "" AND $surveyresp->{answer_id} == $answer->{answer_id})
					{
						
						$otherText = $surveyresp->{text};
					}
				}
				if($otherText != "")
				{
				  $optinOther = "<input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md hiddenBox' type='hidden'>";
				}
					$otherBox = "<tr><td class='otherTextBox' colspan='".count($answers)."'>
						<div class='row form-group'>
				  <div class='col-md-12 CommetBox matrixComment'>".$optinOther."
					<textarea class='form-control extraComment ".$readOnly."' placeholder='Add comments..' rows='2'  name='otherComment_".$answer->{answer_id}."' data='".$answer->{answer_id}."_".$surveyQuestionId."'>".$otherText."</textarea>
				
				  </div>
				</div></td></tr>";
				
			}
			

		}
	}
	if($isOther)
	{
	$answerBoxRating =$answerBoxRating.$otherBox;
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxRating=$answerBoxRating."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxRating;
}
function metrixMulti($answers,$surveyresponses,$surveyQuestionId,$metaDataInfo,$confirmationInfo)
{
	$accessLevel = "";
	$readOnly = "";
	$isMandatoryResp = $metaDataInfo->{mandatory}; 
	$mandatoryResp = "";
	if($isMandatoryResp)
	{
		$mandatoryResp = "mandatoryResp";
	}
	else
	{
		$mandatoryResp = "";
	}
	$confirmationResp = $confirmationInfo->{response};
	$confirmClass = "";
	if($confirmationResp != "" || $confirmationResp != null)
	{
		$confirmClass = "confirmClass";
	}
	else
	{
		$confirmClass = "";
	}
	$accessList = $metaDataInfo->{accessList}; 
	foreach($accessList as $access)
	{
		if(strtoupper($access->{roleName}) == strtoupper($_COOKIE['type']))
		{
			$accessLevel = $access->{accessLevel};			
		}
	}
		if($accessLevel == "EDIT")
		{
			$readOnly = "";
		}
		else if($accessLevel == "READ_ONLY")
		{
			$readOnly = "isDisabled";
		}
		else
		{
			$readOnly = "";
		}
	$cols = 0 ;
	$rows = 0;	
	foreach($answers as $answer)
	{		
		if($answer->{visible})
		{			
			if($answer->{type} == "col")
			{	
				
				//$th = $th." <th>".$answer->{text}."</th>";									
				$cols++;
				
			}
			if($answer->{type} == "row")
			{	
				
										
				$rows++;
				
			}				
		}
	}
	foreach($answers as $answer)
	{ 		
		if($answer->{visible})
		{	
			$respFound = false;
			
			if($answer->{type} == "row")
			{ 	
				$answerBoxMetMulti = $answerBoxMetMulti."<tr>";
				$answerBoxMetMulti =  $answerBoxMetMulti." <input id='' name='options[]' value='".$answer->{answer_id}."_".$surveyQuestionId."' class='form-control input-md' type='hidden'>
				<td class='matrixRow'>".$answer->{text}."</td>";
				
				foreach($answers as $col)
				{	
				    if($col->{type} == "col")
					{	
						foreach($surveyresponses as $responseData)
						{							
							if($responseData->{text} == $answer->{answer_id}AND $responseData->{answer_id} == $col->{answer_id})
							{								
								$respFound = true;
								$answerBoxMetMulti = $answerBoxMetMulti."<td><input id='".$col->{answer_id}."_".$answer->{answer_id}."' type='checkbox' class='check txt1 ".$readOnly." ".$confirmClass." ".$mandatoryResp."' name='r".$answer->{answer_id}."[]' value='".$col->{answer_id}."_".$answer->{answer_id}."' checked='checked' data='".$surveyQuestionId."'/></td>";									
							}						
						}					
						if(!$respFound)
						{
							$answerBoxMetMulti = $answerBoxMetMulti."<td><input id='".$col->{answer_id}."_".$answer->{answer_id}."' type='checkbox' class='check txt1 ".$readOnly." ".$confirmClass." ".$mandatoryResp."' name='r".$answer->{answer_id}."[]' value='".$col->{answer_id}."_".$answer->{answer_id}."' data='".$surveyQuestionId."'/></td>";
						}
						$respFound = false;
					}
				}
				$answerBoxMetMulti = $answerBoxMetMulti."</tr>";
			}
		}
	}
	if($surveyresponses && $isMandatoryResp)
	{
		$answerBoxMetMulti=$answerBoxMetMulti."<input type='hidden' name='mandatory[]' value='".$surveyQuestionId."' id='mandatory_".$surveyQuestionId."' class='mandatoryQuestions'/>";
	}
	return $answerBoxMetMulti;
}
//Confirmation boxes
function confirmationBox($question_id,$confirmationResponse)
{
	
	$textArray = ['Correct','Incorrect','Not Sure'];
	$answerConfirmation="";
	for($i=0;$i<count($textArray);$i++)
	{
		if($confirmationResponse == $textArray[$i])
		{
		$answerConfirmation= $answerConfirmation."<input name='confirmationBox[]' id='confirmHidden".$textArray[$i]."' value='".$textArray[$i]."_".$question_id."' class='form-control input-md confirmHidden' type='hidden'><a class='padTop10 active confirmation' id='".$textArray[$i]."_".$question_id."' href='#'>".$textArray[$i]."</a>";
		}
		else
		{
		$answerConfirmation= $answerConfirmation."<a class='padTop10 confirmation' id='".$textArray[$i]."_".$question_id."' href='#'>".$textArray[$i]."</a>";
		}
					
	}			
						
		
	return $answerConfirmation;
}
?>