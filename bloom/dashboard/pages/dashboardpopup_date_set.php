<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../common/script/css/common-css.css" rel="stylesheet" type="text/css">
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />
<title>Gladstone</title>
<!--Including css files used in all the html pages -->
<link href="../script/css/dashboard.css" rel="stylesheet" type="text/css">
<!--***** -->
<body>
<!--start header -->
<div class="wapper">
  <div class="dashboardpopup_glucometer">
    <h2>Glucometer</h2>
    <div class="dashboardpopup_glucometer_nav">
      <ul>
        <li><a href="#"><img src="../images/schedule.png" alt=""></a></li>
        <li><a href="#"><img src="../images/ranges.png" alt=""></a></li>
      </ul>
    </div>
    <form>
      <div class="dashboardpopup_dateset_left">
        <label>Make/Model</label>
        <br>
        <select>
          <option>Fora Test N' Go</option>
          <option>1</option>
          <option>1</option>
        </select>
      </div>
      <div class="dashboardpopup_dateset_leftpart">
        <div class="dashboardpopup_dateset_day">
          <div class="form-item form-type-checkbox form-item-field-school-education-und-28">
            <input type="checkbox" id="edit-field-school-education-und-28" name="field_school_education[und][28]" value="28" checked="checked" class="form-checkbox">
            <label class="option" for="edit-field-school-education-und-28">Everyday</label>
          </div>
          <input type="text" value="Sun">
          <input type="text" value="Mon">
          <input type="text" value="Tue" class="last">
          <input type="text" value="Wed">
          <input type="text" value="Thu" class="last">
          <input type="text" value="Fri">
          <input type="text" value="Sat" class="last">
        </div>
      </div>
      <div class="dashboard_set_time_pm">
      <div class="dashboard_set_timedate">
        <input type="text" value="00" class="active">
        <input type="text" value="15">
        <input type="text" value="30">
        <input type="text" value="45">
      </div>
      <div class="clear"></div>
      <div class="set_time_text">A.M.</div>
      <div class="set_time_bg">
        <input type="text" value="12" class="active">
        <input type="text" value="1">
        <input type="text" value="2">
        <input type="text" value="3">
        <input type="text" value="4">
        <input type="text" value="5">
        <input type="text" value="6">
        <input type="text" value="7">
        <input type="text" value="8">
        <input type="text" value="9"  class="active">
        <input type="text" value="10">
        <input type="text" value="11">
      </div>
    </form>
  </div>
  <div class="dashboard_set_time_pm">
    <div class="set_time_text">P.M.</div>
    <div class="set_time_bg">
      <input type="text" value="12" class="active">
      <input type="text" value="1">
      <input type="text" value="2">
      <input type="text" value="3">
      <input type="text" value="4">
      <input type="text" value="5">
      <input type="text" value="6"  class="active">
      <input type="text" value="7">
      <input type="text" value="8">
      <input type="text" value="9">
      <input type="text" value="10">
      <input type="text" value="11">
    </div>
    <div class="dashboard_setpm_time">
      <input type="text" value="15" class="active">
    </div>
    <div class="dashboard_setpm_time">
      <input type="text" value="30" class="active">
    </div>
	<div class="dashbord_set_time_popup_but">
		<input type="reset" value="Cancel">
		<input type="submit"  class="submit" value="Submit">
	</div>
    </form>
  </div>
</div>
</body>
</html>
