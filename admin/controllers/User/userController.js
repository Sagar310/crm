
app.controller("userLoginController",function($scope,$http,dataService){
    
    var ulc = this;

    ulc.userLg = {};
    ulc.userLg.action = "userLogin";
    ulc.userLg.email ="";
    ulc.userLg.pass = "";

    ulc.operation = {};
    ulc.operation.complete = false;
    ulc.operation.error = false;
    ulc.operation.msg = "";
    
    ulc.userLogin = function()
    {
        var response = dataService.httpCall(ulc.userLg,"admin/Models/Users/usersDA.php");
        response.then(function(result){            
            console.log(angular.toJson(result));

            var data = result.data;
            ulc.operation.complete = true;
            ulc.operation.error = data.error;
            ulc.operation.msg = data.msg;
            
        },
        function(result){
                alert(angular.toJson(result));
        });        
    }
});