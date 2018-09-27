app.service("dataService", function($http){

    this.httpCall = function(data,url){
            var response = $http.post(url,data);
            return response;
    };
});