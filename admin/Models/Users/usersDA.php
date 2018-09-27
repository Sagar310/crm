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
                $msg=getAllUsers($request);
                break;              
            case "resetPass":
                $msg=getUserById($request);
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

    function changePass($request)
    {
        $email = fetchData($request,"email");
        $cpass = fetchData($request,"cpass");
        $npass = fetchData($request,"npass");
        if($email == NULL || $cpass == NULL || $npass == NULL)
        {
            return RANS();
        }
        else
        {
            $obj = new User();
            $cpass = $obj->encrypt($cpass);
            $npass = $obj->encrypt($npass);
            $where = sprintf(" email='%s' ",$email);
            $msg = $obj->getUser("*",$where,"","");
            $result=json_decode($msg,TRUE);
            $error = $result['error'] == true ? 1 : 0 ;
            if($error == 1)
            {
                $msgArr["error"] = TRUE;
                $msgArr["msg"] = $result['msg'];
                $msg = json_encode($msgArr);
            }
            else
            {
                $dbrow= json_decode($result["data"],TRUE);
                print_r($dbrow);
                $dbpass = $dbrow[0]["pass"];
                $resetQ = $dbrow[0]["resetQ"];
                $resetAns = $dbrow[0]["resetAns"];
                
                //echo "<br>".$dbpass."<br>";
                if($cpass == $dbpass)
                {
                    $obj->email = $email;
                    $obj->pass = $npass;
                    $obj->resetQ = addslashes($resetQ);
                    $obj->resetAns = addslashes($resetAns);
                    $msg = $obj->saveUser();
                    $result=json_decode($msg,TRUE);
                    $error = $result['error'] == true ? 1 : 0 ;
                    if($error == 1)
                    {
                        $msgArr["error"] = TRUE;
                        $msgArr["msg"] = $result['msg'];
                        $msg = json_encode($msgArr);
                    }
                    else
                    {
                        $msgArr["error"] = FALSE;
                        $msgArr["msg"] = "Password changed.";
                        $msg = json_encode($msgArr);                
                    }  
                }
                else
                {
                    $msgArr["error"]=TRUE;
                    $msgArr["msg"]= "Invalid credentials";
                    $msg = json_encode($msgArr);
                }                              
            }    
            return $msg;       
        }
    }

    function userLogin($request)
    {
        $email = fetchData($request,"email");
        $pass = fetchData($request,"pass");
        if($email == NULL || $pass == NULL)
            return RANS();
            
        $obj = new User();
        $pass = $obj->encrypt($pass);
        $where = sprintf(" email='%s'",$email);
        $msg = $obj->getUser("pass",$where,"","");        
        $result=json_decode($msg,TRUE);
        $error = $result['error'] == true ? 1 : 0 ;
        if($error == 1)
        {
            $msgArr["error"] = TRUE;
            $msgArr["msg"] = $result['msg'];
        }
        else
        {
            
            $dbpass= json_decode($result["data"],TRUE);
            $dbpass = $dbpass[0]["pass"];
            if($pass == $dbpass)
            {
                $msgArr["error"] = FALSE;
                $msgArr["msg"] = "Login successful.";
                session_start();
                $_SESSION["lguser"] = $email;
            }
            else
            {
                $msgArr["error"]=TRUE;
                $msgArr["msg"]= "Invalid credentials";
            }
        }
        $msg = json_encode($msgArr);
        return $msg;


    }

    function changePas($request)
    {

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

 