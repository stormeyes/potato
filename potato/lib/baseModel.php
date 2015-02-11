<?php
namespace potato\lib;

use potato\lib\configer as Configer;

/*
 * This should change to factory design mode
 */
class baseModel {

    function __construct(){
        $this->connection = mysqli_connect(
            Configer::$setting['database']['host'],
            Configer::$setting['database']['username'],
            Configer::$setting['database']['password'],
            Configer::$setting['database']['dbname'],
            Configer::$setting['database']['port']
        ) or die('The configuration of database is wrong');

        mysqli_query(
            $this->connection,
            'set names '.Configer::$setting['database']['charset']
        );
    }

    function table($tablename){
        return Configer::$setting['database']['prefix'].$tablename;
    }

    function query($sql,$echo=false){
        if($echo){ echo $sql.'<br>';}
        $query_result = mysqli_query($this->connection,$sql)
        or die(mysqli_error($this->connection));
        if(!is_bool($query_result)){
            $result = array();
            while($row=$query_result->fetch_array(MYSQLI_ASSOC)){
                array_push($result,$row);
            }
            return $result;
        }
    }

    function queryOne($sql,$echo=false){
        if($echo){ echo $sql.'<br>';}
        $query_result = mysqli_query($this->connection,$sql);
        return $query_result->fetch_array(MYSQLI_ASSOC);
    }
}