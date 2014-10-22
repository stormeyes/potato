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
            return $this->select("type='$type' and category='$category' ORDER BY RAND() limit $count");
        }
        
        function getRaceQuestions($count){
            return $this->select("type='choice' or type='judge' ORDER BY RAND() limit $count");
        }
    }
?>
