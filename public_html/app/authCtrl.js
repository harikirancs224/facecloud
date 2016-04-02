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
                /* $location.path('files/Auth'); */
				$location.path("/step3");
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
	
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === "connected") {
          // Logged into your app and Facebook.
          testAPI();
        } else if (response.status === "not_authorized") {
          // The person is logged into Facebook, but not your app.
          console.log("The person is logged into Facebook, but not your app.");
        } else {
          // The person is not logged into Facebook, so were not sure if
          // they are logged into this app or not.
        }
      }

      // This function is called when someone finishes with the Login
      // Button.  See the onlogin handler attached to it in the sample
      // code below.
      function checkLoginState() {
        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
		  if (response.status === "connected") {
			  
			  FB.api("/me", { locale: "en_US", fields: "name, email" }, function(response) {
				  console.log("Fb response");
				  console.log(response);
				  coupon_ajaxgo(response);
				 
				});
			  
		  }
        });
      }

	window.fbAsyncInit = function(){
        FB.init({
          appId: "902365526513195",
          cookie: true, // enable cookies to allow the server to access 
          // the session
          xfbml: true, // parse social plugins on this page
          version: "v2.2" // use version 2.2
        });

        // Now that we have initialized the JavaScript SDK, we call 
        // FB.getLoginStatus().  This function gets the state of the
        // person visiting this page and can return one of three states to
        // the callback you provide.  They can be:
        //
        // 1. Logged into your app ("connected")
        // 2. Logged into Facebook, but not your app ("not_authorized")
        // 3. Not logged into Facebook and can not tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function.

        FB.getLoginStatus(function(response) {
          statusChangeCallback(response);
		  
        });

	};

      // Load the SDK asynchronously
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        //js.src = "//connect.facebook.net/en_US/all.js";
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, "script", "facebook-jssdk"));

      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function testAPI() {
        console.log("Welcome!  Fetching your information.... ");
        FB.api("/me", { locale: "en_US", fields: "name, email" }, function(response) {
          console.log("Fb response");
          console.log(response);
		  
          console.log("Successful login for: " + response.name);
          //document.getElementById("status").innerHTML ="Coupon has been sent to , " + response.email + "!";
        });
		/* FB.api("/me/friends",
			function (response) {
			  if (response && !response.error) {
				  console.log("Frients list");
				  console.log(response);
			
			  }
			}
		); */
      }
	  
	  //google login
	  function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don t send this directly to your server!
        console.log("Name: " + profile.getName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
		
		var response={id:profile.getId(),name:profile.getName(),email:profile.getEmail()};
		//coupon_ajaxgo(response);
      };
    
		function coupon_ajaxgo(cd)
		{
			var c= {email : cd.email, name: cd.name, fbid: cd.id, typ:'fblogin'}
			$scope.doLogin(c);

			request.done(function( msg ) {
				if(msg!='passed')
				{
					alert('Unable to process your request, '+msg);
				}
				else
				{
					alert("Coupon  has been sent to your mail id");
				}
  
			});	
 
			request.fail(function( jqXHR, textStatus ) {
			  alert( "Request failed: ");
			});	
		}

});

app.controller('step3Ctrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,$timeout) {
    
	$scope.face="";
	$scope.signinface = {face:"s",uid:"12"};
    $scope.signInFace = function (customer) {
		customer.uid=$rootScope.uid;
        Data.post('signInFace', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                //$location.path('security-signup');
                $location.path('dashboard');
            }
        });
    };
	$scope.ccolor="red";
	$scope.perce=0;
	$scope.scrorefor=100;
    $scope.incr = function(x){
		var a=parseInt(x);
		$scope.perce=a+"%";
		a++;
		$timeout(function(){
			var cme=parseInt($scope.scorefor);
			if(a>45){ $scope.ccolor="orange"; }
			if(a>90){ $scope.ccolor="green"; }
			
			if(a<cme){
				$scope.incr(a);
			}else{
				if(a>90){
					//alert(cme+" percent matched!");
					
					$location.path("/files/Auth");
				}
			}
		},100);
	};
	$scope.opic={};
	$scope.dpic={};
	/* $scope.randomepic = function(){
		var myArray = ['4', '23', '68', '27', '93', '5', '34', '81', '14'];  
		var rand = myArray[Math.floor(Math.random() * myArray.length)];
		return rand;
		alert(+rand);
	}; */
	$scope.signInFaceScan = function(){
		var abc = document.getElementById("capturedata").value;
		if(abc!=""){
			$scope.scanmode = "true";
			
			$scope.signupface = {face:"s",uid:"12"};
			
			var customer={uid:$rootScope.uid,face:abc};
			Data.post('signUpFacep', {
				customer: customer
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					//$location.path('security-signup');
					//$location.path('dashboard');
					
					var client = new FCClientJS('3208223b92ce411eb58723a0d27a00cb', 'a748918d8a794f84b593d48dbf132ea1');
					var options = new Object();
					options.detect_all_feature_points = true;
					client.facesDetect("http://www.facecloud.us/pic/?uid="+$rootScope.uid, null, options, $scope.opicval);
					
				}
			});
			
			
			
			
			
			
		}else{
			alert("Photo not captured.");
			
		}
	};
	
	$scope.opicval = function(data){
		
		var fb=data.photos[0];
		$scope.opic={eye_leftx:fb.tags[0].eye_left.x, eye_lefty:fb.tags[0].eye_left.y, eye_rightx:fb.tags[0].eye_right.x, eye_righty:fb.tags[0].eye_right.y, mouthx:fb.tags[0].mouth_center.x, mouthy:fb.tags[0].mouth_center.y, nosex:fb.tags[0].nose.x, nosey:fb.tags[0].nose.y};
		
		var client = new FCClientJS('3208223b92ce411eb58723a0d27a00cb', 'a748918d8a794f84b593d48dbf132ea1');
		var options = new Object();
		options.detect_all_feature_points = true;
		//client.facesDetect("https://lh3.googleusercontent.com/-rTAW36HfoE0/AAAAAAAAAAI/AAAAAAAADco/AJpJa-rKsto/photo.jpg", null, options, $scope.sscalback);
		client.facesDetect("http://www.facecloud.us/pic/?pp&uid="+$rootScope.uid, null, options, $scope.sscalback);
	};
	$scope.sscalback = function(data){
		
		var fb=data.photos[0];
		try {
			$scope.dpic={eye_leftx:fb.tags[0].eye_left.x, eye_lefty:fb.tags[0].eye_left.y, eye_rightx:fb.tags[0].eye_right.x, eye_righty:fb.tags[0].eye_right.y, mouthx:fb.tags[0].mouth_center.x, mouthy:fb.tags[0].mouth_center.y, nosex:fb.tags[0].nose.x, nosey:fb.tags[0].nose.y};
		}catch(err) {
			alert("Captured photo is not valid");
			return '';
		}
		
		
		var a = ($scope.dpic.eye_leftx/$scope.opic.eye_leftx)*100;
		var b = ($scope.dpic.eye_lefty/$scope.opic.eye_lefty)*100;
		var c = ($scope.dpic.eye_rightx/$scope.opic.eye_rightx)*100;
		var d = ($scope.dpic.eye_righty/$scope.opic.eye_righty)*100;
		
		var e = ($scope.dpic.mouthx/$scope.opic.mouthx)*100;
		var f = ($scope.dpic.mouthy/$scope.opic.mouthy)*100;
		
		var g = ($scope.dpic.nosex/$scope.opic.nosex)*100;
		var h = ($scope.dpic.nosey/$scope.opic.nosey)*100;
		
		
		$scope.matchp = {eyeleftx:a,eyelefty:b,eyerightx:c,eyerighty:d,mouthx:e,mouthy:f,nosex:g,nosey:h};
		$scope.fresult = {lefteye:a+','+b+' Matched',righteye:c+','+d+' Matched',mouth:e,mouthy:f,nosex:g,nosey:h};
		var fg=((a+b+c+d+e+f+g+h)/800)*100;
		
		var bf=fg;//$scope.randomepic();
		$scope.scorefor=parseInt(bf);
		$scope.incr(1);
		if($scope.scorefor>100) $scope.scorefor=100;
		var customer={uid:$rootScope.uid,face:abc};
		
		if($scope.scorefor>90){
			Data.post('step3', {
				customer: customer
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					
				}
			});
		}
					
		alert(fg+"% Matched,\n Brief: "+JSON.stringify($scope.matchp));
		//$location.path("/files/Auth");
	};
	
	
	$scope.upfrompcrun=function(){
		document.getElementById('upfrompc').click();
	};
	
	
	navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

	navigator.getMedia({video: true}, function() {
	  // webcam is available
	}, function() {
	  // webcam is not available
		alert("webcam is not available.\n  please wait... \n We are redirecting you to dashboard");
		//$location.path("/files/Auth");
	});

	$scope.captureimg=function(){
		$scope.capme=true;
	 // Put event listeners into place
    // Grab elements, create settings, etc.
        var canvas = document.getElementById("canvas"),
				context = canvas.getContext("2d"),
				video = document.getElementById("video"),
				videoObj = { "video": true },
				errBack = function (error) {
				    console.log("Video capture error: ", error.code);
				};

        // Put video listeners into place
        if (navigator.getUserMedia) { // Standard
            navigator.getUserMedia(videoObj, function (stream) {
                video.src = stream;
                video.play();
            }, errBack);
        } else if (navigator.webkitGetUserMedia) { // WebKit-prefixed
            navigator.webkitGetUserMedia(videoObj, function (stream) {
                video.src = window.webkitURL.createObjectURL(stream);
                video.play();
            }, errBack);
        } else if (navigator.mozGetUserMedia) { // WebKit-prefixed
            navigator.mozGetUserMedia(videoObj, function (stream) {
                video.src = window.URL.createObjectURL(stream);
                video.play();
            }, errBack);
        }

        // Trigger photo take
        document.getElementById("snap").addEventListener("click", function () {
			$scope.snap();
			//alert($scope.capme);
            //context.drawImage(video, 0, 0, 160, 160);
           // context.drawImage(video, 120, 120, 160, 160, 0, 0, 160, 160);
		   
			var xx=video.videoWidth;
			var yy=video.videoHeight;
			canvas.setAttribute('width', xx);
			canvas.setAttribute('height', yy);
			context.drawImage(video, 0, 0,xx,yy);
			
			var id="xyz";
            var image = document.getElementById("canvas").toDataURL("image/png");
			//document.getElementById("picavatar").src=image;
            //image = image.replace('data:image/png;base64,', '');

			//$scope.signupface.face = image;
          //  document.getElementById("capturedata").value = image;
		  
		  var width_container = document.getElementById("photo").offsetWidth;
			document.getElementById("photo").innerHTML = document.getElementById("photo").innerHTML + "<img src='' id='" + id + "' />";
			document.getElementById(id).setAttribute("src", image);
			document.getElementById(id).onload = function(){
				face_detection(id,image);
			}
            //canvas.toDataURL();
        });
    
	};
	
	// Trigger photo take
    $scope.snap = function () { 
		$scope.capme=false;
	};
	
	
	function face_detection(id,imgh)
	{
		//alert("called"+id);
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
					var box = "<a class='box' id='box" + iii + "' style='left:" + x + "px; top: " + y + "px; height: " + input_height + "px; width:" + width + "px'>"+input+"</a>";
					document.getElementById("photo").innerHTML = document.getElementById("photo").innerHTML + box;
					
					//document.getElementById("canvas").innerHTML = document.getElementById("photo").innerHTML + box;
					
					
					var canvas = document.getElementById('canvasi');
					  var context = canvas.getContext('2d');
					  var imageObj = new Image();

					//canvas.setAttribute("style","left:" + x + "px; top: " + y + "px;");
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
						
						var imge = document.getElementById("canvasi").toDataURL("image/png");
						document.getElementById("picavatar").src=imge;
						$scope.$apply(function(){
							$scope.signinface.face = imge;
						});
						document.getElementById("capturedata").value = imge;
					  };
					  //imageObj.src = 's.jpg';
					  imageObj.src = imgh;
					  
					
				}
			}
		});

		//alert("Move your mouse over the faces to see the face detection and tagging");
	}
	
	
	function drawFacesAddPoint(control, imgWidth, imgHeight, point, title) {
		var x = Math.round(point.x * imgWidth / 100);
		var y = Math.round(point.y * imgHeight / 100);
		var pointClass = title == null ? "api_face_all_point" : "api_face_point";
		var pointStyle = 'top: ' + y + 'px; left: ' + x + 'px;';
		var pointTitle = (title == null ? '' : title + ': ') + 'X=' + x + ', Y=' + y + ', Confidence=' + point.confidence + '%' + (title == null ? ', Id=' + point.id.toString(16) : '');
		control.append($('<span class="' + pointClass + '" style="' + pointStyle + '" title="' + pointTitle + '"></span>'));
	}
	function drawFaces(div, photo, drawPoints) {
		if (!photo) {
			alert("No image found");
			return;
		}
		if (photo.error_message) {
			alert(photo.error_message);
			return;
		}
		var imageWrapper = $('<div class="image_wrapper"></div>').appendTo(div);
		var maxImgWidth = parseInt(div.prev().children(".img_max_width").html(), 10);
		var maxImgHeight = parseInt(div.prev().children(".img_max_height").html(), 10);
		var imgWidth = photo.width;
		var imgHeight = photo.height;
		var scaleFactor = Math.min(maxImgWidth / imgWidth, maxImgHeight / imgHeight);
		if (scaleFactor < 1) {
			imgWidth = Math.round(imgWidth * scaleFactor);
			imgHeight = Math.round(imgHeight * scaleFactor);
		}
		imageWrapper.append($('<img alt="face detection results" width="' + imgWidth + 'px" height="' + imgHeight + 'px" src="' + photo.url + '" />'));
		if (photo.tags) {
			for (var i = 0; i < photo.tags.length; ++i) {
				var tag = photo.tags[i];
				var tagWidth = tag.width * 1.5;
				var tagHeight = tag.height * 1.5;
				var width = Math.round(tagWidth * imgWidth / 100);
				var height = Math.round(tagHeight * imgHeight / 100);
				var left = Math.round((tag.center.x - 0.5 * tagWidth) * imgWidth / 100);
				var top = Math.round((tag.center.y - 0.5 * tagHeight) * imgHeight / 100);
				if (drawPoints && tag.points) {
					for (var p = 0; p < tag.points.length; p++) {
						drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.points[p], null);
					}
				}
				var tagStyle = 'top: ' + top + 'px; left: ' + left + 'px; width: ' + width + 'px; height: ' + height + 'px; transform: rotate(' +
					tag.roll + 'deg); -ms-transform: rotate(' + tag.roll + 'deg); -moz-transform: rotate(' + tag.roll + 'deg); -webkit-transform: rotate(' +
					tag.roll + 'deg); -o-transform: rotate(' + tag.roll + 'deg)';
				var apiFaceTag = $('<div class="api_face" style="' + tagStyle + '"><div class="api_face_inner"><div class="api_face_inner_tid" name="' + tag.tid + '"></div></div></div>').appendTo(imageWrapper);
				if (drawPoints) {
					if (tag.eye_left) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.eye_left, "Left eye");
					if (tag.eye_right) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.eye_right, "Right eye");
					if (tag.mouth_center) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.mouth_center, "Mouth center");
					if (tag.nose) drawFacesAddPoint(imageWrapper, imgWidth, imgHeight, tag.nose, "Nose tip");
				}
			}
		}
	}
	function callback(data) {
		//drawFaces($("#conent_demo_image"), data.photos[0], true);
		var fb=data.photos[0];
		alert("EYE LEFT x:"+fb.tags[0].eye_left.x+" Y:"+fb.tags[0].eye_left.y);
		alert("EYE RIGHT x:"+fb.tags[0].eye_right.x+" Y:"+fb.tags[0].eye_right.y);
		alert("mouth_center x:"+fb.tags[0].mouth_center.x+" Y:"+fb.tags[0].mouth_center.y);
		alert("nose x:"+fb.tags[0].nose.x+" Y:"+fb.tags[0].nose.y);
		//alert(JSON.stringify(fb.tags[0].mouth_center));
		//alert(JSON.stringify(fb.tags[0].nose));
		//alert(JSON.stringify(fb.tags[0]));
		
		//window.location=JSON.stringify(fb);
	}
				
	
});
