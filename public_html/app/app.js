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
                templateUrl: 'partials/files.html?v3',
                controller: 'authCtrl'
            })
			.when('/account', {
                title: 'Dashboard',
                //templateUrl: 'partials/dashboard.html',
                templateUrl: 'partials/account.html',
                controller: 'accountCtrl'
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
            .when('/step3', {
                title: 'Step 3 Authentication',
                templateUrl: 'partials/step3.html',
                controller: 'step3Ctrl',
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
							$rootScope.loguser="true";
						
						}else{
							$location.path("/step2");
						}
					}
                } else {
					
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login' || nextUrl == '/step2') {
						$rootScope.loguser="false";
                    } else {
						$rootScope.loguser="false";
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
	
	
	
	
	
	
	
	
function load_picture(id, filename)
			{
				//Here we are finding the image container width and then loading the image accordingly.
				var width_container = document.getElementById("photo").offsetWidth;
				document.getElementById("photo").innerHTML = document.getElementById("photo").innerHTML + "<img src='' id='" + id + "' />";
				document.getElementById(id).setAttribute("src", "s.jpg?name=" + filename + "&container=" + width_container);
				document.getElementById(id).onload = function(){
					face_detection(id);
				}				
			}

			function face_detection(id)
			{
				$("#" + id).faceDetection({
		        	complete: function(faces){
		        		var count = faces.length;
		        		for(var iii = 0; iii < count; iii++){
		        			var x = faces[iii].offsetX;
		        			var y = faces[iii].offsetY;
		        			var height = faces[iii].height;
		        			var width = faces[iii].width;

		        			var input_id = iii.toString() + "_input"
		        			//var input_height = height + 20;
		        			var input_height = height + 0;

		        			//Here you can also add some event listener to detect "Enter Key" click so that you can save the name tagged. And also if the tagging is already done then you can add a "value" attribute and assign the name
		        			var input = '';//"<input id='box" + input_id + "' list='players' style='top:" + height + "px'>";
		        			var box = "<a class='box' id='box" + iii + "' style='position:fixed;left:" + x + "px; top: " + y + "px; height: " + input_height + "px; width:" + width + "px'>"+input+"</a>";
		        			document.getElementById("photo").innerHTML = document.getElementById("photo").innerHTML + box;
							
		        			//document.getElementById("canvas").innerHTML = document.getElementById("photo").innerHTML + box;
							
							
							var canvas = document.getElementById('canvasi');
							  var context = canvas.getContext('2d');
							  var imageObj = new Image();

							 <!-- canvas.setAttribute("style","left:" + x + "px; top: " + y + "px;"); -->
							 canvas.setAttribute("width",width);
							canvas.setAttribute("height",input_height);
							
							  imageObj.onload = function() {
								// draw cropped image
								var sourceX = x;
								var sourceY = y;
								var sourceWidth = width;
								var sourceHeight = input_height;
								var destWidth = sourceWidth;
								var destHeight = sourceHeight;
								var destX = canvas.width / 2 - destWidth / 2;
								var destY = canvas.height / 2 - destHeight / 2;

								context.drawImage(imageObj, sourceX, sourceY, sourceWidth, sourceHeight, destX, destY, destWidth, destHeight);
							  };
							  imageObj.src = 's.jpg';
							  
							
		        		}
			        }
			    });

				alert("Move your mouse over the faces to see the face detection and tagging");
			}