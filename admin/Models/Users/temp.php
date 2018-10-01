<?php
    
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    $obj = new User();
    echo $obj->sync_enc("admin@admin.com");
  
?>