<?php
    class BASE_MDL{
    
        var $dbconnection;
        var $config;
        var $db;
        
        function __construct(){
            global $CONFIG;
            $this->config=$CONFIG;
            $this->db=new db();
            $this->dbconnection=$this->db->connection;
        }
    }
?>
