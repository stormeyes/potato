<?php
    function error_handler($statusCode){
        switch($statusCode){
            case '404':
                die("<h1><center>:(</center></h1><h1><center>Sorry,page not found!</center></h1>");
                break;
            case '403':
                die("<h1><center>:(</center></h1><h1><center>Sorry,you don't have permission to enter this page</center></h1>");
                break;
            default:
                die("<h1><center>Unknow error</center></h1>");
        }
    } 
    
    function jsonify($arr){
        foreach($arr as $key=>$value){
            $arr[$key]=urlencode($value);
        }
        return urldecode(json_encode($arr));
    }
    
    function safeInput($input){
        foreach($input as $key=>$value){
            $input[$key] = htmlspecialchars(stripslashes(trim($value)));
        }
        return $input;
    }
?>
