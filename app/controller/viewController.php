<?php
namespace app\controller;
use potato\lib\baseController as baseController;
use potato\http\response as Response;

class viewController extends baseController{
   
    public function index(){
        Response::render_template('index.php');
    }
}
