<?php
    class questions_model extends BASE_MDL{
        var $tablename='questions';
        var $id;
        var $type;
        var $category;
        var $content;
        var $optionA;
        var $optionB;
        var $optionC;
        var $optionD;
        var $answer;
        
        function addChoiceQuestion($category,$content,$optionA,$optionB,$optionC,$optionD,$answer){
            $this->type='choice';
            $this->category=$category;
            $this->content=$content;
            $this->optionA=$optionA;
            $this->optionB=$optionB;
            $this->optionC=$optionC;
            $this->optionD=$optionD;
            $this->answer=$answer;
            $this->insert();
        }
        
        function addjudgeQuestion($category,$content,$answer){
            $this->type='judge';
            $this->category=$category;
            $this->content=$content;
            $this->answer=$answer;
            $this->insert();
        }
        
        function getjudgelist(){
            return $this->select("type='judge' order by id desc");
        }
        
        function getChoicelist(){
            return $this->select("type='choice' order by id desc");
        }
        
        function getQuestions($type,$category,$count){
        /*
            $result=array();
            $set=array();
            $i=0;
            for($i;$i<1;$i++){
                $randomquestions=$this->db->query("SELECT *
FROM {$this->tablename} AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM {$this->tablename})-(SELECT MIN(id) FROM {$this->tablename}))+(SELECT MIN(id) FROM {$this->tablename})) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id LIMIT 1","array")[0];
                echo $randomquestions['id'].PHP_EOL;
                var_dump($randomquestions);
                $i++;
                var_dump($randomquestions);
                
                //var_dump(get_class_methods($this->db));
            }
            return $result;
            */
            
            return $this->select("type='$type' and category='$category' ORDER BY RAND() limit $count");
        }
        
        function getRaceQuestions($count){
            return $this->select("type='choice' or type='judge' ORDER BY RAND() limit $count");
        }
    }
?>
