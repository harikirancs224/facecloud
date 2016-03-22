var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster', 'ui.bootstrap']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
        when('/login', {
            title: 'Login',
            templateUrl: 'partials/login.html',
            controller: 'authCtrl'
        })
            .when('/logout', {
                title: 'Logout',
                templateUrl: 'partials/login.html',
                controller: 'logoutCtrl'
            })
            .when('/signup', {
                title: 'Signup',
                templateUrl: 'partials/signup.html',
                controller: 'authCtrl'
            })
			.when('/security-signup', {
                title: 'Security Signup',
                templateUrl: 'partials/signup2.html',
                controller: 'secCtrl'
            })
            .when('/dashboard', {
                title: 'Dashboard',
                //templateUrl: 'partials/dashboard.html',
                templateUrl: 'partials/files.html',
                controller: 'authCtrl'
            })
			.when('/account', {
                title: 'Dashboard',
                //templateUrl: 'partials/dashboard.html',
                templateUrl: 'partials/account.html',
                controller: 'fileCtrl'
            })
			.when('/files/:slug', {
                title: 'Files',
                templateUrl: 'partials/files.html',
                controller: 'fileCtrl',
				reloadOnSearch: false
            })
            .when('/', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'authCtrl',
                role: '0'
            })
            .when('/step2', {
                title: 'Step 2 Authentication',
                templateUrl: 'partials/step2.html',
                controller: 'authCtrl',
                role: '0'
            })
            .otherwise({
                redirectTo: '/login'
            });
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
			
            Data.get('session').then(function (results) {
				
                
				if(results.uid){
					if(results.step2=='' || results.step2=='null'){
						var nextUrl = next.$$route.originalPath;
						if ( nextUrl == '/step2') {
							
						} else {
							$location.path("/step2");
						}
						
					}else{
						//alert("logged");
						if(results.step2){
							
						
							var nextUrl = next.$$route.originalPath;
							if (nextUrl == '/signup' || nextUrl == '/login' || nextUrl == '/') {
								$location.path("/files/a");
							}
							
							$rootScope.authenticated = true;
							$rootScope.uid = results.uid;
							$rootScope.name = results.name;
							$rootScope.email = results.email;
						}else{
							$location.path("/step2");
						}
					}
                } else {
					
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login' || nextUrl == '/step2') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
			
			$rootScope.splitter = function(str) {
				var tArr = str.split(":");
				//var hour = tArr[0];var minute = tArr[1];var second = tArr[2];
				return tArr;
			};
			$rootScope.getParameterByName = function(name) {
				name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
				var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
					results = regex.exec(location.search);
				return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
			};
			
			$rootScope.getlogout = function () {
				Data.get('logout').then(function (results) {
					Data.toast(results);
					$location.path('login');
				});
			};
			
        });
    }); 