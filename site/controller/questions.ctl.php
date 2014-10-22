<?php
    class questions extends BASE_CTL{
        var $massage=array();
        
        function auth(){
            $user=$this->loadModel('user');
            $studentnumber=encrypt($_POST['authkey'],'D',$CONFIG['SECRET_KEY']);
            if(!$user->getUser('studentnumber='.$studentnumber)){
                $this->massage['status']='error';
                $this->massage['reason']='authkey错误!';
                $this->massage['post']=$_POST;
            }else{
                return true;
            }
            
        }
        
        function formvalidate($formattr){
            $form=new form($formattr);                    
            $result=json_decode($form->attrchecker($_POST),true);
            if($result['status']=='error'){
               switch($result['code']){
                 case '1':
                    $error=$result['error_attr'].'未填写';
                    break;
                            
                 case '2':
                    $error=$result['error_attr'].'与要求的格式不符';
                    break;
                                
                 default:
                    $error='未知的错误';
               }
               $this->massage['status']='error';
               $this->massage['reason']=$error;
               $this->massage['post']=$_POST;
            }else{
                return true;
            }   
        }
        
        function addChoiceQuestion(){
            $question=$this->loadModel('questions');
            if($this->request['method']=='POST'){
                $question->addChoiceQuestion($_POST['category'],$_POST['content'],$_POST['optionA'],$_POST['optionB'],$_POST['optionC'],$_POST['optionD'],$_POST['answer']);
            }
            
            $data=$question->getChoicelist();
            $this->loadview($template='addquestion.php',$params=$data);
        }
        
        function addjudgeQuestion(){
            $question=$this->loadModel('questions');
            if($this->request['method']=='POST'){
                $question->addjudgeQuestion($_POST['category'],$_POST['content'],$_POST['answer']);
            }
            
            $data=$question->getjudgelist();
            $this->loadview($template='addjudgequestion.php',$params=$data);
        }
        
        function race(){
          if($this->method='POST'){
                if($this->auth()){
                    $questions=$this->loadModel('questions');
                    $this->massage['status']='success';
                    $this->massage['questionList']=$questions->getRaceQuestions($count=10);
                }
                $this->loadview($template=false,$params=jsonify($this->massage));
            }else{
                return error_handler(405);
            }
        }
        
        function getquestions(){
            $user=$this->loadModel('user');
            $questions=$this->loadModel('questions');
            if($this->request['method']=='POST'){
                if($this->auth() && $this->formvalidate(array('type'=>'not_empty','category'=>'not_empty','count'=>'number'))){
                        $this->massage['status']='success';
                        $this->massage['questionList']=$questions->getQuestions($_POST['type'],$_POST['category'],(int)$_POST['count']);
                   }
                
                $this->loadview($template=false,$params=jsonify($this->massage));
            }else{
                return error_handler(405);
            }
        }
    }
?>
