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
    .when("/newRawMaterial",{
        templateUrl: "views/rawmaterial/new.html",
        controller: "newRMController",
        controllerAs : "nrmc",
        cache: false
    })
    .when("/RawMaterials",{
        templateUrl: "views/rawmaterial/list.html",
        controller: "rmListController",
        controllerAs : "rmlc",
        cache: false
    })   
    .when("/updateRawMaterial/:rmaterialId",{
        templateUrl: "views/rawmaterial/update.html",
        controller: "updateRMController",
        controllerAs: "urmc",
        cache: false
    }) 
    .when("/deleteRawMaterial/:rmaterialId",{
        templateUrl: "views/rawmaterial/delete.html",
        controller: "deleteRMController",
        controllerAs: "drmc",
        cache: false
    })     
    .otherwise({ redirectTo: '/' });         

});