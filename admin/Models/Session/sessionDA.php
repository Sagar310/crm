<?php

function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $request=json_decode(file_get_contents("php://input"),true);
    
    
    class SessionDAO{
        private $request;
        private $action;

        public function __construct(){
            $this->request = json_decode(file_get_contents("php://input"),true);
            $this->action = $this->request["action"];
        }

        public function RANS()
        {
            $msgArr["error"]=TRUE;
            $msgArr["msg"]="Required attribute(s) not set.";
            return json_encode($msgArr);          
        }
    
        public function fetchData($var){
            if(isset($this->request[$var]))
                return $this->request[$var];
            else
                return NULL;   
        }    
        public function processAction()
        {
            $msg="";   
            switch($action)
            {
                    case "newKey":
                        $msg=$this->newKey();
                        break;
                    case "getKeyValue":
                        $msg=$this->getKeyValue();
                        break;
                    case "updateKey":
                        $msg=$this->updateKey();
                        break;
                    case "destroyKey":
                        $msg=$this->destroyKey();
                        break;                 
                    default :
                        $msg="Invalid action.";
                        break;                   
            }            
            return $msg;
        }

        public function newKey()
        {
            $msg = "";
            $key = fetchData("key");
            $val = fetchData("val");
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
    
        public function getKeyValue()
        {
            $msg = "";
            $key = fetchData("key");
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
    
        public function updateKey()
        {
            $msg = "";
            $key = fetchData("key");
            $val = fetchData("val");
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
    
        public function destroyKey()
        {
            $msg = "";
            $key = fetchData("key");
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
    
    }
   
    
  