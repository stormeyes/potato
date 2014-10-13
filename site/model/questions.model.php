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
        
        function getChoicelist(){
            return $this->select("type='choice' order by id desc");
        }
        
        function getQuestions($type,$category,$count){
            return $this->select("type='$type' and category='$category' ORDER BY RNAD() limit $count");
        }
    }
?>
