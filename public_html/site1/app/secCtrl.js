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
							$scope.signupface.face = imge;
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