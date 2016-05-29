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

app.controller('ProviderListCtrl', function($scope, $http) {
	$scope.dataLoading = false;
	$scope.startPageNo = 0;
	$scope.endPageNo = 1;
	//Buffer = recordsPerPage*pagesToDisplay
	$scope.pagesToDisplay = 10;
	$scope.recordsPerPage = 10;
	$scope.providers = undefined;
	$scope.filterChar = '';
	$scope.alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");
	$scope.authToken = '';
	$scope.attempt = 0;


	$scope.searchNames = function(chars) {
		// Reset data: 
		$scope.startPageNo = 0;
		$scope.endPageNo = 1;
		$scope.providers = undefined;
		
		// Set filterChar:
		$scope.filterChar = chars;
		$scope.loadData(1, true);
	}
	
	$scope.selectCategory = function(newCategory) {
		$scope.searchNames(newCategory);
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
				console.log(token);
			});
		}		
		$http.get(window.location.origin + "/gladstone/rest/providers", 
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
			$scope.updateScopeData(data.data, scrollDown); 
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
		if((arrData == undefined)||(arrData.length == 0)) {
			console.log("Reached end of the data");
			return;
		}
		console.log("arrDatalength",arrData.length);
		if($scope.providers == undefined) {
			// 1st time: 
			$scope.providers = arrData; 
		} else {
			if(scrollDown) {
				for (var i = 0; i < arrData.length; i++) {
					$scope.providers.push(arrData[i]);
				}
			} else {
				for (var i = arrData.length - 1; i >= 0; i--) {
					$scope.providers.unshift(arrData[i]);
				}
				
			}
			if(($scope.endPageNo - $scope.startPageNo) > ($scope.pagesToDisplay)) {
				var raw = document.getElementById("menu-content-aj");
				// Remove old data: 
				if(scrollDown) {
					console.log("Need to set start: " + ($scope.endPageNo - $scope.pagesToDisplay)); 
					$scope.providers.splice(0, $scope.recordsPerPage);
					$scope.startPageNo = ($scope.endPageNo - $scope.pagesToDisplay);
					
					raw.scrollTop = raw.scrollHeight - raw.offsetHeight - 150;
				} else {
					// Splice data from end: 
					var endIndex = $scope.pagesToDisplay * $scope.recordsPerPage;
					$scope.providers.splice(endIndex, $scope.providers.length - endIndex);
					$scope.endPageNo--;
					raw.scrollTop = 150;
				}
			}
			console.log("Providers' count: "+$scope.providers.length);
		}
		$scope.backup = $scope.providers;
		
		if(scrollDown) {
			$scope.endPageNo++;
		} else {
			if($scope.startPageNo > 0) {
				$scope.startPageNo--;
			}
		}
		
		// console.log("$scope.endPageNo: "+$scope.endPageNo+"; $scope.startPageNo: "+$scope.startPageNo);
	}
	
	$scope.editProvider = function(id) {
		console.log("Edit id: "+id);
		openPageWithAjax('../../provider/pages/portal_addProvider.php','edit=edit&providerId='+id,'menu-content',event,this)
	}
	$scope.loadData(1, true);
});

function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}
