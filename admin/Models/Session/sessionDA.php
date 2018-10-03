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
            case "newKey":
                $msg=newKey($request);
                break;
            case "getKeyValue":
                $msg=getKeyValue($request);
                break;
            case "updateKey":
                $msg=updateKey($request);
                break;
            case "destroyKey":
                $msg=destroyKey($request);
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

    function newKey($request)
    {
        $msg = "";
        $key = fetchData($request,"key");
        $val = fetchData($request,"val");
        if($key == NULL || $val == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new Session();
            $msg = $obj->newKey($key,$val);
        }
        return $msg;
    }

    function getKeyValue($request)
    {
        $msg = "";
        $key = fetchData($request,"key");
        if($key == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new Session();
            $msg = $obj->getKeyValue($key);
        }
        return $msg;        
    }

    function updateKey($request)
    {
        $msg = "";
        $key = fetchData($request,"key");
        $val = fetchData($request,"val");
        if($key == NULL || $val == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new Session();
            $msg = $obj->updateKey($key,$val);
        }
        return $msg;
    }

    function destroyKey($request)
    {
        $msg = "";
        $key = fetchData($request,"key");
        if($key == NULL)
        {
            $msg = RANS();
        }
        else
        {
            $obj = new Session();
            $msg = $obj->destroyKey($key);
        }
        return $msg;  
    }

?>