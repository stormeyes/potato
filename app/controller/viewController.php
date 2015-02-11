<?php
namespace app\controller;
use potato\lib\baseController as baseController;
use potato\http\response as Response;
/*
 * viewController
 * 控制模块的视图展现,主要是GET方法的视图展现
 */

class viewController extends baseController{
    public function __construct(){
        $this->departmentModel = new departmentModel();
        $this->userModel = new userModel();
    }

    public function index(){
        Response::render_template('index.php');
    }

    public function home(){
        $centerList=$this->departmentModel->getCenter();
        $departmentList=$this->departmentModel->getDepartment();
        $userList=$this->userModel->userlist(0,0,0,16);
        Response::render_template('contact.php',array(
            'centerList'=>$centerList,
            'departmentList'=>$departmentList,
            'userList'=>$userList
        ));
    }

    public function userinfo(){
        Response::render_template('userinfo.php');
    }

    public function department(){
        Response::render_template('department.php');
    }

    public function report(){
        Response::render_template('report.php');
    }

    public function setting(){
        Response::render_template('setting.php');
    }

    public function beauty(){
        Response::render_template('beauty.php');
    }

    public function feedback(){
        Response::render_template('feedback.php');
    }
}
