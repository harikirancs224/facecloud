app.controller('headerCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,fileUpload) {
	
	if($rootScope.loguser){
		
	}else{
		$rootScope.loguser="false";
	}
	
		if($rootScope.uid){
			

			if($scope.uid != ""){
				$scope.loguser="true";
			}else{
				
			}
		}
	$scope.logout = function(){
		$rootScope.getlogout();
	};
	/* $scope.uid = results.uid;
	$scope.name = results.name;
	$scope.email = results.email; */
	
});