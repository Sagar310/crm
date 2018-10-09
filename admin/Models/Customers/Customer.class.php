<?php
    class Customer{
        private $dbArr;
        private $data=array();
        private $table;
        private $view;
        private $messages;

        public function __construct()
        {
            $this->dbArr=parse_ini_file("../db.ini");
            $this->table="tbl_customers";
            $this->view = "";
            $this->messages=parse_ini_file("Customer_msg.ini");
        }

        public function __set($property,$value)
        {
            if($property=="custid"||$property=="lastName"||$property=="firstName"||$property=="gender"||$property=="cellNo"||$property=="email"||$property=="birthDate"||$property=="wedAniv"||$property=="disPic"||$property=="createdBy"||$property=="modifiedBy"||$property=="timeStamp")
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

        public function getCustomer($field_list="*",$where = "", $order = "", $limit="")
        {
            $query="select ".$field_list." from ".$this->table;
            if($where != "")
                $query.= " where ".$where." ";
            if($order!="")
                $query.=$order." ";
            if($limit!="")
                $query.=$limit."";
            //return $query;
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

        public function newCustomer()
        {
            
            $query = sprintf("INSERT INTO %s (lastName,firstName,gender,cellNo,email,birthDate,wedAniv,disPic,createdBy) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",$this->table,$this->lastName,$this->firstName,$this->gender,$this->cellNo,$this->email,$this->birthDate,$this->wedAniv,$this->disPic,$this->createdBy);            

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

        public function saveCustomer()
        {            
            $query = sprintf("UPDATE %s SET lastName='%s',firstName='%s',gender='%s',cellNo='%s',email='%s',birthDate='%s',wedAniv='%s',disPic='%s',modifiedBy='%s' WHERE custid = '%s'",$this->table,$this->lastName,$this->firstName,$this->gender,$this->cellNo,$this->email,$this->birthDate,$this->wedAniv,$this->disPic,$this->modifiedBy,$this->custid);            
                            
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

        public function deleteCustomer()
        {
            $query=sprintf("DELETE FROM %s WHERE custid=%d",$this->table,$this->custid);
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