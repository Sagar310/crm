<?php
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $request=json_decode(file_get_contents("php://input"),true);
    
    class CustomerDAO{
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
            $msg = "";
            switch($this->action)
            {
                    case "getAllCustomers":
                        $msg=$this->getAllCustomers();
                        break;
                    case "getCustomerById":
                        $msg=$this->getCustomerById();
                        break;
                    case "newCustomer":
                        $msg=$this->newCustomer();
                        break;
                    case "saveCustomer":
                        $msg=$this->saveCustomer();
                        break;
                    case "deleteCustomer":
                        $msg=$this->deleteCustomer();
                        break;
                    case "getDisplayPic":
                        $msg=$this->getDisplayPic();
                        break;                                              
                    default :
                        $msg="Invalid action.";
                        break;                   
            }   
            return $msg;         
        }      

        public function deleteCustomer()
        {
            $msg = "";
            $mmsgArr = array();
            $custid = fetchData("custid");
    
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
        
        public function newCustomer()
        {
            $msg="";
            $lastName = fetchData("lastName");
            $firstName = fetchData("firstName");
            $gender = fetchData("gender");
            $cellNo = fetchData("cellNo");
            $email = fetchData("email");
            $birthDate = fetchData("birthDate");
            $wedAniv = fetchData("wedAniv");
            $disPic = fetchData("disPic");
            $createdBy = fetchData("createdBy");
            
            
            if($lastName == NULL || $firstName  == NULL || $gender  == NULL || $cellNo  == NULL || $email  == NULL || $birthDate  == NULL || $disPic  == NULL || $createdBy  == NULL )
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
                
                $msg=$obj->newCustomer();
            }
            return $msg;
        }    
    
        public function saveCustomer()
        {
            $msg="";
            $custid = fetchData("custid");
            $lastName = fetchData("lastName");
            $firstName = fetchData("firstName");
            $gender = fetchData("gender");
            $cellNo = fetchData("cellNo");
            $email = fetchData("email");
            $birthDate = fetchData("birthDate");
            $wedAniv = fetchData("wedAniv");
            $disPic = fetchData("disPic");        
            $modifiedBy = fetchData("modifiedBy");
            if($custid == NULL || $lastName == NULL || $firstName  == NULL || $gender  == NULL || $cellNo  == NULL || $email  == NULL || $birthDate  == NULL || $disPic  == NULL || $modifiedBy  == NULL)
            {
                $msg = RANS();
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
                $obj->modifiedBy =  $modifiedBy;
                $msg=$obj->saveCustomer();
            }
            return $msg;
        }
            
        public function getCustomerById($request)
        {
            $msg="";
            $msgArr = array();
            $custid = fetchData("custid");
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
    
        public function getAllCustomers()
        {
            $obj = new Customer();
            $msg = $obj->getCustomer("*","","","");
            return $msg;    
        }
    
        public function getDisplayPic()
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
        
    }    
  
    $obj = new CustomerDAO();
    $msg = $obj->processAction();
    echo $msg;