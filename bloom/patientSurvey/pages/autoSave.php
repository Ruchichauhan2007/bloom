<?php
include ('controller/dashboard_controller.php');
$surveyId = $_POST['surveyId'];
$pageId =   $_POST['pageId'];
$patientId =   $_POST['patientId'];
$uniqueSurveyId =   $_POST['uniqueSurveyId'];
	if(isset($_POST['complete']))
	{	
		try
		{
			$surveyId = $_POST['surveyId'];
			$pageId =   $_POST['pageId'];
			$patientId =   $_POST['patientId'];
			$uniqueSurveyId =   $_POST['uniqueSurveyId'];

			$entityUtil = new EntityUtil();
			$msg = "";
			$paramArray = array();			
			if($_COOKIE['type'] == 'Patient' or $_COOKIE['type'] == 'PATIENT' or $_COOKIE['type'] == 'patient')
			{
				$patientId = $entityUtil->getLoggedInEntityId();
			}
			
			$paramArray[0] = $patientId;
			$paramArray[1] = $surveyId;
			$paramArray[2] = $pageId;	
			$paramArray[3] = $uniqueSurveyId;			
		
			$surveyPage = $entityUtil->getObjectFromServer($paramArray, "getPatientSurveyByPageId", VMCPortalConstants::$API_ADMIN);
			
			$m_SurveyConfigQuestionInfo->type = $surveyPage->{type};			
			$heading = $surveyPage->{heading};
			$questions = $surveyPage->{questions};
			$metaInfo = $surveyPage->{metaInfo};
			$responses = array();
			
			$numericTextCount = count($numericText);
				
			foreach ($_POST[options] as $key => $value)
			{
				if (empty($value))
				{
					unset($_POST[options][$key]);
				}
			}
			
			$setoptions = array_values($_POST[options]);
			/*foreach($setoptions as $options)
			{*/
				foreach($questions as $question)
					{
						$question->responses = array();
					}
			//}
			foreach($setoptions as $options)
			{	
				$value = explode("_",$options);
				$answerId = $value[0];
				$questionId = $value[1];
				
				foreach($questions as $question)
				{
					$confirmation = "";
					$confirmationInfo = $question->{confirmationInfo};
					$questionMetaInfo = $question->{metaInfo};
					$choice = $question->{type}->{family};
					$sub_choice = $question->{type}->{subtype};					
					if($choice == "single_choice" || $choice == "multiple_choice" || $choice == "datetime" 
						|| $choice == "open_ended" || $choice == "demographic" || $choice == "matrix")
					{
						
						foreach ($_POST[confirmationBox] as $key => $value)
						{
							if (empty($value))
							{
								unset($_POST[confirmationBox][$key]);
							}
						}
			
						$setconfirmationvalues = array_values($_POST[confirmationBox]);
						if($confirmationInfo)
						{
							if(strtoupper($_COOKIE["type"]) == "PATIENT")
							{
								foreach($setconfirmationvalues as $setconfirmationvalue)
								{	
									$value = explode("_",$setconfirmationvalue);
									$confirmationOption = $value[0];
									$confirmationQuesId = $value[1];									
									if($confirmationQuesId == $question->{question_id})
									{									
										$confirmation = $confirmationOption;										
										$confirmationInfo->{response} = $confirmation;									
										$question->confirmationInfo = $confirmationInfo;
									}
								}
							}
							else if(strtoupper($_COOKIE["type"]) == "PROVIDER")
							{
								
								foreach ($_POST[confirmationHidden] as $key => $value)
								{
									if (empty($value))
									{
										unset($_POST[confirmationHidden][$key]);
									}
								}					
								$confirmationHiddens = array_values($_POST[confirmationHidden]);
								foreach($confirmationHiddens as $confirmationHidden)
								{	
									if($confirmationHidden == $question->{question_id})
									{
									$confirmationInfo->{response} = "";									
									$question->confirmationInfo = $confirmationInfo;
									}
								}
							}
						}
						if($question->{question_id} == $questionId || $choice == "open_ended")
						{
							
							$answers = $question->{answers};
							$responses = $question->{responses};
							//var_dump($responses);
							if($choice != "open_ended")
							{
								foreach($answers as $answer)
								{
									if($answer->{answer_id} == $answerId)
									{
										if($choice== "single_choice")
										{
											
											if($answer->{type} == "other")
											{
												$text = "";
												if($_POST['extraComment_'.$answerId] != "")
												{
													$text = $_POST['extraComment_'.$answerId];
												}
												$m_SurveyConfigQuestionAnswerInfo = new stdClass;												
												$m_SurveyConfigQuestionAnswerInfo->text = $text;
												$m_SurveyConfigQuestionAnswerInfo->visible = true;
												$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;														
												$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
												
											}
											else
											{
												$responses[0] = $answer;												
																							
												
											}
											
										}
										else if($choice== "multiple_choice")
										{
											$tempResponse = $responses; 
											//var_dump(count($tempResponse));
											if(count($tempResponse) > 0)
											{
												if($answer->{type} == "other")
												{
													$text = "";
													if($_POST['extraComment_'.$answerId] != "")
													{
														$text = $_POST['extraComment_'.$answerId];
													}
													$m_SurveyConfigQuestionAnswerInfo = new stdClass;												
													$m_SurveyConfigQuestionAnswerInfo->text = $text;
													$m_SurveyConfigQuestionAnswerInfo->visible = true;
													$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;														
													$responses[count($tempResponse)] = $m_SurveyConfigQuestionAnswerInfo;
													
												}
												else
												{
													$responses[count($tempResponse)]  = $answer;
												}
												
											}
											else
											{
												if($answer->{type} == "other")
												{
													$text = "";
													if($_POST['extraComment_'.$answerId] != "")
													{
														$text = $_POST['extraComment_'.$answerId];
													}
													$m_SurveyConfigQuestionAnswerInfo = new stdClass;												
													$m_SurveyConfigQuestionAnswerInfo->text = $text;
													$m_SurveyConfigQuestionAnswerInfo->visible = true;
													$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;														
													$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
													
												}
												else
												{
													$responses[0] = $answer;
												}
												
											}
											//$confirmationInfo->{response} = $confirmation;
										}
										else if($choice== "datetime")
										{
											if($sub_choice == "date_only")
											{
												$tempResponse = $responses;	
												foreach($answers as $answer)
												{
													if($answer->{answer_id} == $answerId && $_POST['date_only_'.$answerId] != "")
													{
														$m_SurveyConfigQuestionAnswerInfo = new stdClass;
														if(count($tempResponse) > 0)
														{												
															$m_SurveyConfigQuestionAnswerInfo->text = $_POST['date_only_'.$answerId];
															$m_SurveyConfigQuestionAnswerInfo->visible = true;	
															$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;													
															$responses[count($tempResponse)] = $m_SurveyConfigQuestionAnswerInfo;
														}
														else
														{
															$m_SurveyConfigQuestionAnswerInfo->text = $_POST['date_only_'.$answerId];
															$m_SurveyConfigQuestionAnswerInfo->visible = true;	
															$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;													
															$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
														}
													}
												}
												
											}
											//$confirmationInfo->{response} = $confirmation;
										}
										else if($sub_choice == "rating" || $sub_choice == "single")
										{	
								
											$answers = $question->{answers};
											$responses = $question->{responses};
											
											
												
											foreach($answers as $answer)
											{
												
												if($answer->{type} == "row")
												{ 
													if ($answer->{answer_id} == $answerId)
													{
														foreach($answers as $col)
														{
															
															if($col->{type} == "col")
															{ 
																
																$getIds = explode("_",$_POST['rating_'.$answerId]);
																 $col_id = $getIds[0];
																 $row_id = $getIds[1];
																if($col->{answer_id} == $col_id) 
																{ 
																	if(!isset($_POST['rating_'.$answerId]))
																	{
																		return false;
																	}
																	$m_SurveyConfigQuestionAnswerInfo = new stdClass;
																	$m_SurveyConfigQuestionAnswerInfo->answer_id = $row_id."_".$col_id ;
																	$m_SurveyConfigQuestionAnswerInfo->type = "col";
																	$m_SurveyConfigQuestionAnswerInfo->visible = true;
																	$m_SurveyConfigQuestionAnswerInfo->scaleValue = $col->scaleValue;
																	$m_SurveyConfigQuestionAnswerInfo->text = $col->{text};	
																	
																	if(count($responses) > 0)
																	{	
																		if($_POST["surveyName"] == "Kannact_s Multivector Assessment")
																		{														
																			$responses[1] = $m_SurveyConfigQuestionAnswerInfo;
																		}
																		else
																		{																			
																			$responses[count($responses)] = $m_SurveyConfigQuestionAnswerInfo;
																		}
																	}
																	else
																	{
																		$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
																	}										
																	
																}
																
															}
															
															
															
														}
														
													}
													
													
												}
												else if($answer->{type} == "other")
												{
													
												//	if ($answer->{answer_id} == $answerId)
												//	{
													
														$otherAnswer = true;
														$text = "";
														if($_POST['otherComment_'.$answer->{answer_id}] != "")
														{
															$text = $_POST['otherComment_'.$answer->{answer_id}];				
															$m_SurveyConfigQuestionOtherInfo = new stdClass;									
															$m_SurveyConfigQuestionOtherInfo->text = $text;
															$m_SurveyConfigQuestionOtherInfo->visible = true;
															$m_SurveyConfigQuestionOtherInfo->answer_id = $answer->{answer_id};
															$m_SurveyConfigQuestionOtherInfo->type = "other";												
															if(count($responses) > 0){
																if($responses[0]->{type} == "other")
																{
																	$responses[0] = $m_SurveyConfigQuestionOtherInfo;	
																}
																else
																{																
																	$responses[1] = $m_SurveyConfigQuestionOtherInfo;
																}
															}else {
															$responses[0] = $m_SurveyConfigQuestionOtherInfo;
															}
														}															
													//}
												}

												
											}	
											//$confirmationInfo->{response} = $confirmation;								
											
										}
										else if($sub_choice == "multi")
										{	
											$tempResponse = $responses;
											$m_SurveyConfigQuestionAnswerInfo = new stdClass;	
										
											foreach($answers as $answer)
											{
												if($answer->{answer_id} == $answerId && $answer->{type} == "row" )
												{ 
													foreach ($_POST['r'.$answerId] as $key => $value)
													{
														if (empty($value))
														{
															unset($_POST['r'.$answerId][$key]);
														}
													}
												
													$setRatings = array_values($_POST['r'.$answerId]);
													foreach($setRatings as $setRating)
													{
														$getData = explode("_",$setRating);
														$colId = $getData[0];
														$rowId = $getData[1];
														
														foreach($answers as $col)
														{
															if($col->{type} == "col")
															{ 
																if($col->{answer_id} == $colId)
																{ 
																	
																	$m_SurveyConfigQuestionAnswerInfo = new stdClass;
																	$m_SurveyConfigQuestionAnswerInfo->answer_id = $colId ;
																	$m_SurveyConfigQuestionAnswerInfo->type = "col";
																	$m_SurveyConfigQuestionAnswerInfo->visible = true;
																	$m_SurveyConfigQuestionAnswerInfo->text = $rowId;
																	if(count($responses) > 0)
																	{
																		$responses[count($responses)] = $m_SurveyConfigQuestionAnswerInfo;
																	}
																	else
																	{														
																		$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
																	}
																	//var_dump($responses);
																}
																	
															} 
														}
														
														
													}
													

												}
													
											}
											//$confirmationInfo->{response} = $confirmation;									
											
										}
						// end matrix(multi)
									}
								}
							}
							
							if ($choice == "open_ended" || $choice == "demographic")
							{
							
								if($sub_choice == "essay" || $sub_choice == "single")
								{
								
									foreach ($_POST['essay_questionId'] as $key => $value)
									{
										if (empty($value))
										{
											unset($_POST['essay_questionId'][$key]);
										}
									}
									$essay_questionsId = array_values($_POST['essay_questionId']);
									foreach($essay_questionsId as $essay_questionId)
									{
										
										if($question->{question_id} == $essay_questionId && $_POST[$question->{question_id}]!= "")
										{
											$m_SurveyConfigQuestionAnswerInfo = new stdClass;
											$m_SurveyConfigQuestionAnswerInfo->text = $_POST[$question->{question_id}];										
											$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
											
										}
									}
								}
								else if($sub_choice == "numerical" || $sub_choice == "multi")
								{	
									$tempResponse = $responses;	
										
										foreach($answers as $answer)
										{
											if($answer->{answer_id} == $answerId && $_POST['numericText_'.$answerId] != "")
											{ 				
													$numericText = $_POST['numericText_'.$answerId];
																		
													$m_SurveyConfigQuestionAnswerInfo = new stdClass;
													if(count($tempResponse) > 0)
													{
														
														$m_SurveyConfigQuestionAnswerInfo->text = $numericText;
														$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;										
														$responses[count($tempResponse)] = $m_SurveyConfigQuestionAnswerInfo;
														
													}
													else
													{														
														$m_SurveyConfigQuestionAnswerInfo->text = $numericText;	
														$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;																						
														$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
													}
												
											}
										}									
									//$confirmationInfo->{response} = $confirmation;		
								}
								else if($sub_choice == "international")
								{	
								
									$tempResponse = $responses;	
										
										foreach($answers as $answer)
										{
											if($answer->{answer_id} == $answerId && $_POST['numericText_'.$answerId]!= "") 
											{ 				
													$numericText = $_POST['numericText_'.$answerId];
																		
													$m_SurveyConfigQuestionAnswerInfo = new stdClass;
													if(count($tempResponse) > 0)
													{
														
														$m_SurveyConfigQuestionAnswerInfo->text = $numericText;
														$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;										
														$m_SurveyConfigQuestionAnswerInfo->visible = true;										
														$responses[count($tempResponse)] = $m_SurveyConfigQuestionAnswerInfo;
														
													}
													else
													{														
														$m_SurveyConfigQuestionAnswerInfo->text = $numericText;	
														$m_SurveyConfigQuestionAnswerInfo->answer_id = $answerId;																						
														$m_SurveyConfigQuestionAnswerInfo->visible = true;																						
														$responses[0] = $m_SurveyConfigQuestionAnswerInfo;
													}
												
											}
										}									
									//$confirmationInfo->{response} = $confirmation;		
								}
								
								
							}
							$question->responses = $responses;
							$question->metaInfo = $questionMetaInfo;
							
						}
					}
				}		
			}
						
			$m_SurveyConfigPageInfo->questions =  $questions;
			$m_SurveyConfigPageInfo->page_id = $pageId;
			$m_SurveyConfigPageInfo->heading = $heading;
			$m_SurveyConfigPageInfo->metaInfo = $metaInfo;
			$m_SurveyResponseInfo->responsePage = $m_SurveyConfigPageInfo;
			
			$m_SurveyResponseInfo->patientId = $patientId;
			$m_SurveyResponseInfo->survey_id = $surveyId;
			$m_SurveyResponseInfo->uniqueSurveyId = $uniqueSurveyId;
			if(isset($_POST["inComplete"]))
			{
				$m_SurveyResponseInfo->pageCompleted  = false;
			}
			else
			{
				$m_SurveyResponseInfo->pageCompleted  = true;
			}
			$m_SurveyResponseInfo->state  = VMCPortalConstants::$UPDATE;
						
			$paramArray = array();			
			$paramArray[0] = json_encode($m_SurveyResponseInfo);
			//var_dump($paramArray);
			$responseInfo = $entityUtil->postObjectToServer($paramArray, "UpdatePatientSurvey", VMCPortalConstants::$API_ADMIN);
			if(!isset($_POST['redirect']))
			{
				header("Location:survey.php?patientId=".$patientId."&surveyId=".$surveyId."&pageId=".$pageId."&uniqueSurveyId=".$uniqueSurveyId);
			}
		}
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}
	else
	{
		if(isset($_POST['surveyId'] && $_POST['pageId']))
	{	
		try
		{
			$entityUtil = new EntityUtil();
			$msg = "";
			$paramArray = array();			
			if($_COOKIE['type'] == 'Patient' or $_COOKIE['type'] == 'PATIENT' or $_COOKIE['type'] == 'patient')
			{
				$patientId = $entityUtil->getLoggedInEntityId();
			}
			
			$paramArray[0] = $patientId;
			$paramArray[1] = $surveyId;
			$paramArray[2] = $pageId;
			$paramArray[3] = $uniqueSurveyId;			
			$surveyPage = $entityUtil->getObjectFromServer($paramArray, "getPatientSurveyByPageId", VMCPortalConstants::$API_ADMIN);
			
		}
		catch(Exception $e)
		{
			$msg = $e->getMessage();
		}
	}

	}
?>

