<?php
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $request=json_decode(file_get_contents("php://input"),true);
    
    
    $action=null;
    if(isset($request["action"]))
        $action=$request["action"];
    $msg="";   
    
    switch($action)
    {
            case "getAllCustomers":
                $msg=getAllCustomers();
                break;
            case "getCustomerById":
                $msg=getCustomerById($request);
                break;
            case "newCustomer":
                $msg=newCustomer($request);
                break;
            case "saveCustomer":
                $msg=saveCustomer($request);
                break;
            case "deleteCustomer":
                $msg=deleteCustomer($request);
                break;
            case "getDisplayPic":
                $msg=getDisplayPic();
                break;                                              
            default :
                $msg="Invalid action.";
                break;                   
    }
    
    echo $msg;

    function RANS()
    {
        $msgArr["error"]=TRUE;
        $msgArr["msg"]="Required attribute(s) not set.";
        return json_encode($msgArr);          
    }

    function fetchData($request,$var){
            if(isset($request[$var]))
                return $request[$var];
            else
                return NULL;   
    }

    function deleteCustomer($request)
    {
        $msg = "";
        $mmsgArr = array();
        $custid = fetchData($request,"custid");

        if($custid == NULL)
        {
            RANS();          
        }
        else
        {
            $obj = new Customer();   
            $obj->custid = $custid;               
            $msg = $obj->deleteCustomer();
        }
        return $msg;        
    }
    
    function newCustomer($request)
    {
        $msg="";
        $lastName = fetchData($request,"lastName");
        $firstName = fetchData($request,"firstName");
        $gender = fetchData($request,"gender");
        $cellNo = fetchData($request,"cellNo");
        $email = fetchData($request,"email");
        $birthDate = fetchData($request,"birthDate");
        $wedAniv = fetchData($request,"wedAniv");
        $disPic = fetchData($request,"disPic");
        $createdBy = fetchData($request,"createdBy");
        //$modifiedBy = fetchData($request,"modifiedBy");
        
        if($lastName == NULL || $firstName  == NULL || $gender  == NULL || $cellNo  == NULL || $email  == NULL || $birthDate  == NULL || $wedAniv  == NULL || $disPic  == NULL || $createdBy  == NULL || $modifiedBy  == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj=new Customer();
            $obj->lastName =  $lastName;
            $obj->firstName =  $firstName;
            $obj->gender =  $gender;
            $obj->cellNo =  $cellNo;
            $obj->email =  $email;
            $obj->birthDate =  $birthDate;
            $obj->wedAniv =  $wedAniv;
            $obj->disPic =  $disPic;
            $obj->createdBy =  $createdBy;
            $obj->modifiedBy =  $modifiedBy;
            $msg=$obj->newCustomer();
        }
        return $msg;
    }    

    function saveCustomer($request)
    {
        $msg="";
        $custid = fetchData($request,"custid");
        $lastName = fetchData($request,"lastName");
        $firstName = fetchData($request,"firstName");
        $gender = fetchData($request,"gender");
        $cellNo = fetchData($request,"cellNo");
        $email = fetchData($request,"email");
        $birthDate = fetchData($request,"birthDate");
        $wedAniv = fetchData($request,"wedAniv");
        $disPic = fetchData($request,"disPic");
        $createdBy = fetchData($request,"createdBy");
        $modifiedBy = fetchData($request,"modifiedBy");
        
        if($custid == NULL || $lastName == NULL || $firstName  == NULL || $gender  == NULL || $cellNo  == NULL || $email  == NULL || $birthDate  == NULL || $wedAniv  == NULL || $disPic  == NULL || $createdBy  == NULL || $modifiedBy  == NULL)
        {
            RANS();
        }
        else
        {
            $obj=new Customer();
            $obj->custid =  $custid;
            $obj->lastName =  $lastName;
            $obj->firstName =  $firstName;
            $obj->gender =  $gender;
            $obj->cellNo =  $cellNo;
            $obj->email =  $email;
            $obj->birthDate =  $birthDate;
            $obj->wedAniv =  $wedAniv;
            $obj->disPic =  $disPic;
            $obj->createdBy =  $createdBy;
            $obj->modifiedBy =  $modifiedBy;
            $msg=$obj->saveCustomer();
        }
        return $msg;
    }
        
    function getCustomerById($request)
    {
        $msg="";
        $msgArr = array();
        $custid = fetchData($request,"custid");
        if($custid==NULL)
        {
            RANS();         
        }
        else
        {
            $obj = new Customer();            
            $msg = $obj->getCustomer("*","custid=".$custid,"","");
        }
        return $msg;

    }

    function getAllCustomers()
    {
        $obj = new Customer();
        $msg = $obj->getCustomer("*","","","");
        return $msg;    
    }

    function getDisplayPic()
    {
        $dir = "../../assets/images/customers/";
        $files = glob($dir."*.{jpg,png}", GLOB_BRACE);
        for($i=0;$i<count($files);$i++) 
        {
            $arr = explode("/",$files[$i]);  
            $c = count($arr);          
            $files[$i] = $arr[$c-1];
        } 
        $msg = json_encode($files);
        return $msg;  
    }

 