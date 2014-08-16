<?php
    $CONFIG=array(
        'DB'=>array(
            'HOST'=>'localhost',
            'DATABASE'=>'',
            'USERNAME'=>'',
            'PASSWORD'=>'',
            'PORT'=>'3306',
            'CHARSET'=>'utf8'
        ),
        'DEBUG'=>True
    );
    
    //常量定义
    define('APP_VERSION','0.1');
    define('DEBUG', true);
    define('ROOT_PATH', str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME'])).'/');
    define('CTL_PATH',ROOT_PATH.'/site/controller/');
?>
