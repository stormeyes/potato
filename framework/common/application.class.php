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
        if($this->checkRequestURL($requestURL)){
            $mapping=$this->route[$requestURL];
            $controller=explode('->',$mapping)[0];
            $action=explode('->',$mapping)[1];
            //check the existance of controller
            if(!file_exists(CTL_PATH.$controller.'.ctl.php')){
                if($this->config['DEBUG']){
                    die('controller '.$controller.' not exist!');
                }else{
                    die('404');
                }
            }
            
            //check the existance of method
            include_once(CTL_PATH.$controller.'.ctl.php');
            if(!method_exists($controller,$action)){
                if($this->config['DEBUG']){
                    die('controller '.$controller.' exist,but method '.$action.' does not exist!');
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
    
    function checkRequestURL($requestURL){
        $requestURLSplit=array_slice(array_filter(explode('/',$requestURL)),0);
        foreach($this->route as $key => $value){
            $keySplit=array_slice(array_filter(explode('/',$key)),0);
            if(count($requestURLSplit)==count($keySplit)){
                for($i=0;$i<count($keySplit);$i++){
                    if($keySplit[$i]!==$requestURLSplit[$i]){
                        if(substr($keySplit[$i],0,1)!='$'){
                            echo $keySplit[$i];
                            break;
                        }else{
                            array_push($this->params,$requestURLSplit[$i]);
                        }
                    }
                    if($i==count($keySplit)-1){
                        return true;
                    }
                }
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
