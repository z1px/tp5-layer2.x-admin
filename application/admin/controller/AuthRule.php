<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/25
 * Time: 23:46
 */

namespace app\admin\controller;


use app\admin\service\AuthRule as AuthRuleService;

class AuthRule extends Common {

    protected $authRule;

    protected function _before(){
        $this->authRule=new AuthRuleService();
    }

    /**
     * 权限规则列表
     * @return mixed
     */
    public function table(){

        if($this->request->isPost()){
            $this->result=$this->authRule->getList($this->params);
            return $this->_result();
        }else{
            return $this->_fetch(["list_type"=>$this->authRule->list_type,"list_status"=>$this->authRule->list_status]);
        }
    }


    /**
     * 添加权限规则
     */
    public function add(){
        if($this->request->isPost()){
            $this->result=$this->authRule->add($this->params);
            return $this->_result();
        }else{
            return $this->_fetch(["list_type"=>$this->authRule->list_type,"list_status"=>$this->authRule->list_status]);
        }
    }

    /**
     * 修改权限规则信息
     */
    public function edit(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_jump();
        }

        if($this->request->isPost()){
            $this->result=$this->authRule->edit($this->params);
            return $this->_result();
        }else{
            $this->result=$this->authRule->getById($this->params["id"]);
            if($this->result["code"]==0) return $this->_jump();
            $this->result["list_status"] = $this->authRule->list_status;
            return $this->_fetch(["data"=>$this->result["data"],"list_type"=>$this->authRule->list_type,"list_status"=>$this->authRule->list_status]);
        }
    }

    /**
     * 修改权限规则状态
     */
    public function editStatus(){
        $this->result=$this->authRule->editStatus($this->params);
        return $this->_result();
    }

    /**
     * 删除权限规则
     */
    public function del(){
        if(!isset($this->params["id"])){
            $this->result["code"]=0;
            $this->result["msg"]="参数错误";
            return $this->_result();
        }

        $this->result=$this->authRule->del($this->params["id"]);
        return $this->_result();
    }


    public function getAll(){
//        if($this->request->isPost()){
            $this->result=$this->authRule->getAll($this->params);
            return $this->_result();
//        }else{
//            return $this->_fetch(["list_type"=>$this->authRule->list_type,"list_status"=>$this->authRule->list_status]);
//        }
    }

}