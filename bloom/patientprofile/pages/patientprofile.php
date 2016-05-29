<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<!--Including css files used in all the html pages -->
<link href="/gladstone/portal/bloom/common/script/css/common-css.css" rel="stylesheet" type="text/css">
<link href="/gladstone/portal/bloom/patientprofile/script/css/patientprofile.css" rel="stylesheet" type="text/css">


  <div class="row">
    <div class="col-md-6 col-sm-6 patient_profile_left" style="padding-left:25px;">
     <h3>Patient Profile</h3>
      <form>
        <div class="form-group">
          <label class="col-md-3 col-sm-3 control-label" for="textinput">Name<span>*</span></label>
          <div class="col-md-4 col-sm-4">
            <input id="textinput" name="textinput" type="text" placeholder="First Name" class="form-control input-md">
          </div>
          <div class="col-md-4 col-sm-4">
            <input id="textinput" name="textinput" type="text" placeholder="Last Name" class="form-control input-md">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-3 control-label" for="textinput">DOB</label>
          <div class="col-md-8 col-sm-8">
            <input  name="dob" type="text" placeholder="MM/DD/YYYY " id="dob" class="form-control input-md">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-3 control-label" for="textinput">Address<span>*</span></label>
          <div class="col-md-8 col-sm-8">
            <input id="textinput" name="textinput" type="text" placeholder="Address 1" class="form-control input-md">
             <input id="textinput" name="textinput" type="text" placeholder="Address 1" class="form-control input-md" style="margin:15px 0;">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-3 control-label" for="textinput">Phone</label>
          <div class="col-md-8 col-sm-8">
            <input id="textinput" name="textinput" type="text" placeholder="Phone" class="form-control input-md" style="margin-bottom:15px;">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 col-sm-3 control-label" for="textinput">City/State<span>*</span></label>
          <div class="col-md-5 col-sm-5">
            <input id="textinput" name="textinput" type="text" placeholder="City" class="form-control input-md">
          </div>
          
          <div class="col-md-3 col-sm-3">
          <span class="custom-dropdown custom-dropdown--white" style="color:#000">
            <select class="custom-dropdown__select custom-dropdown__select--white" style="width:85px; height:32px;">
              <option>1</option>
              <option>1</option>
              <option>1</option>
              <option>1</option>
            </select>
            </span>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-6 col-sm-6 patient_profile_right" style="padding-right:20px;">
    <h3>Insurance Details</h3>
     <div class="col-md-12 col-sm-12 patient_profile_right1" style="padding:0">
      <p><strong class="col-md-6 col-sm-6">Name</strong>Name of Insurance</p>
      <p><strong class="col-md-6 col-sm-6">Group Id Number</strong>Group Id Number</p>
      <p><strong class="col-md-6 col-sm-6">Employee Name</strong>Employee Name</p>
      <p><strong class="col-md-6 col-sm-6">Employee Contact Number</strong>Employee Contact Number</p>
    </div>
    </div>
    
<div class="col-lg-12 col-sm-12 patient_profile_but" >
<input type="submit" value="Send">
</div>
  </div>

