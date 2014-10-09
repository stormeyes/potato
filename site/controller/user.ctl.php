<?php
    class user extends BASE_CTL{
        var $massage=Array();
        
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
                $this->view($template=false,$params=jsonify($this->massage));
            }else{
                $this->view($template='index.php');
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
                $this->view($template=false,$params=jsonify($this->massage));
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
                //we don't use salt as authkey because it's possible that salt be same in different people
                $this->massage['authkey']=encrypt($singleuser['studentnumber'],'E',$CONFIG['SECRET_KEY']);
            }else{
                $this->massage['status']='error';
                $this->massage['reason']='用户名/密码 错误';
            }
            $this->view($template=false,$params=jsonify($this->massage));
        }else{
            $this->view($template='login.php');
        }
     }
        
    }
?>
