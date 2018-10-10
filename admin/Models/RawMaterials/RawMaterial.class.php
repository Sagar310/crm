<?php
    class RawMaterial{
        private $dbArr;
        private $data=array();
        private $table;
        private $view;
        private $messages;

        public function __construct()
        {
            $this->dbArr=parse_ini_file("../db.ini");
            $this->table="tbl_rmaterials";
            $this->view = "";
            $this->messages=parse_ini_file("RawMaterial_msg.ini");
        }

        public function __set($property,$value)
        {
            if($property=="rmaterialId"||$property=="rmaterialName"||$property=="createdBy"||$property=="modifiedBy"||$property=="timeStamp")
                $this->data[$property]=$value;
        }
        
        
        public function __get($property)
        {
            if(array_key_exists($property,$this->data))
                return $this->data[$property];
            else
                return null;
        }

        public function generateResponse($error, $msg, $data)
        {
            $msgArr["error"]=$error;
            if($data)
                $msgArr["data"]=$msg;
            else
                $msgArr["msg"]=$msg;
            return json_encode($msgArr);
        }

        public function getRawMaterial($field_list="*",$where = "", $order = "", $limit="")
        {
            $query="select ".$field_list." from ".$this->table;
            if($where != "")
                $query.= " where ".$where." ";
            if($order!="")
                $query.=$order." ";
            if($limit!="")
                $query.=$limit."";
            return $query;
            try
            {
                $config = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);				
                $con = new PDO("mysql:host=".$this->dbArr['dbserver'].";dbname=".$this->dbArr['dbname']."", $this->dbArr['dbuser'], $this->dbArr['dbpass'], $config);	
                $stmt=$con->prepare($query);
                $stmt->execute();
                
                if($stmt->rowCount()>0)
                {
                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                    $msg=$this->generateResponse(FALSE,json_encode($result),TRUE);
                    return $msg;                
                }
                else
                {
                    $msg=$this->generateResponse(TRUE,$this->messages["error"],FALSE);
                    return $msg;                                
                }
            }
            catch(PDOException $e){
                $msg=$this->generateResponse(TRUE,$e->getMessage(),FALSE);
                return $msg;                 
            }
        }

        public function newRawMaterial()
        {
            
            $query = sprintf("INSERT INTO %s (rmaterialName,createdBy) VALUES ('%s','%s')",$this->table,$this->rmaterialName,$this->createdBy);            
            //return $query;
            try
            {
                $config = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);				
                $con = new PDO("mysql:host=".$this->dbArr['dbserver'].";dbname=".$this->dbArr['dbname']."", $this->dbArr['dbuser'], $this->dbArr['dbpass'], $config);	
                $stmt=$con->prepare($query);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {                    
                    $msg=$this->generateResponse(FALSE,$this->messages["insupd"],FALSE);
                    return $msg; 
                }
                else
                {
                    $msg=$this->generateResponse(TRUE,$stmt->errorInfo(),FALSE);
                    return $msg;            
                }
            }
            catch(PDOException $e){
                $msg=$this->generateResponse(TRUE,$e->getMessage(),FALSE);
                return $msg; 
            }            
        }

        public function saveRawMaterial()
        {            
            $query = sprintf("UPDATE %s SET rmaterialName='%s',modifiedBy='%s' WHERE rmaterialId = '%s'",$this->table,$this->rmaterialName,$this->modifiedBy,$this->rmaterialId);                                        
            return $query;
            try
            {
                $config = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);				
                $con = new PDO("mysql:host=".$this->dbArr['dbserver'].";dbname=".$this->dbArr['dbname']."", $this->dbArr['dbuser'], $this->dbArr['dbpass'], $config);	
                $stmt=$con->prepare($query);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {
                    $msg=$this->generateResponse(FALSE,$this->messages["insupd"],FALSE);
                    return $msg;
                }
                else
                {
                    $msg=$this->generateResponse(TRUE,$stmt->errorInfo(),FALSE);
                    return $msg; 
                }
            }
            catch(PDOException $e){
                $msg=$this->generateResponse(TRUE,$e->getMessage(),FALSE);
                return $msg; 
            }            
        }

        public function deleteRawMaterial()
        {
            $query=sprintf("DELETE FROM %s WHERE rmaterialId=%d",$this->table,$this->rmaterialId);
            //return $query;
            try
            {
                $config = array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);				
                $con = new PDO("mysql:host=".$this->dbArr['dbserver'].";dbname=".$this->dbArr['dbname']."", $this->dbArr['dbuser'], $this->dbArr['dbpass'], $config);	
                $stmt=$con->prepare($query);
                $stmt->execute();
                if($stmt->rowCount()>0)
                {                    
                    $msg=$this->generateResponse(FALSE,$this->messages["del"],FALSE);
                    return $msg;
                }
                else
                {
                    $msg=$this->generateResponse(TRUE,$stmt->errorInfo(),FALSE);
                    return $msg;
                }
            }
            catch(PDOException $e){
                $msg=$this->generateResponse(TRUE,$e->getMessage(),FALSE);
                return $msg;
            } 
        }        
    }
?>