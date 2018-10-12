app.controller("newRMController",function(dataService,sessionService){

    var nrmc = this;

    nrmc.newRM = {};
    nrmc.newRM.rmaterialName = "";
    nrmc.newRM.createdBy = "";
    nrmc.newRM.action="newRawMaterial";

    nrmc.opr ={};
    nrmc.opr.complete = false;
    nrmc.opr.error = false;
    nrmc.opr.msg;
    
    nrmc.getCurrentUser = function()
    {
        
        var response = sessionService.getKeyValue("lguser");
        response.then(function(result){            
            //console.log(angular.toJson(result));        
            nrmc.newRM.createdBy = result.data.data;            
       },
       function(result){
               alert(angular.toJson(result));
       });           
    };    

    nrmc.newRawMaterial = function(){
        //console.log(nrmc.newRM);
        var response = dataService.httpCall(nrmc.newRM,"Models/RawMaterials/RawMaterialsDA.php");
        response.then(function(result){            
            //console.log(angular.toJson(result));
            nrmc.opr.complete = true;
            nrmc.opr.error = result.data.error;
            nrmc.opr.msg = result.data.msg;      
       },
       function(result){
               alert(angular.toJson(result));
       });        
    };

    nrmc.init = function(){
        nrmc.getCurrentUser();
    }

    nrmc.init();

});

app.controller("rmListController",function(dataService){

    var rmlc = this;
    rmlc.rmaterials = [];

    rmlc.getAllRawMaterials = function(){

        var data = {};
        data.action = "getAllRawMaterials";
         
        var response = dataService.httpCall(data,"Models/RawMaterials/RawMaterialsDA.php");
        response.then(function(result){            
            //console.log(angular.toJson(result.data.data));
            rmlc.rmaterials = angular.fromJson(result.data.data);

    
       },
       function(result){
               alert(angular.toJson(result));
       });          

    };

    rmlc.init = function(){
        rmlc.getAllRawMaterials();
    };

    rmlc.init();

});

app.controller("updateRMController",function(dataService, sessionService, $routeParams,$timeout){

    var urmc = this;
    urmc.rMaterial2Fetch = {};
    urmc.rMaterial2Fetch.rmaterialId = $routeParams.rmaterialId;
    urmc.rMaterial2Fetch.action="getRawMaterialById";

    urmc.rMaterial2Update = {};

    urmc.opr = {};
    urmc.opr.complete = false;
    urmc.opr.error = false;
    urmc.opr.msg = "";

    urmc.getRawMaterialById = function(){        
        var response = dataService.httpCall(urmc.rMaterial2Fetch,"Models/RawMaterials/RawMaterialsDA.php");
        response.then(function(result){            
            //console.log(angular.toJson(result.data.data));
            urmc.rMaterial2Fetch = angular.fromJson(result.data.data)[0];
            //console.log(urmc.rMaterial2Fetch);
            urmc.rMaterial2Update = angular.copy(urmc.rMaterial2Fetch);
            urmc.getCurrentUser();
    
       },
       function(result){
               alert(angular.toJson(result));
       });          

    };

    urmc.saveRawMaterial = function(){
        urmc.rMaterial2Update.action="saveRawMaterial";
        var response = dataService.httpCall(urmc.rMaterial2Update,"Models/RawMaterials/RawMaterialsDA.php");
        response.then(function(result){
            //console.log(result);
            urmc.opr.complete = true;
            urmc.opr.error = result.data.error;
            urmc.opr.msg = result.data.msg;
            $timeout("urmc.opr.complete=false;",5000);
        }, 
        function (result){
            saveRawMaterial
        });
    };

    urmc.getCurrentUser = function()
    {
        
        var response = sessionService.getKeyValue("lguser");
        response.then(function(result){            
            //console.log(angular.toJson(result));                    
            urmc.rMaterial2Update.modifiedBy = result.data.data;
            //console.log(angular.toJson(urmc.rMaterial2Update));
                   
       },
       function(result){
               alert(angular.toJson(result));
       });           
    };    

    urmc.dataChanged = function(){
        if(urmc.rMaterial2Update.rmaterialName != urmc.rMaterial2Fetch.rmaterialName)
            return true;
        else
            return false;
    };

    urmc.init = function(){
        urmc.getRawMaterialById();
    };

    urmc.init();
});

app.controller("deleteRMController",function(dataService, sessionService,$routeParams ){

        var drmc = this;
        drmc.rMaterial2Delete = {};
        drmc.rMaterial2Delete.rmaterialId = $routeParams.rmaterialId;
        drmc.rMaterial2Delete.action = "getRawMaterialById";

        drmc.opr = {};
        drmc.opr.complete = false;
        drmc.opr.error = false;
        drmc.opr.msg = "";

        drmc.getRawMaterialById = function(){
            var response = dataService.httpCall(drmc.rMaterial2Delete,"Models/RawMaterials/RawMaterialsDA.php");
            response.then(function(result){            
                //console.log(angular.toJson(result));
                drmc.rMaterial2Delete = angular.fromJson(result.data.data)[0];
                //console.log(drmc.rMaterial2Delete);        
           },
           function(result){
                alert(angular.toJson(result));
           });          
        };

        drmc.deleteRawMaterial = function(){
            drmc.rMaterial2Delete.action="deleteRawMaterial";
            var response = dataService.httpCall(drmc.rMaterial2Delete,"Models/RawMaterials/RawMaterialsDA.php");
            response.then(function(result){            
                console.log(result);
                drmc.opr.complete = true;
                drmc.opr.error = result.data.error;
                drmc.opr.msg = result.data.msg;
           },
           function(result){
                alert(angular.toJson(result));
           });          
        };            
        

        drmc.init = function(){
            drmc.getRawMaterialById();
        };

        drmc.init();
});