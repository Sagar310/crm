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
            case "newUser":
                $msg=newUser($request);
                break;
            case "userLogin":
                $msg=userLogin($request);
                break;
            case "changePass":
                $msg=changePass($request);
                break;
            case "getResetQ":
                $msg=getResetQ($request);
                break;              
            case "resetPassword":
                $msg=resetPassword($request);
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

    function resetPassword($request)
    {
        $email = fetchData($request,"email");
        $resetAns = fetchData($request,"resetAns");

        if($email == NULL || $resetAns == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new User();
            $obj->email = $email;
            $obj->resetAns = $resetAns;
            $msg = $obj->resetPassword();
        }
        return $msg;
    }

    function getResetQ($request)
    {
        $email = fetchData($request,"email");
        if($email == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new User();
            $obj->email = $email;
            $msg = $obj->getResetQ();
        }
        return $msg;
    }

    function changePass($request)
    {
        $email = fetchData($request,"email");
        $cpass = fetchData($request,"cpass");
        $npass = fetchData($request,"npass");
        if($email == NULL || $cpass == NULL || $npass == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new User();
            $obj->email = $email;
            $obj->cpass = $cpass;
            $obj->npass = $npass;
            $msg = $obj->changePassword();
        }
        return $msg;
    }

    function userLogin($request)
    {
        $email = fetchData($request,"email");
        $pass = fetchData($request,"pass");
        if($email == NULL || $pass == NULL)
            $msg = RANS();
        else  
        {
            $obj = new User();
            $obj->email = $email;
            $obj->pass = $pass;
            $msg = $obj->userLogin();
        }
        return $msg;
    }


    function deleteUser($request)
    {
        $msg = "";
        $mmsgArr = array();
        $userid = fetchData($request,"userid");


        if($bldg_id == NULL)
        {
            RANS();          
        }
        else
        {
            $obj = new User();   
            $obj->userid = $userid;               
            $msg = $obj->deleteUser();
        }
        return $msg;        
    }    

    function updateUser($request)
    {
        $msg = "";        
        $userid =  fetchData($request,"userid");
        $email = fetchData($request,"email");
        $pass = fetchData($request,"pass");
        $resetQ = fetchData($request,"resetQ");
        $resetAns = fetchData($request,"resetAns");
        

        if($userid == NULL || $email == NULL || $pass == NULL || $resetQ == NULL || $resetAns == NULL)
        { 
            return RANS();         
        }
        else
        {
            $obj = new User();   
            $obj->userid = $userid;
            $obj->email = $email;         
            $obj->pass = $pass;         
            $obj->resetQ = $resetQ;         
            $obj->resetAns = $resetAns;               
            $msg = $obj->saveUser();
        }
        return $msg;        
    }
        
    function getUserById($request)
    {
        $msg="";
        $msgArr = array();
        $userid = fetchData($request,"userid");
        if($userid==NULL)
        {
            RANS();         
        }
        else
        {
            $obj = new Member();            
            $msg = $obj->getUser("*","userid=".$userid,"","");
        }
        return $msg;

    }

    function newUser($request){

        $msg="";
        $email = fetchData($request,"email");
        $pass = fetchData($request,"pass");
        $resetQ = fetchData($request,"resetQ");
        $resetAns = fetchData($request,"resetAnd");
        
        if($email == NULL || $pass  == NULL || $resetQ  == NULL || $resetAns  == NULL)
        {
            RANS();
        }
        else
        {
            $obj=new User();
            $obj->email =  $email;
            $obj->pass =  $pass;
            $obj->resetQ =  $resetAns;
            $msg=$obj->newUser();
        }
        return $msg;
    }

    function getAllUsers()
    {
        $obj = new User();
        $msg = $obj->getUser("*","","","");
        return $msg;    
    }

 