<?php
use potato\http\router as Router;

Router::get(array(
    '/'=>'viewController@index'
));

Router::post(array(
    '/login'=>'userController@login',
    '/register'=>'userController@register'
));

/*
Router::get('/aa','aaaaa');
Router::get(array(
    '/'=>'user@index',
    '/login'=>'userController@index'
));

Router::post('/login','userController@index');

Router::any('/view','userController@index');
/*
Router::filter('auth',array(
    '/view',
    '/login'
));

$authURL=array(
    '/view',
    '/login'
);

Router::filter($authURL, function(){
    if($_SESSION['has']){
        echo 'ok';
    }else{
        die('not ok');
        //Response::redirect('/');
    }
});
*/
