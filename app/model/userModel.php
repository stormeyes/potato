<?php
namespace app\model;
use potato\lib\baseModel as baseModel;

class userModel extends baseModel{
    public function addUser($studentnum,$name,$department_id,$email,$password){
        $password=md5($password);
        $register_time=time();
        $this->query("insert into ".$this->table('users').
            "(studentnumber,name,department_id,email,password,register_time)
            values('{$studentnum}','{$name}','{$department_id}','{$email}','{$password}','{$register_time}')"
        );
    }

    public function validateDepartmentCode($department_code){
        return $this->queryOne(
            "select * from ".$this->table('department')." where department_code='".$department_code."'"
        );
    }

    public function userExist($studentnumber){
        return $this->queryOne(
            "select * from ".$this->table('users')." where studentnumber='{$studentnumber}'"
        );
    }

    public function changestate($studentnumber,$tostate){
        $this->query("update ".$this->table('users')." set state={$tostate} where studentnumber='{$studentnumber}'");
    }

    public function validate($studentnumber,$password){
        $password=md5($password);
        return $this->queryOne("select * from "
            .$this->table('users').
            " where studentnumber='{$studentnumber}' and password='{$password}'");
    }

    public function userlist($center=0,$department=0,$starter=0,$limit=16){
        if($center == 0 && $department != 0){
            return $this->queryOne('select * from '
                .$this->table('users').
                " where department_id={$department} and state>0"
            );
        }elseif($center != 0 && $department == 0){
            $data=$this->query("select department_id from "
                .$this->table('department').
                " where parent_department_id={$center}"
            );
            $result=array();
            foreach($data as $row){
                $tmp=$this->query("select * from "
                    .$this->table('department').
                    " where department_id =".$row['department_id']." and state>0"
                );
                $result = array_merge($result,$tmp);
            }
            return array_slice($result,$starter,$limit);
        }elseif($center == 0 && $department == 0){
            return $this->query("select * from "
                .$this->table('users').
                " where state>0 limit ".$limit
            );
        }else{
            return false;
        }
    }
} 