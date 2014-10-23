<?php
	class db{
		var $tablename;
		var $connection;
		var $result;
		var $dbconfig=array();
		var $result_array=array();

		function __construct(){
		    global $CONFIG;
		    $this->dbconfig=$CONFIG['DB'];
			$this->getConnection();
		}

		function getConnection(){
			$this->connection=@mysql_connect($this->dbconfig['HOST'],$this->dbconfig['USERNAME'],$this->dbconfig['PASSWORD']) or die('MYSQL ERROR!'.mysql_error());
			mysql_select_db($this->dbconfig['DATABASE']);
			mysql_query("SET NAMES ".$this->dbconfig['CHARSET']);
		}

		function query($sql,$result_type,$echosql=false){
			if($echosql){
				echo 'The SQL command is[ '.$sql.' ]';
			}
			$this->result=mysql_query($sql,$this->connection);
			if($result_type=='array'){
				return $this->getResultByArray();
			}else{
				return $this->result;
			}
		}

		function getResultByArray(){
			while ($result=mysql_fetch_array($this->result,MYSQL_ASSOC)) {
				array_push($this->result_array, $result);
			}
			return $this->result_array;
		}

		function __destruct(){
            mysql_close($this->connection);
        }
	}
?>
