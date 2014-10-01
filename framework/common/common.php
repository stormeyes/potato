<?php
    error_reporting(E_ALL & ~E_STRICT & ~E_WARNING & ~E_NOTICE);
    $start_time = microtime(true);

    date_default_timezone_set("Asia/Shanghai");
    header("Content-type: text/html; charset=utf-8");

    session_start();
    
    require_once('config.php');
    require_once('global.function.php');
    require_once('db.class.php');
    require_once('application.class.php');
    require_once('controller.class.php');
    /*
    if(DEBUG){
	    ini_set('html_errors', 0);
	    ini_set('display_errors', 0);
    }else{
	    ini_set('html_errors', 1);
	    ini_set('display_errors', 1);
    }
    */
?>
