<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 16:43
 */

namespace app\admin\controller;


use think\Config;
use think\Request;
use think\Url;

class Data extends Common {

    protected function _before() {

    }

    public function onelevel(){
        $this->result = Config::get("onelevel");
        return $this->_result();
    }

    public function navbar(){
        $this->result = Config::get("navbar.{$this->request->param("id",0)}");
        return $this->_result();
    }

    public function table(){
        $this->result = Config::get("table");
        return $this->_result();
    }

}