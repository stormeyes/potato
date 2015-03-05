<?php
namespace potato\utils;
use potato\lib\configer as Configer;

class uploader {
    public $filerList = array();
    public $error;

    public function __construct($filterList){
        $this->filerList=$filterList;
    }

    public function upload($file_in_memory,$target_file_path){
        //http://stackoverflow.com/questions/4636166/only-variables-should-be-passed-by-reference
        $suffix=pathinfo($file_in_memory['name'], PATHINFO_EXTENSION);;
        $filename = md5_file($file_in_memory['tmp_name']);
        if(file_exists($target_file_path.DIRECTORY_SEPARATOR.$filename.'.'.$suffix)){
            $this->error='文件已存在';
            return $filename.'.'.$suffix;
        }
        if(!in_array($suffix,$this->filerList)){
            $this->error='该文件类型不允许上传';
            return false;
        }

        //todo: set the default_setting in Configer to prorected;
        move_uploaded_file($file_in_memory['tmp_name'],$target_file_path.DIRECTORY_SEPARATOR.$filename.'.'.$suffix);
        return $filename.'.'.$suffix;
    }
} 