app.controller("newCustController",function($scope,$http,dataService,sessionService){
        
    var ncc = this;
    ncc.newcust = {};
    ncc.newcust.lastName = "";
    ncc.newcust.firstName = "";
    ncc.newcust.gender = "";
    ncc.newcust.cellNo = "";
    ncc.newcust.email = "";
    ncc.newcust.birthDate = "";
    ncc.newcust.wedAniv = "";
    ncc.newcust.disPic = "";
    ncc.newcust.createdBy = "";
    ncc.newcust.action = "newCustomer";

    ncc.opr ={};
    ncc.opr.complete = false;
    ncc.opr.error = false;
    ncc.opr.msg = "";

    ncc.disPics = [];

    ncc.showPicDialog = 0;

    ncc.getCurrentUser = function()
    {
        var response = sessionService.getKeyValue("lguser");
        response.then(function(result){            
            //console.log(angular.toJson(result))        
            ncc.newcust.createdBy = result.data.data;
            
       },
       function(result){
               alert(angular.toJson(result));
       });           
    };

    ncc.showSelPicDialog =function(){
        ncc.showPicDialog = 1;
    }

    ncc.selectDisPic = function(pic)
    {        
        ncc.newcust.disPic = pic;
        ncc.showPicDialog = 0;
    };


    ncc.initDatePicker = function(){
        var date_input1=$('.dpic'); //our date input has the name "date"
        var container1=$('#newcustForm').length>0 ? $('#newcustForm').parent() : "body";
        date_input1.datepicker({
            format: 'dd/mm/yyyy',
            container: container1,
            todayHighlight: true,
            autoclose: true,
        });  
       

    };

    ncc.getDisPics = function(){
        var data = {};
        data.action="getDisplayPic";
        var response = dataService.httpCall(data,"Models/Customers/customersDA.php");
        response.then(function(result){            
             //console.log(angular.toJson(result));

            ncc.disPics = angular.fromJson(result.data);
            //console.log(ncc.disPic);
            

            
        },
        function(result){
                alert(angular.toJson(result));
        });          
    };

    ncc.newCustomer = function(){        
        //console.log(ncc.newcust);
        var response = dataService.httpCall(ncc.newcust,"Models/Customers/customersDA.php");
        response.then(function(result){            
            console.log(angular.toJson(result));
            ncc.opr.complete = true;
            ncc.opr.error = result.data.error;
            ncc.opr.msg = result.data.msg;      
       },
       function(result){
               alert(angular.toJson(result));
       });          
    };


    ncc.init = function(){
        ncc.getCurrentUser();
        ncc.initDatePicker();
        ncc.getDisPics();
    };

    ncc.init();
});

app.controller("custListController",function($http,dataService){

    var clc = this;
    clc.custList = [];

    clc.getCustomers = function()
    {
        var data ={};
        data.action="getAllCustomers";
        var response = dataService.httpCall(data,"Models/Customers/customersDA.php");
        response.then(function(result){            
             //console.log(angular.toJson(result));

            clc.custList = angular.fromJson(result.data.data);
            //console.log(clc.custList);
            

            
        },
        function(result){
                alert(angular.toJson(result));
        });         
    };

    clc.init = function(){
        clc.getCustomers();
    };

    clc.init();

});

app.controller("updateCustController",function($http,$routeParams,dataService,sessionService){

    var ucc = this;
    ucc.customer2Fetch = {};
    ucc.customer2Fetch.custid = $routeParams.custid;
    ucc.customer2Fetch.action = "getCustomerById";

    ucc.customer2Update = {};
    ucc.disPic =[];
    ucc.showPicDialog = 0;
    ucc.opr = {};
    ucc.opr.complete = false;
    ucc.opr.error = false;
    ucc.opr.msg = "";

    ucc.getCustomer = function(){
        var response = dataService.httpCall(ucc.customer2Fetch,"Models/Customers/customersDA.php");
        response.then(function(result){            
             //console.log(angular.toJson(result));

            if(!result.data.error){
                //console.log(ucc.customer2Fetch);
                ucc.customer2Fetch = angular.fromJson(result.data.data)[0];                
                ucc.customer2Update = angular.copy(ucc.customer2Fetch);           
                ucc.getCurrentUser();     
            }
             
            
            

            
        },
        function(result){
                alert(angular.toJson(result));
        });         
    };

    ucc.getCurrentUser = function()
    {
        var response = sessionService.getKeyValue("lguser");
        response.then(function(result){            
            //console.log(angular.toJson(result))        
            ucc.customer2Update.modifiedBy = result.data.data;
            //console.log(ucc.customer2Update.modifiedBy);
            //alert(angular.toJson(ucc.customer2Update));
            
            
       },
       function(result){
               alert(angular.toJson(result));
       });           
    };

    ucc.getDisPics = function(){
        var data = {};
        data.action="getDisplayPic";
        var response = dataService.httpCall(data,"Models/Customers/customersDA.php");
        response.then(function(result){            
             //console.log(angular.toJson(result));
            ucc.disPics = angular.fromJson(result.data);
            //console.log(ncc.disPic);
        },
        function(result){
            alert(angular.toJson(result));
        });          
    };    

    ucc.showSelPicDialog =function(){
        ucc.showPicDialog = 1;
    }

    ucc.selectDisPic = function(pic)
    {        
        ucc.customer2Update.disPic = pic;
        ucc.showPicDialog = 0;
    };

    ucc.initDatePicker = function(){
        var date_input1=$('.dpic'); //our date input has the name "date"
        var container1=$('#newcustForm').length>0 ? $('#newcustForm').parent() : "body";
        date_input1.datepicker({
            format: 'dd/mm/yyyy',
            container: container1,
            todayHighlight: true,
            autoclose: true,
        });         
    };

    ucc.dataChanged = function(){

        var changed = false;
        if(ucc.customer2Fetch.lastName != ucc.customer2Update.lastName)
        {
            changed = true;
        }
        if(ucc.customer2Fetch.firstName != ucc.customer2Update.firstName)
        {
            changed = true;
        }  
        if(ucc.customer2Fetch.gender != ucc.customer2Update.gender)
        {
            changed = true;
        } 
        if(ucc.customer2Fetch.cellNo != ucc.customer2Update.cellNo)
        {
            changed = true;
        }      
        if(ucc.customer2Fetch.email != ucc.customer2Update.email)
        {
            changed = true;
        } 
        if(ucc.customer2Fetch.birthDate != ucc.customer2Update.birthDate)
        {
            changed = true;
        }  
        if(ucc.customer2Fetch.wedAniv != ucc.customer2Update.wedAniv)
        {
            changed = true;
        }      
        if(ucc.customer2Fetch.disPic != ucc.customer2Update.disPic)
        {
            changed = true;
        }
        return changed;                                                    

    };

    ucc.saveCustomer = function(){

        ucc.customer2Update.action = "saveCustomer";
        alert(angular.toJson(ucc.customer2Update));
        
        var response = dataService.httpCall(ucc.customer2Update,"Models/Customers/customersDA.php");
        response.then(function(result){            
            console.log(angular.toJson(result));
            ucc.opr.complete = true;
            ucc.opr.error = result.data.error;
            ucc.opr.msg = result.data.msg;
                   
        },
        function(result){
                alert(angular.toJson(result));
        });         
    
    }

    ucc.init = function(){
        ucc.getCustomer();        
        ucc.getDisPics();
        ucc.initDatePicker();
    };

    ucc.init();
});

app.controller("deleteCustController",function($routeParams,dataService,sessionService){

    var dcc = this;
    dcc.customer2Delete = {};
    dcc.customer2Delete.custid = $routeParams.custid;
    dcc.customer2Delete.action = "getCustomerById"

    dcc.opr = {};
    dcc.opr.complete = false;
    dcc.opr.error = false;
    dcc.opr.msg = "";

    dcc.getCustomer = function(){
        var response = dataService.httpCall(dcc.customer2Delete,"Models/Customers/customersDA.php");
        response.then(function(result){            
             //console.log(angular.toJson(result));

            if(!result.data.error){
                //console.log(ucc.customer2Fetch);
                dcc.customer2Delete = angular.fromJson(result.data.data)[0];                
                       
                //dcc.getCurrentUser();     
            }                                     
        },
        function(result){
                alert(angular.toJson(result));
        });         
    };

    dcc.deleteCustomer = function(){
        dcc.customer2Delete.action="deleteCustomer";
        var response = dataService.httpCall(dcc.customer2Delete,"Models/Customers/customersDA.php");
        response.then(function(result){            
            console.log(angular.toJson(result));
            dcc.opr.complete = true;
            dcc.opr.error = result.data.error;
            dcc.opr.msg = result.data.msg;
                                  
        },
        function(result){
                alert(angular.toJson(result));
        });          
    }

    
    dcc.init = function(){
        dcc.getCustomer();
    };

    dcc.init();
    
});