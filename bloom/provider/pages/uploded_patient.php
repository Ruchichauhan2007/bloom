<link rel="stylesheet" type="text/css" href="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/script/css/NPI_Style.css">
<div class="col-lg-12">
<div class="NPI_Card">
<div class="employeeDetail">
<div class="col-md-2 NPI_CardImg">
<a href="#"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/Upload_Pat.png" /></a>
</div>
<div class="col-md-3 NPI_CardDOB NPI_CardDOB_Upload">
<h1>PRESUTTI CRISTIAN</h1>
<p>Info@Example.com</p>
<p style="height:30px;"></p>
<a id="moredetail">More <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
</div>

<div class="col-md-3 NPI_CardBttn1" style="padding:0;">
<h1>NPI Detail</h1>
<p>First name Last name</p>
<p>Phone : +91-12345-67890</p>
<p>Fax : (800) 123 454</p>

</div>

<div class="col-md-4 NPI_CardBttn12">
<p>2964 NE ROSETREE DR </p>
<p>Lorem ipsum dolor sit amet</p>
<p>Phone : +91-12345-67890</p>
<p>Fax : (800) 123 454</p>

</div>
</div>

<div class="NPI_CardDetails" id="NPI_CardDetails" style="display:none;">
<div class="col-md-6 ADD_Detail_NPI ADD_Detail_NPI_Upload">
<h1>Additional Detail</h1>
<p><span class="col-md-6">Lorem ipsum dolor :</span> Lorem ipsum</p>
<p><span class="col-md-6" style="height:30px;">Lorem ipsum dolor :</span>  Lorem ipsum dolor sit amet <br /> Lorem ipsum dolor sit amet</p>
<p><span class="col-md-6">Lorem ipsum dolor :</span>  Lorem ipsum dolor sit amet</p>
</div>
<div class="col-md-6 ADD_Detail_NPI ADD_Detail_NPI_Upload">
<h1>Additional Detail</h1>
<p><span class="col-md-6">Lorem ipsum dolor :</span>  Lorem ipsum dolor sit amet</p>
<p><span class="col-md-6">Lorem ipsum dolor :</span>  Lorem ipsum dolor sit amet</p>
<p><span class="col-md-6">Lorem ipsum dolor :</span>  Lorem ipsum dolor sit amet</p>
<p><span class="col-md-6">Lorem ipsum dolor :</span>  Lorem ipsum dolor sit amet</p>
</div>
<div class="lessCardUpload">
<a id="lessDetail">Less <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
<div class="ChangeNPI">
<button class="btn btn-default Change-NPI-orange">Fax</button>
<button class="btn btn-default Change-NPI" data-toggle="modal" data-target="#myModal">Change NPI</button>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/images/Cross_Modal.png" /></span></button>
        <h4 class="modal-title" id="myModalLabel">NPI Search</h4>
      </div>
      <div class="modal-body">
       <div class="form-group">
  <div class="col-md-12">
    <div class="input-group">
      <input id="appendedtext" name="appendedtext" class="form-control" placeholder="NPI Number" type="text">
      <span class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
    </div>
    <div class="table-responsive">
    <table class="table table-striped">
      <tbody>
        <tr>
          <td scope="row">Name :</td>
          <td>Prusetti Cristain</td>
          <td>NPI Number :</td>
          <td>1508913534</td>
        </tr>
        <tr>
          <td scope="row">Address :</td>
          <td>2964 ne rosetree dr<br />
			 Lorem ipsum dolor sit amet</td>
          <td>E-mail :</td>
          <td>info@example.com</td>
        </tr>
        <tr>
          <td scope="row">Phone :</td>
          <td>+91-12345-56789</td>
          <td>Identifiers :</td>
          <td>32592</td>
        </tr>
        <tr>
          <td scope="row">Fax :</td>
          <td>(800) 123 456</td>
          <td>Taxonomies  :</td>
          <td>207Q00000X</td>
        </tr>
      </tbody>
    </table>
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#moredetail").click(function(){
		  $("#NPI_CardDetails").slideDown();
		  $("#moredetail").css("display","none")
		}); 
		
		$("#lessDetail").click(function(){
		  $("#NPI_CardDetails").slideUp();
		  $("#moredetail").css("display","block")
		}); 
	});
</script>

