app.controller('fileCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,fileUpload) {
    //initially set those objects to null to avoid undefined error
    //data
	$scope.auth="sdfg sdhgfs";
	$scope.explorer=[];
	$scope.curentfolder="";
	
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

			window.open('http://site1.facecloud.us/download/Auth?q='+v); 
			
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