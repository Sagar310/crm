app.service("sessionService", function($http){

    this.newKey = function(key,val){
        var data = {};
        data.action = "newKey";
        data.key = key;
        data.val = val;
        var response = $http.post("Models/Session/sessionDA.php",data);
        return response;
    };

    this.getKeyValue = function(key){
        var data = {};
        data.action= "getKeyValue";
        data.key = key;
        var response = $http.post("Models/Session/sessionDA.php",data);
        return response;        
    };

    this.updateKey = function(key, val){
        var data = {};
        data.action = "updateKey";
        data.key = key;
        data.val = val;
        var response = $http.post("Models/Session/sessionDA.php",data);
        return response;        
    };

    this.destroyKey = function(key){
        var data = {};
        data.action= "destroyKey";
        data.key = key;
        var response = $http.post("Models/Session/sessionDA.php",data);
        return response;        
    };    
});