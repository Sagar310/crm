<?php
    
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $obj = new User();
    echo $obj->encrypt("admin789")."<br>";
    $email = "admin@admin.com";
    $pass = "pYxcPN0zZ;";
    echo $obj->encrypt($pass)."<br>";
    $msg = $obj->getUser("pass", "email='".$email."'","","");
    //$msg = $obj->getResetQ();
    echo $msg;
  
?>