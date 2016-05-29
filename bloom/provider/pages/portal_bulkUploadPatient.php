<?php
include ('controller/upload_patient_controller.php');
include '../../common/util/Constants.php';
$institutionName = explode(":", $_SERVER['HTTP_HOST']);
    // Get the user name and password from he multipart items
 /* try
  { */
   	$entityUtil = new EntityUtil();

    $userName = $_COOKIE['user'];
    $password = $_COOKIE['password'];
   	$authType = $_COOKIE['authType'];
    $clientId = $_COOKIE['id'];
    $institutionName = explode(":", $_SERVER['HTTP_HOST']);
    $messageStr = "";
  	$imageName = $_COOKIE['imageLoginName'];
	
	$paramArray = array() ;
  	$paramArray[0] = VMCPortalConstants::$PHP_EMPTY;
	$paramArray[1] = "";
  	$providerList=$entityUtil->getObjectFromServer($paramArray, "getProviderList", VMCPortalConstants::$API_EMR);
	
 /* } 
    catch(UnsupportedEncodingException ex)
    {
    	throw new VMCException(ex.getMessage());
    }
    catch (Exception ex)
    {
    	throw new VMCException(ex.getMessage());
    }
    finally
    {
        if (reqInfo != null)
        {
            reqInfo.release();
        }
    }*/
?>
<div class="col-md-8 padd-top20">
<center>
<h2 style="margin-top: 25px;">Bulk Upload Patient</h2>

	<p>
		<?php echo $messageStr ?>
	</p>

	<form  method="post"
		enctype="multipart/form-data" onSubmit="return validateForm(this,event)" id="uploadData" name="uploadData">
		<table style="ali">
			<tr>
				<td>&nbsp; </td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Primary Provider:</td>
				<td> 
					<select name = "primary" id="primary">
                   
					<?php
                        foreach($providerList as $prov)
                        {
                      
		 			 ?>
                        <option value="<?php	echo $prov->{entityId}; ?>"> 
                         <?php	echo $prov->{firstName}."  ".$prov->{lastName}.", ".$prov->{credentials};?>
                        </option>
						<?php
                        }
                        ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Secondary Provider:</td>
				<td>
					<select name = "secondary" id="secondary"> 
							<?php
                        foreach($providerList as $prov)
                        {
                      
		 			 ?>
                        <option value="<?php	echo $prov->{entityId}; ?>"> 
                         <?php	echo $prov->{firstName}."  ".$prov->{lastName}.", ".$prov->{credentials};?>
                        </option>
						<?php
                        }
                        ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>Select file</td>
				<td><input type="file" name="file" id="file"/></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align: right;"><input type="submit"  value="Submit"  /></td>
			</tr>
		</table>
		<input type="hidden" value="CREATE_PATIENT" name="uploadType">
		 <input type="hidden" name="user" value="<?php echo $_COOKIE['user'];?>"/>
	  <input type="hidden" name="password" value="<?php echo $_COOKIE['password'];?>"/>
	  <input type="hidden" name="institutionName" value="<?php echo $institutionName[0];?>"/>
	   <input type="hidden" name="imageName" value="<?php echo $_COOKIE['imageLoginName'];?>"/>
        <input type="hidden" value="submit" name="submit">
	</form>
</center>
</div>
<script>
function validateForm(ele,e)
{
	var primary = $('#primary').val();
	var secondary = $('#secondary').val();
	var msg = "";
	if(primary == secondary)
	{
		msg += "Choose different provider";
	}
	
	if(msg != "")
	{
		alert(msg);
		return false;
	}
	else
	{
		console.log('in else');
		postContentMultipartForm('<?php $_SERVER['SERVER_NAME']?>/gladstone/dataUpload',ele, e);

		return false;
	}
}
function postContentMultipartForm(action, ele, e) {
    if (typeof e != undefined) {
        e.preventDefault();
    }
	var formData = new FormData($(ele)[0]);
    $.ajax({
        url: action,
        type: 'POST',
        data: formData,//$('#' + formId).serialize(),
        crossDomain: true,
		 // async: false,
           cache: false,
		   //dataType:json,
           contentType: false,
           processData: false,
		 beforeSend: function(){showLoading()},
        success: function(result) {
		 $('.close').click()
          // alert('sent successfully');
		  var text = '{ "patientData" : ' + result + '}'; 
		  var jsonData = JSON.parse(text);
		  console.log(jsonData);
		  $("#menu-content").html("");
		  for(var i=0;i<jsonData.patientData.length;i++)
		  {	
		  	var objData = jsonData.patientData[i];
			
			
		   	patientData(objData);		  
		  }   
		// $("#menu-content").html(result);
		//console.log(result);
        },
        error: function( request, textStatus, errorThrown) {
       	 //request.getResponseHeader('VMCErrorCode')
           // console.log('jqXHR'+formData.elements['title'].value);
		 //  alert("Incorrect File! Please choose different file or upload file with different name.");
		   	
        },
        complete: function() {
			hideLoading();
			console.log('completed')
			//openPageWithAjax('<?php $_SERVER['SERVER_NAME']?>/gladstone/portal/bloom/provider/pages/portal_bulkUploadPatient.php','','menu-content',e,this)
		 }
    });
}
function patientData(objData)
{		
			//var localTime  = moment.utc(objData.dateOfbirth).toDate();
			localTime = moment(objData.dateOfbirth).format('MM/ DD /YY');
					
				$("#menu-content").append("<div class='NPI_Card' style='background: #f4f4f4 none repeat scroll 0 0;  border-radius: 5px; box-shadow: 0 4px 0 0 #a6a9b8; float: left; margin-top: 10px; padding: 10px 0 4px; width: 97%; margin-left:12px;'>"
        		+ "<div class='employeeDetail'>"
        		+ "<div class='col-md-2 NPI_CardImg' style='width: 14%;'>"
        		+ "<a href='#'>"
        		+ "<img style='width: 100%;' src='/gladstone/portal/bloom/provider/images/Upload_Pat.png' />"
        		+ "</a>"
        		+ "</div>"
        		+ "<div class='col-md-4 NPI_CardDOB NPI_CardDOB_Upload'>"
        		+ "<h1 style='font-size: 19px;'>" + objData.lastName + " " + objData.firstName + "</h1>"
        		+ "<p style='color: #4a4a4a; font-size: 15px; padding-bottom: 5px; word-break: break-all;'>" + objData.userName + "</p>"
				+ "<p style='padding-bottom: 5px; color: #4a4a4a; font-size: 14px; float: left; margin-top: 15px;' class = 'time_date'>DOB : " + localTime + "</p>"
        		+ "<p style='height:30px;'></p>"
        		+ "</a>"
        		+ "</div>"
        		+"</div></div>");
			
}

</script>