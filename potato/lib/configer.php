<?php

namespace potato\lib;

class configer {
    /*
     * Only support mysql database
     * The ROOT PATH can only dymanic decide,
     * so it can't be set const final
     */
    protected  static $default_setting=array(
        'debug'=>True,
        'crypt'=>array(
            'salt'=>''
        ),
        'database'=>array(
            'host'=>'127.0.0.1',
            'driver'=>'mysqli',
            'charset'=>'utf8',
            'username'=>'',
            'password'=>'',
            'port'=>'',
            'dbname'=>'',
            'prefix_'=>''
        ),
        'logger'=>array(
            'log_path'=>'log/',
            'log_level'=>'warning'
        ),
        'mail'=>array(
            'smtp'=>array(
                'username'=>'',
                'password'=>'',
                'from_mail'=>'',
                'server'=>'',
                'server_port'=>''
            ),
            'mail_level'=>'error',
            'receiver'=>array()
        )
    );

    /* The merged setting array
     * @var array
     */
    public static $setting;

    public static function mergeSetting(){
        /*
         *don't use explode('/',__DIR__) because you
         *are not sure it will run on Linux or Windows
         */
        $ROOT_PATH = dirname(dirname(__DIR__));
        //todo: change the / to DIRECTORY_SEPARATOR to adapter windows
        self::$default_setting['const'] = array(
            'ROOT_PATH'=>$ROOT_PATH,
            'APP_PATH'=>implode(DIRECTORY_SEPARATOR,array($ROOT_PATH,'app')),
            'Controller_PATH'=>implode(DIRECTORY_SEPARATOR,array($ROOT_PATH,'app/controller')),
            'Model_PATH'=>implode(DIRECTORY_SEPARATOR,array($ROOT_PATH,'app/model')),
            'Template_PATH'=>implode(DIRECTORY_SEPARATOR,array($ROOT_PATH,'app/template')),
            'static_PATH'=>implode(DIRECTORY_SEPARATOR,array($ROOT_PATH,'app/static')),
            'media_PATH'=>implode(DIRECTORY_SEPARATOR,array($ROOT_PATH,'app/media'))
        );
        /*
         * the customSetting don't have const,so the const
         * in defaultSetting will not be override
         */
        self::$setting = array_merge(
            self::$default_setting,
            self::getCustomSetting()
        );
    }

    private static function getCustomSetting(){
        return include_once(self::$default_setting['const']['APP_PATH'].'/config.php');
    }
} 