<?php
    
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $dir = "../../assets/images/customers/";
    $files = scandir($dir);  
    $msg = json_encode($files);
    echo $msg;
  
?>