<?php
 
 class application{
    
    var $route;
    var $handler;
    var $params=array();
    var $dbconnection;
    
    function __construct(){
        $db=new db();
        $this->dbconnection=$db->connection;
    }
    
    function checkRoute($requestURL){
        if(array_key_exists($requestURL,$this->route)){
            $mapping=$this->route[$requestURL];
            $controller=explode('.',$mapping)[0];
            $action=explode('.',$mapping)[1];
            
            //check the existance of controller
            if(!file_exists(CTL_PATH.$controller.'.class.php')){
                if($config['DEBUG']){
                    die('控制器'.$controller.'不存在');
                }else{
                    die('404');
                }
            }
            
            //check the existance of method
            $this->$handler=array(CTL_PATH.$controller.'.class.php',$action);
            if(!is_callable($handler)){
                if($config['DEBUG']){
                    die('控制器'.$controller.'不存在'.$action.'方法');
                }else{
                    die('404');
                }
            }
            
            return true;
            
        }else{
            die('This URL not mapping any router');
        }
    }
    
    function run($requestURL){
        if($this->checkRoute($requestURL)){
            echo 'fuckkkkkkk';
            call_user_func_array($this->$handler,$this->$params);
        }      
    }
 }
?>
