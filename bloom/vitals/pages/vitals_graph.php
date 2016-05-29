<style>
.graph-content {
    background: none repeat scroll 0 0 #fff;
}
.vitals-content {
    background: none repeat scroll 0 0 #fff;
}
#segmentSelect, #zoomSelect {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 20px;
    padding: 3px 6px !important;
    vertical-align: middle;
    width: 144px !important;
}
.vitals-content p {
    font-family: raleway;
    padding: 0 0 6px;
}
.vitals-content > h4 {
    height: 50px;
}
.y.label {
    font-size: 15px;
	margin-bottom:10px;
}
.tick {
    font-size: 15px;
}
</style>
<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
<script src="/gladstone/portal/bloom/common/script/js/d3.v3.js" charset="utf-8"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/vitals/scripts/js/vitals_constants.js"></script>
<script type="text/javascript" src="/gladstone/portal/bloom/common/script/js/post-data.js"></script>
<script src="/gladstone/portal/bloom/vitals/scripts/js/vitals_graph.js"></script>

<link rel="stylesheet" type="text/css" href="/gladstone/portal/bloom/vitals/scripts/css/vitals.css">

<div>
    <p id="selectedPatient">
        <img  style="height:42px; width:42px; border-radius:100%; margin-right:10px;"  src="/gladstone/portal/bloom/portalLearn/images/learn_patient_img.jpg" alt="">
        <span></span>
        </span>
    </p>
    <script>
    $(function() {
        if ($('#contextPatientName').val() != "") {
            $('#selectedPatient').find('img').attr('src', $('#contextPatientImage').val());
            $('#selectedPatient').find('span').html($('#contextPatientName').val());
        } else {
            $('#selectedPatient').hide();
        }
    });
$(document).ready(function() {
	$("td.glucose-table-item normal").each(function( index, element) {
	var time = moment($(element).html());
	//time.subtract(time.zone(), 'minutes');
	var localTime  = moment.utc($(element).text()).toDate();
    localTime = moment(localTime).format('MMM D h:mm A');
	$(element).html(localTime);
});
});
    </script>
</div>

<div class="vitals-content">
    <h4>
        <select id="segmentSelect" onchange="javascript:reloadGraph()">
            <option selected="selected" value="ALL">All</option>
            <option value="BREAKFASTPRE">Pre-breakfast</option>
            <option value="BREAKFASTPOST">Post-breakfast</option>
            <option value="LUNCHPRE">Pre-lunch</option>
            <option value="LUNCHPOST">Post-lunch</option>
            <option value="DINNERPRE">Pre-dinner</option>
            <option value="DINNERPOST">Post-dinner</option>
            <option value="SLEEP">Sleep</option>
            <option value="NA">Unspecified</option>
        </select>
   
        <select id="zoomSelect" onchange="javascript:zoom()">
            <option selected="selected" value="7 day">7 day</option>
            <option value="30 day">30 day</option>
            <option value="90 day">90 day</option>
        </select>
        
        <div style="display:inline-block;margin-top:15px;vertical-align:middle;">
            <div style="display:inline-block;margin-right:1px;">
                <p style="font-size:14px;" id="breakfast-label"></p>
                <p style="font-size:14px;" id="lunch-label"></p>
            </div>
            <div style="display:inline-block;">
                <p style="font-size:14px;" id="dinner-label"></p>
                <p style="font-size:14px;" id="bedtime-label"></p>
            </div>
        </div>
        
  <button style="font-size: 12px; background-color: #1adb82; padding: 10px 10px;  border: none;  border-radius: 5px;  color: #fff;  float: right; margin-top: 14px;    margin-right: 3px;" data-toggle="modal" data-target="#moremodal">More</button>
    </h4>
    <div class="graph-content">
    </div>
</div>

<div class="modal fade" id="moremodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="../images/close.jpg" align="right" class="close" /></span></button>
        <h4 class="modal-title" id="myModalLabel">More Details..</h4>
      </div>
      <div class="modal-body">
        <div class="Section1" style=" background:#fff; font-size: 14px;padding: 7px 10px; text-align: justify;">
        <p>Green band represents the target ranges recommended by the ADA for most non pregnant adults with diabetes.*</p>
        </div>
        <div class="Section2" style="background: #00FF66;font-size: 14px;padding: 7px 10px; text-align: justify;">
        <p>Before a meal:70-130 mg/dl</p>
        </div>
        <div class="Section3" style="background: #009900;font-size: 14px;padding: 7px 10px; text-align: justify;">
        <p>1-2 hour after begining a meal: Less than 180 mg/dl</p>
        </div>
        <!--<div class="Section4" style="background: #D6D9DE;font-size: 14px;padding: 7px 10px; text-align: justify;">
        <p></p>
        </div>-->
      </div>
      <div class="modal-footer" style="margin:0px;">
        <button type="button" class="btn btn-primary" style=" background-color: #1adb82;
    border-color: -moz-use-text-color -moz-use-text-color #18ab67;
    border-radius: 5px;
    border-style: none none solid;
    border-width: medium medium 0px;
    color: #fff;
    cursor: pointer;
    font-size: 14pt;
    height: 40px;
    margin: 0px 10px 10px 0;
    padding: 3px;
    text-align: center;
    width: 100px;" data-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>