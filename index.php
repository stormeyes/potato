<?php
    //load the framework and init const variable,read the config file
    require_once('framework/common/common.php');
    //init the application , such as init db connection and environment
    $app=new application();
    //RouteMapping,check the URL is callable or not to avoid uncareable fault
    $app->route=array(
        '/'=>'index->index',
        '/register'=>'user->register',
        '/sendSMS'=>'user->sendSMS',
        '/login'=>'user->login',
        '/get/questions'=>'questions->getquestions',
        '/game/race'=>'questions->race',
        '/add'=>'questions->addChoiceQuestion',
        '/add/judge'=>'questions->addjudgeQuestion',
        '/article/$id/fuck/$times'=>'article->view'
    );
    //response the request
    $app->run($_SERVER['REQUEST_URI']);    
?>
