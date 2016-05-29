app.directive('whenScrolled', function() {
	return function(scope, elm, attr) {
		var raw = elm[0];
		
		elm.bind('scroll', function() {
			if(scope.dataLoading) {
				console.log("data is loading..");
				return; 
			}
			if (raw.scrollTop + raw.offsetHeight >= raw.scrollHeight) {
				console.log("Scroll down");
				scope.loadData(scope.endPageNo, true);
				
				scope.$apply(attr.whenScrolled);
			} else if(raw.scrollTop == 0) {
				console.log("Scroll up ["+scope.startPageNo+"]");
				if(scope.startPageNo > 0) {
					scope.loadData(scope.startPageNo, false);
				}
			}
			// console.log("offsetY: " + raw.offsetY);
		});
	};
});

app.controller('PatientListCtrl', function($scope, $http, $routeParams, $location) {
	$scope.localDateFormatter = function (dob)
	{
		var dateTime = new Date(dob);
		var month = dateTime.getUTCMonth() + 1;
		var day = dateTime.getUTCDate();
		if(month < 10)
		{
			month = "0"+month;
		}
		if(day < 10)
		{
			day = "0"+day;
		}
		var finalDate = month+"/"+day+"/"+dateTime.getUTCFullYear();
		return finalDate;
	}

	$scope.dataLoading = false;
	$scope.startPageNo = 0;
	$scope.endPageNo = 1;
	//Buffer = recordsPerPage*pagesToDisplay
	$scope.pagesToDisplay = 10;
	$scope.recordsPerPage = 10;
	$scope.patients = undefined;
	$scope.filterChar = '';
	$scope.alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
	$scope.authToken = '';
	$scope.attempt = 0;
	
	$scope.actionId = $routeParams.actionId;
	if($routeParams.filter) {
		$scope.filterChar = $routeParams.filter;
	}

	if($scope.actionId != "list") {
		document.cookie="patListOpened=true";
	} else {
		document.cookie="patListOpened=false";
	}
	
	$scope.searchAllFields = function() {
		console.log("Search for: "+$scope.searchTxt);
		// TODO: 
		var formData = {
		'search'	: "true",
		'searchStr'	: $scope.searchTxt
		};
		
		$.ajax({
		type		: 'POST',
		url			: "/gladstone/portal/bloom/dashboard/pages/portal_patientList.php?param='SELECTPATIENT'&currentPage=&page=&patientSelectVal=undefined",
		data		: formData,
		success		: function(data) {
			$("#menu-content").html(data);
		}});
	}
	
	$scope.searchNames = function(chars) {
		$location.path("/patient_list_aj/list/"+chars);
		
		/*
		// Reset data: 
		$scope.startPageNo = 0;
		$scope.endPageNo = 1;
		$scope.patients = undefined;
		
		// Set filterChar:
		$scope.filterChar = chars;
		$scope.loadData(1, true);
		*/
	}
	
	$scope.selectCategory = function(newCategory) {
		$scope.searchNames(newCategory);
		// $location.path("/patient_list_aj/list/"+newCategory);
	}
	
	$scope.loadData = function(currentPageNo, scrollDown) {
		if($scope.dataLoading) {
			return;
		}
		if(currentPageNo < $scope.endPageNo && currentPageNo > $scope.startPageNo) {
			// nothing load: no need to do backend call!
			console.log("not loading ["+$scope.startPageNo+" -> "+$scope.endPageNo+"]; current: "+currentPageNo);
			return;
		}
		
		$scope.dataLoading = true;
		console.log("loadData -> page: " + currentPageNo);
		if($scope.authToken == '') {
			refreshAuthToken(function(token) {
				$scope.authToken = token;
			});
		}
		
		var auth = {};
		auth["Authorization"] = $scope.authToken;
		var pageInfo = {};
		pageInfo["currentPageNo"] = currentPageNo;
		pageInfo["recordsPerPage"] = $scope.recordsPerPage;
		var filterInfo = {}
		filterInfo["pageInfo"] = pageInfo;
		// filterInfo["headers"] = auth;
		
		if($scope.authToken == '') {
			refreshAuthToken(function(token) {
				$scope.authToken = token;
			});
		}		
		$http.get(window.location.origin + "/gladstone/rest/patients", 
			{
			headers: {
				'Authorization': $scope.authToken
			},
			params: {
				"pageInfo.currentPageNo":currentPageNo,
				"pageInfo.recordsPerPage":$scope.recordsPerPage,
				"chars":$scope.filterChar
			}}
		)
	   .then(function(data) {
			console.log("success - Code:"+data.status);
			$scope.updateScopeData(data.data.entityDetailInfos, scrollDown); 
			$scope.dataLoading = false;
			$("#menu-content").html("");
			$scope.attempt = 0;
		},function(data) {
			if(data.status == 401) {
				if($scope.attempt < 3) {
					console.log("Refreshing authToken.."+$scope.attempt)
					refreshAuthToken(function(token) {
						$scope.authToken = token;
						$scope.dataLoading = false;
						$scope.attempt++;
						$scope.loadData(currentPageNo, scrollDown);
					});
				}
			}			
		});
	}
	
	$scope.updateScopeData = function(arrData, scrollDown) {
		if(arrData == undefined) {
			console.log("Reached end of the data");
			return;
		}
		console.log("arrDatalength",arrData.length);
		if($scope.patients == undefined) {
			// 1st time: 
			$scope.patients = arrData; 
		} else {
			if(scrollDown) {
				for (var i = 0; i < arrData.length; i++) {
					$scope.patients.push(arrData[i]);
				}
			} else {
				for (var i = arrData.length - 1; i >= 0; i--) {
					$scope.patients.unshift(arrData[i]);
				}
				
			}
			if(($scope.endPageNo - $scope.startPageNo) > ($scope.pagesToDisplay)) {
				var raw = document.getElementById("menu-content-aj");
				// Remove old data: 
				if(scrollDown) {
					console.log("Need to set start: " + ($scope.endPageNo - $scope.pagesToDisplay)); 
					$scope.patients.splice(0, $scope.recordsPerPage);
					$scope.startPageNo = ($scope.endPageNo - $scope.pagesToDisplay);
					
					raw.scrollTop = raw.scrollHeight - raw.offsetHeight - 150;
				} else {
					// Splice data from end: 
					var endIndex = $scope.pagesToDisplay * $scope.recordsPerPage;
					$scope.patients.splice(endIndex, $scope.patients.length - endIndex);
					$scope.endPageNo--;
					raw.scrollTop = 150;
				}
			}
			console.log("Patients' count: "+$scope.patients.length);
		}
		$scope.backup = $scope.patients;
		
		if(scrollDown) {
			$scope.endPageNo++;
		} else {
			if($scope.startPageNo > 0) {
				$scope.startPageNo--;
			}
		}
		// console.log("$scope.endPageNo: "+$scope.endPageNo+"; $scope.startPageNo: "+$scope.startPageNo);
	}
	$scope.addPatient = function(id) {
		console.log("addPat id: "+id);
		window.location.hash = "/patient_add";
		openPageWithAjax('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php','','menu-content',event,this)
		$("#menu-content-aj").hide();
		$("#menu-content").show();
	}

	$scope.patIconClicked = function(id) {
		if($scope.actionId == "list") {
			$scope.editPatient(id);
		} else {
			document.cookie="selectedPat="+id;
			// var thisPatContent = $(this).html()+" "+$(this).parent().parent().find(".patient_address h2").html();
			var thisPatContent = "<h4>"+this.x.firstName + " " + this.x.lastName+"</h4>";
			document.cookie="selectedPatContent="+thisPatContent;
			console.log("Opening action: "+$scope.actionId+" for pat: "+id);
			if($scope.actionId == "bio") {
				openPageWithAjax('/gladstone/portal/bloom/vitals/pages/setPath.php','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
			if($scope.actionId == "learn") {
				openPageWithAjax('/gladstone/portal/bloom/portalLearn/pages/portal_learn.php','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
			if($scope.actionId == "messages") {
				openPageWithAjax('/gladstone/portal/bloom/messages/pages/messages.html','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
			if($scope.actionId == "patientcare") {
				openPageWithAjax('/gladstone/portal/bloom/patientcare/pages/patient_care.php','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
			if($scope.actionId == "supplies") {
				openPageWithAjax('/gladstone/portal/bloom/dashboard/pages/portal_supplies.php','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
			if($scope.actionId == "reports") {
				openPageWithAjax('/gladstone/portal/bloom/reports/pages/report_weekly_dashboard.php','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
			if($scope.actionId == "survey") {
				openPageWithAjax('/gladstone/portal/bloom/survey/pages/showSurvey.php','contextPId='+id,'menu-content',event,this);
				$("#menu-content-aj").hide();
  		  		$("#menu-content").show();
			}
		}
	}
	
	$scope.editPatient = function(id) {
		console.log("Edit id: "+id);
		window.location.hash = "/patient_edit";
		 $('#menu-content-container li').attr('ref', id);
		 $("#headerMenu li").attr("ref",id);
		openPageWithAjax('/gladstone/portal/bloom/dashboard/pages/portal_addPatient.php','edit=true&patientId='+id,'menu-content',event,this)
		$("#menu-content-aj").hide();
		$("#menu-content").show();
		
		// set context
		var image = $("#"+id).find('img').attr('src');
		var name = $("#"+id).find('h2').text();
		$('#contextPatientName').val(name);
			
			
		$('#contextPatientId').val(id);
		$('#contextPatientImage').val(image);
		$('#patientName').html(name);
		setTimeout(patientName(), 5);
		
		
	}
	
function patientName()
 {
	 if($('#contextPatientName').val() != "")
	 {
		$('#patientName').text($('#contextPatientName').val());
		var patientName = $('#patientName').text();
		var patName ;
		if(patientName.length > 11)
		{
		 patName = patientName.substring(0,11)+"..";
		 }
		 else
		 {
			patName = patientName;
		 }
		$('#patients option[value="selectedPatient"]').show();
		$('#patients option[value="selectedPatient"]').text(patName);
		//$("#patients").append('<option value="'+patientName+'">'+patientName+'</option>');
		$("#patients").prop("selectedIndex", 3); 
		$('#patImage').show();
		$('#patsImages').hide();
		$("#patients").show();
	}
	else
	{
	$('#patImage').hide();
	$('#patsImages').show();
	}
 }
	
	$scope.confirmDelPatient = function(id) {
		console.log("del pat "+id);
		$("#patient-delete-button").attr('delete-id',id)
	}
	$scope.delPatient = function() {
		var patientId= $("#patient-delete-button").attr('delete-id');
		
		$http.delete(window.location.origin + "/gladstone/rest/patients/"+patientId, 
			{
			headers: {
				'Authorization': $scope.authToken
			}}
		)
	   .then(function(data) {
			console.log("success - Code:"+data.status);
			$('#patientDeleteModal').hide();
			$('#'+patientId).hide();
		},function(data) {
			if(data.status == 401) {
				if($scope.attempt < 3) {
					console.log("Refreshing authToken.."+$scope.attempt)
					refreshAuthToken(function(token) {
						$scope.authToken = token;
						
					});
				}
				
			}
			
		});
			
		
	}
	
	$scope.loadData(1, true);
});

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}

