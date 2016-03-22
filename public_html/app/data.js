app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = 'api/v1/';

        var obj = {};
        obj.toast = function (data) {
            toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
        }
        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };
        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };
		
		

        return obj;
}]);


app.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

app.service('fileUpload', ['$http', function ($http,Data) {
    this.uploadFileToUrl = function(file, uploadUrl,parent){
        /* var fd = new FormData();
        fd.append('file', file); */
		var serviceBase = 'api/v1/';
		
		
		
		var fd = new FormData();
        fd.append('file', file);
        fd.append('text', parent);
		$http.defaults.headers.post["Content-Type"] =  "application/x-www-form-urlencoded; charset=UTF-8;";
        $http.post(serviceBase+uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type':  "application/x-www-form-urlencoded; charset=UTF-8;"}
        })
        .success(function(results){
			alert(results);
			//Data.toast(results);
        })
        .error(function(results){
			//Data.toast(results);
        });  
    }
}]);





