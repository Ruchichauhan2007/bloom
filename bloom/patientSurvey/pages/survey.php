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

<?php include('controller/survey_controller.php');
$count = 0;
$summaryPages = "";
$status = "";
?>
<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientSurvey/script/css/Survey.css">

<div class="col-md-8 padd-top20">
<div class="col-lg-12 survey">
<?php
//var_dump($survey);
 foreach($survey as $eachSurvey)
{
	
	if($eachSurvey->{surveyId} == $_REQUEST['surveyId'] && $eachSurvey->{uniqueSurveyId} == $_REQUEST['uniqueSurveyId'])
	{
	 $surveyName = $eachSurvey->{surveyName};
?>
<h1><?php echo $eachSurvey->{surveyName}; ?></h1>
<?php 
	}
}
?>
<!--<div class="infoSurvey">
<p>Hey there! I'm <strong>Nicole Partridge</strong>, your personal Care Coordinator.</p>
<p>Before your in-person visit, I need your help completing each of the sections below. If you can't answer everything or you aren't sure, we will review it together</p>
<p>If you get stuck, tap <a href="#">Ask Nicole</a> to send me a message. Talk to you soon!</p>
</div>-->
</div>
<div class="col-lg-12 Table_Survey">
<div class="table-responsive">
<table class="table">
      <thead>
        <tr>
           <th class="Number">#</th>
           <th class="Number">Section</th>
          <th class="Number">Answered</th>
          <th class="Number StatusArrow">Status</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $userTYPE = $_COOKIE['type'];
		
		$reportUrl = "";
		$reportFileName = "";
	  foreach($survey as $eachSurvey)
	{	
		$pageCount = 1;
		if($eachSurvey->{surveyId} == $_REQUEST['surveyId'] && $eachSurvey->{uniqueSurveyId} == $_REQUEST['uniqueSurveyId'])
		{
			
			$newstr = str_replace("'", '_', $eachSurvey->{surveyName});
			$reportUrl = $eachSurvey->surveySummary->{reportUrl};
			$reportFileName = $eachSurvey->surveySummary->{reportFileName};
			$surveyStatus = $eachSurvey->surveySummary->{surveyStatus};
			//echo $surveyStatus;
			$pages = $eachSurvey->surveySummary->{summaryPages};
			  foreach($pages as $page)
			{
				$accessLevel = "";
				$sectionDisabled = "";
				$metaDataInfo = $page->{metaInfo};
				
				$accessList = $metaDataInfo->{accessList}; 
				foreach($accessList as $access)
				{
					if(strtoupper($access->{roleName}) == strtoupper($userTYPE))
					{
						$accessLevel = $access->{accessLevel};
					}
				}
				if(strtoupper($accessLevel) == "NONE" && $surveyStatus != "Reviewed")
				{
					$sectionDisabled = "isDisabled";
				}
				else
				{
					$sectionDisabled = "";
				}
			   ?>     
				<tr class="<?php echo $sectionDisabled; ?>">
				  <td class="SectionSurveyNumber"><?php echo $pageCount ; ?></td>
				  <td class="SectionSurvey"><?php echo $page->{title} ; ?></td>
				  
				  <td><span class="inComplete"><?php echo $page->{answeredQuestions} ; ?></span>/<span><?php echo $page->{totalQuestions} ; ?></span></td>
				  <td align="right"><a class="inComplete" href="#" onClick="openPageWithAjax('../../patientSurvey/pages/surveyDetail.php','surveyId=<?php echo $eachSurvey->{surveyId}; ?>&pageId=<?php echo $page->{pageId}; ?>&patientId=<?php echo $eachSurvey->{patientId}; ?>&surveyStatus=<?php echo $surveyStatus; ?>&surveyName=<?php echo $newstr; ?>&uniqueSurveyId=<?php echo $eachSurvey->{uniqueSurveyId}; ?>','menu-content',event,this)"><?php echo $page->{status} ; ?><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></td>
				</tr>
                        
			<?php
				
				if($page->{status} == "Review" || $page->{status} == "Completed")
				{
					$count++; 
				}
				$pageCount++;
			}
			if($surveyStatus == "Reviewed" && $surveyName =="Annual Wellness Visit")
			{
				try
				{
					$entUtil = new EntityUtil();
					$msg = "";
						
					//$paramArray array();
					$paramArray[0] = $reportFileName;
					$paramArray[1] = "PDF";
					$reportUrl = $entUtil->getObjectFromServer($paramArray, "getAWNReportContentUrl", VMCPortalConstants::$API_EMR);
				
				}
				catch(Exception $e)
				{
					$msg = $e->getMessage();
				}
				
				?>			
				<tr> 
				<td></td>
				<td class="SectionSurvey">Report</td>
				<td></td>
				<td align="right"><a class="1" id="1"  href="javascript:void(0);" onclick='contentReport()'>View<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></td>
				</tr>
				<?php
			}
		}
		
		$summaryPages = count($eachSurvey->surveySummary->{summaryPages});
		
		
    }
	
    ?>      
      </tbody>
    </table>
</div>
</div>
<div class="col-lg-12 SubmitSurvey">

<?php 
	if($surveyStatus != "Reviewed")
		{
			if($surveyName !="Annual Wellness Visit")
			{?>
            <div class="col-md-6">
			<p>You have completed <strong><?php echo $count; ?></strong> sections. Keep going!</p>
            </div>
			<?php
			}
						
		}
		else
		{
			if($surveyName !="Annual Wellness Visit")
			{?>
			<p>You have completed this survey, thank you!</p>
			<?php
			}
			else
			{
			?>
			<p>Congratulations, this survey is complete! You can view all answers, but you can&rsquo;t make any changes.</p>
			<?php
            }
			
		}
?>

<form  id="surveyForm" onSubmit="postForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/patientSurvey/pages/survey.php','surveyForm','menu-content',event)">
<?php
if($surveyName !="Annual Wellness Visit")
{?>
<div class="col-md-6" style="text-align:right;">
<?php
}
else
{
?>
<div class="col-md-12" style="text-align:right;">
<?php
}
?>
<?php 
	if(count($pages) == $count && strtoupper($_COOKIE['type']) == 'PROVIDER' && $surveyStatus != "Reviewed")
		{
?>	
			<button class="btn btn-default btn-submitS btn-lg btn-enable" type="submit" >Complete</button>
            <input type="hidden" name="Reviewed"  value="Reviewed" />
            <input type="hidden" name="surveyId" value="<?php echo $_REQUEST['surveyId'];?>"  />
            <input type="hidden" name="patientId" value="<?php echo $_REQUEST['patientId'];?>" />
            <input type="hidden" name="uniqueSurveyId" value="<?php echo $_REQUEST['uniqueSurveyId'];?>" />

<?php			
		}
		else
		{
?>
			<!--<button class="btn btn-default btn-submitS btn-lg" type="submit" disabled="disabled"><?php //echo $surveyStatus ?> <span class="glyphicon glyphicon-send"></span></button>-->
<?php		
		}
?>

</div>
</form>
</div>
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
function contentReport()
{
	window.open('<?php echo $reportUrl; ?>','video','top=150, left=352, width=700, height=500, toolbar=no, menubar=no, location=no, scrollbars=no, resizable=no');
	return false;
}
</script>