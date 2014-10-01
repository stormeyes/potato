<?php
    class user_model extends BASE_MDL{
        var $id;
        var $username;
        var $password;
        
        function __construct(){
            parent::__construct();
        }

        function getUserByName($username){
            var_dump($this->db->query('select * from user','array'));
        }
    }
?>
