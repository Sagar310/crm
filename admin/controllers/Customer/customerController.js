app.controller("newCustController",function($scope,$http,dataService){
        
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

    ncc.disPics = [];

    ncc.showPicDialog = 0;

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

    ncc.init = function(){
       ncc.initDatePicker();
       ncc.getDisPics();
    };

    ncc.init();
});