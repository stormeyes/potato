<?php

namespace potato\http;

use potato\lib\configer as Configer;

class router {
    public  static $getRouter = array();
    public  static $postRouter = array();
    public  static $filterRouter = array();
    public  static $filterFunc = array();

    static function get(){
        $params=func_get_args();
        if(count($params) == 1){
            //Attention:the array_merge doesn't change the array itself
            self::$getRouter=array_merge(self::$getRouter,$params[0]);
        }else if(count($params) == 2){
            //Need better and improve
            self::$getRouter[$params[0]]=$params[1];
        }else{
            throw new \ErrorException('Routers definition is wrong!');
        }
    }

    static function post(){
        $params=func_get_args();
        if(count($params) == 1){
            //Attention:the array_merge doesn't change the array itself
            self::$postRouter=array_merge(self::$postRouter,$params[0]);
        }else if(count($params) == 2){
            //Need better and improve
            self::$postRouter[$params[0]]=$params[1];
        }else{
            throw new \ErrorException('Routers definition is wrong!');
        }
    }

    static function any(){
        $params=func_get_args();
        if(count($params) == 1){
            //Attention:the array_merge doesn't change the array itself
            self::$postRouter=array_merge(self::$postRouter,$params[0]);
            self::$getRouter=array_merge(self::$getRouter,$params[0]);
        }else if(count($params) == 2){
            //Need better and improve
            self::$postRouter[$params[0]]=$params[1];
            self::$getRouter[$params[0]]=$params[1];
        }else{
            throw new \ErrorException('Routers definition is wrong!');
        }
    }

    /*
     * todo: validate if $router in $getrouter and $postrouter
     * Howto: array_merge $getrouter and $postrouter then validate key
     */
    static function filter($callback, $router){
        self::$filterFunc=$callback;
        self::$filterRouter=$router;
    }

    static function collection(){
        require_once(Configer::$setting['const']['APP_PATH'].'/router.php');
    }

    /*
     * The __autoload function
     */
    public static function loader($classname){
        list($potato,$subpath,$filename)=explode('\\',$classname);
        require_once(dirname(__DIR__).DIRECTORY_SEPARATOR.$subpath.DIRECTORY_SEPARATOR.$filename.'.php');
    }
}

spl_autoload_register(array('potato\http\router', 'loader'));