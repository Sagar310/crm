var app = angular.module("lgApp", ["ngRoute"]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "admin/views/user/login.html",
        controller: "userLoginController",
        controllerAs: "ulc",
        cache: false
    })
    .when("/newcust", {
        templateUrl : "admin/views/customer/new_customer.html",
        controller: "newCustController",
        controllerAs: "ncc",
        cache: false
    })    
    .otherwise({ redirectTo: '/' });         

});