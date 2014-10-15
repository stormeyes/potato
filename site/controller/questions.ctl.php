<?php
    class questions extends BASE_CTL{
        var $massage=array();
        
        function addChoiceQuestion(){
            $question=$this->loadModel('questions');
            if($this->request['method']=='POST'){
                $question->addChoiceQuestion($_POST['category'],$_POST['content'],$_POST['optionA'],$_POST['optionB'],$_POST['optionC'],$_POST['optionD'],$_POST['answer']);
            }
            
            $data=$question->getChoicelist();
            $this->loadview($template='addquestion.php',$params=$data);
        }
        
        function getquestions(){
            $user=$this->loadModel('user');
            $questions=$this->loadModel('questions');
            if($this->request['method']=='POST'){
                $studentnumber=encrypt($_POST['authkey'],'D',$CONFIG['SECRET_KEY']);
                if($user->getUser('studentnumber='.$studentnumber)){
                    $form=new form(array(
                        'type'=>'not_empty',
                        'category'=>'not_empty',
                        'count'=>'number'
                    ));
                    
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
                    }else{
                        $qesData=$questions->getQuestions($_POST['type'],$_POST['category'],(int)$_POST['count']);
                        //var_dump($qesData);
                        $this->massage['status']='success';
                        //$this->massage['questionList']=array();
                        $this->massage['questionList']=$qesData;
                        //echo json_encode($this->massage,JSON_PRETTY_PRINT);
                   }
                }else{
                    $this->massage['status']='error';
                    $this->massage['reason']='authkey错误!';
                    $this->massage['post']=$_POST;
                }
                
                $this->loadview($template=false,$params=jsonify($this->massage));
            }else{
                return error_handler(405);
            }
        }
    }
?>
