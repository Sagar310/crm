<?php
    Class Session
    {
        private $messages;
        public function __construct()
        {
            $this->messages=parse_ini_file("Session_msg.ini");
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

        public function newKey($key,$val)
        {
            session_start();
            $msg = "";
            $_SESSION[$key] = $val;
            $msg = $this->generateResponse(FALSE,$this->messages["insupds"],FALSE);
            return $msg;
        }

        public function getKeyValue($key)
        {
            $msg = "";
            session_start();
            if(array_key_exists($key,$_SESSION))
            {
                $msg = $this->generateResponse(FALSE,$_SESSION[$key],TRUE);
            }
            else
            {
                $msg = $this->generateResponse(TRUE,$this->messages["updgetdelerr"],FALSE);
            }
            return $msg;
        }

        public function updateKey($key, $val)
        {
            $msg = "";
            session_start();
            if(array_key_exists($key,$_SESSION))
            {
                $_SESSION[$key] = $val;
                $msg = $this->generateResponse(FALSE,$this->messages["insupds"],FALSE);
            }
            else
            {
                $msg = $this->generateResponse(TRUE,$this->messages["updgetdelerr"],FALSE);
            }
            return msg;
        }

        public function destroyKey($key)
        {
            $msg = "";
            session_start();
            if(array_key_exists($key,$_SESSION))
            {
                unset($_SeSSION[$key]);
                $msg = $this->generateResponse(FALSE,$this->messages["dels"]);

            }
            else
            {
                $msg = $this->generateResponse(TRUE,$this->messages["updgetdelerr"],FALSE);
            }
            return msg;            
        }
    }
?>