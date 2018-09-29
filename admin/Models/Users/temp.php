<?php
    
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $obj = new User();
    $email = "admin@admin.com";
    $where = sprintf(" email='%s' ",$email);
    $cpass = $obj->encrypt("admin123");
    $npass = $obj->encrypt('admin789');
    
    $msg = $obj->getUser("*",$where,"","");
    echo $msg."<br>";    
    $result=json_decode($msg,TRUE);
    //print_r($result)."<br>";
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

    echo "<br>".$msg;
  
?>