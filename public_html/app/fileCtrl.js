app.controller('fileCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,fileUpload,$timeout) {
    //initially set those objects to null to avoid undefined error
    //data
	$scope.auth="sdfg sdhgfs";
	$scope.explorer=[];
	$scope.curentfolder="";
	
	$scope.capme = "false";
	$scope.rootresults=[];
	$scope.logout = function () {         Data.get('logout').then(function (results) {            Data.toast(results);            $location.path('login');        });    };
	$scope.get_folders=function(){
		Data.get('directorylisting').then(function (results) {
			//Data.toast(results);
			if (results.status == "success") {
				//$scope.explorer.push({});
				$scope.folders=results.list;
				$scope.rootresults=results.list;
				angular.forEach(results.list, function(item) {
					//alert(item.post_title);
				});
				$scope.listner=$scope.folders;
				$scope.refun(results.list);
			}else{
				
			}
		}); 
	};
	$scope.reload =  function(){
		$scope.get_folders();
	};
	
	
	$scope.validate = function(v) {
	   if(v=="pending") // if your going to return true
		  return true;
   };
	$scope.level=0;
	$scope.routename = $scope.getParameterByName("router");
	/* $scope.routArr = $scope.splitter($scope.routename);
	
	$scope.routeexplore = function(v){
		if($scope.routArr[$scope.level]==v.folder){
			$scope.exploreme(v);
		}
	}; */
	$scope.loc=$location.search();
	$scope.checkmeforexplore = function(x){
		if(x.link==$scope.loc.router){
			//alert("explored");
			console.log("Mateched");
			$scope.exploreme(x);
		}else{
			//console.log("Not Mateched, "+x.link+"=="+$scope.loc.router);
		}
	};
	$scope.stepback = function(){
		var str=$scope.loc.router;
		
		var cArr=str.split("/");
		var i=1;var h="";
		cArr.forEach(function(x) {
			//console.log(x);
			if(i<cArr.length){
				if(x!="")
					h+='/'+x;
			}
			i++;
		});
		if(h=="") h="/";
		
		$scope.loc.router=h;
		$scope.steprefun($scope.rootresults,h);
		location.href="#/files/"+$scope.auth+"?router="+h;
		/* $location.search().router=h;
		
		$scope.refun($scope.rootresults); */
	};
	
	$scope.steprefun = function(set,c){
		if(c=="/"){
			$scope.exploreme("all");
		}else{
			
			angular.forEach(set, function(item) {
				if(item.sublist){
					if(item.link==c){
						console.log("Matched");
						$scope.exploreme(item);
					}else{
						console.log("Not Mateched, "+item.link+"=="+c);
					}
					
					if(Object.keys(item.sublist).length === 0){
					}else{
						$scope.steprefun(item.sublist,c);	
					}
				}
				//alert(item.post_title);
			});
		}
	};
	
	$scope.refun = function(set){
		angular.forEach(set, function(item) {
			if(item.sublist){
				if(item.link==$scope.loc.router){
					console.log("Matched");
					$scope.exploreme(item);
				}else{
					console.log("Not Mateched, "+item.link+"=="+$scope.loc.router);
				}
				
				if(Object.keys(item.sublist).length === 0){
				}else{
					$scope.refun(item.sublist);	
				}
			}
			//alert(item.post_title);
		});
	};
	
	$scope.get_folders();
	$scope.exploreme=function(v){
		$scope.selecteditems.length = 0;
		if(v=="all"){
			$scope.listner=$scope.folders;
			$scope.curentfolder="/";
			$scope.loc.router="/";
		}
		else{ 
			if(v.type!="folder"){
				alert("Toggle to download symbol to download!...");
			}else{
				$scope.listner=v.sublist;
				$scope.curentfolder=v.link;
				$scope.loc.router=v.link;
				
			}
			
		}
	};
	//alert($routeParams.slug);
	$scope.incls=function(x){
		var v=x.sublist;
		
		if((v==null||v.length==0)&&(x.type=="folder")){
			return '-o';
		}
	};
	$scope.infilefolder=function(x){
		if(x.type=="folder")
			return 'fa-folder-open';
		else{
			var a="fa-file";
			a+=x.typemode;
			
			return a;
		}
	};
	/* $scope.new_file = function(){
		document.getElementById("file")
	}; */
	$scope.onFileSelect = function($files) {
    //$files: an array of files selected, each file has name, size, and type.
    for (var i = 0; i < $files.length; i++) {
      var $file = $files[i];
      Upload.upload({
        url: 'my/upload/url',
        file: $file,
        progress: function(e){}
      }).then(function(data, status, headers, config) {
        // file is uploaded successfully
        console.log(data);
      }); 
    }
  };
  
  
  $scope.filemessage=function(){
	Data.toast({"status":"success","message":"Folder created successfully s"});  
  };
  
	$scope.uploadFile = function(e){
		
		//e.preventDefault();
       // var file = $scope.myFile;
       // console.log('file is ' );
       /*  console.dir(file); */
       
		var file = $scope.file;
		var fd = new FormData();
		 fd.append("file", file);
		 //fd.append("parent",$scope.curentfolder);
		 //{parent:$scope.curentfolder,file:fd}
        //fd.append('file', $scope.file);
        //fd.append('file', document.getElementById("myFile").value);
		
		//var file = $scope.myFile;
		//fileUpload.uploadFileToUrl(file, "filequee",$scope.curentfolder);
		var serviceBase = 'api/v1/';
		
		
		$('#form').attr("action",serviceBase+'filequee');
		$scope.underfolder=$scope.curentfolder;

	
		 $('#form').ajaxForm( {
			target:"#preview",
			success: function(response) {
				var results=$(response).find('#result');
				//var responseObj=jQuery.parseJSON(response);	
				//var results=responseObj.ResponseData; 
				//$scope.ir=results;
				//$scope.filemessage();
				
				var ab=$("#preview").html();
				var rc=ab.split('|');
				var re={"status":rc[0],"message":rc[1]};
				alert(rc[1]);
				$scope.$apply(function(){
					$scope.get_folders();
				});
				
				//Data.toast($("#preview").html());
				//$("#file").val("");
				
			},
			error:function(){
				alert("Error");
			}
		}).submit(); 
	
		 /* Data.post('filequee', {
            file: {parent:$scope.curentfolder,file:fd}
        }).then(function (results) {
            //Data.toast(results);
			alert(results);
            if (results.status == "success") {
				
            }
        });  */
		
        //fileUpload.uploadFileToUrl(file, uploadUrl);
    };
	
	
	$scope.new_file=function(){
		angular.element('#file').trigger('click');
		//document.getElementById('file').click();
		//$("#file").click();
		//$scope.file.clicked=true;
	};
	$scope.newfolder=function(){
		var a = prompt("Give your folder name.. (Folder will create under "+$scope.curentfolder+")","New Folder");
		$scope.ffsign = {parent:$scope.curentfolder,foldername:a};
		Data.post('foldersign', {folder: $scope.ffsign}).then(function (results) {Data.toast(results); $scope.get_folders();});
	};
	$scope.download=function(v){
		/* Data.post('download', {downloader:{path:v}}).then(function (results) {
			
			 var blob = new Blob([results], {
				type: "text/text"
			});
			alert(results); */
			
			/*  var objectUrl = URL.createObjectURL(blob);
			objectUrl.download = "ds.text"; */
			
			//var url  = URL.createObjectURL(blob);
			//alert("update download link:");
			// var a = document.createElement('a');
			
			/* var a = link;
			a.download    = "sx" + ".pdf";
			a.href        = url; */
			$scope.startfacedown(v);
			//$scope.capme = "true";
			//window.open('http://facecloud.us/download/Auth?q='+v); 
			
			//Data.toast(results); $scope.get_folders();
		/* }); */
	};
	
	/* $scope.isselect=function(x){
		x.selected = !x.selected;
		x.selected = !x.selected;
	}; */
	$scope.deletefilefolder=function(){
		var dc=$scope.selecteditems;
		try{
			if(dc==null||dc.length==0){
				alert("Select files/folders to delete");
			}
			else{
			//if(c.length > 0){
				var a = confirm("Sure !, Do you want to delete!");
				if(a==true){
					Data.post('deletesign', {list: $scope.selecteditems}).then(function (results) {Data.toast(results); $scope.get_folders();});
				}
			//}else{
				
			}
		}catch(error){
			alert("Select files/folders to delete");
		}
	};
	
	$scope.selecteditems=[];
	$scope.selectType = function(opt){
		opt.selected = !opt.selected;
		if(opt.selected){ $scope.selecteditems.push(opt.link); }else{ var index = $scope.selecteditems.indexOf(opt.link); $scope.selecteditems.splice(index, 1);  }
	};
	$scope.type = {
      options: [{name:'Fax', selected:true},{name:'Physical', selected:false}, {name:'Digital', selected:false}],
    };
	
	
	$scope.vlink="";
	/* Face capture download starts here */
	$scope.face="";
	$scope.signinface = {face:"s",uid:"12"};
	$scope.startfacedown = function(v){
		$scope.vlink = v;
		$scope.capme = "true";
		$scope.scanmode = "false";
			//window.open('http://facecloud.us/download/Auth?q='+v); 
		navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

		navigator.getMedia({video: true}, function() {
		  // webcam is available
		 // navigator.getMedia({video: false}, function() {},function(){});
		  $scope.captureimg();
		}, function() {
		  // webcam is not available
			alert("webcam is not available.\n  please wait... \n We are redirecting you to dashboard");
			$scope.capme = "false";
		});
		
	};
	$scope.perce=0;
    $scope.incr = function(x){
		var ac=parseInt(x);
		$scope.perce=ac+"%";
		ac++;
		$timeout(function(){
			var cme=parseInt($scope.scorefor);
			if(ac>29){ $scope.ccolor="green"; }else{
				//$scope.ccolor="red";
			}
			if(ac<cme){
				$scope.incr(ac);
				
			}else{
				if(ac>29){
					if($scope.vlink!=""){
						window.open('http://www.facecloud.us/download/Auth?q='+$scope.vlink); 
						$scope.canceldown();
					}
				}else{
					alert("Failed!");
					$scope.canceldown();
				}
				//$location.path("/files/Auth");
			}
		},100);
	};
	$scope.randomepic = function(){
		var myArray = ['23', '68', '47', '93', '5', '34', '81', '14'];  
		var rand = myArray[Math.floor(Math.random() * myArray.length)];
		return rand;
	};
	
	$scope.signInFaceScan = function(){
		var abc = document.getElementById("capturedata").value;
		if(abc==null){
			alert("Capture Again");
		}
		if(abc!=""){
			var bf=$scope.randomepic();
			$scope.scorefor=parseInt(bf);
			
			$scope.incr(1);
			$scope.scanmode = "true";
			
		}else{
			alert("Photo not captured.");
			$scope.scanmode = "false";
		}
	};
	
	$scope.canceldown = function(){
		$scope.capme = "false";
		$scope.scanmode = "false";
		$scope.vlink="";
		$scope.perce=0;
		document.getElementById("capturedata").value="";
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
		//$scope.capme=false;
		$scope.scanmode = "true";
		
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
						$scope.signInFaceScan();
					  };
					  //imageObj.src = 's.jpg';
					  imageObj.src = imgh;
					  
					
				}
			}
		});

		//alert("Move your mouse over the faces to see the face detection and tagging");
	}
	

});

app.controller('ModalInstanceCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $modal,items) {
	$scope.items = items;
  $scope.selected = {
    item: $scope.items[0]
  };

  $scope.ok = function () {
    $modalInstance.close($scope.selected.item);
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
});