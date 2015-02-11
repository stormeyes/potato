<?php
namespace potato\lib;

class baseController {
    function sessionAdd($array){
        foreach($array as $key=>$value){
            $_SESSION[$key] = $value;
        }
    }
} 