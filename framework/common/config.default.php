<?php
    $CONFIG=array(
        'DB'=>array(
            'HOST'=>'localhost',
            'DATABASE'=>'',
            'USERNAME'=>'root',
            'PASSWORD'=>'',
            'PORT'=>'3306',
            'CHARSET'=>'utf8'
        ),
        'DEBUG'=>True,
        'AUTO_SLASH'=>True,
        'SECRET_KEY'=>'AzuTHj'
    );
    
    //CONST define
    define('APP_VERSION','0.1');
    define('DEBUG', true);
    define('ROOT_PATH', str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME'])).'/');
    define('CTL_PATH',ROOT_PATH.'site/controller/');
    define('MODEL_PATH',ROOT_PATH.'site/model/');
    define('VIEW_PATH',ROOT_PATH.'site/view/');
    define('STATIC_PATH',ROOT_PATH.'site/static/')
?>
