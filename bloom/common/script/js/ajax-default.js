 function openPageWithAjax(action, parameters, resultingDivId, e, ele) {
   	 $('#menu-content').css("overflow-y", "auto");
	 if (typeof e !== "undefined" && e !== undefined && e != '') {
         e.preventDefault();
     }
     if(!checkMessage())
     {
    	 return false;
     }
	 
	$('#btnExportPDF').hide();   // To hide export to messages PDF button
	 
     var pagination = "";
     if (ele != undefined && ele != null) {
    	 pagination = $(ele).attr('paginate');
    	 var ref = $(ele).parent().attr('ref');
         if (typeof ref !== "undefined" && ref !== undefined) {
             if (parameters != null && parameters != "") {
                 parameters += "&contextPId=" + ref;
                 parameters += "&patientId=" + ref;
             } else {
                 parameters += "contextPId=" + ref;
                 parameters += "&patientId=" + ref;
             }
         } else {
             var html = $.trim($(ele).find('p').html());
             if (html == "" || html == null) {
                 html = $.trim($(ele).find('img').attr('title'));
             }
             if (html == "Messages" || html == "Track Biometrics" || html == "Learn" || html == "Patient Care" || html == "Reports" || html == "Lab Metrics" || html =="Supplies" ||html =="Survey") {
                 pagination = "true";
            	 action = "../../dashboard/pages/portal_patientList.php?param=SELECTPATIENT&currentPage=1&page=" + html;
             }

             
            /* var title = $.trim($(ele).find('img').attr("title"));
             if (title == "Track Biometrics") {
                 action = "../../dashboard/pages/portal_patientList.php?param='SELECTPATIENT'&page=" + "Track Biometrics";
             }*/

         }
     }
     var hasContent = false;
     var dataLength;
     $.ajax({
         url: action,
         type: 'POST',
         data: parameters,
         crossDomain: true,
         beforeSend: function() {
			// alert(action);
			 if(action != "../../provider/pages/orderDetail.php"){
             showLoading();
			 }
         },
         success: function(result) {
			 if(result == "acknowledgeDashboard_")
			 {	  var patientsValue = $("#patients").val();

				 var purls = '../../login/pages/portal_dashCard.php';
				openPageWithAjax(purls,'categoryFilter='+patientsValue,'dashCard','');
			  }
			 else if(result == "acknowledgeDashboard_true")
			 {	  var patientsValue = $("#patients").val();

				 var purls = '../../login/pages/portal_dashCard.php';
				openPageWithAjax(purls,'selectedPatientTrue=true&categoryFilter='+patientsValue,'dashCard','');
			  }
			  
             $("#" + resultingDivId).html(result);
             var divContent = $("#" + resultingDivId).html();
//             console.log('Data : '+divContent);
//             console.log('Data length : '+$(divContent).find('div.cardPanel').length);
             dataLength = $(divContent).find('.cardPanel').length;
             if($(divContent).find('.cardPanel').length > 4)
            {
            	 hasContent=true;	 
            }
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
             try {
                $("#selectedPatient").html(getCookie("selectedPatContent"))
                } catch (err) {
					console.log("Error occured "+ err);
				}
             if(hasContent)
            {
            	 appendNavigation(action,parameters,resultingDivId,1,dataLength);
				
            }
			
         }
     });
 }
 
 function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}


 function appendNavigation(action,params,resultingDivId,pageNumber,dataLen)
 {
	 console.log("action:"+action+"params:"+params+resultingDivId+pageNumber+dataLen);
	 var startPage=1;
	var recordFound = $("#moveNext").val();
	var moveNext = $("#nextButton").val();
	if(moveNext == true)
	{
	recordFound = recordFound+$("#moveNext").val();
	}
	if(recordFound <= $("#moveNext").val())
	{
	page=1;
	}
	else
	{
	recordFound = recordFound/$("#moveNext").val();
	recordFound = parseInt(recordFound);
	page=recordFound;
	}
	
	var prew="";
	var next="";
	var prewPage="";
	var nextPage="";
	var pageNo="";
	if(pageNumber == undefined )
		pageNumber = 1;
		
	if(moveNext)
	{
		
	nextPage = parseInt(pageNumber)+1;
	next='<a href="#" class="activePage nextPage" ref="'+nextPage+'" action = "'+action+'"  params = "'+params+'"  resultingDivId = "'+resultingDivId+'" onclick="openPage(&quot;'+action+'&quot;,&quot;'+params+'&quot;,&quot;'+resultingDivId+'&quot;,event,this)">';
	next += '<img style="height:27px" src="../../common/images/arrow_right.jpg"/></a>';
	}
	//console.log('page number ===== '+pageNumber);
	if(pageNumber == undefined || pageNumber == "undefined" || pageNumber ==1)
	{
	pageNumber=1;
	}
	else{
	prewPage= parseInt(pageNumber)-1;
	prew='<a href="#" class="activePage prevPage" ref="'+prewPage+'"  onclick="openPage(&quot;'+action+'&quot;,&quot;'+params+'&quot;,&quot;'+resultingDivId+'&quot;,event,this)">';
	prew += '<img style="height:27px" src="../../common/images/arrow_left.jpg"/></a>';
	
	}
   
	
 	var html = '<div id="pagination" class="pagination"><div class="wrapper1">';
	html +=prew;
 	// for(i = startPage; i <= page ; i++)
 	// {
		// if(i==pageNumber)
		// {
		// pageNo='<a href="#" class="activePage" ref="'+i+'" onclick="openPage(&quot;'+action+'&quot;,&quot;'+params+'&quot;,&quot;'+resultingDivId+'&quot;,event,this)">'+i+'</a>';
		// }
		// else{
		// pageNo='<a href="#" class="Page" ref="'+i+'" onclick="openPage(&quot;'+action+'&quot;,&quot;'+params+'&quot;,&quot;'+resultingDivId+'&quot;,event,this)">'+i+'</a>';
		// }
 		 // html +=pageNo; 
 		// //html += '<a href="#" onclick="openPage(&quot;'+action+'&quot;,event,this)">'+i+'</a>';
 	// }

		html +=next;
		
	
 	html += '</div></div></div><div class="push">';
	$('#'+resultingDivId).append(html);
	if(resultingDivId == "dashCard")
	{
		$(".prevPage,.nextPage").hide();
	}
 }
 
 function openPage(action,params,resultingDivId,e,ele)
 {
	 e.preventDefault();
	  var pageNumber = 0;
	 if($(ele).attr('ref') != undefined)
		 pageNumber = $.trim($(ele).attr('ref'));
	 if(params != null && params != "")
	 {
		 params += "&currentPage="+pageNumber;
	 }
	 else
	 {
		 params += "currentPage="+pageNumber;
	 }
	 var hasContent = false;
     var dataLength;
	 $.ajax({
         url: action,
         type: 'POST',
         data: params,
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $("#" + resultingDivId).html(result);
             var divContent = $("#" + resultingDivId).html();
//             console.log('Data : '+divContent);
//             console.log('Data length : '+$(divContent).find('div.cardPanel').length);
             dataLength = $(divContent).find('.cardPanel').length;
             if($(divContent).find('.cardPanel').length > 0)
            {
            	 hasContent=true;	 
            }
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
             if(hasContent)
            appendNavigation(action,params,resultingDivId,pageNumber,dataLength);
         } 
	 	});
 }
//for dashboard only
function openPagewithScroll(action,params,resultingDivId,e,ele)
 {
	 if (typeof e !== "undefined" && e !== undefined && e != '') {
         e.preventDefault();
     }

	  var pageNumber = 0;
	 if($(ele).attr('ref') != undefined)
		 pageNumber = $.trim($(ele).attr('ref'));
	 if(params != null && params != "")
	 {
		 params += "&currentPage="+pageNumber;
	 }
	 else
	 {
		 params += "currentPage="+pageNumber;
	 }
	 var hasContent = false;
     var dataLength;
	 $.ajax({
         url: action,
         type: 'POST',
         data: params,
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $("#" + resultingDivId).append(result);
             var divContent = $("#" + resultingDivId).html();
//             console.log('Data : '+divContent);
//             console.log('Data length : '+$(divContent).find('div.cardPanel').length);
             dataLength = $(divContent).find('.cardPanel').length;
             if($(divContent).find('.cardPanel').length > 0)
            {
            	 hasContent=true;	 
            }
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
             if(hasContent)
			 $(".pagination").remove();
			 $("#scriptData").remove();
            appendNavigation(action,params,resultingDivId,pageNumber,dataLength);
			
         } 
	 	});
 }
// end dashboard call
 function postForm(action, formId, resultingDivId, e) {
     if (typeof e != undefined) {
         e.preventDefault();
     }

     $.ajax({
         url: action,
         type: 'POST',
         data: $('#' + formId).serialize(),
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $("#" + resultingDivId).html(result);
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
         }
     });
 }
// Post form without animation
function postFormWithoutLoding(action, formId, resultingDivId) {
    /* if (typeof e != undefined) {
         e.preventDefault();
     }*/

     $.ajax({
         url: action,
         type: 'POST',
         data: $('#' + formId).serialize(),
         crossDomain: true,
         beforeSend: function() {
             //showLoading()
         },
         success: function(result) {
             $("#" + resultingDivId).html(result);
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
           //  hideLoading();
		  
         }
     });
 }
  function postFormWithPagination(action,formId, resultingDivId, e) {
     if (typeof e != undefined) {
         e.preventDefault();
     }
	var hasContent = false;
	var parameters = $('#' + formId).serialize();
     var dataLength;
     $.ajax({
         url: action,
         type: 'POST',
         data: $('#' + formId).serialize(),
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $("#" + resultingDivId).html(result);
			 
             var divContent = $("#" + resultingDivId).html();
//             console.log('Data : '+divContent);
//             console.log('Data length : '+$(divContent).find('div.cardPanel').length);
             dataLength = $(divContent).find('.cardPanel').length;
			
             if($(divContent).find('.cardPanel').length > 4)
            {
            	 hasContent=true;	 
            }
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
             if(hasContent)
            {
				
            	 appendNavigation(action,parameters,resultingDivId,1,dataLength);
				
            }
         }
        
	
     });
 }

 function postFormAndHideAlert(action, formId, resultingDivId, e,modalId) {
     if (typeof e != undefined) {
         e.preventDefault();
     }

     $.ajax({
         url: action,
         type: 'POST',
         data: $('#' + formId).serialize(),
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $("#" + resultingDivId).html(result);
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
        	 $('#'+modalId).modal('hide');
        		$('body').removeClass('modal-open');
        		$('.modal-backdrop').remove();
             hideLoading();
         }
     });
 }
 
 function setPatientValue(patientId, action) {
     $('#menu-content-container li').attr('ref', patientId);
     openPageWithAjax(action, 'contextPId=' + patientId, 'menu-content')
 }


 function openWithAjaxAndClosePopup(action, parameters, resultingDivId, e) {
     if (typeof e !== "undefined" && e !== undefined) {
         e.preventDefault();
     }
     $.ajax({
         url: action,
         type: 'POST',
         data: parameters,
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $('.close').click()
             $("#" + resultingDivId).html(result);
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
         }
     });
 }

 function postFormAndClosePopup(action, formId, resultingDivId, e) {
     if (typeof e != undefined) {
         e.preventDefault();
     }

     $.ajax({
         url: action,
         type: 'POST',
         data: $('#' + formId).serialize(),
         crossDomain: true,
         beforeSend: function() {
             showLoading()
         },
         success: function(result) {
             $('.close').click()
             $("#" + resultingDivId).html(result);
         },
         error: function() {
             console.log('error');
         },
         complete: function() {
             hideLoading();
         }
     });
 }

 function showLoading() {
     $('.wrapper2').css('opacity', 0.2);
     $('.ajax-loading').show();
 }

 function hideLoading() {
     $('.wrapper2').css('opacity', 1);
     $('.ajax-loading').hide();
 }
 
 function postMultipartForm(action, ele, resultingDivId, e) {
     if (typeof e != undefined) {
         e.preventDefault();
     }
	var formData = new FormData($(ele)[0]);
     $.ajax({
         url: action,
         type: 'POST',
         data: formData,//$('#' + formId).serialize(),
         crossDomain: true,
		  async: false,
            cache: false,
            contentType: false,
            processData: false,
		 beforeSend: function(){showLoading()},
         success: function(result) {
		 $('.close').click()
           // alert('sent successfully');
		 $("#" + resultingDivId).html(result);
         },
         error: function( request, textStatus, errorThrown) {
        	 //request.getResponseHeader('VMCErrorCode')
            // console.log('jqXHR'+formData.elements['title'].value);
         },
         complete: function() {
			hideLoading();
		 }
     });
 }
 function checkMessage()
 {
	var savedData = $.data( document.body, "message");
	var newData = $.trim($("#message_box").val());
	if(savedData != undefined && savedData != newData)
	{
		showPopAlert();
		$("#light").show();
		$("#txt").html("Are you sure you want to leave this page? All changes will be lost.");
		$("#okey_close").focus();
		return false;
	}
	return true;
 }
 
 function convertToLocalTime(utcDate)
 {
	 //console.log('date : '+utcDate)
	 var date = new Date(utcDate);
	 var offsetTime = moment.utc(date).toDate();
    localTime = moment(offsetTime).format('MMM D h:mm A');
	return localTime;
		
 }
 function formatDate(date) {
	 var m_names = new Array("Jan", "Feb", "Mar", 
			 "Apr", "May", "Jun", "Jul", "Aug", "Sep", 
			 "Oct", "Nov", "Dec");
	  var hours = date.getHours();
	  var minutes = date.getMinutes();
	  var ampm = hours >= 12 ? 'pm' : 'am';
	  hours = hours % 12;
	  hours = hours ? hours : 12; // the hour '0' should be '12'
	  minutes = minutes < 10 ? '0'+minutes : minutes;
	  var strTime = hours + ':' + minutes + ' ' + ampm;
	  return m_names[date.getMonth()] + " " + date.getDate() + "  " + strTime;
	}