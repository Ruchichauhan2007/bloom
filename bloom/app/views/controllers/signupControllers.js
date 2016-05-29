'use strict';

 /* Controllers */

 var app = angular.module('starter.controllers', []);

// initial page Controller
	app.controller('initialCtrl', ['$scope', '$http','$routeParams', '$location','$window', '$rootScope',
		function ($scope, $http, $routeParams, $location, $window,  $rootScope) {
		$(".closeBtn,.close,#fadeDivLoading").click(function()
		{
			$(".popErrorMsg").text("Error occurred,please contact Kannact support.");
		});
			
	var userData = $location.search();
				if(userData["firstName"] && userData["lastName"] && userData["dateOfBirth"] && userData["institutionName"])
				{
					$scope.institutionName = userData["institutionName"];
				}
var employerList = function ()
				{
					showSpinner();					
					$http({url: window.location.origin + "/gladstone/rest/public/employerList",
					method: "GET"
					})
					.then(function(response) {
						  $scope.employers = response.data;
						  console.log(response);
							hideSpinner();	
							},
					function(response)
					{ // optional
					$('#errorPopup').modal();hideSpinner();});
					
				}
				
$scope.setUserData = function ()
{
	
			var employer = $("#employer option:selected").text();
			var userData ={};
			if($scope.fname != undefined && $scope.fname != undefined && $scope.dob != undefined && $scope.employer != undefined)
			{
			 userData['firstName'] = $scope.fname;
			 userData['lastName'] = $scope.lname;
			 userData['dateOfBirth'] = $scope.dob ;
			 userData['institutionName'] = $scope.employer;
			 userData['employer'] = employer
			 window.localStorage.clear();
window.location.href = "https://"+$scope.employer+"/gladstone/portal/bloom/app/index.html#/havingTrouble?firstName="+$scope.fname+"&lastName="+$scope.lname+"&dateOfBirth="+$scope.dob+"&institutionName="+$scope.employer+"&employer="+employer;					
			}
			else
			{
				
					 $('#errorPopup').modal();
					 $(".popErrorMsg").text("Please enter required data.");
				//alert("Please enter required data.");
			}
}
				
				employerList();
$scope.signup = function ()
				{
					var fname = $scope.fname;
					var lname = $scope.lname;
					var dob = $scope.dob;
					var institutionName = $scope.employer;
					var employer = $("#employer option:selected").text();
window.location.href = "https://"+institutionName+"/gladstone/portal/bloom/app/index.html#/initial?firstName="+fname+"&lastName="+lname+"&dateOfBirth="+dob+"&institutionName="+institutionName+"&employer="+employer;					
				}
				
	var  sigupUser = function ()
	{
       showSpinner();	
		window.localStorage.setItem('entereddob', userData['dateOfBirth']);
		$http({url: "https://"+userData['institutionName'] + "/gladstone/rest/public/patientBySignupDetails?firstName="+userData['firstName']+"&lastName="+userData['lastName']+"&dateOfBirth="+userData['dateOfBirth'],
			method: "GET"
	})
	.then(function(response) {
		console.log(response);		   
		if(response.data)
		{
		console.log(response);
		  var patientInfo = JSON.stringify(response.data);
		  window.localStorage.setItem('patientInfo', patientInfo);
		  var employerData = {};
		  employerData['employer'] = userData['employer'];
		  employerData['institutionName']= userData['institutionName'];
		  window.localStorage.setItem('employerData',JSON.stringify(employerData));
		  window.location.href = window.location.origin+"/gladstone/portal/bloom/app/index.html#/shippingAddress";hideSpinner();}
		else
		{
		$scope.msg = "Unable to verify. Please review and update your information before trying again.";
			$scope.fname = userData['firstName'];
			$scope.lname = userData['lastName'];
			$scope.dob  = userData['dateOfBirth'];
			$scope.employer= userData['institutionName'];
			window.localStorage.setItem('userData',JSON.stringify(userData));
			hideSpinner();
			}
		  //console.log(response);
	},
	function(response)
	{ // optional
	$('#errorPopup').modal();hideSpinner();});
	}
				
				
				if(userData["firstName"] && userData["lastName"] && userData["dateOfBirth"] && userData["institutionName"])
				{
					sigupUser();                                                                                  showSpinner();}
				console.log(userData);
				
							 
	}]);
// shippingAddress page Controller
	app.controller('shippingAddressCtrl', ['$scope', '$http', '$routeParams', '$location','$window', '$rootScope',
		function ($scope,$http,  $routeParams, $location, $window,  $rootScope) {
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			if(!patientInfo)
			{
				$location.path('/initial');
			}
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
			var addressInfo = patientInfo['addressInfo'][1];
			$scope.addressLine = addressInfo['addressLine1']+" "+addressInfo['addressLine2']+" "+addressInfo['addressLine3'];
			$scope.city = addressInfo['city'];
			$scope.postalCode = addressInfo['postalCode'];
			$scope.stateId = addressInfo['stateId'];
			
var stateList = function ()
				{
				showSpinner();
				$http({url: window.location.origin+"/gladstone/rest/public/stateList",
					method: "GET"
					})
					.then(function(response) {
						  $scope.states = response.data;
						  console.log(response);hideSpinner();},
			function(response)
			{ // optional
			$('#errorPopup').modal();hideSpinner();});
				}
			 stateList();
			 
$scope.addShipingAddress = function ()
{
				addressInfo['addressLine1'] = $scope.addressLine;
				addressInfo['city'] = $scope.city ;
				addressInfo['postalCode'] = $scope.postalCode  ;
				addressInfo['stateId'] = $scope.stateId ;
				patientInfo['addressInfo'][1] = addressInfo;
				console.log(patientInfo);
				var shippingStateText = $("#stateId option:selected").text();
				console.log( $("#stateId option:selected").text());
				patientInfo = JSON.stringify(patientInfo);
				window.localStorage.setItem('patientInfo', patientInfo);
				window.localStorage.setItem('shippingStateText', shippingStateText);
				$location.path('/prescription');
				hideSpinner();
				}
			
			
							 
	}]);

// prescription page Controller
	app.controller('prescriptionCtrl', ['$scope','$http', '$routeParams', '$location','$window', '$rootScope',
		function ($scope,$http,  $routeParams, $location, $window,  $rootScope) {
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			if(!patientInfo)
			{
				$location.path('/initial');
			}
			
			
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
var prescriptionDetailInfoDoc = JSON.parse(window.localStorage.getItem('prescriptionDetailInfoDoc'));
if(prescriptionDetailInfoDoc)
{
console.log(prescriptionDetailInfoDoc['stateId']);
 $scope.Dname = prescriptionDetailInfoDoc['prescriberName'];
 $scope.Dcity = prescriptionDetailInfoDoc['city'];
 $scope.Dstate = prescriptionDetailInfoDoc['stateId'];
}
var prescriptionDetailInfoPhar = JSON.parse(window.localStorage.getItem('prescriptionDetailInfoPhar'));
if(prescriptionDetailInfoPhar)
{
 $scope.Fname = prescriptionDetailInfoPhar['prescriberName'];
 $scope.Pcity = prescriptionDetailInfoPhar['city'];
 $scope.Pstate = prescriptionDetailInfoPhar['stateId'];
 $scope.Baddress = prescriptionDetailInfoPhar['addressLine1'];
}
 
var pharmacy = window.localStorage.getItem('pharmacy');	
if(pharmacy == "true")
{
$scope.pharmacy = true;

}
else
{
$scope.pharmacy = false;	
	
}

var stateList = function ()
				{showSpinner();
				$http({url:  window.location.origin+"/gladstone/rest/public/stateList",
					method: "GET"
					})
					.then(function(response) {
						  $scope.states = response.data;
						  console.log(response);hideSpinner();},
			function(response)
			{ // optional
			$('#errorPopup').modal();hideSpinner();});
				}
			 stateList();
 $scope.addDoctorAddress = function ()
				{
				showSpinner();
				if($scope.Dname != ""  && $scope.Dcity !="")
					{
					var DprescriptionDetailInfo = {};
					DprescriptionDetailInfo['prescriberName'] = $scope.Dname;
					DprescriptionDetailInfo['city'] = $scope.Dcity ;
					DprescriptionDetailInfo['stateId'] = $scope.Dstate ;
					DprescriptionDetailInfo['prescriberType'] = "DOCTOR";
					DprescriptionDetailInfo['state'] = 1;
					
					
					var doctorStateText = $("#Dstate option:selected").text();
				//	console.log( $("#Dstate option:selected").text());
					DprescriptionDetailInfo = JSON.stringify(DprescriptionDetailInfo);
					window.localStorage.setItem('prescriptionDetailInfoDoc', DprescriptionDetailInfo);
					window.localStorage.setItem('doctorStateText', doctorStateText);
					}
					else
					{
						window.localStorage.removeItem('prescriptionDetailInfoDoc');
						window.localStorage.removeItem('doctorStateText');
					}
					window.localStorage.setItem('pharmacy', $scope.pharmacy);
					
					if($scope.pharmacy)
					{
					var prescriptionDetailInfo = {};
					prescriptionDetailInfo['prescriberName'] = $scope.Fname;
					prescriptionDetailInfo['addressLine1'] = $scope.Baddress;
					prescriptionDetailInfo['city'] = $scope.Pcity ;
					prescriptionDetailInfo['stateId'] = $scope.Pstate ;
					prescriptionDetailInfo['prescriberType'] = "PHARMACY";
					prescriptionDetailInfo['state'] = 1;
					console.log(prescriptionDetailInfo);
					var PstateStateText = $("#Pstate option:selected").text();
					//console.log( $("#Pstate option:selected").text());
					prescriptionDetailInfo = JSON.stringify(prescriptionDetailInfo);
					window.localStorage.setItem('prescriptionDetailInfoPhar', prescriptionDetailInfo);
					window.localStorage.setItem('PstateStateText', PstateStateText);
					
					}
					else
					{
						window.localStorage.removeItem('prescriptionDetailInfoPhar');
						window.localStorage.removeItem('PstateStateText');
					}
					$location.path('/eligibility');
					hideSpinner();}
}]);

// eligibility page Controller
	app.controller('eligibilityCtrl', ['$scope','$http','$routeParams', '$location','$window', '$rootScope',
		function ($scope,$http,  $routeParams, $location, $window,  $rootScope) {
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			if(!patientInfo)
			{
				$location.path('/initial');
			}
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
			
var Incentives = function ()
				{
				showSpinner();
				$http({url:  window.location.origin+ "/gladstone/rest/public/signupIncentives",
					method: "GET"
					})
					.then(function(response) {
						$scope.Incentives = response.data;
						$scope.IncentivesData = response.data.incentiveItems
						console.log(response);hideSpinner();},
			function(response)
			{ // optional
			$('#errorPopup').modal();
			hideSpinner();
			});
					
				}
			Incentives();
			
var healthCoaching = window.localStorage.getItem('healthCoaching');	
if(healthCoaching == "true")
{
$scope.healthCoaching = true;	
}
else
{
$scope.healthCoaching = false;	
	
}
$scope.addIncentive = function()
{   showSpinner();
	var healthCoaching = $scope.healthCoaching;
	window.localStorage.setItem('healthCoaching',healthCoaching);
	$location.path('/instructions');
	hideSpinner();
	}

							 
	}]);
// instructions page Controller
	app.controller('instructionsCtrl', ['$scope', '$http','$routeParams', '$location','$window', '$rootScope',
		function ($scope,$http,$routeParams, $location, $window,  $rootScope) {
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			if(!patientInfo)
			{
				$location.path('/initial');
			}
			
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
var emailAddressInfo = patientInfo['emailAddressInfo'][0];
var splitEmail = emailAddressInfo['emailAddress'].split("@");
if(splitEmail[1] != "dummy.kannact.com")
{
$scope.emailAddress = emailAddressInfo['emailAddress'];
$scope.emailAddressConfirm = emailAddressInfo['emailAddress'];
$scope.preferred = patientInfo['preferredContactType'];
}


var checkEmailAddress = function ()
{
	if($scope.emailAddressConfirm != undefined)
	{
		showSpinner();
		console.log($scope.emailAddressConfirm);
		$http({url:  window.location.origin+"/gladstone/rest/public/checkForDuplicateUserNameAcrosDBs",
			 method: "POST",
			 data:$scope.emailAddressConfirm
			 })
			 .then(function(response) {
				hideSpinner();
				if(response.data == true)
				   {
					   console.log(response.data);
					   $scope.emailError = true;
					   $scope.emailMatch = false;
					   
					}
				   else
				   {
							//console.log(response.data);
							 
					}
					},
					function(response)
					{ // optional
					$('#errorPopup').modal();
					hideSpinner();
					});
	}

}
			
$scope.emailMatch = false;
$scope.matchEmail = function ()
{
	if($scope.emailAddress === $scope.emailAddressConfirm)
	{	 $scope.emailError = false;
		$scope.emailMatch = false;
		if($scope.emailAddressConfirm != "")
		{
		checkEmailAddress();
		}
	}
	else
	{
		$scope.emailMatch = true;
		 $scope.emailError = false;
		
	}
}
			$scope.matchEmail();
			var phoneInfo = patientInfo['phoneInfo'][0];
			$scope.phoneNumber = phoneInfo['phoneNumber'];
			$scope.specialInstructions = patientInfo['specialInstructions'];
			console.log( patientInfo);
			
			
$scope.addInstructions = function ()
{               showSpinner();
				emailAddressInfo['emailAddress'] = $scope.emailAddress;
				phoneInfo['phoneNumber'] = $scope.phoneNumber ;
				patientInfo['preferredContactType'] = $scope.preferred;
				patientInfo['specialInstructions'] = $scope.specialInstructions;
				patientInfo = JSON.stringify(patientInfo);
				window.localStorage.setItem('patientInfo', patientInfo);
				$location.path('/confirmation');
				hideSpinner();
				}
			
							 
	}]);

// confirmation page Controller
app.controller('confirmationCtrl', ['$scope','$http', '$routeParams', '$location','$window', '$rootScope',
			function ($scope, $http, $routeParams, $location, $window,  $rootScope) {
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			if(!patientInfo)
			{
				$location.path('/initial');
			}
			
var Incentives = function ()
				{
					showSpinner();
					$http({url:  window.location.origin+ "/gladstone/rest/public/signupIncentives",
					method: "GET"
					})
					.then(function(response) {
						$scope.Incentives = response.data;
						$scope.IncentivesData = response.data.incentiveItems;
						hideSpinner();},
			function(response)
			{ // optional
			$('#errorPopup').modal();
			hideSpinner();
			});
					
				}
			Incentives();
			$scope.specialInstructions = patientInfo['specialInstructions'];
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
				
			var addressInfo = patientInfo['addressInfo'][1];
			if(window.localStorage.getItem('prescriptionDetailInfoDoc'))
			{
			$scope.prescriptionDetailInfoDoc = JSON.parse(window.localStorage.getItem('prescriptionDetailInfoDoc'));
			$scope.doctorStateText = window.localStorage.getItem('doctorStateText');
			$scope.prescriptionDetailInfo = false;
			if($scope.prescriptionDetailInfoDoc['city'])
			{
			$scope.prescriptionDetailInfo = true;
			$scope.prescriptionDetailInfoDoc = JSON.parse(window.localStorage.getItem('prescriptionDetailInfoDoc'));
			$scope.doctorStateText = window.localStorage.getItem('doctorStateText');
			}
			}
				var pharmacy = window.localStorage.getItem('pharmacy');	
				if(pharmacy == "true")
				{
						$scope.prescriptionDetailInfoPhar = JSON.parse(window.localStorage.getItem('prescriptionDetailInfoPhar'));
						$scope.PstateStateText = window.localStorage.getItem('PstateStateText');
				}
			 $scope.preferredContactType = patientInfo['preferredContactType'];
			var healthCoaching = window.localStorage.getItem('healthCoaching');
			
			//console.log(patientInfo);
			$scope.patientName = patientInfo['firstName']+" "+patientInfo['lastName'];
			var dob = new Date(patientInfo['dateOfBirth']);//January 5, 1999
			var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			function myDateFormatter (dob) {
			//var d = new Date(dob);
			var d = dob;
			var day = d.getUTCDate();
			var month = d.getUTCMonth();
			var year = d.getUTCFullYear();
			var date =  months[month] +" "+ day + ", " + year;
			return date;
			};
			
			
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			
			var newPatientInfo = {};
			$scope.addressLine = addressInfo['addressLine1']+" "+addressInfo['addressLine2']+" "+addressInfo['addressLine3'];
			$scope.city = addressInfo['city'];
			$scope.postalCode = addressInfo['postalCode'];
			//$scope.stateId = addressInfo['stateId'];
			$scope.stateId =  window.localStorage.getItem('shippingStateText');
			var emailAddressInfo = patientInfo['emailAddressInfo'][0];
			$scope.emailAddress = emailAddressInfo['emailAddress'];
			var phoneInfo = patientInfo['phoneInfo'][0];
			$scope.phoneNumber = phoneInfo['phoneNumber'];                                   
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			
			var addressInfo1 = patientInfo['addressInfo'][0];
			var addressInfo2 = patientInfo['addressInfo'][1];
			
			var newAddInfo = {};
			newAddInfo["addressLine1"] = addressInfo1["addressLine1"];
			newAddInfo["addressLine2"] = addressInfo1["addressLine2"];
			newAddInfo["city"] =                    addressInfo1["city"];
			newAddInfo["postalCode"] = addressInfo1["postalCode"];
			newAddInfo["addressTypeDesc_i18nId"] = addressInfo1["addressTypeDesc_i18nId"];
			newAddInfo["addressType"] = addressInfo1["addressType"];
			newAddInfo["stateId"] = addressInfo1["stateId"];
			newAddInfo["state"] = 1;
			newAddInfo["preferred"] =false;
			
			var newAddInfo1 = {};
			newAddInfo1["addressLine1"] = addressInfo2["addressLine1"];
			newAddInfo1["addressLine2"] = addressInfo2["addressLine2"];
			newAddInfo1["city"] = addressInfo2["city"];
			newAddInfo1["postalCode"] = addressInfo2["postalCode"];
			newAddInfo1["addressTypeDesc_i18nId"] = addressInfo2["addressTypeDesc_i18nId"];
			newAddInfo1["addressType"] = addressInfo2["addressType"];
			newAddInfo1["stateId"] = addressInfo2["stateId"];
			newAddInfo1["state"] = 1;
			newAddInfo1["preferred"] =false;
			
			patientInfo['addressInfo'][0] = newAddInfo;
			patientInfo['addressInfo'][1] = newAddInfo1;
			var newEmailInfo = {};
			newEmailInfo['emailAddress'] =  emailAddressInfo['emailAddress'];
			newEmailInfo['state'] =  1;
			newEmailInfo['emailType'] =  emailAddressInfo['emailType'];
			newEmailInfo['emailTypeDesc_18nId'] =  emailAddressInfo['emailTypeDesc_18nId'];
			newEmailInfo['preferred'] =  true;
			
			patientInfo['emailAddressInfo'][0] = newEmailInfo;
			
			
			var newPhoneInfo = {};
			newPhoneInfo['phoneNumber'] = phoneInfo['phoneNumber'];
			newPhoneInfo['phoneType'] = "HOME";
			newPhoneInfo['phoneTypeDesc_i18nId'] = phoneInfo['phoneTypeDesc_i18nId'];
			newPhoneInfo['preferred'] =true;
			
			
			newPhoneInfo['state'] = 1;
			patientInfo['phoneInfo'][0] = newPhoneInfo;
			
			var credentialInfo = {};
			credentialInfo["userName"] = emailAddressInfo['emailAddress'];
			credentialInfo["isPasswordChangeReqd"] = true;
			credentialInfo["userLoginMethodDesc"] ="PASSWORD";
			credentialInfo["state"] = 1;
			
			var ProviderInfo = patientInfo['patientProviderInfos'][0];             
			var ProviderInfo1 = patientInfo['patientProviderInfos'][1];          
			
			var newProviderInfo = {};             
			newProviderInfo['providerId']=ProviderInfo['providerId'];
			newProviderInfo['primary']=true;
			newProviderInfo['priorityNo']=ProviderInfo['priorityNo'];
			
			var newProviderInfo1 = {};          
			newProviderInfo1['providerId']=ProviderInfo1['providerId'];
			newProviderInfo1['primary']=false;
			newProviderInfo1['priorityNo']=ProviderInfo1['priorityNo'];
			
			patientInfo['patientProviderInfos'][0]= newProviderInfo;
			patientInfo['patientProviderInfos'][1]= newProviderInfo1;
			//patientInfo['state']= 1;
			
			newPatientInfo['addressInfo'] = patientInfo['addressInfo'];
			
			newPatientInfo['patientProviderInfos'] = patientInfo['patientProviderInfos'];
			//var entityRoleInfo = [{roleId:3,state:1}];
			//entityRoleInfo["roleId"] = 3;
			//entityRoleInfo["state"] =  1;
		//	newPatientInfo["entityRoleInfos"] = entityRoleInfo;
			if(healthCoaching == "true")
			{
				var healthCoachingValue = false;
			}
			else
			{
				var healthCoachingValue = true;	
			}
			newPatientInfo['phoneInfo'] = patientInfo['phoneInfo'];
			newPatientInfo['emailAddressInfo'] = patientInfo['emailAddressInfo'];
			newPatientInfo['coaching'] = healthCoachingValue;
			newPatientInfo['firstName'] = patientInfo['firstName'];
			newPatientInfo['middleInitial'] = patientInfo['middleInitial'];
			newPatientInfo['lastName'] = patientInfo['lastName'];
			newPatientInfo['programType'] = "DMP";
			//newPatientInfo['dateOfBirth'] = "2015-12-12";
			newPatientInfo['userTimeZone'] = patientInfo['userTimeZone'];
			newPatientInfo['state'] = 1;
			newPatientInfo['genderCode'] = patientInfo['genderCode'];
			newPatientInfo['isActive'] = patientInfo['isActive'];
			newPatientInfo['entityType'] = patientInfo['entityType'];
			newPatientInfo['avatar'] = patientInfo['avatar'];
			//newPatientInfo['status'] = "AV";
			newPatientInfo['status'] = patientInfo['status'];
			newPatientInfo['preferredContactType'] =  patientInfo['preferredContactType'];
			newPatientInfo['patientInsuranceInfo'] = patientInfo['patientInsuranceInfo'];
			newPatientInfo['preferredName'] = patientInfo['firstName'];
			newPatientInfo['patientType'] = 'New';
			newPatientInfo['specialInstructions'] = patientInfo['specialInstructions'];
			newPatientInfo['adherenceVariance'] = false ;
			newPatientInfo['stage'] = "New Patient (successful)";

			
			 var dob = new Date(patientInfo['dateOfBirth']);
		 	/* var dobDate = dob.toUTCString();
			 var getDateFormat = dobDate.split(",");
			var splitDate = getDateFormat[0].split("/");
			$scope.DOB = myDateFormatter (getDateFormat[0]);*/
			 $scope.DOB = myDateFormatter(dob);
			var month = dob.getUTCMonth() + 1;
			
			
			var day = dob.getUTCDate();
			var year = dob.getUTCFullYear();
			var dobDate = year+"-"+month+"-"+day;
			newPatientInfo['dateOfBirth'] = dobDate;
			var signupPatientInfo = {};
			signupPatientInfo["patientInfo"] =newPatientInfo;
			signupPatientInfo["credentials"] = credentialInfo;
			signupPatientInfo["state"] = 1;
			var dataVal = signupPatientInfo;
			console.log(dataVal);
			
			var prescriptionDetailInfoDoc = $scope.prescriptionDetailInfoDoc;
			//console.log(prescriptionDetailInfoDoc);
			
			var createUpdatePrescriptionDetail = function (prescriptionDetailInfoDoc)
			{
			$http({url:  window.location.origin+ "/gladstone/rest/public/createUpdatePrescriptionDetail",
			method: "POST",
			data:prescriptionDetailInfoDoc
			})
			.then(function(response) {
			console.log(response);
			},
			function(response)
			{ // optional
			$('#errorPopup').modal();
			hideSpinner();
			});
			
			}
			
			var addPatient = function ()
			{
			$http({url:  window.location.origin+"/gladstone/rest/public/addPatient",
			method: "POST",
			data:dataVal
			})
			.then(function(response) {
			if(response.data)
			{
				if(prescriptionDetailInfoDoc['prescriberName'] !="" && prescriptionDetailInfoDoc['city'] !="")
				{
				prescriptionDetailInfoDoc['patientId'] = response.data["patientId"];
				createUpdatePrescriptionDetail (prescriptionDetailInfoDoc);
				}
				var pharmacy = window.localStorage.getItem('pharmacy');	
				if(pharmacy == "true")
				{
					var prescriptionDetailInfoPhar = JSON.parse(window.localStorage.getItem('prescriptionDetailInfoPhar'));
					prescriptionDetailInfoPhar['patientId'] = response.data["patientId"];
					createUpdatePrescriptionDetail (prescriptionDetailInfoPhar);
				}
				$location.path('/confirmed');
				hideSpinner();
				}
				console.log(response);
			},
			function(response)
			{ // optional
			$('#errorPopup').modal();
			hideSpinner();
			});
			
			}
$scope.addPatient = function ()
{                                                                                 
showSpinner();
addPatient();
}


 }]);


// confirmed page Controller
app.controller('confirmedCtrl', ['$scope', '$routeParams', '$location','$window', '$rootScope',
	function ($scope,  $routeParams, $location, $window,  $rootScope) {
		
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
			
var healthCoaching = window.localStorage.getItem('healthCoaching');
if(healthCoaching == "true")
{
$scope.healthCoaching = false;
}
else
{
	$scope.healthCoaching = true;
}
window.localStorage.clear();
}]);

// havingTrouble page Controller
app.controller('havingTroubleCtrl', ['$scope', '$http','$routeParams', '$location','$window', '$rootScope',
	function ($scope,$http, $routeParams, $location, $window,  $rootScope) {
			var patientInfo = JSON.parse(window.localStorage.getItem('patientInfo'));
			var userData = $location.search();
			if(window.localStorage.getItem('employerData'))
			{
			$scope.employers = JSON.parse(window.localStorage.getItem('employerData'));
			var institutionName = $scope.employers['institutionName'];
			}
			else if(userData)
			{
				$scope.employer = userData["employer"];
			}
			function DateFormatter (dob) {
			var day = dob.getUTCDate();
			var month = dob.getUTCMonth();
			var year = dob.getUTCFullYear();
			var date =  months[month] +" "+ day + ", " + year;
			return date;
			};
		
			function DateFormat (dob) {
			var day = dob.getUTCDate();
			var month = dob.getUTCMonth()+1;
			var year = dob.getUTCFullYear();
			var date =  year +"-"+ month + "-" + day;
			//var date =   month+"/"+ day + "/" + year;
			return date;
			};
		
			if(patientInfo)
			{
			$scope.patientName = patientInfo['firstName']+" "+patientInfo['lastName'];
			var dob = new Date(patientInfo['dateOfBirth']);//January 5, 1999
		 	/* var dobDate = dob.toUTCString();
			 var getDateFormat = dobDate.split(",");*/
			var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			$scope.DOB = DateFormatter (dob);
			}
			else if(userData)
			{
			$scope.patientName = userData['firstName']+" "+userData['lastName'];
			var dob = new Date(userData['dateOfBirth']);//January 5, 1999
		 	/* var dobDate = dob.toUTCString();
			 var getDateFormat = dobDate.split(",");*/
			var months = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
			$scope.DOB = DateFormatter (dob);

			}

var signupSupport = function ()
{

			var SignupAdditionalInfo = {};
			if(patientInfo)
			{
				SignupAdditionalInfo['firstName'] = patientInfo['firstName'];
				SignupAdditionalInfo['lastName'] = patientInfo['lastName'];
				SignupAdditionalInfo['dateOfBirth'] = DateFormat(dob);
				SignupAdditionalInfo['employerName']= $scope.employers.employer;
				SignupAdditionalInfo['institutionName']= $scope.employers.institutionName;
			}
			else if(userData)
			{
				SignupAdditionalInfo['firstName'] = userData['firstName'];
				SignupAdditionalInfo['lastName'] = userData['lastName'];
				SignupAdditionalInfo['dateOfBirth'] = DateFormat(dob);
				SignupAdditionalInfo['employerName']= userData['employer'];
				SignupAdditionalInfo['institutionName']= userData['institutionName'];

			}
			
				SignupAdditionalInfo['contactEmailAddress']= $scope.contactEmailAddress;
				SignupAdditionalInfo['constactPhoneNumber']= $scope.constactPhoneNumber;
				console.log(SignupAdditionalInfo);
				$http({url:  window.location.origin+ "/gladstone/rest/public/signupSupportRequest",
				method: "POST",
				data:SignupAdditionalInfo
				})
				.then(function(response) {
					 //alert("Request succesfully submitted.");
					 $(".popErrorMsg").text("Request successfully submitted.");
					 $('#errorPopup').modal();
					 hideSpinner();
			},
			function(response)
			{ // optional
			$('#errorPopup').modal();
			hideSpinner();
			});
}


			$scope.signupSupportRequest = function ()
			{
				showSpinner();
				signupSupport();
			}
			
		$(".closeBtn,.close,#fadeDivLoading").click(function()
		{
			$(".popErrorMsg").text("Error occurred,please contact Kannact support.");
		});
}]);

// privacyPolicyCtrl page Controller
app.controller('privacyPolicyCtrl', ['$scope', '$http','$routeParams', '$location','$window', '$rootScope',
	function ($scope,$http, $routeParams, $location, $window,  $rootScope) {
}]);

// termsServiceCtrl page Controller
app.controller('termsServiceCtrl', ['$scope', '$http','$routeParams', '$location','$window', '$rootScope',
	function ($scope,$http, $routeParams, $location, $window,  $rootScope) {
}]);

