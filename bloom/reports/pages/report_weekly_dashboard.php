<script>
	 function reload_report(){
	 openPageWithAjax('../../reports/pages/report_weekly_dashboard.php','reload=reload','menu-content','',this);
	}
</script>
<?php
	include ('helper/report_weekly_dashboard_helper.php');
?>

<style>
span.input-group-addon {
	background: none;
	border: none;
	padding: 0px 0px 0 7px;
}
</style>
<script>
window.location.hash = '/report';
</script>
    <link rel="stylesheet" type="text/css" href="../../reports/script/css/report_stylesheet.css">
    <script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="/gladstone/portal/bloom/vitals/scripts/css/bootstrap-datetimepicker.min.css">
    <script src="../../reports/script/js/report_weekly_dashboard.js"></script>
<div class="col-md-8 padd-top20">	
    <div class="col-lg-12 createReport card">
	<input type="hidden" value="<?php echo $_COOKIE['type'];?>" id="UserType" />
	<input type="hidden" value="<?php echo $_COOKIE['id'];?>" id="Userid" />
    <input type="hidden" value="" id="status" name="status" />
        <!--<div class="reporthead">
            <img src="../../common/images/DEFAULT.png" />
            <span>Taylor , John</span>
        </div>-->
            <div class="card_create_report" onclick="createNewReport()" id="createReportDiv">
                <!--<div class="col-lg-2 card_create_report_img">
                    <a href="#">
                        <img src="../../reports/images/create-report.png" />
                    </a>
                </div>-->
                <div class="card_create_report_link">
                    <a class="linkCreate" href="#">Create a new report</a>
                </div>
            </div>

        <div id="reportCardDiv">
            <div class="card_create_report_1">
                <!--<div class="col-lg-2 card_create_report_img">
                    <a href="#">
                        <img src="../../reports/images/create-report_submit.png" />
                    </a>
                </div>-->
                <div class="col-xs-offset-1 col-lg-10 card_create_report_link" style="text-align: center;">
                    <form  method="post"  id="add-report-form" 
  onSubmit="postFormAndHideAlert('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/reports/pages/report_weekly_dashboard.php?reload=reload','add-report-form','menu-content',event,'myModal')">
                        <span class="custom-dropdown custom-dropdown--white">
                            <select class="custom-dropdown__select custom-dropdown__select--white"  id="reportConfigDropDown" name="reportConfigDropDown" style="padding-left:5px !important;">
                                 <?php
									 $i = 0;
									 foreach($allKannactReportConfig as $report)
									 {
										if(!is_null($report))
										{
											  if($i == 0)
											  {
													$defaultTitle = $report->{reportTitle};
										?>
										<option selected="selected" value="<?php echo $report->{kannactReportConfigId};?>"><?php	echo $report->{reportTitle};?></option>	<?php }
										 else
										{
										?><option value="<?php	echo $report->{kannactReportConfigId};?>"><?php	echo $report->{reportTitle};?></option>
										<?php }
										}

										$i++;
									  }
									  ?>
                            </select>
                        </span>
                        <div class="row">
						
                            <div class="col-lg-6 fromDate">
                                <div class="form-group">
                                    <label class="col-md-3 fromToDate control-label" for="textinput">From</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input id="fromDateInput" type='text' class="form-control" name="fromDateInput" />
                                        <span class="input-group-addon">
                                            <img src="/gladstone/portal/bloom/reports/images/celender.png" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 fromDate">
                                <div class="form-group">
                                    <label class="col-md-3 fromToDate control-label" for="textinput">To</label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input id="toDateInput" type='text' class="form-control" name="toDateInput" />
                                        <span class="input-group-addon">
                                            <img src="/gladstone/portal/bloom/reports/images/celender.png" />
                                        </span>
                                    </div>
                                </div>
                            </div>
							
                        </div>
						<input type="hidden" name="contextPId" id="contextPId" value=<?php echo $_REQUEST['contextPId']?> />
                        <div class="form-group Engagement_Report_input">
                            <div class="col-md-9 fromToDate_input">
                                <input  name="textTitleinput" placeholder="<?php echo $defaultTitle; ?>" class="form-control input-md" type="text" id="report-title" value="<?php echo $defaultTitle; ?>" maxlength="35">
                            </div>
                            <div class="col-lg-3" style="padding-right: 0px; text-align: right;">
								<input type="hidden" name="submit" />
                                <input id="submit-adhoc" class="submit" type="submit" name="submit" value="Submit" data-toggle="modal" data-target="#PopUpOnSubmit" >
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="PopUpOnSubmit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Your Patient Biometrics Report is being created. Please check back in a few minutes.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="col-md-4 padd-top50">
			<div class="sidebar-filter">
				<div class="card">
					<div class="filter-tabs">
						<div class="padd-15">
							<button class="btn btn-neutral">All</button>
							<button class="btn btn-default active">Pre Meal</button>
							<button class="btn btn-neutral">Post Meal</button>
						</div>
						<div class="divider"></div>
						<div class="padd-15">
							<button class="btn btn-default active">7 Days</button>
							<button class="btn btn-neutral">14 Days</button>
							<button class="btn btn-neutral">30 Days</button>
						</div>
				</div>
			</div>
</div>	
-->