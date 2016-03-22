app.controller('accountCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,fileUpload) {
    //initially set those objects to null to avoid undefined error
    //data
	$scope.auth="sdfg sdhgfs";
	$scope.explorer=[];
	$scope.curentfolder="";
	
	$scope.rootresults=[];
	$scope.logout = function () {         Data.get('logout').then(function (results) {            Data.toast(results);            $location.path('login');        });    };
	$scope.get_profile=function(){
		Data.get('myprofile').then(function (results) {
			$scope.profile=results.profile;
		}); 
	};
	$scope.get_profile();
	$scope.reload =  function(){
		$scope.get_profile();
	};
	$scope.signUp = function(profile){
		Data.post('signUpModify', {
            customer: profile
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
               //alert("Profile Updated");
			   $scope.get_profile();
            }
        });
	};
	$scope.changepswrd = function(password){
		Data.post('passwordModify', {
            customer: password
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
               //alert("Profile Updated");
			  // $scope.get_profile();
            }
        });
	};	
});
