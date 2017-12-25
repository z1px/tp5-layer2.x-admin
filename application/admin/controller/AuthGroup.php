<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/25
 * Time: 23:46
 */

namespace app\admin\controller;


use app\admin\service\AuthGroup as AuthGroupService;

class AuthGroup extends Common {

    protected $authGroup;

    protected function _before(){
        $this->authGroup=new AuthGroupService();
    }

    /**
     * 权限组列表
     * @return mixed
     */
    public function table(){

        if($this->request->isPost()){
            $this->result=$this->authGroup->getList($this->params);
            return $this->_result();
        }else{
            return $this->_fetch(["list_status"=>$this->authGroup->list_status]);
        }
    }


    /**
     * 添加权限组
     */
    public function add(){
        if($this->request->isPost()){
            $this->result=$this->authGroup->add($this->params);
            return $this->_result();
        }else{
            return $this->_fetch(["list_status"=>$this->authGroup->list_status]);
        }
    }

    /**
     * 修改权限组信息
     */
    public function edit(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_jump();
        }

        if($this->request->isPost()){
            $this->result=$this->authGroup->edit($this->params);
            return $this->_result();
        }else{
            $this->result=$this->authGroup->getById($this->params["id"]);
            if($this->result["code"]==0) return $this->_jump();
            $this->result["list_status"] = $this->authGroup->list_status;
            return $this->_fetch(["data"=>$this->result["data"],"list_status"=>$this->authGroup->list_status]);
        }
    }

    /**
     * 修改权限组状态
     */
    public function editStatus(){
        $this->result=$this->authGroup->editStatus($this->params);
        return $this->_result();
    }

    /**
     * 删除权限组
     */
    public function del(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_result();
        }

        $this->result=$this->authGroup->del($this->params["id"]);
        return $this->_result();
    }

}