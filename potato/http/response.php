<?php

namespace potato\http;

use potato\lib\configer as Configer;
use potato\utils\tool as Tool;

class response {

    public static $statusMsg = array(
        302=>'Temporarily Moved',
        404=>'Not Found',
        500=>'Internal Server Error'
    );

    static function makeapp($class){
        require_once(
            Configer::$setting['const']['Controller_PATH'].DIRECTORY_SEPARATOR.$class['classname'].'.php'
        );
        $class['classname'] ='app\\controller\\'.$class['classname'];
        if(class_exists($class['classname'])){
            $obj = new $class['classname'];
            if(method_exists($obj,$class['classmethod'])){
                $obj->$class['classmethod']();
            }else{
                self::abort(500,$message='method not found!');
            }
        }else{
            self::abort(500,$message='class not found!');
        }
    }

    static function redirect($url,$message='',$delay_time=0){
        if($message){
            //ajax响应302是不可行的，要么ajax读取要跳转的页面并js端跳转，要么用form而不是ajax
            header('Content-Type: text/html; charset=utf-8');
            header("Refresh: {$delay_time}; url={$url}");
            echo $message;
            exit();
        }else {
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . self::$statusMsg[302]);
            header("Location:$url");
        }
    }

    static function abort($statusCode,$message=''){
        $message=$statusCode==500?$message:'this page not found';
        if(Configer::$setting['debug']){
            die($message);
        }else{
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . self::$statusMsg[$statusCode], true, $statusCode);
        }
    }

    static function render_template($template,$data=array()){
        $Template_PATH=Configer::$setting['const']['Template_PATH'];
        extract($data);
        include_once($Template_PATH.DIRECTORY_SEPARATOR.$template);
    }

    static function jsonify(array $array){
        header('Content-Type:application/json');
        echo Tool::jsonify($array);
        die();
    }
} 