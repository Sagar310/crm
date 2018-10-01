
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
           
            if(!data.error)
            {
                document.location.href = "admin/";
            }
            
        },
        function(result){
                alert(angular.toJson(result));
        });        
    };
});

app.controller("forgotPassController",function($scope,$http,dataService){
    
    var fpc = this;
    fpc.fetchRQ = {};
    fpc.fetchRQ.email="";
    fpc.fetchRQ.action="getResetQ";

    fpc.resetPass = {};
    fpc.resetPass.resetQ = "";
    fpc.resetPass.action="resetPassword";
    fpc.resetPass.npass  = "";

    fpc.tab = 0;


    fpc.isCurrentTab = function(n)
    {
        if(fpc.tab == n)
            return true;
        else
            return false;
    };

    fpc.setTab = function(n)
    {
        fpc.tab = n;
    };

    fpc.getResetQ = function()
    {
        var response = dataService.httpCall(fpc.fetchRQ,"admin/Models/Users/usersDA.php");
        response.then(function(result){            
            //console.log(angular.toJson(result));
            var data = angular.fromJson(result.data);
            if(!data.error)
            {
                data = angular.fromJson(data.data);
                fpc.resetPass.resetQ = data[0].resetQ;
                fpc.resetPass.email = fpc.fetchRQ.email;
                fpc.setTab(1);
            }
            else
                alert(data.msg);
            
        },
        function(result){
                alert(angular.toJson(result));
        });        
    };

    fpc.resetPassword = function()
    {
        var response = dataService.httpCall(fpc.resetPass,"admin/Models/Users/usersDA.php");
        response.then(function(result){
            console.log(result);
            if(!result.data.error)
            {
                fpc.resetPass.npass = angular.fromJson(result.data.data).pass;
                //console.log(fpc.resetPass.npass);
                fpc.setTab(2);
            }
        },
        function(result){
            alert(angular.toJson(result));
        });
    }
    

});