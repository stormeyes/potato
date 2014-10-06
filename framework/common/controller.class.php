<?php
    class BASE_CTL{
        function __construct(){
            //avoid injection attack
            $_POST=safeInput($_POST);
            $_GET=safeInput($_GET);
        }
        
        function view($template,$parmas){
            if($template){
                echo '============';
            }else{
                echo $parmas;
            }
        }
    }
?>
