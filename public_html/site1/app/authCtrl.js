app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('step2');
            }
        });
    };
	
	$scope.checkstep = function (step) {
        Data.post('step2', {
            step: step
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('files/Auth');
            }
        });
    };
	
    $scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('security-signup');
                //$location.path('dashboard');
            }
        });
    };
	$scope.cnvs="";
	$scope.signupface = {face:$scope.cnvs,cid:$scope.uid};
    $scope.signUpFace = function (customer) {
        Data.post('signUpFace', {
            customer: customer
        }).then(function (results) {
            //Data.toast(results);
            if (results.status == "success") {
                //$location.path('security-signup');
                $location.path('dashboard');
            }
        });
    };
	
    $scope.logout = function () { 
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    };
	
	$scope.upfrompcrun=function(){
		document.getElementById('upfrompc').click();
	};
	
});
