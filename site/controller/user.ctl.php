<?php
    class user extends BASE_CTL{
        var $massage=Array();
        
        function auth(){
            $user=$this->loadModel('user');
            $studentnumber=encrypt($_POST['authkey'],'D',$CONFIG['SECRET_KEY']);
            $this->studentnumber=$studentnumber;
            if(!$user->getUser('studentnumber='.$studentnumber)){
                $this->massage['status']='error';
                $this->massage['reason']='authkey错误!';
                $this->massage['post']=$_POST;
            }else{
                return true;
            }            
        }        
                
        function register(){
            if($this->request['method']=='POST'){
                $user=$this->loadModel('user');
                if($user->getUser('studentnumber='.$_POST['studentnumber'])[0]['status']==0){
                    if($_POST['SMScode']=='2333'){
                        $user->changeStatus($_POST['studentnumber'],1);
                        $singleuser=$user->getUser('studentnumber='.$_POST['studentnumber'])[0];
                        $this->massage['status']='success';
                        $this->massage['uid']=$singleuser['id'];
                        $this->massage['studentnumber']=$singleuser['studentnumber'];
                        $this->massage['lastlogin']=$singleuser['lastlogin'];
                        $this->massage['lastIP']=$singleuser['lastIP'];
                        //we don't use salt as authkey because it's possible that salt be same in different people
                        $this->massage['authkey']=encrypt($singleuser['studentnumber'],'E',$CONFIG['SECRET_KEY']);
                    }else{
                        $this->massage['status']='error';
                        $this->massage['reason']='手机验证码错误!请检查短信后再重新输入';
                    }
                }else{
                    $this->massage['status']='error';
                    $this->massage['reason']='此用户已验证手机，请直接登陆';
                }
                $this->loadview($template=false,$params=jsonify($this->massage));
            }else{
                $this->loadview($template='index.php');
            }
        }
        
        function sendSMS(){
            if($this->request['method']=='POST'){
                $form=new form(array(
                    'studentnumber'=>'studentnumber',
                    'password'=>'not_empty',
                    'phonenumber'=>'phone'
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
                    $user=$this->loadModel('user');
                    if(!$user->getUser('studentnumber='.$_POST['studentnumber'])){
                        
                        $user->addUser($_POST['studentnumber'],$_POST['phonenumber'],$_POST['password'],'2333',$this->request['IP'],0);
                        
                        $this->massage['status']='success';
                        
                    }else{
                        $this->massage['status']='error';
                        $this->massage['reason']='此用户已注册';
                    }
                }
                $this->loadview($template=false,$params=jsonify($this->massage));
            }else{
                error_handler(405);
            }
        }
     
     function login(){
        if($this->request['method']=='POST'){
            $user=$this->loadModel('user');
            if($user->validate($_POST['studentnumber'],$_POST['password'])){
                $singleuser=$user->getUser('studentnumber='.$_POST['studentnumber'])[0];
                $this->massage['status']='success';
                $this->massage['uid']=$singleuser['id'];
                $this->massage['studentnumber']=$singleuser['studentnumber'];
                $this->massage['lastlogin']=$singleuser['lastlogin'];
                $this->massage['lastIP']=$singleuser['lastIP'];
                $this->massage['level']=$singleuser['level'];
                $this->massage['averageScore']=$singleuser['averageScore'];
                $this->massage['averageTime']=$singleuser['averageTime'];
                //we don't use salt as authkey because it's possible that salt be same in different people
                $this->massage['authkey']=encrypt($singleuser['studentnumber'],'E',$CONFIG['SECRET_KEY']);
            }else{
                $this->massage['status']='error';
                $this->massage['reason']='用户名/密码 错误';
            }
            $this->loadview($template=false,$params=jsonify($this->massage));
        }else{
            $this->loadview($template='login.php');
        }
     }
     
     function singleupdate(){
        if($this->request['method']=='POST'){
            if($this->auth()){
                $user=$this->loadModel('user');
                $user->updateRace($_POST['score'],$_POST['time'],$this->studentnumber);
                $this->massage['status']='success';
                $singleuser=$user->getUser('studentnumber='.$this->studentnumber)[0];
                $user->updateMax($singleuser['studentnumber'],$singleuser['max'],$singleuser['maxDaliy'],$_POST['score']);
                $this->massage['level']=$singleuser['level'];
                $this->massage['averageScore']=$singleuser['averageScore'];
                $this->massage['averageTime']=$singleuser['averageTime'];
                $this->massage['max']=$singleuser['max'];
                $this->massage['maxDaliy']=$singleuser['maxDaliy'];
            }
            $this->loadview($template=false,$params=jsonify($this->massage));
        }else{
            error_handler(405);
        }
     }
    
    function listsingle(){
        if($this->request['method']=='POST'){
            if($this->auth()){
                $user=$this->loadModel('user');
                $this->massage['max']=$user->listrank('max',10);
                $this->massage['maxDaliy']=$user->listrank('maxDaliy',10);
            }
            $this->loadview($template=false,$params=jsonify($this->massage));
        }else{
            error_handler(405);
        }
    }
      
    }
?>
