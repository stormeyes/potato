<?php
    error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE);
    //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    $start_time = microtime(true);

    date_default_timezone_set("Asia/Shanghai");
    header("Content-type: text/html; charset=utf-8");
    
    require_once('config.php');
    
    function __autoload($className) { 
        include_once ROOT_PATH.'/framework/utils/'.$className . '.class.php'; 
    } 
    
    session_start();
    
    require_once('global.function.php');
    require_once('db.class.php');
    require_once('application.class.php');
    require_once('controller.class.php');
    require_once('model.class.php');
    
    if(DEBUG){
	    ini_set('html_errors', "On");
	    ini_set('display_errors', "On");
    }else{
	    ini_set('html_errors', "Off");
	    ini_set('display_errors', "Off");
    }
?>
