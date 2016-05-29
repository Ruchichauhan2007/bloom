<style>
.config h1 {
    background: none repeat scroll 0 0 #dedfe0;
    color: #46464b;
    font-size: 23px;
    font-weight: normal;
    padding: 7px 35px 6px;
	border: 1px solid #8a8c98;
}
.GlucoseAcceptable h2 {
    background: none repeat scroll 0 0 #cacdcd;
    border-bottom: 1px solid #b5b7c0;
    font-size: 23px;
    padding: 8px 37px;
}
.Caution > p {
    font-size: 22px;
    padding: 5px 0;
}
.Caution2 > p {
    font-size: 22px;
    padding: 5px 0;
}
.Caution1 > input {
    box-shadow: 0 2px 2px 1px #777 inset;
    float: right;
    font-size: 18px;
    height: 35px;
    margin-top: 5px;
    padding: 1px 5px;
    text-align: right;
    width: 75%;
}
.GlucoseAcceptable h3 {
    background: none repeat scroll 0 0 #cacdcd;
    border-bottom: 1px solid #b5b7c0;
    float: left;
    font-size: 23px;
    padding: 8px 37px;
    width: 100%;
	margin-top:15px;
}
.custom-dropdown__select {
    font-size: 17px;
    height: 33px;
    width: 75px !important;
}
span.custom-dropdown.custom-dropdown--white {
    margin-top: 5px;
}
.GlucoseAcceptableTable {
    float: left;
    margin: 1px 0;
    width: 100%;
}
</style>
<div class="config">
<h1>Configuration</h1>
</div>
<div class="GlucoseAcceptable">
<h2>Glucose Acceptable Range</h2>
</div>
<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-6 Caution">
<p>Caution Zone High (Yellow)</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="180"/>
</div>
<div class="col-lg-3 Caution2">
<p>mg/dL</p>
</div>
</div>
<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-6 Caution">
<p>Target Zone High (Green)</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="120"/>
</div>
<div class="col-lg-3 Caution2">
<p>mg/dL</p>
</div>
</div>
<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-6 Caution">
<p>Target Zone Low (Green)</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="80"/>
</div>
<div class="col-lg-3 Caution2">
<p>mg/dL</p>
</div>
</div>
<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-6 Caution">
<p>Caution Zone Low (Yellow)</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="70"/>
</div>
<div class="col-lg-3 Caution2">
<p>mg/dL</p>
</div>
</div>
<div class="GlucoseAcceptable">
<h3>Meal Setup</h3>
</div>

<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-2 Caution">
<p>Breakfast</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="05:00"/>
</div>
<div class="col-lg-3 Caution2">
<form>
<span class="custom-dropdown custom-dropdown--white">
<select id="patientList" class="custom-dropdown__select custom-dropdown__select--white" name="patientList">
<option selected="selected" value="MYPATIENT">AM</option>
<option value="ALL">PM</option>
</select>
</span>
</form>
</div>
</div>
<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-2 Caution">
<p>Breakfast</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="05:00"/>
</div>
<div class="col-lg-3 Caution2">
<form>
<span class="custom-dropdown custom-dropdown--white">
<select id="patientList" class="custom-dropdown__select custom-dropdown__select--white" name="patientList">
<option selected="selected" value="MYPATIENT">AM</option>
<option value="ALL">PM</option>
</select>
</span>
</form>
</div>
</div>
<div class="GlucoseAcceptableTable">
<div class="col-xs-offset-1 col-lg-2 Caution">
<p>Breakfast</p>
</div>
<div class="col-lg-2 Caution1">
<input type="text" placeholder="Caution" value="05:00"/>
</div>
<div class="col-lg-3 Caution2">
<form>
<span class="custom-dropdown custom-dropdown--white">
<select id="patientList" class="custom-dropdown__select custom-dropdown__select--white" name="patientList">
<option selected="selected" value="MYPATIENT">AM</option>
<option value="ALL">PM</option>
</select>
</span>
</form>
</div>
</div>
