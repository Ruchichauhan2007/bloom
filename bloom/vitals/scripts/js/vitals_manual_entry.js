var patientDevice;


function getPatientDeviceDetails(vitalType) {
    var arr = new Array();
    arr[0] = vitalType;
    var dataVal = JSON.stringify(arr);
    var retVal = postDataToServer(dataVal, EMR, 'getDeviceByLoginNameAndVitalType', processDeviceDetails);
}

function processDeviceDetails(result) {
    patientDevice = JSON.parse(result.message);
	if(patientDevice == null || patientDevice =="null")
	{
	popupshow();
	$("#txt_div").text("No glucose device Assigned to the user.");
	$("#vitalSave").attr('disabled','disabled');
	$("#vitalSave").fadeTo(100,0.33);

	}
	
}



function callFunction() {
	dateFormate();
    var dateVal = $("#vitalDateInput").val();
    var timeVal = $("#vitalTimeInput").val();
    var segment = $("#segmentSelect").val();
    if (dateVal.length > 9 && timeVal.length > 0) {
        var date = new Date(dateVal + " " + timeVal);
		
        var inputVal = $("#vitalValInput").val();
        //var isnum =  /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/.test(inputVal);

        $('#confirmModal').removeClass('hide').addClass('in');
        
        if (parseInt(inputVal) > 0) {
            patientDevice.unitValue1 = inputVal;
            var dt = date.toISOString().replace('Z', '') + '-0000';

/*            
 			var m = moment().format();
            var sign ;
            if(m.indexOf("+") > 0)
            {
            	sign = "+";
            }
            else
            {
            	sign = "-";
            }
            var dtime = m.split(sign);
            var zone = dtime[1].replace(":","");
            var dt = date.toISOString().replace('Z', sign+zone);
*/            
            patientDevice.vitalTime = dt;
            patientDevice.mealType = segment;
            patientDevice.state = INSERT;
            patientDevice.fkPatientDeviceDetailId = patientDevice.patientDeviceDetailId;
            patientDevice.observationMode = PAT_TAKEN_MANUAL;
            var arr = new Array();
            arr[0] = JSON.stringify(patientDevice);
            var dataVal = JSON.stringify(arr);
            var retVal = postDataToServer(dataVal, EMR, 'createUpdatePatientVitals', processResponse);
        } else {
        	$('#confirmModal').removeClass('in').addClass('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
			$("#lightbox").show();
			$("#cart_page").text("Vital ");
			$("#txt_div").text("Please enter valid data (numeric) value to Glucose field");

			
        }
    } else {
    	$('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
			$("#lightbox").show();
			$("#cart_page").text("Vital ");
			$("#txt_div").text("The date and time must be selected.");
    }
}

function processResponse(result) {
    if (result.success == true) {
        if ($('#myModal').hasClass('in')) {
            //jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graph.php', '', 'menu-content', undefined, undefined);
            });
        } else {
           // jQuery.noConflict();
            //$('#myModal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            openPageWithAjax('../../vitals/pages/vitals_graph.php', '', 'menu-content', undefined, undefined);
           // jQuery.noConflict();
            $('#confirmModal').on('hidden.bs.modal', function(e) {
                openPageWithAjax('../../vitals/pages/vitals_graph.php', '', 'menu-content', undefined, undefined);
            });
           // jQuery.noConflict();
            $('#confirmModal').modal('hide');
        }
		    //jQuery.noConflict();
			$('#myModal').removeClass('in')
            $('#confirmModal').modal('hide');

    } else {
        alert(result.message);
    }
}

$(document).ready(function() {
    getPatientDeviceDetails(GLUCOSE_VITALS);

    $("#type-select").val(inputType);

    $('#vitalValInput').on('keydown', function(event) {	
        if (($(this).val().length > 2 && event.which != 8 && event.which != 9) || isNaN(String.fromCharCode(event.which)) && event.which != 8 && (event.keyCode < 96 || event.keyCode > 105))
		{
            return false;
		}
    });

    $('#vitalTimeInput').on('keydown', function(event) {
        return false;
    });

   /* $('#vitalDateInput').on('keydown', function(event) {
        return false;
    });*/

    $('#datetimepicker1').datetimepicker({
        pickTime: false,
        maxDate: moment(),
		
    });
    $("#datetimepicker1").on("dp.show", function(e) {
        $('#datetimepicker2').trigger("dp.hide");
    });
    $('#datetimepicker2').datetimepicker({ 
		pickDate: false
		
	
    });
    $("#datetimepicker2").on("dp.show", function(e) {
        $('#datetimepicker1').trigger("dp.hide");
    });
    $('#datetimepicker2').data("DateTimePicker").setDate(moment());
    $('#datetimepicker1').data("DateTimePicker").setDate(moment());
    
    $('input.cancelButton').on('click',function(){
    	location.href = "../../login/pages/portal_dashboard.php";
    });
});


function dateFormate()
{
           var dateformat = /^(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d+$/;
		   
           var Val_date=$('#vitalDateInput').val();
           var Val_dateLength=$('#vitalDateInput').val().length;
		   if(Val_dateLength < 9 )
		   {
		   popupshow();
		   return false;
		   }
               if(Val_date.match(dateformat)){
              var seperator1 = Val_date.split('/');

              if (seperator1.length>1)
              {
                  var splitdate = Val_date.split('/');
              }
              var dd = parseInt(splitdate[1]);
              var mm  = parseInt(splitdate[0]);
              var yy = parseInt(splitdate[2]);
              var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
              if (mm==1 || mm>2)
              {
                  if (dd>ListofDays[mm-1])
                  {
                     popupshow();
                      return false;
                  }
              }
              if (mm==2)
              {
                  var lyear = false;
                  if ( (!(yy % 4) && yy % 100) || !(yy % 400))
                  {
                      lyear = true;
                  }
                  if ((lyear==false) && (dd>=29))
                  {
                      popupshow();
                      return false;
                  }
                  if ((lyear==true) && (dd>29))
                  {
                     popupshow();
                      return false;
                  }
              }
          }
          else
          {
			popupshow();
            return false;
          }



}

function popupshow()
{
			$("#lightbox").show();
			$("#fadediv").show();
			$("#cart_page").text("Vital ");
			$("#txt_div").text("Invalid date format.");
            return false;

}
var today ="";
$("#vitalDateInput,#vitalSave").on ('focusout click',function(){
  cheakPastDate();
		 todaydate = new Date();
	var ddd = todaydate.getDate();
	var mmm = todaydate.getMonth()+1; //January is 0!
	var yyy = todaydate.getFullYear();
		ddd = ddd.toString()
		mmm = mmm.toString()
		yyy = yyy.toString()
	if(ddd<10) {
		ddd='0'+ddd
	} 

	if(mmm<10) {
		mmm='0'+mmm
	} 

	todayDate = mmm+"/"+ddd+"/"+yyy;
  var vitalDate= $("#vitalDateInput").val();
  if(vitalDate =="")
  {
  	popupshow();
	$("#cart_page").text("Warning");
	$("#txt_div").text("Blank date not allowed.");
	 $("#vitalDateInput").val(todayDate);
	 return false;
  }
  var splitDate=vitalDate.split("/");
 vitalDate=splitDate[2]+splitDate[0]+splitDate[1];
  var diffDate=today-vitalDate;
  console.log(today);
  console.log(vitalDate);
  if(today < vitalDate)
  {
	popupshow();
	$("#cart_page").text("Warning");
	$("#txt_div").text("Future date not allowed.");
	 $("#vitalDateInput").val(todayDate);
	 return false;

  }
});

function cheakPastDate()
{

 today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
	dd = dd.toString()
	mm = mm.toString()
	yyyy = yyyy.toString()
if(dd<10) {
    dd='0'+dd
} 

if(mm<10) {
    mm='0'+mm
} 

today = yyyy+mm+dd;
return today;

}

// $("#vitalSave").click(function()
// {


// });

$("#vitalSave").click(function()
{
var dataTime = new Date();
var dd = dataTime.getDate();
var mm = dataTime.getMonth()+1; //January is 0!
var yyyy = dataTime.getFullYear();
var hou = dataTime.getHours();
var min = dataTime.getMinutes();

	dd = dd.toString();
	mm = mm.toString();
	yyyy = yyyy.toString();
	hou = hou.toString();
	min = min.toString();

if(dd < 10 )
{
dd="0"+dd;
}
if(mm < 10 )
{
mm="0"+mm;
}

if(min < 10 )
{
min="0"+min;
}

var currentDataTime=yyyy+mm+dd+hou+min;

var dataUser=$('#vitalDateInput').val();
var timeUser=$('#vitalTimeInput').val(); 

var userDate=dataUser.split('/');

var umm=userDate[0];
var udd=userDate[1];
var uyyy=userDate[2];

var userTime=timeUser.split(':');
var uthh=userTime[0];
var tmm=userTime[1].split(' ');
var utmm=tmm[0];
var uamPm=tmm[1];

if(uamPm=='PM' && uthh < 12)
{
uthh=parseInt(uthh)+12;
}

	// udd = udd.toString();
	// umm = umm.toString();
	// uyyy = uyyy.toString();
	// uthh = uthh.toString();
	// utmm = utmm.toString();

var userDataTime=parseInt(uyyy+umm+udd+uthh+utmm);
console.log("user:"+userDataTime);
console.log("currentDataTime:"+currentDataTime);
console.log("diff:"+parseInt(currentDataTime)-userDataTime);

if(currentDataTime >= userDataTime)
{	
	return true;
}
else{
	popupshow();
	$("#cart_page").text("Warning");
	$("#txt_div").text("Future date and time not allowed.");
	return false;
} 


});