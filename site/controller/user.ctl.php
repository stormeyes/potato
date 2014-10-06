<?php
    class user extends BASE_CTL{
        var $massage=Array();
        
        function firstRegister(){
            $form=new form(array(
                'studentNumber'=>'number',
                'phoneNumber'=>'phone',
                'username'=>'not_empty'
            ));
            //add true to force the json_decode function return array other than object
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
                        $error='为止的错误';
                }
                $this->massage['status']='error';
                $this->massage['reason']=$error;
            }else{
                $this->massage['status']='success';
            }
            
            $this->view($template=false,$params=jsonify($this->massage));
        }
    }
?>
