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
        <li><a href="#"><img src="../images/dashboard_schedule.jpg" alt=""></a></li>
        <li><a href="#"><img src="../images/dashboard_ranges.png" alt=""></a></li>
      </ul>
	  
    </div>
	<form>
	  		<div class="dashboardpopup_glucometer_left">
				<label>Make/Model</label><br>
				<select>
					<option>Fora Test N' Go</option>
					<option>1</option>
					<option>1</option>
				</select>
			</div>
			<div class="dashboardpopup_glucometer_left">
				<label>Set Acceptable Glucose Range</label><br>
				<div class="dashboard_box"><input type="text" placeholder="80"><span>LOW</span></div>
				<div class="dashboard_box"><input type="text" placeholder="150"><span>High</span></div>
				<p>mg/dl</p>
				<div class="dashboard_popup_buttonsbg">
					<input type="reset" value="Cancel">
					<input type="submit"  class="submit" value="Save">
				</div>
			</div>
	  </form>
  </div>
</div>
</body>
</html>
