<?php
    class BASE_CTL{
        var $request=array();
        
        function __construct(){
            //avoid injection attack
            $_POST=safeInput($_POST);
            $_GET=safeInput($_GET);
            $this->request['method']=$_SERVER['REQUEST_METHOD'];
            $this->request['IP']=$_SERVER["REMOTE_ADDR"];
        }
        
        function loadModel($modelName){
            require_once MODEL_PATH.$modelName.'.model.php';
            $model=$modelName.'_model';
            return new $model;
        }
        
        function loadview($template,$params){
            if($template){
                include_once VIEW_PATH.$template;
            }else{
                echo $params;
            }
        }
    }
?>
