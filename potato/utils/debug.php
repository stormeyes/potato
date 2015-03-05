<?php

class debug {
    function get_function($function_name){
        $reflFunc = new ReflectionFunction($function_name);
        echo $reflFunc->getFileName() . ':' . $reflFunc->getStartLine();
    }

    function get_class_info($class){
        var_dump(get_class_methods($class));
    }

    function get_class($classname){
        $reflector = new ReflectionClass($classname);
        return $reflector->getFileName();
    }
} 