<?php
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }

    class RawMaterialDAO{
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
    
       
            switch($this->action)
            {
                        case "newUser":
                            $msg=$this->newUser();
                            break;
                        case "userLogin":
                            $msg=$this->userLogin();
                            break;
                        case "changePass":
                            $msg=$this->changePass();
                            break;
                        case "getResetQ":
                            $msg=$this->getResetQ();
                            break;              
                        case "resetPassword":
                            $msg=$this->resetPassword();
                            break;    
                        default :
                            $msg="Invalid action.";
                            break;                   
            }                  
            
            return $msg;            
        }  
        
        public function resetPassword($request)
        {
            $email = fetchData("email");
            $resetAns = fetchData("resetAns");
    
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
    
        public function getResetQ($request)
        {
            $email = fetchData("email");
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
    
        public function changePass($request)
        {
            $email = fetchData("email");
            $cpass = fetchData("cpass");
            $npass = fetchData("npass");
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
    
        public function userLogin($request)
        {
            $email = fetchData("email");
            $pass = fetchData("pass");
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
    
    
        public function deleteUser($request)
        {
            $msg = "";
            $mmsgArr = array();
            $userid = fetchData("userid");
    
            if($userid == NULL)
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
    
        public function updateUser($request)
        {
            $msg = "";        
            $userid =  fetchData("userid");
            $email = fetchData("email");
            $pass = fetchData("pass");
            $resetQ = fetchData("resetQ");
            $resetAns = fetchData("resetAns");
            
    
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
            
        public function getUserById()
        {
            $msg="";
            $msgArr = array();
            $userid = $this->fetchData("userid");
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
    
        public function newUser(){
    
            $msg="";
            $email = $this->fetchData("email");
            $pass = $this->fetchData("pass");
            $resetQ = $this->fetchData("resetQ");
            $resetAns = $this->fetchData("resetAnd");
            
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
    
        public function getAllUsers()
        {
            $obj = new User();
            $msg = $obj->getUser("*","","","");
            return $msg;    
        }
            
    }//class

    $obj = new UserDAO();
    $msg = $obj->processAction();
    echo $msg;    
 