<?php
    class BASE_MDL{
        var $db;

        function __construct(){
            $this->db=new db();
        }
        
        function get($condition){
            var_dump($this->db->query('select * from '.$this->tablename.' where '.$condition,'array'));
        }
        
        function insert(){
            $attr=get_object_vars($this);
            unset($attr['db']);
            unset($attr['tablename']);
            $s1='';
            $s2='';
            foreach($attr as $key=>$value){
                if(!is_numeric($value)){
                    $attr[$key]="'".$value."'";
                }
            }
            $insert="insert into ".$this->tablename."(".implode(',',array_keys($attr)).") values(".implode(',',array_values($attr)).")";
            echo $insert;
            
        }
        
        function update(){
        
        }
        
        function delete(){
        
        }
    }
?>
