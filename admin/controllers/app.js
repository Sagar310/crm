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
        templateUrl : "views/customer/newCustomer.html",
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
    .when("/updateCustomer/:custid", {
        templateUrl : "views/customer/updateCustomer.html",
        controller: "updateCustController",
        controllerAs: "ucc",
        cache: false
    }) 
    .when("/deleteCustomer/:custid",{
        templateUrl: "views/customer/deleteCustomer.html",
        controller: "deleteCustController",
        controllerAs : "dcc",
        cache: false
    })
    .otherwise({ redirectTo: '/' });         

});