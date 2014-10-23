<?php
    class user_model extends BASE_MDL{
        var $tablename='user';
        var $id;
        var $studentnumber;
        var $phonenumber;
        var $password;
        var $status;
        var $SMScode;
        var $lastlogin;
        var $lastIP;
        var $salt;
        var $level;
        var $averageScore;
        var $averageTime;
        
        function getUser($filter){
            return $this->select($filter);
        }
        
        
        function addUser($studentnumber,$phonenumber,$password,$SMScode,$lastIP,$status){
            $this->studentnumber=$studentnumber;
            $this->phonenumber=$phonenumber;
            $this->password=md5($password);
            $this->SMScode=$SMScode;
            $this->lastlogin=time();
            $this->lastIP=$lastIP;
            $this->status=$status;
            $this->salt=generateSalt(8);
            $this->insert();
        }
        
        function changeStatus($studentnumber,$toStatus){
            $this->update('status='.$toStatus,'studentnumber='.$studentnumber);
        }
        
        function validate($studentnumber,$password){
            //var_dump($this->select("studentnumber=".$studentnumber." and password='".md5($password)."'"));
            return $this->select("studentnumber=".$studentnumber." and password='".md5($password)."'")?true:false;
        }
        
        function updateRace($score,$time,$studentnumber){
            $this->update("averageScore=(averageScore*level+$score)/(level+1),averageTime=(averageTime*level+$time)/(level+1),level=level+1","studentnumber=".$studentnumber);
        }
    }
?>
