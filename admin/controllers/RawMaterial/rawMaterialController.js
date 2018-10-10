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