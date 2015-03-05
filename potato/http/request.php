<?php

namespace potato\http;
use potato\http\router as Router;
use potato\http\response as Response;

class request {
    public static $server = array();
    public static $GET = array();
    public static $POST = array();
    public static $matchClassname;
    public static $matchClassmethod;

    public static function dispatch(){
        self::initialize();
        self::match(
            $_SERVER['REQUEST_URI'],
            strtoupper($_SERVER['REQUEST_METHOD'])
        );


        Router::urlValidate(
            $_SERVER['REQUEST_URI'],
            strtoupper($_SERVER['REQUEST_METHOD'])
        );

        return array(
            'classname'=>self::$matchClassname,
            'classmethod'=>self::$matchClassmethod
        );
    }

    static function initialize(){
        self::$server=$_SERVER;
        self::filter();
    }

    public static function filter(){
        foreach($_POST as $key=>$value){
            self::$POST[$key]=self::safe($value);
        }
    }

    public static function safe($r){
        return htmlspecialchars(stripslashes(trim($r)));
    }

    //Default methods set to GET
    public static function match($url,$method){
        $found=False;
        if($method == 'GET'){
            foreach(Router::$getRouter as $regex=>$class){
                $regex = str_replace('/', '\/', $regex);
                $regex = '^' . $regex . '\/?$';
                if (preg_match("/$regex/i", $url, $matches)){
                    $found =  True;
                    self::$GET=$matches;
                    list(self::$matchClassname,self::$matchClassmethod)=explode('@',$class);
                    break;
                }
            }
            !$found?Response::abort(404):'';
        }else if($method == 'POST'){
            foreach(Router::$postRouter as $regex=>$class){
                $regex = str_replace('/', '\/', $regex);
                $regex = '^' . $regex . '\/?$';
                if (preg_match("/$regex/i", $url, $matches)){
                    $found =  True;
                    self::$GET=$matches;
                    list(self::$matchClassname,self::$matchClassmethod)=explode('@',$class);
                    break;
                }
            }
            !$found?Response::abort(404):'';
        }else{
            Response::abort(500,'unsupport method');
        }
    }
} 