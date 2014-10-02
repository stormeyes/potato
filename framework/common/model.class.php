<?php
    class BASE_MDL{
        var $db;

        function __construct(){
            $this->db=new db();
        }
        
        function get($condition){
            var_dump($this->db->query('select * from '.$this->tablename.' where '.$condition,'array'));
            //echo $this->tablename;
        }
        
        function insert(){
            echo '<br>===============</br>';
            $attr=get_object_vars($this);
            unset($attr['db']);
            unset($attr['tablename']);
            $s1='';
            $s2='';
            foreach($attr as $key=>$value){
                $s1=$s1.$key.',';
                $s2=$s2.$value.',';
            }
            $insert="insert into ".$this->tablename."(".$s1.") values(".$s2.")";
            echo $insert;
            
        }
        
        function update(){
        
        }
        
        function delete(){
        
        }
    }
?>
