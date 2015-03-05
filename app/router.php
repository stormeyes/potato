<?php
use potato\http\router as Router;
use potato\http\response as Response;

Router::get(array(
    '/'=>'viewController@index',
    '/mail/validate/([a-zA-Z0-9]*)'=>'emailController@validate',
    '/home'=>'viewController@home',
    '/login'=>'userController@login',
    '/contact'=>'viewController@home',
    '/contact/page/(\d+)'=>'viewController@home',
    '/userinfo'=>'viewController@userinfo',
    '/department'=>'viewController@department',
    '/report'=>'reportController@reportView',
    '/setting'=>'viewController@setting',
    '/beauty'=>'viewController@beauty',
    '/feedback'=>'viewController@feedback',
    '/admin/home'=>'viewController@adminContact',
    '/admin/contact/page/(\d+)'=>'viewController@adminContact',
    '/admin/feedback'=>'viewController@adminFeedback',
    '/admin/feedback/page/(\d+)'=>'viewController@adminFeedback',
    '/logout'=>'userController@logout',
    '/admin/account'=>'viewController@adminAccount',
    '/admin/account/page/(\d+)'=>'viewController@adminAccount'
));

Router::post(array(
    '/login'=>'userController@login',
    '/register'=>'userController@register',
    '/update/avatar'=>'userController@updateAvatar',
    '/update/userinfo'=>'userController@updateProfile',
    '/update/password'=>'userController@updatePassword',
    '/add/report'=>'reportController@addReport',
    '/feedback/submit'=>'userController@feedback',
    '/report/view'=>'reportController@viewDetail',
    '/report/update'=>'reportController@updateReport',
    '/report/delete'=>'reportController@deleteReport',
    '/report/pass'=>'reportController@passReport',
    '/department/position/update'=>'userController@updatePosition',
    '/beauty/vote'=>'userController@beauty_vote',
    '/beauty/page'=>'userController@beauty_page',
    '/setting/update'=>'settingController@updateSetting',
    '/download/xls'=>'toolController@downloadxls',
    '/report/view/page/(\d+)'=>'reportController@reportViewAjax',
    '/user/list/page/(\d+)'=>'userController@userlist',
    '/user/del'=>'userController@userdel',
    '/user/data'=>'userController@userdata',
    '/admin/account/add'=>'userController@addAdmin'
));

$authURL=array(
    'GET'=>array(
        '/home',
        '/report',
        '/contact',
        '/userinfo',
        '/department',
        '/setting',
        '/beauty',
        'feedback'
    ),
    'POST'=>array(
        '/update/avatar',
        '/update/userinfo',
        '/update/password',
        '/add/report',
        '/feedback/submit',
        '/report/view',
        '/report/update',
        '/report/delete',
        '/beauty/vote',
        '/beauty/page',
        '/setting/update',
        '/download/xls'
    )
);

Router::filter($authURL, function(){
    if(!isset($_SESSION['state'])) {
        Response::redirect('/',"您尚未登陆,请登陆后执行该操作",2);
    }
});

/*
example:
单个路由注册:
Router::get('/aa','aaaaa');

多个(组路由)注册:
Router::get(array(
    '/'=>'user@index',
    '/login'=>'userController@index'
));

Router::post('/login','userController@index');

同一路由同时响应GET/POST 方法
Router::any('/view','userController@index');
*/