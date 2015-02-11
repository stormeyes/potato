<?php
namespace potato;

class potato {
    /*
     * The construct function in PHP can be set into
     * private or protected, but that is meaningless
     */
    function __construct($debug = false){
        session_start();
        if($debug) {
            ini_set('display_errors', 'On');
            ini_set('error_reporting',E_ALL);
        }else{
            ini_set('display_errors','Off');
            ini_set('error_reporting',0);
        }
        date_default_timezone_set('Asia/Shanghai');
        $this->initComponent();
    }

    private function initComponent(){
        lib\configer::mergeSetting();
        http\router::collection();
    }

    public function run(){
        $request=new http\request();
        $class=$request->dispatch();
        http\response::makeapp($class);
    }

    /*
     * The __autoload function
     */
    public static function loader($classname){
        list($potato,$subpath,$filename)=explode('\\',$classname);
        if($potato == 'potato'){
            require_once($subpath.DIRECTORY_SEPARATOR.$filename.'.php');
        }else{
            require_once(lib\configer::$setting['const']['APP_PATH'].DIRECTORY_SEPARATOR.$subpath.DIRECTORY_SEPARATOR.$filename.'.php');
        }
    }
}

spl_autoload_register(array('potato\potato', 'loader'));