<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/27
 * Time: 22:03
 */

namespace app\admin\controller;


use app\admin\logic\Auth;
use think\Controller;

class Test extends Controller {

    public function index(){
        $auth = new Auth();

        dump($auth->check("qqq",1));
    }

}