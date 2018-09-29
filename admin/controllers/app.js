var app = angular.module("lgApp", ["ngRoute"]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "admin/views/user/login.html",
        controller: "userLoginController",
        controllerAs: "ulc",
        cache: false
    })
    .otherwise({ redirectTo: '/' });         

});