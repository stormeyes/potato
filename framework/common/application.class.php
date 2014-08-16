<?php
 
 class application{
    
    var $route;
    var $handler;
    var $config;
    var $params=array();
    var $dbconnection;
    
    function __construct(){
        global $CONFIG;
        $this->config=$CONFIG;
        $db=new db();
        $this->dbconnection=$db->connection;
    }
    
    function checkRoute($requestURL){
        if(array_key_exists($requestURL,$this->route)){
            $mapping=$this->route[$requestURL];
            $controller=explode('->',$mapping)[0];
            $action=explode('->',$mapping)[1];
            //check the existance of controller
            if(!file_exists(CTL_PATH.$controller.'.ctl.php')){
                if($this->config['DEBUG']){
                    die('控制器'.$controller.'不存在');
                }else{
                    die('404');
                }
            }
            
            //check the existance of method
            $this->handler=array(CTL_PATH.$controller.'.ctl.php',$action);
            if(!is_callable($handler)){
                if($this->config['DEBUG']){
                    die('控制器'.$controller.'存在,但是不存在'.$action.'方法');
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
