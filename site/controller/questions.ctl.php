<?php
    class questions extends BASE_CTL{
        
        function addChoiceQuestion(){
            $question=$this->loadModel('questions');
            if($this->request['method']=='POST'){
                $question->addChoiceQuestion($_POST['category'],$_POST['content'],$_POST['optionA'],$_POST['optionB'],$_POST['optionC'],$_POST['optionD'],$_POST['answer']);
            }
            
            $data=$question->getChoicelist();
            $this->loadview($template='addquestion.php',$params=$data);
        }
    }
?>
