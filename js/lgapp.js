var app = angular.module("lgApp", ["ngRoute","ngMessages"]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "admin/views/user/login.html",
        controller: "userLoginController", 
        controllerAs: "ulc",
        cache: false        

    })
    .when("/forgotpass",{
        templateUrl : "admin/views/user/forgotpass.html",
        controller: "forgotPassController", 
        controllerAs: "fpc",
        cache: false         
    })
    .otherwise({ redirectTo: '/' });                    
});  