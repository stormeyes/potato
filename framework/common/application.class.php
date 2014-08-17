<?php
 
 class application{
    
    var $route;
    var $config;
    var $handler;
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
            include_once(CTL_PATH.$controller.'.ctl.php');
            if(!method_exists($controller,$action)){
                if($this->config['DEBUG']){
                    die('控制器'.$controller.'存在,但是不存在'.$action.'方法');
                }else{
                    die('404');
                }
            }
            $this->handler=array($controller,$action);
            return true;
            
        }else{
            if($this->config['DEBUG']){
                die('This URL not mapping any router');
            }else{
                die('404');
            }
        }
    }
    
    function run($requestURL){
        if($this->checkRoute($requestURL)){
            new $this->handler[0];
            //Dynamic call(动态调用)
            call_user_func_array($this->handler,$this->params);
        }
    }
 }
?>
