<?php
    
    function __autoload($class_name)
    {
        include $class_name.".class.php";
    }
    /*
    $dir = "../../assets/images/customers/";
    $files = scandir($dir);  
    $msg = json_encode($files);
    echo $msg;
    */
    Class MyClass
    {
        private $nm;

        public function __construct()
        {
            $this->nm = "John";
        }

        public function getName()
        {
            return $this->nm;
        }
    }

    $obj = new MyClass();
    echo $obj->getName();
?>