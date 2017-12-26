<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/24
 * Time: 1:51
 */

namespace app\admin\controller;


use app\admin\service\Admin;
use app\admin\service\BehaviorLog;
use app\admin\service\LoginLog;
use app\admin\service\AuthGroup as AuthGroupService;

class Account extends Common {

    protected $admin;
    protected $authGroup;

    protected function _before(){
        $this->admin=new Admin();
        $this->authGroup=new AuthGroupService();
    }

    /**
     * 修改管理员信息
     */
    public function myinfo(){

        if($this->request->isPost()){
            $this->result=$this->admin->editMyInfo($this->params);

            return $this->_jump("/");
        }else{
            return $this->_fetch(["data"=>$this->account]);
        }
    }

    /**
     * 管理员列表
     * @return mixed
     */
    public function table(){

        if($this->request->isPost()){
            $this->result=$this->admin->getList($this->params);
            return $this->_result();
        }else{
            return $this->_fetch(["list_status"=>$this->admin->list_status]);
        }
    }


    /**
     * 添加管理员
     */
    public function add(){
        if($this->request->isPost()){
            $this->result=$this->admin->add($this->params);
            return $this->_result();
        }else{
            return $this->_fetch(["list_status"=>$this->admin->list_status,"list_group"=>$this->authGroup->getAll($this->params)]);
        }
    }

    /**
     * 修改管理员信息
     */
    public function edit(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_jump();
        }

        if($this->request->isPost()){
            $this->result=$this->admin->edit($this->params);
            return $this->_result();
        }else{
            $this->result=$this->admin->getById($this->params["id"]);
            if($this->result["code"]==0) return $this->_jump();
            $this->result["list_status"] = $this->admin->list_status;
            return $this->_fetch(["data"=>$this->result["data"],"list_status"=>$this->admin->list_status,"list_group"=>$this->authGroup->getAll($this->params)]);
        }
    }

    /**
     * 修改管理员账号状态
     */
    public function editStatus(){
        $this->result=$this->admin->editStatus($this->params);
        return $this->_result();
    }

    /**
     * 删除管理员
     */
    public function del(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_result();
        }

        $this->result=$this->admin->del($this->params["id"]);
        return $this->_result();
    }

    /**
     * 修改用户组信息
     */
    public function editGroup(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_jump();
        }


        if($this->request->isPost()){
            $this->result=$this->authGroup->editGroupAccess($this->params);
            return $this->_result();
        }else{
            $this->result=$this->admin->getById($this->params["id"]);
            if($this->result["code"]==0) return $this->_jump();
            return $this->_fetch(["data"=>$this->result["data"],"list_group"=>$this->authGroup->getAll($this->params)]);
        }
    }

    /**
     * 登录日志
     * @return mixed
     */
    public function loginLog(){

        if($this->request->isPost()){
            $loginLog = new LoginLog();
            $this->result=$loginLog->getList($this->params);
            unset($loginLog);
            return $this->_result();
        }else{
            return $this->_fetch(["list_admin"=>$this->admin->getAll()]);
        }
    }

    /**
     * 行为日志
     * @return mixed
     */
    public function behaviorLog(){

        if($this->request->isPost()){
            $behaviorLog = new BehaviorLog();
            $this->result=$behaviorLog->getList($this->params);
            unset($behaviorLog);
            return $this->_result();
        }else{
            return $this->_fetch(["list_admin"=>$this->admin->getAll()]);
        }
    }

}