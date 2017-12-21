<?php
namespace app\admin\controller;

use app\admin\logic\Login;
use think\Request;
use think\Url;

class Index extends Common {

    protected $login;

    protected function _before() {
        $this->login = new Login();
    }

    public function index() {
        return $this->_fetch();
    }

    public function main() {
        return $this->_fetch();
    }

    /**
     * 登陆
     * @return mixed
     */
    public function login(Request $request){
        if($request->isPost()){
            $this->result=$this->login->login($this->params);
            return $this->_result();
        }else{
            return $this->_fetch();
        }
    }

    /**
     * 注销
     * @return mixed
     */
    public function logout(){
        $this->result=$this->login->logout();
        return $this->_jump(Url::build("admin/Index/login"));
    }

    public function table(){
        return $this->_fetch();
    }

    public function form(){
        if($this->request->isPost()){
            $this->result=[];
            return $this->_result();
        }else{
            return $this->_fetch();
        }
    }

    public function echarts(){
        return $this->_fetch();
    }
}
