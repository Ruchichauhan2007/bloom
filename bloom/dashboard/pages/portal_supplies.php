<style>
.mytab { position: relative; }
.pDet { position: absolute; right: 0; top: 0; }
.pName, .pDate { display: inline-block; font-size: 13px; font-weight: bold; padding: 5px 16px; }
.mytab .pull-right { margin: 0; }
.btn.btn-default.btn-linktype { background-color: transparent; border: medium none; color: #666; text-transform: capitalize; }
.mytab .nav a { background: transparent none repeat scroll 0 0 !important; border-radius: 0; color: #000; cursor: pointer; font-size: 12px; font-weight: bold; margin: 0; padding: 5px 17px; text-decoration: none; }
.nav > li.active > a { border-color: #333 #333 #fff; }
.mytab .nav { padding-left: 20px; }
.mytab legend { border-bottom: medium none; border-top: 1px solid #eee; margin-top: 30px; padding: 10px 0; }
.mytab .control-label { text-align: left; }
.mytab .btn.btn-success { background-color: #93c47d; border-color: #666; border-radius: 2px; font-weight: bold; padding: 7px 20px; text-transform: uppercase; }
.mytab .nav li { background: #DDD none repeat scroll 0 0; height: auto; }
.mytab .tab-pane.active { background-color: transparent; border: medium none; }
.mytab label { color: #777 !important; font-size: 14px !important; }
.mytab label.radio-inline { color: #000 !important; }
.mytab .form-control { border-color: #333 !important; box-shadow: none !important; }
.mytab .nav li.active > a { border-color: #333 #333 transparent; }
.mytab .nav li > a { border-color: #333; }
/* Page 2 styles */

.two { border-bottom: medium none !important; }
.mytab .table.my-style { background-color: #eeeeee; border: 1px solid #333; }
.mytab .my-style > thead > tr > th { border-bottom: 1px solid; color: #777; padding: 5px; text-transform: uppercase; vertical-align: middle; }
.mytab .my-style .checkbox { padding: 0; margin: 0; }
.table.my-style th:first-child, .table.my-style td:first-child { text-align: center; }
.table.my-style th:last-child, .table.my-style td:last-child { text-align: right; }
.mytab .my-style > thead > tr > td { border-bottom: medium none; }
.mytab .my-style > tbody > tr > td { border: medium none !important; cursor: pointer; font-weight: bold; padding: 5px; text-transform: capitalize; vertical-align: middle; }
.mytab .my-style > tbody > tr:hover > td, .mytab .my-style > tbody > tr:active > td, .mytab .my-style > tbody > tr:hover > td, .mytab .my-style > tbody > tr.active > td { background-color: #9fc5f8; }
.mytab .my-style td:last-child .form-control { border-color: #666; border-radius: 0; display: inline-block; margin-right: 10px; width: 35px; }
.mytab .Bval { color: #000 !important; font-size: 22px !important; padding: 0; }
.mytab .myLtable .Bval { font-size: 14px !important; }
</style>
<div class="clearfix">
  <form class="form-horizontal">
    <fieldset>
    <!-- Form Name -->
    <legend>Supply Levels</legend>
    <div class="form-group">
      <div class="col-md-1">
        <label for="ex1">STRIPS</label>
        <input id="textinput" name="textinput" placeholder="43" class="form-control input-md" required="" type="text">
      </div>
      <div class="col-md-1">
        <label for="ex3">LANCATS</label>
        <input id="textinput" name="textinput" placeholder="  43" class="form-control input-md" required="" type="text">
      </div>
      <div class="col-md-2">
        <label for="ex2">SOLUTION AFTER</label>
        <div class="row">
          <div class="col-md-9" style="">
            <input id="textinput" class="form-control input-md" type="text" name="textinput" placeholder=" / / " required="">
          </div>
          <div class="col-md-3 text-left"> <img src="https://cdn3.iconfinder.com/data/icons/linecons-free-vector-icons-pack/32/calendar-24.png" style="padding-top: 7px;"> </div>
        </div>
      </div>
      <div class="col-md-2">
        <label for="ex3">GLUCOMETER ID</label>
        <input id="textinput" name="textinput" placeholder=" 00001891874719" class="form-control input-md" required="" type="text">
      </div>
      <div class="col-md-4">
        <label for="selectbasic" class="">TYPE</label>
        <div>
          <label class="control-label Bval" for="textinput">GL AT&T 3G</label>
        </div>
      </div>
      <div class="col-md-2">
      <div class="clearfix">
      <label class="" for="selectbasic">&nbsp;</label>
      </div>
      <div class="clearfix">
        <div class="pull-right">
          <button type="reset" class="btn btn-default btn-linktype">cancel</button>
          <button type="button" class="btn btn-success">Save</button>
        </div>
        </div>
      </div>
    </div>
  </fieldset>
  </form>
</div>
<div class="form-group">
<form class="form-horizontal">
  <fieldset>
    <!-- Form Name -->
    <legend> Order New Supplies</legend>
    <div class="row">
      <div class="col-md-2">
        <div>
          <label for="ex2">FREQUENCY</label>
        </div>
        <div>
          <label class="col-md-2 control-label Bval" for="textinput">5</label>
        </div>
      </div>
      <div class="col-md-2">
        <div>
          <label for="ex2">ASSIGNED COACH</label>
        </div>
        <div>
          <label class="col-md-2 control-label Bval" for="textinput">Stephen</label>
        </div>
      </div>
      <div class="col-md-3">
        <div>
          <label for="ex1">ORDER NOTE</label>
        </div>
        <div>
          <input class="form-control" id="ex1" type="text">
        </div>
      </div>
      <div class="col-md-2">
        <div>
          <label for="ex2">SHIPPING METHOD</label>
        </div>
        <select id="selectbasic" name="selectbasic" class="form-control pt5">
          <option value="1">Select Method</option>
        </select>
      </div>
    </div>
    </fieldset>
    </form>
    </div>
<div class="row">
  <div class="col-md-9 bg_clr">
    <table class="table my-style">
      <thead>
        <tr>
          <th width="10%"> <div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div>
          </th>
          <th>Code</th>
          <th>Description</th>
          <th width="15%">Amount</th>
        </tr>
      </thead>
      <tbody class="two">
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td class="two">GL Test Strips (50 Count)</td>
          <td>KAN0021.0003</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Lancets (25 Count)</td>
          <td>KAN0022.0001</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Solution</td>
          <td>KAN0023.0002</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Lancing pen</td>
          <td>KAN0024.0001</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Lancing Device</td>
          <td>KAN0024</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Meter-T-mobile 3G</td>
          <td>KAN0036</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Meter-AT &amp; T 3G</td>
          <td>KAN0037</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Meter-T-mobile 2G</td>
          <td>KAN0020</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Stater Kit Guide</td>
          <td>KAN0028</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>GL Partient Welcome Letter</td>
          <td>KAN0029</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>AAA Batteries(4 Count)</td>
          <td>KAN0025</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>Return Postcard</td>
          <td>KAN0033</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>Coach Mike Note</td>
          <td>KAN0015</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>Coach Stephen Note</td>
          <td>KAN0014</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>Return Shipping Label</td>
          <td>KAN0032</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
        <tr>
          <td><div class="checkbox">
              <label>
                <input type="checkbox" value="">
              </label>
            </div></td>
          <td>Return Envelope</td>
          <td>KAN0034u</td>
          <td><input id="textinput" name="textinput" placeholder="5" class="form-control input-md" required="" type="text"></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-3 btn_order" style="margin-top: 710px;">
    <div class="pull-right">
      <button type="reset" class="btn btn-default btn-linktype">cancel</button>
      <button type="button" class="btn btn-success">ORDER</button>
    </div>
  </div>
</div>
<div class="">
  <form class="form-horizontal">
    <fieldset>
      
      <!-- Form Name -->
      <legend>Order History</legend>
      
      <!-- Text input-->
      <div class="row">
      <div class="col-md-9 bg_clr">
        <table class="my-style table ">
          <thead>
            <tr>
              <th>Date</th>
              <th>ID</th>
              <th>Note</th>
              <th>Shipping</th>
              <th>Status</th>
              <th>Tracking</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="one">01/05/2017</td>
              <td>567-00988</td>
              <td>Pending</td>
              <td>-</td>
              <td>Next Day Air Sat</td>
              <td>Pending</td>
            </tr>
            <tr>
              <td>12/25/2016</td>
              <td>567-00742</td>
              <td>Rush Order-Out Of  Strips</td>
              <td>Next Day Air </td>
              <td>Submitted</td>
              <td>-</td>
            </tr>
            <tr class="one">
              <td>03/15/2016</td>
              <td>567-00188</td>
              <td>Last Refill</td>
              <td>-</td>
              <td>Shipped</td>
              <td>98789798179</td>
            </tr>
            <tr class="one">
              <td>01/15/2016</td>
              <td>567-00187</td>
              <td>welcome Kit Special Order</td>
              <td>USPS Express</td>
              <td>Shipped</td>
              <td>36673627361</td>
            </tr>
          </tbody>
        </table>
      </div>
      </div>
      <div class="row">
      <div class="col-md-9 myLtable">
        <div class="clearfix">
          <div class="col-md-4">
            <label for="selectbasic" class="">CODE</label>
          </div>
          <div class="col-md-6">
            <label for="selectbasic" class="">DESCRIPTION</label>
          </div>
          <div class="col-md-2 text-right">
            <label for="selectbasic" class="">AMOUNT</label>
          </div>
        </div>
        <div class="clearfix">
          <div class="col-md-4">
            <label class="control-label Bval" for="textinput">GLStrips</label>
          </div>
          <div class="col-md-6">
            <label class="control-label Bval" for="textinput">GL Test Strips ( Cloudia ) - 50 Count</label>
          </div>
          <div class="col-md-2 text-right">
            <label class="control-label Bval" for="textinput">5</label>
          </div>
        </div>
        <div class="clearfix">
          <div class="col-md-4">
            <label class="control-label Bval" for="textinput">GLLancets</label>
          </div>
          <div class="col-md-4">
            <label class="control-label Bval" for="textinput">GL Lancets 30 G - 25 Count</label>
          </div>
          <div class="col-md-4 text-right">
            <label class="control-label Bval" for="textinput">10</label>
          </div>
        </div>
      </div>
      </div>
    </fieldset>
  </form>
</div>