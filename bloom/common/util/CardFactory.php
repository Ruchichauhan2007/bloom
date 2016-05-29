<?php
include 'DateUtil.php';
include 'Constants.php';
$serverimgpath = constants::$WEB_ROOT;
$imgKey =  constants::$IMAGE_KEY;

function   addDashboardCards($portalcards, $type)
{
	
$userType = $_COOKIE['type'];
	$dateUtil = new DateUtil();
	$htmlCard = "";
	$cardColor = "";
	$vitalTrends="";
	$serverimgpath = constants::$WEB_ROOT;
	$imgKey =  constants::$IMAGE_KEY;

	foreach($portalcards as $ptcard)
	{
		$dbCardType = $ptcard->{cardType};
		$patient_id = $ptcard->{patientId};
		$contentDatas = $ptcard->{contentData};
		if(count($contentDatas) == 1)
		{
			foreach($contentDatas as $contentData)
			{
				$avatar = $ptcard->{avatar};
				if($avatar === "default.svg" OR $avatar === "")
				{
					$imgPath = "/gladstone/portal/bloom/common/images/default.svg";
				}
				else
				{
				//https://mainlinetest.vismc.com/gladstone/imagepath/mainlinetest.vismc.com/image/avatar/picture/69_1.JPEG
					$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
				}
		
				$name = "";
		
				if($ptcard->{patientId} != $ptcard->{createdUserId})
				{
					$name = $contentData->{providerLastName}." ".$contentData->{providerFirstName}." ".$contentData->{credentials};
					$messageCardIcon = "../images/PortProvCard_Message.jpg";
				}
				else
				{
					$name = $ptcard->{patLastName}." ".$ptcard->{patFirstName};
					$messageCardIcon = "../images/PortPtCard_Message.jpg";
		
		
				}
				
				
				if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE" || $ptcard->{alertNotification} == "true" && $dbCardType == "STICKY_NOTE" || $ptcard->{alertNotification} == "true" && $dbCardType == "CARE_COMMUNICATION")
				{
					$mainDivClass="ALERTS";
				 
				}
				else
				{
					$mainDivClass="";
				}
				
				
				
				
				if($ptcard->{viewedUserId} != "")
				{
					$isReview="isReviewed";
					$reviewDiv="<div class='cardPanel dashboardCards ".$isReview."' id=".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}." cartType='".$userType."'  style='display:none'>";
				}
				else
				{
					$reviewDiv="<div class='cardPanel dashboardCards ".$ptcard->{cardType}." providerFilterClass".$ptcard->{providerId}." ".$mainDivClass."' cartType='".$userType."' id='".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."' ref='".$ptcard->{patientId}."'>";
				}
				// Sticky Note Card
				if($dbCardType == "STICKY_NOTE" && $ptcard->{alertNotification} != "true")
				{
					$cardColor = "yellow-card-action";
					$title = substr($contentData->{title},0,20);
		
						if(strlen($title) == 20)
							$title = $title.'...';
					$htmlCard = $htmlCard.$reviewDiv."<div class='message_box_bg Admin text-left'>
					<div class='message_box_bg_blue'>
					<h2>".$name."</h2>
					<h4>".$ptcard->{createTimestamp}."</h4>
					</div>
					<div class='message_text_cl'>
						<h3 id=TITLE_".$ptcard->{dashboardDetailId}.">".$title."</h3>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$imgPath."' id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='notes'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."'  name='".$imgPath."' onclick='Cards(this.id);'>
					<button class='btn-icon' id=".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}." onclick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);'></button>
				</a>
			</div>";
			}
				// Education Content - VIDEO or PDF
			else if($dbCardType == "PDF_NEW" OR $dbCardType == "VIDEO_NEW" OR $dbCardType == "PDF_VIEWED" OR $dbCardType == "VIDEO_VIEWED")
			{
			 $cardColor = "purple-card-action";
			if($dbCardType == "PDF_NEW" OR $dbCardType == "PDF_VIEWED" )			$imageNamePath = "../images/dashboard_content_pdf.jpg";
			else if($dbCardType == "VIDEO_NEW" OR $dbCardType == "VIDEO_VIEWED")		$imageNamePath = "../images/dashboard_content_video.png";
		
			$patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
			$title = substr($contentData->{title},0,15);
		
						if(strlen($title) == 15)
							$title = $title.'...';
			$viewed = "";
			if($dbCardType == "PDF_VIEWED" OR $dbCardType == "VIDEO_VIEWED")
			{
				$viewed = "Viewed";
			}
			$htmlCard = $htmlCard.$reviewDiv."
			<div class='message_box_bg Admin text-left ".$vitalTrends."'>
					<div class='message_box_bg_blue'>
					<h2>".$patientName."</h2>
					<h4>".$ptcard->{createTimestamp}."</h4>
					<h3 class='yellow-card-h3'><i>".$viewed."</i></h3>
					</div>
					<div class='desc'>".$title."</div>
					<div class='message_text_cl'>
						<h2>".$reading." <span class='patient-status ".$dbCardType."'>".$vitalName."<span></h2>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$imageNamePath."'id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='pdf_video'  alt='".$patientName."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>
					<button class='btn-icon' id=".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}." onclick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);'></button>
				</a>
			</div>";
		}
		else if($dbCardType == "CALL_MISSED_INCOMING" OR $dbCardType == "CALL_MISSED_OUTGOING" OR $dbCardType == "CALL_SERVICED_INCOMING" OR $dbCardType == "CALL_SERVICED_OUTGOING"){
			$cardColor = "";
			$callerName = $ptcard->{patLastName}->{patFirstName};
			$receiverName = $contentData->{providerLastName}.",".$contentData->{providerFirstName};
			$imageNamePath = "";
			if($dbCardType == "CALL_MISSED_INCOMING")
			{
				$reasonForCall = $contentData->{reasonForCall};
				$imageNamePath = "../images/dashboard_missed_incoming.jpg";
			}
			else if($dbCardType == "CALL_MISSED_OUTGOING")
			{
				$imageNamePath = "../images/dashboard_missed_outgoing.jpg";
			}
			else if($dbCardType == "CALL_SERVICED_INCOMING")
			{
				$reasonForCall = $contentData->{reasonForCall};
				$imageNamePath = "../images/dashboard_serviced_incoming.jpg";
			}
			else if($dbCardType == "CALL_SERVICED_OUTGOING")
			{
				$imageNamePath = "../images/dashboard_serviced_outgoing.jpg";
			}
		
			$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2 Prov_img_on_dashbord'>
			<a href='#' class='".$cardColor."'>
		
			<img src='".$imageNamePath."'id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='pdf_video'  alt='".$callerName."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/></a>
		
			</a>
		</div>
		<div class='col-md-6 Admin text-left'>
			<h4 class=''>".$callerName."</h4>
			<h3 class='yellow-card-h3'>".$contentData->{title}."</h3>
			<p>".$receiverName." ".$reasonForCall."</p>
		</div>
		<div class='col-md-3 ActionPlan right-card'>
			<button class='btn btn-green' id=".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}." onclick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);'>Review</button>
		
		</div>
		<div class='col-md-1 AdminImg right-card'>
			<img class='dashboard_img' src='".$imgPath."' />
		</div>
		<div class='col-md-4 PatCardTime PatCardTime2'>
			<h5 class='time_date second-h5-b text-left'>".$ptcard->{createTimestamp}."</h5>
		</div>
		</div>";
		}
		else if(($dbCardType == "VITALS_OUT_OF_RANGE" OR $dbCardType == "VITALS_ACCEPTABLE" OR $dbCardType == "VITALS_MISSED" OR $dbCardType == "VITALS_TREND")
		&&($contentData->{vitalName} != "Diastolic" || $contentData->{vitalName} != "Systolic"))
		{
			
			$vitalReading = "";
			$entityUtil = new EntityUtil();
			$paramArray = array();
			$allDevices = $entityUtil->getObjectWithoutFilter($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
			foreach($allDevices as $eachDevice)
			{	$deviceName = strtoupper($eachDevice->{measurementName1});
				if($deviceName == strtoupper($contentData->{vitalName}))
				{
					if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$WEIGHT)
						{
							$vitalId = $eachDevice->{deviceConfigId};
							$vitalReading = contentData->{vitalUnits};
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$GLUCOSE)
						{
							
							$vitalId = $eachDevice->{deviceConfigId};
							$vitalReading = "mg/dL";
							
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$PEAKFLOW)
						{
							
							$vitalId = $eachDevice->{deviceConfigId};
							$vitalReading = contentData->{vitalUnits};
							
						}
					
				}
			}
			$patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
			$vitalName  = $contentData->{vitalName};
			$vitalClass = $contentData->{vitalName};
			//$vitalTime =  $dateUtil->formatCreatedDate($contentData->{vitalTime});
			$vitalTime =  $contentData->{vitalTime};
			$reading = $contentData->{vitalMeasurment}." ".$vitalReading;
			if($dbCardType == "VITALS_OUT_OF_RANGE")
			{
			  $cardColor = "red-card-action";
			  if($contentData->{keyTonecard} == "true") $imageNamePath = "../images/ketone_out_of_range.png";
				else                                               $imageNamePath = "../images/vitals-default.png";
				if($reading >600)
				{
					  $reading = "HI";
				}
				else if($reading<20)
				{
					  $reading= "LO";
				}
			}
			else if($dbCardType == "VITALS_ACCEPTABLE")
			{
			$cardColor = "green-card-action";
			if($contentData->{keyTonecard} == "true") $imageNamePath = "../images/ketone_acceptable.png";
			else                                                $imageNamePath = "../images/vitals-default.png";
			}
			else if($dbCardType == "VITALS_MISSED")
			{
				$cardColor = "";
				$imageNamePath = "../images/dashboard_vitals_missed.png";
				$reading = "";
				$vitalName = $vitalName.' Missed';
				$due = 'Due';
			}
				
			else if($dbCardType == "VITALS_TREND")
			{
				$cardColor = "";
				$vitalName = "Weekly BG Testing";
				$vitalTrends= "trend";
				$trendPercent = $contentData->{trendPercent};
				/*$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
				$reading = "87% of prescribed - Great!";*/
				
				if($trendPercent >= 80)
				{
					$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
					
				}
				else if($trendPercent >= 60 && $trendPercent <= 79)
				{
					$imageNamePath = "../images/ic_dash_vitals_trend_yellow.png";
				}
				else
				{
					$imageNamePath = "../images/ic_dash_vitals_trend_orange.png";
				}
		
				$reading = $contentData->{trendMessage};
				
			}
			 if($vitalName == "Peak Flow")
			{
					$vitalClass = "PEAKFLOW";
		
			}
			if($dbCardType == "VITALS_TREND")
			{
					$dueTimeSet="";
		
			}
			else
			{
					$dueTimeSet=$due." "."<span id='card_h5_".$ptcard->{dashboardDetailId}."'></span><script>var time = convertToLocalTime('".$vitalTime."');$('#card_h5_".$ptcard->{dashboardDetailId}."').text(time)</script>";
		
			}
			
			if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE")
			{
			 
			 $imageNamePath = "../images/vitals-default.png";	 
			 $clickFunction = 'alertCards(this.id);';
			  $onClick = 'alertCards(this.id);';
			 $divClass ="vitals";
			 
			}
			else
			{
			$clickFunction = "reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);";
			$divClass ="vitals";
			$onClick = "Cards(this.id);";
		
			}
			
			
			$htmlCard = $htmlCard.$reviewDiv."<div class='message_box_bg Admin text-left ".$vitalTrends."'>
					<div class='message_box_bg_blue'>
					<h2 class='".$dbCardType."'>".$patientName."</h2>
					<h4>".$dueTimeSet."</h4>
					</div>
					<div class='message_text_cl'>
						<h2 class=' ".$dbCardType."'>".$reading." <span class='patient-status ".$dbCardType."'>".$vitalName."<span></h2>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$imageNamePath."' id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$vitalClass."_".$ptcard->{dashboardDetailId}."'  class='".$divClass."' cardType='".$vitalClass."' deviceId = ".$vitalId." alt='".$patientName."' name='".$imgPath."' onClick='".$onClick."'	reviewId='".$ptcard->{dashboardDetailId}."' border='0'/>
					<button class='btn-icon btn_".$divClass."' id='".$ptcard->{patientId}."_".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}."' onClick = '".$clickFunction."' reviewId='".$ptcard->{dashboardDetailId}."'></button>
				</a>
			</div>";
		}
		else if($dbCardType == "SURVEY_NEW" OR $dbCardType == "SURVEY_COMPLETED")
		{
			$completed = "";
			$cardColor = "";
			$surveyTitle = substr($contentData->{title},0,15);
			if(strlen($surveyTitle) >= 15)
							$surveyTitle = $surveyTitle.'...';
			if($dbCardType == "SURVEY_NEW")
			{
				$imageNamePath = "../images/dashboard_survey_completed.png";
			}
			else if($dbCardType == "SURVEY_COMPLETED")
			{
				$imageNamePath = "../images/dashboard_survey_completed.png";
				$completed = "Completed";
			}
		
			$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2 Prov_img_on_dashbord'>
			<a href='#' class='".cardColor."'>
			<img src='".$imageNamePath."'id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='survey'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>
		
			</a>
		</div>
		<div class='col-md-6 Admin Admin text-left'>
			<h4 class=''>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
			
			<h2 class=''>".$surveyTitle."</h2>
			<h3 class='yellow-card-h3'><i>".$completed."</i></h3>
		</div>
		<div class='col-md-3 ActionPlan right-card'>
			<button class='btn btn-green' id=".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}." onclick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);'>Review</button>
		
		</div>
		<div class='col-md-1 AdminImg right-card'>
			<img class='dashboard_img' src='".$imgPath."' />
		</div>
		<div class='col-md-4 PatCardTime PatCardTime2'>
			<h5 class='time_date second-h5-b text-left'>".$ptcard->{createTimestamp}."</h5>
		</div>
		</div>";
		}
		
		// Patient Care
		else if($dbCardType == "ACTION_PLAN" OR $dbCardType == "ACTION_PLAN_VIEWED")
		{
		$title = substr($contentData->{title},0,20);
		
							if(strlen($title) >= 20)
							$title = $title.'...';
			$viewed="";
			$cardColor = "blue-card-action";
			if($dbCardType == "ACTION_PLAN")
			{
				$imageNamePath = "../images/dashboard_action_plan.png";
			}
			else if($dbCardType == "ACTION_PLAN_VIEWED")
			{
				$imageNamePath = "../images/dashboard_action_plan.png";
				$viewed = "Viewed";
			}
		
			$htmlCard = $htmlCard.$reviewDiv."<div class='message_box_bg Admin text-left ".$vitalTrends."'>
					<div class='message_box_bg_blue'>
					<h2 class='".$dbCardType."'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h2>
					<h4>".$ptcard->{createTimestamp}."</h4>
					<h3 class=''>".$title."</h3>
					</div>
					<h3  class='yellow-card-h3'><i>".$viewed."</i></h3>
					<div class='message_text_cl'>
						<h2 class=' ".$dbCardType."'>".$reading." <span class='patient-status ".$dbCardType."'>".$vitalName."<span></h2>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$imageNamePath."' id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='patient'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>
					<button class='btn-icon' id=".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}." onclick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);'></button>
				</a>
			</div>";
		}
		// Care Communication Card
		if($dbCardType == "CARE_COMMUNICATION" && $ptcard->{alertNotification} != "true")
		{
		$cardColor = "green-card-action";
		$title = "Care Communication";

		$messageCardIcon = "../images/careGreen.jpg";
		$providerName = $contentData->{providerFirstName}." ".$contentData->{providerLastName}.", ".$contentData->{credentials};
		$providerName = substr($providerName,0,17);
						if(strlen($providerName) == 17)
							$providerName = $providerName.'..';
							$careCommHeaderId  = $contentData->{careCommHeaderId};
		$htmlCard = $htmlCard.$reviewDiv."<div class='message_box_bg text-left'>
					<div class='message_box_bg_blue'>
					<h2 class='".$dbCardType."'>".$name."</h2>
					<h4>".$ptcard->{createTimestamp}."</h4>
					</div>
					<div class='desc'><p>".$providerName."</p></div>
					<div class='message_text_cl'>
						<h2 class=' ".$dbCardType."'>".$contentData->{credentials}." <span class='patient-status' id=TITLE_".$ptcard->{dashboardDetailId}." class='URGENTtitle S-urgenttitle both-card-align'>".$title."</span></h2>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$messageCardIcon."' id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."'  class='care'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."'  name='".$imgPath."' onclick='Cards(this.id);' careCommHeaderId='".$careCommHeaderId."'	border='0'/>
				<button class='btn-icon' id=".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}." onclick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);'></button>
				</a>
			</div>";
		}
		elseif($dbCardType == "STICKY_NOTE" && $ptcard->{alertNotification} == "true")
		{
		
			 $cardColor = "yellow-card-action";
			 $patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
			 $imageNamePath = "../images/vitals_default.png";	 
			 $clickFunction = 'alertCards(this.id);';
			  $onClick = 'openPageWithAjax("../../patientcare/pages/reviewAlert.php","patientId='.$ptcard->{patientId}.'&reviewId='.$ptcard->{dashboardDetailId}.'","menu-content",event,this);';
			 $divClass ="notes";
		
		
			$title = substr($contentData->{title},0,20);
		
						if(strlen($title) == 20)
							$title = $title.'...';
			$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
			<a href='#' class='".$cardColor."'>
			<img src='".$imageNamePath."' id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."'  class='".$divClass."'  alt='".$patientName."' name='".$imgPath."' onclick='alertCards(this.id);' reviewId='".$ptcard->{dashboardDetailId}."'	border='0'/>
			</a>
		</div>
		<div class='col-md-6 Admin text-left'>
			<h4 class=''>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
			<h3 class='yellow-card-h3'>".$title."</h3>
		
		</div>
		<div class='col-md-3 ActionPlan right-card'>
			<button class='btn btn-green btn_".$divClass."' id='".$ptcard->{patientId}."_".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}."' onClick = '".$clickFunction."' reviewId='".$ptcard->{dashboardDetailId}."'>Review</button>
		
		</div>
		<div class='col-md-1 AdminImg right-card'>
			<img class='dashboard_img' src='".$imgPath."' />
		</div>
		<div class='col-md-4 PatCardTime PatCardTime2'>
			<h5 class='time_date second-h5-b text-left'>".$ptcard->{createTimestamp}."</h5>
		</div>
		</div>";
		}

		else if($dbCardType == "CARE_COMMUNICATION" && $ptcard->{alertNotification} == "true")
		{
			 $cardColor = "red-card-action";
			 $patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
			 $imageNamePath = "../images/redCare.jpg";	 
			 $clickFunction = 'openPageWithAjax("../../dashboard/pages/portal_careManagement.php","patientId='.$ptcard->{patientId}.'","menu-content",event,this);';
			  //$onClick = reviewedDashboardCards($ptcard->{dashboardDetailId}, event);
			 $divClass ="care";
			$providerName = $contentData->{providerFirstName}." ".$contentData->{providerLastName}.", ".$contentData->{credentials};
		    $providerName = substr($providerName,0,17);
						if(strlen($providerName) == 17)
							$providerName = $providerName.'..';
		
			$title = "Care Communication";
			$careCommHeaderId  = $contentData->{careCommHeaderId};
				//var_dump($contentData->{providerFirstName});

						
			$htmlCard = $htmlCard.$reviewDiv."<div class='message_box_bg'>
					<div class='message_box_bg_blue'>
					<h2 class='".$dbCardType."'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h2>
					<h4>".$ptcard->{createTimestamp}."</h4>
					</div>
					<div class='desc'><p>".$providerName."</p></div>
					<div class='message_text_cl'>
						<h2 class='".$contentData->{credentials}."'>URGENT <span class='patient-status URGENT S-urgenttitle both-card-align'>".$title."</span></h2>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$imageNamePath."' id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."'  class='".$divClass."'  alt='".$patientName."' name='".$imgPath."'  onClick='Cards(this.id)' careCommHeaderId='".$careCommHeaderId."'	border='0'/>
					<button class='btn-icon' id='".$ptcard->{patientId}."_".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}."' onClick='reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);' reviewId='".$ptcard->{dashboardDetailId}."' ></button>
				</a>
			</div>";
			}
		
			$reviewDiv = "";
		
		}
	}
	else
	{
		if($dbCardType == "VITALS_OUT_OF_RANGE" OR $dbCardType == "VITALS_ACCEPTABLE" OR $dbCardType == "VITALS_MISSED" OR $dbCardType == "VITALS_TREND") 
		{
			$entityUtil = new EntityUtil();
			$paramArray = array();
			$allDevices = $entityUtil->getObjectWithoutFilter($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
			//fkdeviceConfigId measurementName1;
			foreach($allDevices as $eachDevice)
			{	//var_dump($eachDevice);		
				
				foreach($contentDatas as $contentData)
				{
					
					if(strtoupper($eachDevice->{measurementName1}) == strtoupper($contentData->{vitalName}) || strtoupper($eachDevice->{measurementName2}) == strtoupper($contentData->{vitalName}))
					{
						
						if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$DIASTOLIC)
						{
							$readingD = $contentData->{vitalMeasurment};
							$vitalTime =  $contentData->{vitalTime};
							$vitalUnit = $contentData->{vitalUnits};
							$vitalName = "Blood Pressure";
							$vitalClass = $contentData->{vitalName};
							$vitalId = $eachDevice->{deviceConfigId};
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$SYSTOLIC)
						{
							$systolic  = $contentData->{vitalName};
							$readingS = $contentData->{vitalMeasurment};
							$vitalTime =  $contentData->{vitalTime};
							$vitalUnit = $contentData->{vitalUnits};
							$vitalName = "Blood Pressure";
							$vitalId = $eachDevice->{deviceConfigId};
							$link = "/";
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$OXYGEN)
						{
							$readingS = $contentData->{vitalMeasurment};
							$vitalTime =  $contentData->{vitalTime};
							$vitalUnit = "%";
							$vitalName = "Blood Oxygen";
							$link = "";
							$readingD = "";
							$vitalClass = $contentData->{vitalName};
							$vitalId = $eachDevice->{deviceConfigId};
						}
						
						
						$reading = 	 $readingS.$link.$readingD." ".$vitalUnit;
					}
				}
				
			}
					$avatar = $ptcard->{avatar};
					if($avatar === "default.svg" OR $avatar === "")
					{
						$imgPath = "/gladstone/portal/bloom/common/images/default.svg";
					}
					else
					{
					//https://mainlinetest.vismc.com/gladstone/imagepath/mainlinetest.vismc.com/image/avatar/picture/69_1.JPEG
						$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
					}
					if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE" || $dbCardType == "STICKY_NOTE" && $ptcard->{alertNotification}== "true")
					{
						$mainDivClass="ALERTS";
					 
					}
					else
					{
						$mainDivClass="";
					}
					$name = "";
					if($ptcard->{viewedUserId} != "")
					{
						$isReview="isReviewed";
						$reviewDiv="<div class='cardPanel dashboardCards ".$isReview."' id=".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}." cartType='".$userType."'  style='display:none'>";
					}
					else
					{
						$reviewDiv="<div class='cardPanel dashboardCards ".$ptcard->{cardType}." providerFilterClass".$ptcard->{providerId}." ".$mainDivClass."' cartType='".$userType."' id='".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."' ref='".$ptcard->{patientId}."'>";
					}
				
				$patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};

				if($dbCardType == "VITALS_OUT_OF_RANGE")
				{
					$cardColor = "";
					$imageNamePath = "../images/dashboard_outof_range.png";
					
				}
			else if($dbCardType == "VITALS_ACCEPTABLE")
			{
				$cardColor = "green-card-action";
				$imageNamePath = "../images/vitals-default.png";
			}
			else if($dbCardType == "VITALS_MISSED")
			{
				$cardColor = "";
				$imageNamePath = "../images/dashboard_vitals_missed.png";
				$reading = "";
				$vitalName = $vitalName.' Missed';
				$due = 'Due';
			}
				
			else if($dbCardType == "VITALS_TREND")
			{
		
				$cardColor = "green-card-action";
				$vitalName = "Weekly BP Testing";
				$vitalTrends= "trend";
				
				/*$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
				$reading = "87% of prescribed - Great!";*/
				
				if($trendPercent >= 80)
				{
					$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
					
				}
				else if($trendPercent >= 60 && $trendPercent <= 79)
				{
					$imageNamePath = "../images/ic_dash_vitals_trend_yellow.png";
				}
				else
				{
					$imageNamePath = "../images/ic_dash_vitals_trend_orange.png";
				}
		
				//$trendPercent = $contentData->{trendPercent};
				//$reading = $contentData->{trendMessage};
				
			}
			if($dbCardType == "VITALS_TREND")
			{
					$dueTimeSet="";
		
			}
			else
			{
					$dueTimeSet=$due." "."<span id='card_h5_".$ptcard->{dashboardDetailId}."'></span><script>var time = convertToLocalTime('".$vitalTime."');$('#card_h5_".$ptcard->{dashboardDetailId}."').text(time)</script>";
		
			}
			
			if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE")
			{
			
			 $imageNamePath = "../images/vitals_default.png";	 
			 $clickFunction = 'alertCards(this.id);';
			  $onClick = 'alertCards(this.id);';
			 $divClass ="vitals";
			 
			}
			else
			{
			$clickFunction = "reviewedDashboardCards(".$ptcard->{dashboardDetailId}.", event);";
			$divClass ="vitals";
			$onClick = "Cards(this.id);";
		
			}
			
			
			
			
			
			
			$htmlCard = $htmlCard.$reviewDiv."<div class='message_box_bg text-left ".$vitalTrends."'>
					<div class='message_box_bg_blue'>
					<h2 class='".$dbCardType."'>".$name."</h2>
					<h2 class='".$dbCardType."'>".$patientName."</h2>
					<h4>".$dueTimeSet."</h4>
					</div>
					<div class='message_text_cl'>
						<h2 class=' ".$dbCardType."'>".$reading." <span class='patient-status'>".$vitalName."</span></h2>
					</div>
				</div>
				<a class='message-box-btn ".$cardColor."'>
					<img src='".$imageNamePath."' id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$vitalClass."_".$ptcard->{dashboardDetailId}."'  class='".$divClass."' cardType='".$vitalClass."' deviceId = ".$vitalId."  alt='".$patientName."' name='".$imgPath."' onClick='".$onClick."' reviewId='".$ptcard->{dashboardDetailId}."'	border='0'/>
					<button class='btn-icon btn_".$divClass."' id='".$ptcard->{patientId}."_".$ptcard->{dashboardDetailId}."_".$ptcard->{cardType}."' onClick = '".$clickFunction."' reviewId='".$ptcard->{dashboardDetailId}."' ></button>
				</a>
			</div>";
	}
		
	}
}

return $htmlCard;
}

function   addReviewedDashboardCards($portalcards, $type)
{
	$dateUtil = new DateUtil();
	$serverimgpath = constants::$WEB_ROOT;
	$imgKey =  constants::$IMAGE_KEY;
	$vitalTrends= "";
	$htmlCard = "";

	foreach($portalcards as $ptcard)
	{
		$avatar = $ptcard->{avatar};
		$contentDatas = $ptcard->{contentData};
	$dbCardType = $ptcard->{cardType};
		if(count($contentDatas) == 1)
		{
			foreach($contentDatas as $contentData)
			{
						if($avatar === "DEFAULT.PNG" OR $avatar === "")
						{
							$imgPath = "/gladstone/portal/bloom/common/images/DEFAULT.png";
						}
						else
						{
							$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
						}


						if($ptcard->{patientId} != $ptcard->{createdUserId})
						{
							$outerCardSizeClass = "col-md-9";
							$innerCardSizeClass = "col-md-9";
							$messageCardIcon = "../images/PortProvCard_Message.jpg";
							$name = $contentData->{providerLastName}." ".$contentData->{providerFirstName}." ".$contentData->{credentials};
						}
						else
						{
							$outerCardSizeClass = "col-md-9";
							$innerCardSizeClass = "col-md-9";
							$messageCardIcon = "../images/PortPtCard_Message.jpg";
							$name = $ptcard->{patLastName}." ".$ptcard->{patFirstName};
						}
						
						$dbCardType = $ptcard->{cardType};
						if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE" || $dbCardType == "STICKY_NOTE" && $ptcard->{alertNotification}== "true" || $ptcard->{alertNotification} == "true" && $dbCardType == "CARE_COMMUNICATION")
						{
							$mainDivClass="ALERTS";
						 
						}
						else
						{
							$mainDivClass="";
						}
						
						
						

						if($ptcard->{viewedUserId} != "")
						{

							$dbCardType = $ptcard->{cardType};

							$isReview="isReviewed";
							$reviewDiv="<div class='cardPanel ".$outerCardSizeClass." dashboardCards ".$ptcard->{cardType}." providerFilterClass".$ptcard->{providerId}." ".$mainDivClass."' id=".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}. "  ref='".$ptcard->{patientId}."'>";

							// Sticky Note Card
							if($dbCardType == "STICKY_NOTE" && $ptcard->{alertNotification}!= "true")
							{
								$title = substr($contentData->{title},0,20);

								if(strlen($title) >= 20)
									$title = $title.'...';
								$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
								<a href='#' class='reviewd_div'>


							<img src='".$messageCardIcon."' id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='notes'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."'  name='".$imgPath."' onclick='Cards(this.id);'	border='0'/></a>


								</a>
							</div>
							<div class='".$innerCardSizeClass."'>
								<h4 class='revewied-text-left'>".$name."</h4>
								<h3 class='yellow-card-h3 revewied-text-left'>".$title."</h3>
							</div>
							<div class='col-md-1'>

								<h3>
									<img src='".$imgPath."' alt=''class='dashboard_text_img reviewed-r-img'>
								</h3>
							</div>
							<div class='col-md-5 dob' ><h5 class='time_date second-h5-b reviewed-r-img'>".$ptcard->{viewedTime}."</h5></div>

						</div>";
					}
							// Education Content - VIDEO or PDF
					else if($dbCardType == "PDF_NEW" OR $dbCardType == "VIDEO_NEW" OR $dbCardType == "PDF_VIEWED" OR $dbCardType == "VIDEO_VIEWED"){

						if($dbCardType == "PDF_NEW" OR $dbCardType == "PDF_VIEWED" )			$imageNamePath = "../images/dashboard_content_pdf.jpg";
					else if($dbCardType == "VIDEO_NEW" OR $dbCardType == "VIDEO_VIEWED")		$imageNamePath = "../images/dashboard_content_video.png";

						$patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
					$title = substr($contentData->{title},0,15);

								if(strlen($title) >= 15)
									$title = $title.'...';
					if($dbCardType == "PDF_VIEWED" OR $dbCardType == "VIDEO_VIEWED")
					{
						$viewed = "Viewed";
					}
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2  imgReviewedCard'>
					<a href='#' class='reviewd_div'>

							<img src='".$imageNamePath."' id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='pdf_video'  alt='".$patientName."'  name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>

					</a>
					</div>
					<div class='col-md-9 contentReviewedCard'>
						<h4 class='revewied-text-left'>".$patientName."</h4>
						<h2 class='revewied-text-left'>".$title."</h2>
						<h3 class='yellow-card-h3 revewied-text-left'><i>".$viewed."</i></h3>
					</div>
					<div class='col-md-1 timeReviewedCard'>

						<h3>
							<img src='".$imgPath."' alt='' class='reviewed-r-img'>
						</h3>
					</div>
					<div class='col-md-5 dob ".$dbCardType."'><h5 class='time_date second-h5-b second-h5-b-2 reviewed-r-img'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}
				else if($dbCardType == "CALL_MISSED_INCOMING" OR $dbCardType == "CALL_MISSED_OUTGOING" OR $dbCardType == "CALL_SERVICED_INCOMING" OR $dbCardType == "CALL_SERVICED_OUTGOING"){
					$callerName = $ptcard->{patLastName}->{patFirstName};
					$receiverName = $contentData->{providerLastName}.",".$contentData->{providerFirstName};
					$imageNamePath = "";
					if($dbCardType == "CALL_MISSED_INCOMING")
					{
						$reasonForCall = $contentData->{reasonForCall};
						$imageNamePath = "../images/dashboard_missed_incoming.jpg";
					}
					else if($dbCardType == "CALL_MISSED_OUTGOING")
					{
						$imageNamePath = "../images/dashboard_missed_outgoing.jpg";
					}
					else if($dbCardType == "CALL_SERVICED_INCOMING")
					{
						$reasonForCall = $contentData->{reasonForCall};
						$imageNamePath = "../images/dashboard_serviced_incoming.jpg";
					}
					else if($dbCardType == "CALL_SERVICED_OUTGOING")
					{
						$imageNamePath = "../images/dashboard_serviced_outgoing.jpg";
					}

					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>

					<img src='".$imageNamePath."' id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='pdf_video'  alt='".$patientName."'  name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>

					</a>
				</div>
				<div class='col-md-9'>
					<h4 class='revewied-text-left'>".$callerName."</h4>
					<h3 class='yellow-card-h3 revewied-text-left'>".$contentData->{title}."</h3>
					<p>".$receiverName." ".$reasonForCall."</p>
				</div>
				<div class='col-md-1'>

					<h3>
						<img src='".$imgPath."' alt='' class='reviewed-r-img'>
					</h3>
				</div>
				<div class='col-md-5 dob' ><h5 class='time_date reviewed-r-img second-h5-b'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}
				else if(($dbCardType == "VITALS_OUT_OF_RANGE" OR $dbCardType == "VITALS_ACCEPTABLE" OR $dbCardType == "VITALS_MISSED" OR $dbCardType == "VITALS_TREND")
						&&($contentData->{vitalName} != "Diastolic" || $contentData->{vitalName} != "Systolic"))
				{
					$vitalReading = "";
					$entityUtil = new EntityUtil();
					$paramArray = array();
					$allDevices = $entityUtil->getObjectWithoutFilter($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
					foreach($allDevices as $eachDevice)
					{	$deviceName = strtoupper($eachDevice->{measurementName1});
						if($deviceName == strtoupper($contentData->{vitalName}))
						{
							if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$WEIGHT)
								{
									$vitalId = $eachDevice->{deviceConfigId};
									$vitalReading = $contentData->{vitalUnits};
								}
								else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$GLUCOSE)
								{
									
									$vitalId = $eachDevice->{deviceConfigId};
									$vitalReading = "mg/dL";
									
								}
								else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$PEAKFLOW)
								{
									
									$vitalId = $eachDevice->{deviceConfigId};
									$vitalReading = $contentData->{vitalUnits};
									
								}
							
						}
					}
					$patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
					$vitalName  = $contentData->{vitalName};
					$vitalClass  = $contentData->{vitalName};
					//$vitalTime =  $dateUtil->formatCreatedDate($contentData->{vitalTime});
					$vitalTime =  $contentData->{vitalTime};
					$reading = $contentData->{vitalMeasurment}." ".$vitalReading;
					if($dbCardType == "VITALS_OUT_OF_RANGE")
					{
					  if($contentData->{keyTonecard} == "true") $imageNamePath = "../images/ketone_out_of_range.png";
						else                                               $imageNamePath = "../images/dashboard_outof_range.png";
						if($reading >600)
						{
							  $reading = "HI";
						}
						else if($reading<20)
						{
							  $reading= "LO";
						}

					}
					else if($dbCardType == "VITALS_ACCEPTABLE")
					{
					if($contentData->{keyTonecard} == "true") $imageNamePath = "../images/ketone_acceptable.png";
					else                                                $imageNamePath = "../images/vitals-default.png";
					}
					else if($dbCardType == "VITALS_MISSED")
					{
						$imageNamePath = "../images/dashboard_vitals_missed.png";
						$reading = "";
						$vitalName = $vitalName.' Missed';
						$vitalTime = 'Due '.$vitalTime;
						$vitalMissedClass="VITALS_MISSED";
					}
					else if($dbCardType == "VITALS_TREND")
					{
						$vitalName = "Weekly BG Testing";
						$vitalTrends= "trend";
						$trendPercent = $contentData->{trendPercent};
						/*$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
						$reading = "87% of prescribed - Great!";*/
						
						if($trendPercent >= 80)
						{
							$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
							
						}
						else if($trendPercent >= 60 && $trendPercent <= 79)
						{
							$imageNamePath = "../images/ic_dash_vitals_trend_yellow.png";
						}
						else
						{
							$imageNamePath = "../images/ic_dash_vitals_trend_orange.png";
						}

						$reading = $contentData->{trendMessage};		
					}
					if($vitalName == "Peak Flow")
					{
							$vitalClass = "PEAKFLOW";
				
					}
					if($dbCardType == "VITALS_TREND")
					{
							$dueTimeSet="";
					}
					else
					{
							$dueTimeSet=$due." "."<span id='card_h5_".$ptcard->{dashboardDetailId}."'></span><script>var time = convertToLocalTime('".$vitalTime."');$('#card_h5_".$ptcard->{dashboardDetailId}."').text(time)</script>";

					}
					
					if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE")
					{
					
					/* $reading =$ptcard->{reviewNotes};
					 $reading=explode("<br>",$reading);
					 $reading = substr($reading[0],0,15);
					if(strlen($reading) >= 15)
					{
						
						//$reading = implode(" ",$reading);
						//$reading = str_replace("--","",$reading);
						$reading = $reading.'...';
					}*/
					 $imageNamePath = "../images/vitals_default.png";
					 $onClick = 'alertCards(this.id);';
					 $divClass ="vitals";	 
					
					}
					else
					{
					
						$onClick = "Cards(this.id);";
						$divClass ="vitals";

					}
					
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2 col-md-5 imgReviewesCard'>
					<a href='#' class='reviewd_div'>

							<img src='".$imageNamePath."'id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$vitalClass."_".$ptcard->{dashboardDetailId}."'  class='vitals' cardType='".$vitalClass."' deviceId = ".$vitalId." alt='".$patientName."' name='".$imgPath."' onClick='".$onClick."' reviewId='".$ptcard->{dashboardDetailId}."'	border='0'/>

					</a>
				</div>
				<div class='col-md-9 contentReviewesCard ".$vitalTrends."'>
					<h4 class='revewied-text-left'>".$patientName."</h4>

					<h3 class='yellow-card-h3 revewied-text-left ".$dbCardType."'>".$vitalName."</h3>
					<h2 class='revewied-text-left ".$dbCardType."'>".$reading."</h2>
					<h5 class='card-h5 revewied-text-left ".$dbCardType."'>".$dueTimeSet."</h5>
				</div>
				<div class='col-md-1 timeReviewesCard'>

					<h3>
						<img src='".$imgPath."' alt='' class='reviewed-r-img'>
					</h3>
				</div>
				<div class='col-md-5 dob vital' ><h5 class='time_date reviewed-r-img third-h5-b".$vitalMissedClass."'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}
				/*else if($dbCardType == "STICKY_NOTE" && (!$ptcard->{alertNotification}))
				{
					$patientName = $ptcard->{patLastName}->{patFirstName};
					$imageNamePath = "../images/dashboard_vitals_missed.png";
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>

							<img src='".$imageNamePath."'id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='notes'  alt='".$patientName."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>

					</a>
				</div>
				<div class='col-md-9'>
					<h4>".$patientName."</h4>
					<h4>".$contentData->{stickyTextNote}."</h4>
				</div>
				<div class='col-md-1'>

					<h3>
						<img src='".$imgPath."' alt=''>
					</h3>
				</div>
				<div class='col-md-5 dob' ><h5 class='time_date'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}*/
				else if($dbCardType == "SURVEY_NEW" OR $dbCardType == "SURVEY_COMPLETED")
				{
					$completed = "";
					$surveyTitle = substr($contentData->{title},0,15);
					if(strlen($surveyTitle) >= 15)
									$surveyTitle = $surveyTitle.'...';
					if($dbCardType == "SURVEY_NEW")
					{
						$imageNamePath = "../images/dashboard_survey_completed.png";
					}
					else if($dbCardType == "SURVEY_COMPLETED")
					{
						$imageNamePath = "../images/dashboard_survey_completed.png";
						$completed = "Completed";
					}

					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>
							<img src='".$imageNamePath."'id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='survey'  alt='".$patientName."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>
					</a>
				</div>
				<div class='col-md-9'>
					<h4 class='revewied-text-left'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
					<h3 class='yellow-card-h3 revewied-text-left'>".$surveyTitle."</h3>
					<h3 class='yellow-card-h3 revewied-text-left'>".$completed."</h3>
				</div>
				<div class='col-md-1'>

					<h3>
						<img src='".$imgPath."' alt='' class='reviewed-r-img'>
					</h3>
				</div>
				<div class='col-md-5 dob' ><h5 class='time_date class='reviewed-r-img second-h5-b'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}

				// Patient Care

				else if($dbCardType == "ACTION_PLAN" OR $dbCardType == "ACTION_PLAN_VIEWED")
				{
					$title = substr($contentData->{title},0,20);

								if(strlen($title) >= 20)
									$title = $title.'...';
					$viewed="";
					if($dbCardType == "ACTION_PLAN")
					{
						$imageNamePath = "../images/dashboard_action_plan.png";
					}
					else if($dbCardType == "ACTION_PLAN_VIEWED")
					{
						$imageNamePath = "../images/dashboard_action_plan.png";
						$viewed = "Viewed";
					}

					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>
							<img src='".$imageNamePath."'id=".$ptcard->{patientId}."_".$ptcard->{cardType}."  class='patient'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."' name='".$imgPath."' onclick='Cards(this.id);'	border='0'/>
					</a>
				</div>
				<div class='col-md-9'>
					<h4 class='revewied-text-left'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
					<h2 class='revewied-text-left'>".$title."</h2>
					<h3 class='yellow-card-h3 revewied-text-left'><i>".$viewed."</i></h3>
				</div>
				<div class='col-md-1'>

					<h3>
						<img src='".$imgPath."' alt='' class='reviewed-r-img'>
					</h3>
				</div>
				<div class='col-md-5 dob' ><h5 class='time_date reviewed-r-img second-h5-b second-h5-b-2 '>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}
				// Care Communication
				else if($dbCardType == "CARE_COMMUNICATION" && $ptcard->{alertNotification} != "true")
				{
					$title = "Care Communication";					
					$imageNamePath = "../images/careGreen.jpg";			
					$careCommHeaderId  = $contentData->{careCommHeaderId};
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>
							<img src='".$imageNamePath."'id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."'  class='care'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."' name='".$imgPath."' onclick='Cards(this.id);' careCommHeaderId='".$careCommHeaderId."'	border='0'/>
					</a>
				</div>
				<div class='col-md-9'>
					<h4 class='second-h4 revewied-text-left'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
					<h1 class='credentials second-h1 revewied-text-left'>".$contentData->{credentials}." </h1><h3 class='URGENTtitle S-urgenttitle revewied-text-left both-card-align'>".$title."</h3>
					
				</div>
				
				<div class='col-md-6 dob' ><h5 class='time_date second-h5 reviewed-r-img'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
				}
				elseif($ptcard->{alertNotification} == "true" && $dbCardType == "STICKY_NOTE")
				{
					 $imageNamePath = "../images/vitals_default.png";	 
					 $clickFunction = 'openPageWithAjax("../../patientcare/pages/reviewAlert.php","patientId='.$ptcard->{patientId}.'&reviewId='.$ptcard->{dashboardDetailId}.'","menu-content",event,this);';
					  $onClick = 'openPageWithAjax("../../patientcare/pages/reviewAlert.php","patientId='.$ptcard->{patientId}.'&reviewId='.$ptcard->{dashboardDetailId}.'","menu-content",event,this);';
					// $divClass ="vitals";

					
					$title = substr($contentData->{title},0,20);

								if(strlen($title) >= 20)
									$title = $title.'...';
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>
							<img src='".$imageNamePath."'id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."'  class='notes'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."' name='".$imgPath."' onclick='alertCards(this.id);' reviewId='".$ptcard->{dashboardDetailId}."'	border='0'/>
					</a>
				</div>
				<div class='col-md-9'>
					<h4 class='revewied-text-left'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
					<h3 class='yellow-card-h3 revewied-text-left'>".$title."</h3>

				</div>
				<div class='col-md-1'>

					<h3>
						<img src='".$imgPath."' alt='' class='reviewed-r-img'>
					</h3>
				</div>
				<div class='col-md-5 dob' ><h5 class='time_date second-h5-b reviewed-r-img'>".$ptcard->{viewedTime}."</h5></div>
				</div>";


				}
				// Care Communication Alert
				elseif($ptcard->{alertNotification} == "true" && $dbCardType == "CARE_COMMUNICATION")
				{
					 $imageNamePath = "../images/redCare.jpg";
					 $careCommHeaderId  = $contentData->{careCommHeaderId};					 
					 $clickFunction = 'openPageWithAjax("../../dashboard/pages/portal_careManagement.php","patientId='.$ptcard->{patientId}.'","menu-content",event,this);';
					  
					// $divClass ="vitals";

					
					$title = "Care Communication";
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2'>
					<a href='#' class='reviewd_div'>
							<img src='".$imageNamePath."'id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}."'  class='care'  alt='".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."' name='".$imgPath."' onclick='alertCards(this.id);' &reviewId='".$ptcard->{dashboardDetailId}."' careCommHeaderId='".$careCommHeaderId."'	border='0'/>
					</a>
				</div>
				<div class='col-md-9'>
					<h4 class='second-h4 revewied-text-left'>".$ptcard->{patLastName}." ".$ptcard->{patFirstName}."</h4>
					<h1 class='credentials second-h1 revewied-text-left'>".$contentData->{credentials}." </h1><h3 class='URGENT S-urgenttitle revewied-text-left both-card-align'><span>URGENT</span></br>".$title."</h3>

				</div>
				
				<div class='col-md-6 dob' ><h5 class='time_date second-h5 reviewed-r-img'>".$ptcard->{viewedTime}."</h5></div>
				</div>";


				}

				if($type == "Provider" or $type == "PROVIDER")
				{
				$credentials = substr($contentData->{credentials},0,8);

								if(strlen($title) == 8)
									$credentials = $credentials.'..';
					$reviewDivHtml = "<div class='col-md-2 dashboardCards lastName ".$ptcard->{cardType}." providerFilterClass".$ptcard->{providerId}."  ".$mainDivClass."'   ref='".$ptcard->{patientId}."'>".$contentData->{providerLastName}." ".$contentData->{providerFirstName}."  ".$credentials." </div>";
				}

				$htmlCard = $htmlCard.$reviewDivHtml;

				$reviewDiv = "";
				$reviewDivHtml = "";
				}

			}
		}
		else
		{
			if($ptcard->{patientId} != $ptcard->{createdUserId})
						{
							$outerCardSizeClass = "col-md-9";
							$innerCardSizeClass = "col-md-9";
							$messageCardIcon = "../images/PortProvCard_Message.jpg";
							$name = $contentData->{providerLastName}." ".$contentData->{providerFirstName}." ".$contentData->{credentials};
						}
						else
						{
							$outerCardSizeClass = "col-md-9";
							$innerCardSizeClass = "col-md-9";
							$messageCardIcon = "../images/PortPtCard_Message.jpg";
							$name = $ptcard->{patLastName}." ".$ptcard->{patFirstName};
						}
			if($dbCardType == "VITALS_OUT_OF_RANGE" OR $dbCardType == "VITALS_ACCEPTABLE" OR $dbCardType == "VITALS_MISSED" OR $dbCardType == "VITALS_TREND") 
		{
		
				$credential = "";
				$providerName = "";
				$entityUtil = new EntityUtil();
				$paramArray = array();
				$allDevices = $entityUtil->getObjectWithoutFilter($paramArray, "getDeviceList", VMCPortalConstants::$API_EMR);
			//fkdeviceConfigId measurementName1;
			foreach($allDevices as $eachDevice)
			{
				foreach($contentDatas as $contentData)
				{	
					
					if(strtoupper($eachDevice->{measurementName1}) == strtoupper($contentData->{vitalName}) || strtoupper($eachDevice->{measurementName2}) == strtoupper($contentData->{vitalName}))
					{
						if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$DIASTOLIC)
						{
							$readingD = $contentData->{vitalMeasurment};
							$vitalTime =  $contentData->{vitalTime};
							$vitalUnit = $contentData->{vitalUnits};
							$vitalName = "Blood Pressure";
							$credential = $contentData->{credentials};
							$vitalClass =  $contentData->{vitalName};
							$providerName = $contentData->{providerLastName}." ".$contentData->{providerFirstName};
							$vitalId = $eachDevice->{deviceConfigId};
							
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$SYSTOLIC)
						{
							$systolic  = $contentData->{vitalName};
							$readingS = $contentData->{vitalMeasurment};
							$vitalTime =  $contentData->{vitalTime};
							$vitalUnit = $contentData->{vitalUnits};
							$vitalName = "Blood Pressure";
							$vitalClass =  $contentData->{vitalName};
							$vitalId = $eachDevice->{deviceConfigId};
							$link = "/";
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$OXYGEN)
						{
							$readingS = $contentData->{vitalMeasurment};
							$vitalTime =  $contentData->{vitalTime};
							$vitalUnit = "%";
							$vitalName = "Blood Oxygen";
							$link = "";
							$readingD = "";
							
							$vitalClass =  $contentData->{vitalName};
							$vitalId = $eachDevice->{deviceConfigId};
							
							
						}
						else if(strtoupper($contentData->{vitalName}) == VMCPortalConstants::$PULSE)
						{
							
							$providerName = $contentData->{providerLastName}." ".$contentData->{providerFirstName};
							$credential = $contentData->{credentials};
							$vitalId = $eachDevice->{deviceConfigId};
						}
						$reading = 	 $readingS.$link.$readingD." ".$vitalUnit;
					}
				}
			}
				$patientName = $ptcard->{patLastName}.' '.$ptcard->{patFirstName};
				if($avatar === "DEFAULT.PNG" OR $avatar === "")
				{
					$imgPath = "/gladstone/portal/bloom/common/images/DEFAULT.png";
				}
				else
				{
					$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
				}
	
				$dbCardType = $ptcard->{cardType};
				if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE" || $dbCardType == "STICKY_NOTE" && $ptcard->{alertNotification}== "true")
				{
					$mainDivClass="ALERTS";
				 
				}
				else
				{
					$mainDivClass="";
				}
				if($ptcard->{viewedUserId} != "")
				{

					$dbCardType = $ptcard->{cardType};

					$isReview="isReviewed";
					$reviewDiv="<div class='cardPanel ".$outerCardSizeClass." dashboardCards ".$ptcard->{cardType}." providerFilterClass".$ptcard->{providerId}." ".$mainDivClass."' id=".$ptcard->{cardType}."_".$ptcard->{dashboardDetailId}. "  ref='".$ptcard->{patientId}."'>";
					if($dbCardType == "VITALS_OUT_OF_RANGE")
					{
					 $imageNamePath = "../images/dashboard_outof_range.png";
					}
					else if($dbCardType == "VITALS_ACCEPTABLE")
					{
					$imageNamePath = "../images/vitals-default.png";
					}
					else if($dbCardType == "VITALS_MISSED")
					{
						$imageNamePath = "../images/dashboard_vitals_missed.png";
						$reading = "";
						$vitalName = $vitalName.' Missed';
						$vitalTime = 'Due '.$vitalTime;
						$vitalMissedClass="VITALS_MISSED";
					}
					else if($dbCardType == "VITALS_TREND")
					{
						$vitalName = "Weekly BG Testing";
						$vitalTrends= "trend";
						$trendPercent = $contentData->{trendPercent};
						/*$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
						$reading = "87% of prescribed - Great!";*/
						
						if($trendPercent >= 80)
						{
							$imageNamePath = "../images/ic_dash_vitals_trend_green.png";
							
						}
						else if($trendPercent >= 60 && $trendPercent <= 79)
						{
							$imageNamePath = "../images/ic_dash_vitals_trend_yellow.png";
						}
						else
						{
							$imageNamePath = "../images/ic_dash_vitals_trend_orange.png";
						}

						$reading = $contentData->{trendMessage};		
					}
					if($dbCardType == "VITALS_TREND")
					{
							$dueTimeSet="";
					}
					else
					{
							$dueTimeSet=$due." "."<span id='card_h5_".$ptcard->{dashboardDetailId}."'></span><script>var time = convertToLocalTime('".$vitalTime."');$('#card_h5_".$ptcard->{dashboardDetailId}."').text(time)</script>";

					}
					
					if($ptcard->{alertNotification} == "true" && $dbCardType == "VITALS_OUT_OF_RANGE")
					{
					
					/* $reading =$ptcard->{reviewNotes};
					 $reading=explode("<br>",$reading);
					 $reading = substr($reading[0],0,15);
					if(strlen($reading) >= 15)
					{
						
						//$reading = implode(" ",$reading);
						//$reading = str_replace("--","",$reading);
						$reading = $reading.'...';
					}*/
					 $imageNamePath = "../images/vitals_default.png";
					 $onClick = 'alertCards(this.id);';
					 $divClass ="vitals";	 
					
					}
					else
					{
					
						$onClick = "Cards(this.id);";
						$divClass ="vitals";

					}
					
					$htmlCard = $htmlCard.$reviewDiv."<div class='col-md-2 col-md-5 imgReviewesCard'>
					<a href='#' class='reviewd_div'>

							<img src='".$imageNamePath."'id='".$ptcard->{patientId}."_".$ptcard->{cardType}."_".$vitalClass."_".$ptcard->{dashboardDetailId}."'  class='vitals' cardType='".$vitalClass."' deviceId = ".$vitalId."  alt='".$patientName."' name='".$imgPath."' onClick='".$onClick."' reviewId='".$ptcard->{dashboardDetailId}."'	border='0'/>

					</a>
				</div>
				<div class='col-md-9 contentReviewesCard ".$vitalTrends."'>
					<h4 class='revewied-text-left'>".$patientName."</h4>

					<h3 class='yellow-card-h3 revewied-text-left ".$dbCardType."'>".$vitalName."</h3>
					<h2 class='class='revewied-text-left ".$dbCardType."'>".$reading."</h2>
					<h5 class='card-h5 revewied-text-left ".$dbCardType."'>".$dueTimeSet."</h5>
				</div>
				<div class='col-md-1 timeReviewesCard'>

					<h3>
						<img src='".$imgPath."' alt=''  class='reviewed-r-img'>
					</h3>
				</div>
				<div class='col-md-5 dob vital' ><h5 class='time_date reviewed-r-img third-h5-b ".$vitalMissedClass."'>".$ptcard->{viewedTime}."</h5></div>
				</div>";
					if($type == "Provider" or $type == "PROVIDER")
					{
					$credentials = substr($contentData->{credentials},0,8);
					$credentials = substr($credential,0,8);

									if(strlen($title) == 8)
										$credentials = $credentials.'..';
						$reviewDivHtml = "<div class='col-md-2 dashboardCards lastName ".$ptcard->{cardType}." providerFilterClass".$ptcard->{providerId}."  ".$mainDivClass."'   ref='".$ptcard->{patientId}."'>".$providerName."  ".$credentials." </div>";
					}

					$htmlCard = $htmlCard.$reviewDivHtml;

					$reviewDiv = "";
					$reviewDivHtml = "";
				}
			}
		}
	}

return $htmlCard;
}

function   addPatientsCards($patientList, $type, $selectPatient)
{
	$dateUtil = new DateUtil();
	$serverimgpath = constants::$WEB_ROOT;
	$imgKey =  constants::$IMAGE_KEY;
	$htmlPatientList = "";
	$htmlAllPatientList = "";

	foreach($patientList as $patient)
	{
		$avatar = $patient->{avatar};
		if($avatar === "DEFAULT.PNG" OR $avatar === "")
		{
			$imgPath = "/gladstone/portal/bloom/common/images/DEFAULT.png";
		}
		else
		{
			$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
		}

		$edit = "";
		$delete = "";

		if($selectPatient === FALSE)
		{
			$edit = "<li class='editbtn' id='edit_".$patient->{entityId}."'><a href='#' class='btn-neutral' onclick='openPageWithAjax(\"../../dashboard/pages/portal_addPatient.php\",\"edit=true&patientId=".$patient->{entityId}."\",\"menu-content\",event,this)'>Edit</a></li>";
			$delete = "<li class='deletebtn' id='delete_".$patient->{entityId}."'><a href='#' onclick='deletePatient(".$patient->{entityId}.");' class='last1 btn-neutral' data-toggle='modal' data-target='#patientDeleteModal'>Delete</a></li>";
		}
		else{
		$ancher="href='#'";
		}

		if($type == "MYPATIENT"  AND $patient->{myPatient} == "1")
		{
			$htmlPatientList = $htmlPatientList."<div class='PatientList_part_bg cardPanel showBtn_".$patient->{entityId}."'  id=".$patient->{entityId}.">
			<div class='col-lg-2 patient_img_left'><a ".$ancher."><img class='default_img' src='".$imgPath."' alt=''/></a></div>
			<div class='col-lg-5 patient_address'>
				<h2>".$patient->{lastName}." ".$patient->{firstName}."</h2>
				<h3>".$dateUtil->formatDateForDob($patient->{dateOfBirth})."</h3>
				<span style='display:none'>".$patient->{emailAddress}."</span>
				<span style='display:none'>".$patient->{phoneNumber}."</span>
				<span style='display:none'>".$patient->{firstName}."</span>
				<span style='display:none'>".$patient->{lastName}."</span>
				<span style='display:none'>".$dateUtil->formatDatetoStr($patient->{dateOfBirth})."</span>
			</div>
			<div class='col-lg-5 edit_sub_button'>
				<ul id='bttnGroup121'>
					".$edit.$delete."
				</ul>
			</div>
			</div>";
		}

		if($type == "ALL")
		{

			$htmlAllPatientList = $htmlAllPatientList."<div class='PatientList_part_bg cardPanel ' id=".$patient->{entityId}.">
				<div class='row patient_address'>
					<div class='col-md-4 name'>
						<h2>".$patient->{lastName}." ".$patient->{firstName}."</h2>
					</div>
					<div class='col-md-4 date'>
						<h3>".$dateUtil->formatDateForDob($patient->{dateOfBirth})."</h3>
					</div>
					<span style='display:none'>".$patient->{emailAddress}."</span>
					<span style='display:none'>".$patient->{phoneNumber}."</span>
					<span style='display:none'>".$patient->{firstName}."</span>
					<span style='display:none'>".$patient->{lastName}."</span>
					<span style='display:none'>".$dateUtil->formatDatetoStr($patient->{dateOfBirth})."</span>
					<div class='col-md-4 edit_sub_button'>
						<ul id='bttnGroup121'>
							".$edit.$delete."
						</ul>
					</div>
				</div>
			</div>";
		}

	}

	if($type == "ALL")	$htmlPatientList = $htmlAllPatientList;

	return $htmlPatientList;
}

function   addContentLibraryCards($contentInfos)
{
	$dateUtil = new DateUtil();
	$htmlContentListCards = "";
	//var_dump($contentInfos);
	foreach($contentInfos as $content)
	{
		//var_dump($content->{fileUploadDate});
		$htmlContentListCards = $htmlContentListCards."<div class='row content_Library_care '>
		<div class='content_Library_care1'><a href='#'>
			<img src='../images/dashboard_survey_new.jpg' alt='' ></a></div>
			<div class='content_Library_care1'><a href='#'>".$content->{title}."</a></div>
			<div class='content_Library_care1'><a href='#'>".$dateUtil->formatDatetoStr($content->{fileUploadDate})."</a></div>
		</div>";

	}

	return $htmlContentListCards;
}

function addNewContentLibraryCards($contentInfos)
{
	$dateUtil = new DateUtil();
	$htmlContentListCards = "";

	foreach($contentInfos as $content)
	{	
		$public = "";
		$imageIconName = "ProvCard_ViewedPDF_v5.png";
		$pos = stripos($content->{contentType} ,'pdf');

		if($pos === FALSE)		$imageIconName = "dashboard_content_video.png";
		if($content->{viewableToAll} == 1)
		{
			$public = "<span class='glyphicon glyphicon-ok'></span>";
		}
		else
		{
			$public = "";
		}
		$htmlContentListCards = $htmlContentListCards."<tr id='".$content->{contentsId}."' content-type='".$content->{contentType}."' title='".$content->{title}."' fileUploadDate='".$content->{fileUploadDate}."'><td>
		<img src='../../login/images/".$imageIconName."' alt='' ></td>
		<td>".$content->{title}."</td>
		<td>".$dateUtil->formatDatetoStr($content->{fileUploadDate})."</td>
		
		<td>".$public."</td></tr>";

	}

	return $htmlContentListCards;
}

function   addProviderCards($providerList, $type)
{
	$htmlProviderList = "";
	$serverimgpath = constants::$WEB_ROOT;
	$imgKey =  constants::$IMAGE_KEY;


	foreach($providerList as $provider)
	{
		if($provider->deleted != 0)
		{
			continue;
		}

		$avatar = $provider->{avatar};
		if($avatar === "DEFAULT.PNG" OR $avatar === "")
		{
			$imgPath = "/gladstone/portal/bloom/common/images/DEFAULT.png";
		}
		else
		{
			$imgPath = $serverimgpath."/images/".$avatar."?imagekey=".$imgKey;
		}
		$htmlProviderList = $htmlProviderList."<div class='ProviderList_part_bg cardPanel'>
		<!--<div class='col-lg-2 patient_img_left'><a href='#'><img src='".$imgPath."' alt=''/></a></div>-->
		<div class='row patient_address'>
			<div class='col-md-6 name'>".$provider->{lastName}." ".$provider->{firstName}." ".$provider->{credentials}."</div>
			<div class='col-md-3 date'>".$provider->{specialityCode}."</div>
			<div class='col-lg-3 edit_sub_button'>
				<ul id='bttnGroup121'>
					<li><a href='javascript:void(0);' class='btn-neutral'  onclick='openEditProvider(".$provider->{providerId}.");'>Edit</a></li>
					<!--<li><a href='javascript:void(0);' class='last1 btn-neutral' onclick='deleteProvider(".$provider->{providerId}.");'>Delete</a></li>--->
				</ul>
			</div>
		</div>
		</div>";
	}

return $htmlProviderList;
}

/*  start code for learn */
function   addLearnCards($learnList)
{
	$htmllearnList = "";
	$dateUtil = new DateUtil();
	foreach($learnList as $learn)
	{
		//var_dump($learn->{createTimeStamp});
		$imageIconName = "ProvCard_ViewedPDF_v5.png";

		$pos = stripos($learn->{content}->{contentType} ,'pdf');

		if($pos === FALSE)		$imageIconName = "dashboard_content_video.png";

		$title = $learn->{customTitle};

		if($title ===  VMCPortalConstants::$PHP_EMPTY)
		{
			$title = $learn->{content}->{title};
		}

		$htmllearnList = $htmllearnList."<div class='learn_content_bg bordered' id='delete".$learn->{educationalContentId}."'>
		<div class='row'>
			<div class='col-md-1 learn_box_img'>
				<a class='".$learn->{educationalContentId}."' id='content".$learn->{educationalContentId}."'  onclick='contentOpen(this.id)'><img src='/gladstone/portal/bloom/login/images/".$imageIconName."' alt=''/></a>
			</div>
			<div class='col-md-4 learn_box_content'>
				<h2> ".$title."</h2>
			</div>
			<div class='col-md-4'>
				<span class='date_span learnTime'>".$learn->{createTimeStamp}."</span>
			</div>

			<div class='col-md-3 learn_box_content_button text-right'>
				<a href='#' class='delete' name='".$learn->{contentId}."'   id='".$learn->{educationalContentId}."'>Delete</a>
			</div>
		</div>

	</div>";
}

return $htmllearnList;
}

function   addMessageCards($messageList)
{
	$htmlMessageList = "";

	foreach($messageList as $message)
	{
		$color = "blue";
		$editUserId = $message->{'editUserId'};
		$patientId = $message->{'patientId'};

		if( $editUserId == $patientId)	{
			$color = "yellow";
		}

		$htmlMessageList = $htmlMessageList."<div class='message_box_bg'>
		<div class='message_box_bg_".$color."'>
			<h2>".$message->{lastModifiedName}."</h2>
			<h4>Sep. 1 11:23A.M.</h4>
		</div>
		<div class='message_text_cl'>
			<h3>".$message->{description}."</h3>
		</div>
	</div>";
}

return $htmlMessageList;
}

function   assignLearnCards($contentInfos)
{
	$dateUtil = new DateUtil();
	$htmlContentListCards = "";

	foreach($contentInfos as $content)
	{
		$imageIconName = "ProvCard_ViewedPDF_v5.png";
		$pos = stripos($content->{contentType} ,'pdf');

		if($pos === FALSE)		$imageIconName = "dashboard_content_video.png";

		$htmlContentListCards = $htmlContentListCards."<div class='learn_content_bg bordered'>
		<div class='row'>
			<div class='col-md-1 learn_box_img'>
				<img src='../../login/images/".$imageIconName."' alt='../../login/images/check_learn.png'  id='".$content->{contentsId}."' />
			</div>
			<div class='col-md-7 learn_box_content'>
				<h2>".$content->{title}."</h2>
			</div>
			<div class='col-md-4 learn_box_content_button'>
				<span class='date_span'>".$dateUtil->formatDatetoStr($content->{fileUploadDate})."</span>
			</div>
		</div>
	</div>";
	}

	return $htmlContentListCards;
}

function   addObservations($stickyNotesInfos)
{
	$htmlObservations = "";
	$dateUtil = new DateUtil();

	foreach($stickyNotesInfos as $stickyNotes)
	{

		if($stickyNotes->{noteType} == "OBSERVATION")
		{
			$htmlObservations = $htmlObservations."<div class='patientcare_messagebg_text'>
			<h5 id='Observation_lastModifiedName'>".$stickyNotes->{lastModifiedName}." ".$stickyNotes->{credentials}."</h5>
			<h5 id='Observation_createdTimeStamp' style='float:right;' class='time_date'>".$stickyNotes->{createTimeStamp}."</h5>
			<p id='Observation_obsDescription'>".$stickyNotes->{description}."</p>
			</div>";
		}
	}

	return $htmlObservations;
}


function  addNotes($Notes)
{
	$htmlNotes = "";

	foreach($Notes as $Note)
	{
		$htmlNotes = $htmlNotes.$Note->{draftId}."_".$Note->{draftData};
	}

	return $htmlNotes;
}
function  addActionPlan($actionPlans)
{
	$htmlActionPlan = "";

	foreach($actionPlans as $actionPlan)
	{
					$htmlActionPlan = $htmlActionPlan.$actionPlan->{goals};
	}

	return $htmlActionPlan;
}


function   reportCard($reportCardInfos)
{
	$htmlreportCard = "";
	//$dateUtil = new DateUtil();

	foreach($reportCardInfos as $reportCards)
	{


			$htmlreportCard = $htmlreportCard."<div class='card_report pending'>
			<div class='col-md-2 card_create_report_img'>
				<a href='#'><img src='../../reports/images/report_panding.png'></a>
			</div>
			<div class='col-md-7 card_create_report_link'>
				<p>ravi Biometric Report <span>.....Pending........</span></p>
				<ul class='createrName'><li>Create by: ravi kumawat, RN</li></ul>
			</div>
			<div class='col-md-3'>Nov 22 2014 - Nov 11 2014</div>
			</div>";

	}

	return $htmlreportCard;
}


//start pending reg

function   pendingApplicantCards($pendingProviderList, $stateId)
{

	foreach($pendingProviderList as $pendingProvider)
	{
		$registrationInfo = $pendingProvider->patientRegistrationInfo;
		$insuranceInfo = $pendingProvider->patientRegInsuranceInfo;
	//	if($registrationInfo->patientId > 0 AND $registrationInfo->message != "Could not match insurance info.")
	//	{
	//		continue;
	//	}
			foreach($stateId as $stateName)
			{	
				if($registrationInfo->stateId == $stateName->{stateId})
				{
				$state_Name = $stateName->{stateCode};
				}
			}


		$dateUtil = new DateUtil();
		$insuranceName = $insuranceInfo->insuredFirstName."&nbsp;".$insuranceInfo->insuredLastName;
		$groupID = $pendingProvider->patientRegInsuranceInfo->groupId;
		if($groupID !="")
		{
		$moreButton = "<a id='moredetail-".$registrationInfo->patientRegistrationId."' class='moreDetail'>More <span class='glyphicon glyphicon-chevron-down' aria-hidden='true' style='margin-left: 3px; font-weight: normal; font-size: 11px;'></span></a>
";
		}
		else{
		$moreButton = "<a id='moredetail-".$registrationInfo->patientRegistrationId."' class='moreDetailFade'>More <span class='glyphicon glyphicon-chevron-down' aria-hidden='true' style='margin-left: 3px; font-weight: normal; font-size: 11px;'></span></a>";
		}
		if(empty($insuranceName))
		{
			$insuranceName = "&nbsp;";
		}

		$address = $registrationInfo->addressLine1." ".$registrationInfo->addressLine2." ".$registrationInfo->city." ".$state_Name." ".$registrationInfo->postalCode;
		// if($address == 0 or $address == "")
		// {
		
		// $address = "";
		
		// }
		$patientDetail = "";
		if($registrationInfo->patientId != "")
		{
			$patientDetail = "Patient Detail";
		}
		$registrantName = $registrationInfo->firstName."&nbsp;".$registrationInfo->lastName;

		$htmlPendingProvList = $htmlPendingProvList."<div class='insurance' id='insurance-".$registrationInfo->patientRegistrationId."'>
		<div class='employeeDetail'>
			<div class='col-lg-2 insuranceImg'>
				<a href='#'><img src='../../login/images/insurance.png' /></a>
			</div>
			<div class='col-lg-7 insuranceDOB'>
				<p>".$registrantName."</p>
				<h1>".$dateUtil->formatDateForDob($registrationInfo->dob)."</h1>
					".$moreButton."				 
			<a class='patient_detail_link' id='".$registrationInfo->patientId."'  href ='../../login/pages/portal_dashboard.php'  target='_blank'>".$patientDetail."</a>
			</div>
			<div class='col-lg-3 insuranceBttn'>
			
			<p class='address".$groupID."'>".$address."</p>
			</div>
		</div>
		<div class='insuranceDetails' id='insuranceDetails-".$registrationInfo->patientRegistrationId."' style='display:none;'>
			<h1>Additional Details</h1>
			<p><span class='col-lg-6'>Group ID :-</span>".$pendingProvider->patientRegInsuranceInfo->groupId."</p>
			<p><span class='col-lg-6'>Member ID :-</span>".$pendingProvider->patientRegInsuranceInfo->memberId."</p>
			<p><span class='col-lg-6'>Contact Number :-</span>".$registrationInfo->phoneNumber."</p>
			<p><span class='col-lg-6'>Contact Email:-</span>".$registrationInfo->emailAddress."</p>
			<a id='lessDetail-".$registrationInfo->patientRegistrationId."' class='lessDetail'>Less <span class='glyphicon glyphicon-chevron-up' aria-hidden='true' style='margin-left: 3px; font-weight: normal; font-size: 11px;'></span></a>
		</div>
		<div class='closing bttnGrp'>
		<a class='approvePatient' href='#' id='approvePatient-".$registrationInfo->patientRegistrationId."'><img src='../../login/images/Right.png'/></a>
		<a class='rejectPatient' href='#' id='rejectPatient-".$registrationInfo->patientRegistrationId."'><img src='../../login/images/Close.png' /></a>
		</div>

		</div>";
	}

return $htmlPendingProvList;
}



function   suppliesCards($data,$patientSuppliesList)
{
	$htmlsuppilesCard = "";
	$htmlElement =0;
	//$dateUtil = new DateUtil();

	foreach($data as $suppliyCard)
	{
		foreach($patientSuppliesList as $deviceinfo)
		{
				if($suppliyCard->{supplyConfigId} == $deviceinfo->{supplyConfigId})
				{
				$imageName=$deviceinfo->{imageName};
				$deviceName=$deviceinfo->{supplyDescription};
				
				}
		}
			$htmlsuppilesCard = $htmlsuppilesCard."
			<div class='test_strip'>
			<div class='col-lg-2 col-md-2 test_strip_img'>
			<a href='#'><img src='/gladstone/portal/bloom/dashboard/images/".$imageName.".png'  /></a>
			</div>
			<div class='col-lg-3 col-md-3 test_strip_headline'>
			<p>".$deviceName."</p>
			</div>
			<div class='col-lg-7 col-md-7 test_strip_quantity'>
			<p><span class='col-lg-8' style='padding-left:0px;'>Recommended Uses : </span>".$suppliyCard->{usageQuantity}." Per day</p>
			<p><span class='col-lg-8' style='padding-left:0px;'>Estimated Remaining Quantity : </span><span  id='textbox_p".$htmlElement."'> 
			<span class='InlineFlote'><input type='text' value='".$suppliyCard->{remainingQuantity}."' id='".$suppliyCard->patientSupplyId."' class='input_text input_text".$suppliyCard->patientSupplyId."'
			 style='border: 0px none; width: 100%; padding: 5px 0px 5px 2px;' name='remainingQuantity' maxlength='4'/></span>
			 <span class='InlineFlote'><a  class='approvePatient' disabled='disabled' href='#' id='update-".$suppliyCard->patientSupplyId."'><span class='glyphicon glyphicon-check' aria-hidden='true'></span></a>
			 </span>
			 <span class='InlineFlote'><a  class='approvePatient1' disabled='disabled'  href='#' data='".$suppliyCard->{remainingQuantity}."' id='reset_".$suppliyCard->patientSupplyId."' id='reset'><span class='glyphicon glyphicon-share-alt'style=' transform: rotateY(180deg);' aria-hidden='true'></span></a>
			 </span>
			 </p></div>
			
			</div>
			
			";
			$htmlElement++;
	}

	return $htmlsuppilesCard;
}


//start pending reg


function createSurveyCard($survey)
{
	foreach($survey as $surveyCards)
	{

	$sureyHtml=$sureyHtml."<div class='Survey_Card'><div class='row'>
					<div class='col-md-2 surveyImg'>
						<a href='#' onclick='openPageWithAjax(\"../../survey/pages/survey_question.php\",\"surveyHeaderId=".$surveyCards->{surveyHeaderId}."&surveyConfigHeaderId=".$surveyCards->{surveyConfigHeaderId}."\",\"menu-content\",event,this)'><img src='../../survey/images/survey.png' /></a>
					</div>
					<div class='col-md-10 surveyImg'>
						<h1>".$surveyCards->{surveyDescription}."</h1>
						<p class='date'>".$surveyCards->{createTimeStamp}."</p>
					</div>
				</div></div>";
	}
	return $sureyHtml;

}

// Start NPI detail cards
function   showNPIDetail($NPIDetails)
{
	$counter =0;
	foreach($NPIDetails as $NPIDetail)
	{
		$counter++;
		$namesHTML = "";
		$addressHTML = "";
		$phoneHTML = "";
		$taxonomiesHTML1 = "";
		$taxonomiesHTML2 = "";
		$taxonomiesHTML3 = "";
		$taxonomiesHTML4 = "";
		
		$identifiersHTML1 = "";
		$identifiersHTML2 = "";
		$identifiersHTML3 = "";
		$names        = $NPIDetail->{names};
		$addresses    = $NPIDetail->{addresses};
		$taxonomies   = $NPIDetail->{taxonomies};
		$identifiers  = $NPIDetail->{identifiers};
		foreach($names as $name)
		{
			if($name->{last_name}." ".$name->{first_name} != $names[0]->{last_name}." ".$names[0]->{first_name})
			{
				$namesHTML .="<p> ".$name->{last_name}." ".$name->{first_name}."</p>";
			}
		}
		foreach($addresses as $address)
		{
			if($address->{street1} != $addresses[0]->{street1})
			{
				$addressHTML .="<p>".$address->{street1}.", ".$addresses[0]->{city}."</p>";
				
										  
				$phoneHTML .= "<p>".$addresses[0]->{telephone}." / ".$addresses[0]->{fax}."</p>";
							
			}
		}
		foreach($taxonomies as $taxonomy)
		{
			
				if($taxonomy->{primary} == Y)
				{
					$primary = "Yes";
				}
				else
				{
					$primary = "No";
				}
				$taxonomiesHTML1 .=" <p>
									".$primary."
									</p>";
				$taxonomiesHTML2 .=" <p class='Taxonomy'>".$taxonomy->{code}."</p>";
				$taxonomiesHTML3 .=" <p>
									".$taxonomy->{state}."
									</p>";
				$taxonomiesHTML4 .=" <p>
									".$taxonomy->{license}."
									</p>";
									
							
			
		}
		foreach($identifiers as $identifier)
		{
			
			$identifiersHTML1 .="<p>	".$identifier->{issuer}." </p>";
			$identifiersHTML2 .="<p>	".$identifier->{state}." </p>";
			$identifiersHTML3 .="<p>	".$identifier->{code}." </p>";
									
							
		}
		if($NPIDetail->{npi} !="")
		{
			$cardHTML = "<div class='col-md-6 NPI_CardDOB detailinfo'>
		<p class='npiid'>NPI : ".$NPIDetail->{npi}."</p>
		
		<h1 class='name'>".$names[0]->{last_name}." ".$names[0]->{first_name}."</h1>
		<p></p>
		</div>
		
		<div class='col-lg-4 NPI_CardBttn addressinfo'>
		<p class='city'>".$addresses[0]->{street1}." , ".$addresses[0]->{city}."</p>
		<p class='state'>".$addresses[0]->{postal_code}.", ".$addresses[0]->{state}." ,".$addresses[0]->{country_code}."</p>
		<p class='phone'>Phone:".$addresses[0]->{telephone}."</p>
		<p class='fax'>Fax :".$addresses[0]->{fax}."</p>
		<a id='moredetail_".$counter."' class='moredetail'>More <span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a>
		</div>";
		
		}
		else
		{
			$invalidNPI = $NPIDetail->{portalError};
			$invalidNPI = explode(" ",$invalidNPI);
			$cardHTML = "<div class='col-md-6 NPI_CardDOB detailinfo'>
			<p class='npiid'>NPI : ".$invalidNPI[2]."</p>
			<h1> ".constantAppResource::$TXT_INVALID_NPI."</h1>
			</div>
			<div class='col-lg-4 NPI_CardBttn addressinfo'></div>";
		
		}
		
		$htmlNPIDetails = $htmlNPIDetails."<div class='col-lg-12'>
	
			<div class='NPI_Card'>
	
		<div class='employeeDetail'>
		<div class='col-md-2 NPI_CardImg'>
		<a href='#'><img src='../../provider/images/Icon12.png' /></a>
		</div>".$cardHTML."</div>
		<div class='NPI_CardDetails' id='NPI_CardDetails_".$counter."' style='display:none;'>
		<h1>Additional Detail</h1>
		<div class='col-md-12 ADD_Detail_NPI table-responsive'>
		<div class='row'>
		<div class='col-md-4 Name'>
		<h2>Name</h2>
		 ".$namesHTML."
		</div>
		<div class='col-md-4 Address'>
		<h2>Address</h2>
		 ".$addressHTML."
		 </div>
		<div class='col-md-4 PhoneFax'>
		<h2>Phone/Fax</h2>	
		 ".$phoneHTML."
		</div>
		</div>
		</div>
		<div class='border_NPI'></div>
		<div class='row ADD_Detail_NPIMain'>
		<div class='col-md-12 ADD_Detail_NPI'>
		<div class=''>
		<h2 class='col-lg-12'>Taxonomy:</h2>
		<div class='col-md-3 taxonomy'>
		<h3>Primary Taxonomy</h3>
		".$taxonomiesHTML1."
		</div>
		<div class='col-md-3 taxonomy'>
		<h3>Selected Taxonomy</h3>
		".$taxonomiesHTML2."
		</div>
		<div class='col-md-3 taxonomy'>
		<h3>State</h3>
		".$taxonomiesHTML3."
		</div>
		<div class='col-md-3 taxonomy'>
		<h3>License</h3>
		" .$taxonomiesHTML4."
		</div>		
		
		</div>
		</div></div>
		<div class='border_NPI'></div>
		<div class='row'>
		<div class='col-md-12 ADD_Detail_NPI'>
		<div class=''>
		<h2 class='col-lg-12'>Identifiers:</h2>
		<div class='col-md-4 taxonomy'>
		<h3>Issuer</h3>
		".$identifiersHTML1."
		</div>
		<div class='col-md-4 taxonomy'>
		<h3>State</h3>
		".$identifiersHTML2."
		</div>
		<div class='col-md-4 taxonomy'>
		<h3>Code</h3>
		".$identifiersHTML3."
		</div>
		</div>	
		</div>
		</div>
		<a id='lessDetail_".$counter."'class='lessDetail'>Less <span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a>
		</div>
		</div>
		</div>
		</div>";
		
		
	}
	return $htmlNPIDetails;
}
// End NPI detail cards
function   showPatientResult($patientList)
{
	$dateUtil = new DateUtil();
	$htmlPatientList = "";
	$htmlAllPatientList = "";

	foreach($patientList as $patient)
	{
		
			$showPatientResultHTML=	$showPatientResultHTML."	
			<div class='col-md-12 '>
			<div class='col-lg-12 searchCardNPI selectPatient'>
			<div class='col-md-6 SearchInfo'>
			<p><span class='col-sm-4'>Name :</span><span class='col-sm-8'>".$patient->{lastName}." ".$patient->{firstName}."</span></p>
			<p><span class='col-sm-4'>DOB  :</span><span class='col-sm-8'>".$dateUtil->formatDatetoStr($patient->{dateOfBirth})."</span></p>
			<p><span class='col-sm-4'>Phone :</span><span class='col-sm-8'>".$patient->{phoneNumber}."</span></p>
			<p><span class='col-sm-4'>Fax  :</span><span class='col-sm-8'></span></p>
			</div>
			<div class='col-md-6 SearchInfo'>
			<p><span class='col-sm-4'>Address :</span><span class='col-sm-8'>".$patient->{addressLine1}."</span></p>
			<p><span class='col-sm-4'>City :</span><span class='col-sm-8'>".$patient->{addressLine2}."</span></p>
			<p><span class='col-sm-4'>Email :</span><span class='col-sm-8'>".$patient->{emailAddress}."</span></p>
			<input type='hidden' name ='faxPatientId' id='faxPatientId' value=".$patient->{entityId}." >
			</div>
			</div>
			</div>";
	}

	return $showPatientResultHTML;
}

function   assignSurveyCards($surveyResp,$surveyList)
{
	$dateUtil = new DateUtil();
	$htmlSueryListCards = "";
	
	foreach($surveyResp as $survey)
	{
	$existingClass = "";
	$latModified = "";
		foreach($surveyList as $existingSurvey)
		{
			if($survey->{survey_id} == $existingSurvey->{surveyId} && $existingSurvey->surveySummary->{surveyStatus} == "Reviewed" && strtoupper($existingSurvey->{surveyName}) == "ANNUAL WELLNESS VISIT")
			{
				$existingClass = "existingClass";
				$latModified = $existingSurvey->{lastModified};
			}
		}
		$imageIconName = "dashboard_survey_completed.png";
		$htmlSueryListCards = $htmlSueryListCards."<div class='learn_content_bg'>
		<div class='col-md-2 learn_box_img'><img src='../../login/images/".$imageIconName."' alt='../../login/images/check_learn.png'  id=".$survey->{survey_id}." data='".$existingClass."' date='".$latModified."'/></div>
		<div class='col-md-7 learn_box_content'>
			<h2 style='margin-left:-17px;'>".$survey->{title}."</h2></div>
			<div class='learn_box_content_button'><span class='date_span'></span></div></div>";
		
	}

	return $htmlSueryListCards;
}



function   showSurveyCards($surveyList)
{
	
	foreach($surveyList as $showsurvey)
	{
		$surveyStatus = $showsurvey->surveySummary->{surveyStatus};
		$htmlsurveyList = "";
		$dateUtil = new DateUtil();
		$imageIconName = "dashboard_survey_completed.png";
		$lastModified = "";
		$lastModifiedDate = "";
		$modificationDate = ""; 
		if($showsurvey->{lastModified} != "")
		{
		$lastModified = "Last Modified - ";
		$lastModifiedDate = $showsurvey->{lastModified}; 
		$modificationDate = "modificationDate";
		}
	
		$htmlSurveyList = $htmlSurveyList."<div class='learn_content_bg' id='delete1'>
	
		<div class='col-md-2 learn_box_img'><a  class='' id='content1' onclick='openPageWithAjax(\"../../patientSurvey/pages/survey.php\",\"surveyId=".$showsurvey->{surveyId}."&patientId=".$showsurvey->{patientId}."&uniqueSurveyId=".$showsurvey->{uniqueSurveyId}."\",\"menu-content\",event,this)' style='cursor:pointer;'><img src='/gladstone/portal/bloom/login/images/".$imageIconName."' alt=''/></a></div>
		<div class='col-md-10 learn_box_content cardTitle' style='padding-top: 15px !important;'>
			<h2>".$showsurvey->{surveyName}."</h2>
			<div class='learn_box_content_button' style='font-size: 15px;'>".$surveyStatus."</div>
			<div class='learn_box_content_Status_button'><h5 style='font-size: 15px; padding-top:25px; text-align: right;' >".$lastModified."<span class='".$modificationDate."'> ".$lastModifiedDate."</span></h5></div>
		</div>
		</div>";
	}
	return $htmlSurveyList;
}

function getAllFaxes($getAllPendingFaxes)
{
	$entityUtil = new EntityUtil();
	 $faxHtml = "";
	  $Fcount = 0;
      foreach($getAllPendingFaxes as $getPendingFaxes)
			{
				$inOut = "";
				 $Fcount++;
				$dateUtil = new DateUtil();
				$faxNumber = $getPendingFaxes->{faxNumber};
				$faxId =$getPendingFaxes->{patientFaxId};
				$NPI = $getPendingFaxes->{nPINumber};
				$fileName = $getPendingFaxes->{fileName};
				$inOut = $getPendingFaxes->{inOut};	
				
				$date = $dateUtil->formatDatetoStr($getPendingFaxes->{createTimeStamp});
				$d = date('mdy_h',$getPendingFaxes->{createTimeStamp}); 
                $patientId = $getPendingFaxes->{patientId};
				 $paramArray = array();
                 $entityUtil = new EntityUtil();
				$paramArray[0] = $patientId;
				$patientInfo = $entityUtil->getObjectWithoutFilter($paramArray, "findPatientDetailsById", VMCPortalConstants::$API_EMR);
				$patientName = $patientInfo->{lastName}." ".$patientInfo->{firstName};
				$imageName = "";
				$patientLink = "";
				if($patientId == NULL or $patientId == "")
				{
					$patientName = "None";
				}
				if($inOut == "OUTGOING")
				{
					$in= "OUT";
					$imageName = "TopArrow.png";
					$patientLink = $patientName;
				}
				else if($inOut == "INCOMING")
				{
					$in= "IN";
					$imageName = "BottomArrow.png";
					$patientLink = "<a href='#' class='searchNpiName'  data-toggle='modal' onClick='openPageWithAjax('".$_SERVER['SERVER_NAME']."/gladstone/portal/bloom/provider/pages/showPatientResult.php','searchStr=".$patientName."&faxId=".$faxId."','searchResult',event,this);' data-target='#myModal'>".$patientName."</a> ";				
				}
				else
				{
					$imageName = "Wrong.png";		
				}	
				$file = $in."_".$d."".$faxId;
                
                
               $faxHtml = $faxHtml."<tr name='".$patientName."' faxNum='".$faxNumber."' fileName='".$fileName."' patientId='".$patientId."' faxId='".$faxId."' class='cardPanel'>
			   <th scope='row'><img src='/gladstone/portal/bloom/dashboard/images/$imageName' /></th>
             
          <td>".$date."</td>
          <td>".$faxNumber."</td>
          <td  style='cursor:pointer' onclick='openPendingFax(".$faxId.");'><a href='javascript:void(0);' >".$file."</a></td>
          <td>".$patientLink."</td></tr>";
		
		}
		return $faxHtml;
    
}
function  getAdherenceReport($aReportList)
{
	$htmlaReportList = "";
	foreach($aReportList as $aReport)
	{
		$extractFileName = $aReport->{extractFileName};
		$extractDesc = $aReport->{extractDescription};
		$extractType = $aReport->{extractType};
		$adherenceExtractContentId  = $aReport->{adherenceExtractContentId};
				
		$dateUtil = new DateUtil();
		$imageIconName = "dashboard_survey_completed.png";
			
		$htmlaReportList = $htmlaReportList." <div class='patientList_parent_bg' id='PatientList_part_bg_all'><div class='learn_content_bg'>
		<div class='col-md-2 report_box_img reportImagecss'><a  class='' id='content1'  style='cursor:pointer;' onClick='openPageWithAjax(\"/gladstone/portal/bloom/adherenceReport/pages/adherenceReportList.php\",\"extractType=".$extractType."&adherenceExtractContentId=".$adherenceExtractContentId."\",\"menu-content\",event,this);' ><img src='/gladstone/portal/bloom/login/images/".$imageIconName."' alt=''/></a></div>
		<div class='col-md-10 learn_box_content cardTitle' style='padding-top: 15px !important;'>
			<h2>".$extractDesc."</h2>
			<div class='learn_box_content_button' style='font-size: 15px;'>".$extractType."</div>
		</div>
		<div class='learn_box_content_Status_button'><h5 style='font-size: 15px; padding-top:25px; text-align: right;padding-right: 10px;' ><span>".$dateUtil->formatDateForDob($aReport->{prevStartTime})."</span> - <span>".$dateUtil->formatDateForDob($aReport->{prevEndTime})."</span></h5></div>
		</div> </div>";
	}
	//var_dump($htmlaReportList);
	return $htmlaReportList;
}
//care communication 
function   getAllCareMessage($careCommInfos)
{
	$htmlCareMsgCard = "";
	$imageIconName =  "";
	$envelopeImage = "";
	$urgent  = "";
	$dateUtil = new DateUtil();
	foreach($careCommInfos as $careCommInfo)
	{

			$imageIconName =  "";
			$envelopeImage = "";
			$urgent  = "";
			$createUserName = "";
			$assignUserName = "";
			$createTime = "";
			$updateTime = "";
			$showUrgent = false;
			$msgRead = true;
			$topRow = 0;
			$careCommDetailInfos = $careCommInfo->{careCommDetailInfos};
			foreach($careCommDetailInfos as $careCommDetailInfo)
			{
				
				if($careCommDetailInfo->{careCommHeaderId} == $careCommInfo->{careCommHeaderId})
				{				
					if($careCommDetailInfo->{urgent} == true)
					{
						$showUrgent = true;
					
					}
					
					if($careCommDetailInfo->{msgRead} != true)
					{
						$msgRead = false;
					}
				}
				if($topRow == 0)
				{
					$createUserName = $careCommDetailInfo->{createCareProvFirstName}." ".$careCommDetailInfo->{createCareProvLastName}.", ".$careCommDetailInfo->{createCareProvCredential};
					$assignUserName = $careCommDetailInfo->{assignCareProvFirstName}." ".$careCommDetailInfo->{assignCareProvLastName}.", ".$careCommDetailInfo->{assignCareProvCredential};
				$createTime = $careCommDetailInfo->{createTimeStamp};
				$updateTime = $careCommDetailInfo->{assignUserUpdateTime};
				}
				$topRow++;
			}
					if($showUrgent)
					{
						$urgent = "<img src='/gladstone/portal/bloom/login/images/warningRed.png' alt='' class='imageSize' ".$careCommInfo->{careCommHeaderId}."'/>";
						
					}
					else 
					{
						$urgent = "<img src='/gladstone/portal/bloom/login/images/warningGray.png' alt='' class='imageSize' ".$careCommInfo->{careCommHeaderId}."'/>";
					}
					if(!$msgRead)
					{
						$imageIconName = "envelopeBlack.png";
						$envelopeImage = "<img src='/gladstone/portal/bloom/login/images/".$imageIconName."' alt='' class='imageImageBlack'/>";
					}
					else 
					{
						$imageIconName = "envelopeGray.png";
						$envelopeImage = "<img src='/gladstone/portal/bloom/login/images/".$imageIconName."' alt='' class='imageImageGray'/>";
					}
				$htmlCareMsgCard = $htmlCareMsgCard."<div class='container-fluid'><div class='careMsgCard' id='careDetail_".$careCommInfo->{careCommHeaderId}."'><div class='row pd10Msg'><div class='col-lg-12 col-md-12 h4-align'><h4>".$careCommInfo->{reason}."</h4></div><div class='col-lg-5 col-md-5'>				
				<span class='labelBold'>Created by: </span> <span style='color:#000;'> ".$createUserName." </span><span class='tileDate'>".$createTime."</span></br>
				<span class='labelBold'>Assigned to: </span> <span style='color:#000;'> ".$assignUserName." </span><span class='tileDate'>".$updateTime."</span></br>				
				</div>
				<div class='col-lg-3 col-md-3 btn-bottom'>
				<a class='newText status ".$careCommInfo->{status}."D' onclick='updateCareCommStatusPopup(".$careCommInfo->{careCommHeaderId}.",".$careCommInfo->{patientId}.",this);'>".$careCommInfo->{status}." </a>
				</div>
				<div class='col-lg-2 col-md-2'><a  class='envelopeImage' onclick='updateCareCommStatus(".$careCommInfo->{careCommHeaderId}.",".$careCommInfo->{patientId}.",this);'>".$envelopeImage."</a>&nbsp; <a>".$urgent."</a></div>
				<div class='col-lg-2 col-md-2 left-pull saveButton'>
				<input class='btn btn-default btn-linktype newText showHide".$careCommInfo->{careCommHeaderId}." textChange' onclick='updateCareCommStatus(".$careCommInfo->{careCommHeaderId}.",".$careCommInfo->{patientId}.",this);' type='button' value='SHOW..'/></div>
				</div></div></div>";
			

	}
	return $htmlCareMsgCard;
}


?>
