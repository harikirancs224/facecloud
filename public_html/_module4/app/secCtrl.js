app.controller('secCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    
	$scope.face="";
	$scope.signupface = {face:"s",uid:"12"};
    $scope.signUpFace = function (customer) {
		customer.uid=$rootScope.uid;
        Data.post('signUpFace', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                //$location.path('security-signup');
                $location.path('dashboard');
            }
        });
    };
	
    
	
	$scope.upfrompcrun=function(){
		document.getElementById('upfrompc').click();
	};
	
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
            context.drawImage(video, 120, 120, 160, 160, 0, 0, 160, 160);

            var image = document.getElementById("canvas").toDataURL("image/png");
			document.getElementById("picavatar").src=image;
            //image = image.replace('data:image/png;base64,', '');

			$scope.signupface.face = image;
            document.getElementById("capturedata").value = image;
            //canvas.toDataURL();
        });
    
	};
	
	// Trigger photo take
    $scope.snap = function () {
		$scope.capme=false;
	};
	
});

function fillpic(v){
	try{
		var a=document.getElementById('picavatar');
		var ctx = document.getElementById('canvas').getContext('2d');
		var img = new Image;
		img.onload = function() {
			ctx.drawImage(img, 20,20);
			alert('the image is drawn');
		}
		img.src = URL.createObjectURL(e.target.files[0]);
		a.src=img.src;
	}catch(err){
		alert(err);
	}
}
function readURL(input, target) {
//target=$(target).find("img");
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var image_target = $(target);
        reader.onload = function (e) {
            image_target.attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
     }
 }