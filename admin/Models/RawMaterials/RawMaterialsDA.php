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
                    case "getAllRawMaterials":
                        $msg=$this->getAllRawMaterials();
                        break;
                    case "getRawMaterialById":
                        $msg=$this->getRawMaterialById();
                        break;
                    case "newRawMaterial":
                        $msg=$this->newRawMaterial();
                        break;
                    case "saveRawMaterial":
                        $msg=$this->saveRawMaterial();
                        break;
                    case "deleteRawMaterial":
                        $msg=$this->deleteRawMaterial();
                        break;                                             
                    default :
                        $msg="Invalid action.";
                        break;                   
            }
            return $msg;            
        }

        public function getAllRawMaterials()
        {
            $obj = new RawMaterial();
            $msg = $obj->getRawMaterial("*","","","");
            return $msg;    
        }  

        function getRawMaterialById()
        {
            $msg="";
            $msgArr = array();
            $rmaterialId = $this->fetchData("rmaterialId");
            if($rmaterialId==NULL)
            {
                $msg = $this->RANS();         
            }
            else
            {
                $obj = new RawMaterial();            
                $msg = $obj->getRawMaterial("*","rmaterialId=".$rmaterialId,"","");
            }
            return $msg;
        }        

        public function newRawMaterial()
        {
            $msg="";
            $rmaterialName = $this->fetchData("rmaterialName");
            $createdBy = $this->fetchData("createdBy");
                        
            if($rmaterialName == NULL || $createdBy  == NULL )
            {
                $msg = $this->RANS();
            }
            else
            {
                $obj=new RawMaterial();
                $obj->rmaterialName =  $rmaterialName;
                $obj->createdBy =  $createdBy;            
                $msg=$obj->newRawMaterial();
            }
            return $msg;
        }            
        
        public function saveRawMaterial()
        {
            $msg="";
            $rmaterialId = $this->fetchData("rmaterialId");
            $rmaterialName = $this->fetchData("rmaterialName");  
            $modifiedBy = $this->fetchData("modifiedBy");
            if($rmaterialId == NULL || $rmaterialName == NULL || $modifiedBy  == NULL)
            {
                $msg = $this->RANS();
            }
            else
            {
                $obj=new RawMaterial();
                $obj->rmaterialId =  $rmaterialId;
                $obj->rmaterialName =  $rmaterialName;         
                $obj->modifiedBy =  $modifiedBy;
                $msg=$obj->saveRawMaterial();
            }
            return $msg;
        }      
        
        public function deleteRawMaterial()
        {
            $msg = "";            
            $rmaterialId = $this->fetchData("rmaterialId");
    
            if($rmaterialId == NULL)
            {
                $msg = $this->RANS();          
            }
            else
            {
                $obj = new RawMaterial();   
                $obj->rmaterialId = $rmaterialId;               
                $msg = $obj->deleteRawMaterial();
            }
            return $msg;        
        }        
        

    }

    $obj = new RawMaterialDAO();
    $msg = $obj->processAction();
    echo $msg;








 