<?php
    class user extends BASE_CTL{
        var $massage=Array();
        
        function firstRegister(){
            if(isset($_POST['studentCode'])){
                
            }else{
                $this->massage['status']='error';
                $this->massage['reason']='学号未填写';
                //echo json_encode($this->massage,JSON_UNESCAPED_UNICODE);
                $this->view(jsonify($this->massage));
            }
        }
    }
?>
