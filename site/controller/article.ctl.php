<?php
    class article extends BASE_CTL{

        function loadModel($modelName){
            include MODEL_PATH.$modelName.'.model.php';
            $model=$modelName.'_model';
            return new $model;
        }

        function view($id,$times){
            /*
            echo 'finally show on...';
            echo $id.'==========';
            echo $times.'===========';
            */
            $user=article::loadModel('user');
            $user->getUserByName('haha');
        }
    }
?>
