<?php
    class BASE_MDL{
        var $db;

        function __construct(){
            $this->db=new db();
        }
        
        function select($condition){
            $select="select * from ".$this->tablename." where ".$condition;
            return $this->db->query($select,'array');
        }
        
        function insert(){
            $attr=get_object_vars($this);
            unset($attr['db']);
            unset($attr['tablename']);
            foreach($attr as $key=>$value){
                if(isset($value)){
                    if(!is_numeric($value)){
                        $attr[$key]="'".$value."'";
                    }
                }else{
                    unset($attr[$key]);
                }
            }
            $insert="insert into ".$this->tablename."(".implode(',',array_keys($attr)).") values(".implode(',',array_values($attr)).")";
            //echo $insert;
            $this->db->query($insert);
        }
        
        function update($set,$filter){
            $update="update ".$this->tablename." set ".$set." where ".$filter;
            $this->db->query($update);
        }
        
        function delete($filter){
            $delete="delete from ".$this->tablename." where ".$filter;
            $this->db->query($delete);
        }
        
    }
?>
