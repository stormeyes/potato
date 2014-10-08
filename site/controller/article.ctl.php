<?php
    class article extends BASE_CTL{

        function view($id,$times){
            /*
            echo 'finally show on...';
            echo $id.'==========';
            echo $times.'===========';
            */
            $user=article::loadModel('user');
            $user->addUser(123,'321');
        }
    }
?>
