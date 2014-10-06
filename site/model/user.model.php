<?php
    class user_model extends BASE_MDL{
        var $tablename='user';
        var $id;
        var $username;
        var $password;

        function getUserByName($username){
            //var_dump($this->db->query('select * from user','array'));
            $this->get('id=1',$this);
            $this->id=2;
            $this->username='heihei';
            $this->password='fuckman';
            $this->insert();
        }
    }
?>
