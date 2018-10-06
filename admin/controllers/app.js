var app = angular.module("crmApp", ["ngRoute","ngMessages"]);
app.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "views/dashboard.html",
        controller: "dashboardController",
        controllerAs: "dbc",
        cache: false
    })
    .when("/newcust", {
        templateUrl : "views/customer/new_customer.html",
        controller: "newCustController",
        controllerAs: "ncc",
        cache: false
    })    
    .when("/customers", {
        templateUrl : "views/customer/customers.html",
        controller: "custListController",
        controllerAs: "clc",
        cache: false
    })    
    .otherwise({ redirectTo: '/' });         

});