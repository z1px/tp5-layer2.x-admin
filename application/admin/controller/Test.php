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

        dump(url("admin/index/deaaa"));
        dump(url("admin/Index/index"));

        dump($auth->check("admin/Index/index",2));
        dump($auth->getGroups(2));
        dump($auth->getOnelevel(2));
        dump($auth->getNavbar(2));
    }

}