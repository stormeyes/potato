<?php
namespace potato\lib;

class baseController {
    function sessionAdd($array){
        foreach($array as $key=>$value){
            $_SESSION[$key] = $value;
        }
    }

    //todo:可以用array_walk
    function sessionPop($popdata=''){
        if(is_array($popdata)){
            foreach($popdata as $key){
                unset($_SESSION[$key]);
            }
        }elseif(empty($popdata)){
            foreach($_SESSION as $key=>$value){
                unset($_SESSION[$key]);
            }
        }else{
            unset($_SESSION[$popdata]);
        }
    }
} 