app.controller('headerCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,fileUpload) {
	
	$scope.loguser="false";
	
		if($scope.uid!=""){
			$scope.loguser="true";
		}else{
			
		}
	
	$scope.logout = function(){
		$rootScope.getlogout();
	};
	/* $scope.uid = results.uid;
	$scope.name = results.name;
	$scope.email = results.email; */
	
});