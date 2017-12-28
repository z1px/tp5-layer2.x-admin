<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 16:43
 */

namespace app\admin\controller;


use app\admin\logic\Auth;

class Data extends Common {

    protected $auth;
    protected $uid;

    protected function _before() {
        $this->auth = new Auth();
        $this->uid = isset($this->account["id"])?$this->account["id"]:0;
    }

    //顶部菜单
    public function onelevel(){
        $this->result = $this->auth->getOnelevel($this->uid);
        return $this->_result();
    }

    //左侧菜单
    public function navbar(){
        $this->result = $this->auth->getNavbarByPid($this->uid,$this->request->param("id",0));
        return $this->_result();
    }

}