<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 11:33
 */

namespace app\admin\service;


use \app\admin\model\Admin as AdminModel;
use think\Cookie;
use think\Loader;

class Admin extends AdminModel {

    public function editMyInfo($params){
        $params=params_format($params,["password"]);
        $params["id"]=Cookie::get("login_id");
        $validate = Loader::validate('Admin');
        if(!$validate->scene("edit")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if(check_phone($params["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是手机号";
            return $this->result;
        }
        if(check_email($params["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是邮箱号";
            return $this->result;
        }
        $id=$params["id"];
        unset($params["id"]);
        $data=$this->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="数据不存在，修改失败";
            return $this->result;
        }
        $res=$data->allowField(true)->save($params);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="修改失败";
        }else{
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }


    public function add($params){
        $params=params_format($params,["password"]);
        $validate = Loader::validate('Admin');
        if(!$validate->scene("add")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if(check_phone($params["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是手机号";
            return $this->result;
        }
        if(check_email($params["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是邮箱号";
            return $this->result;
        }
        $this->allowField(true)->isUpdate(false)->save($params);
        if(empty($this->id)){
            $this->result["code"]=0;
            $this->result["msg"]="新增失败";
        }else{
            if(isset($params["group_id"])){
                $authGroup = new AuthGroup();
                $this->result=$authGroup->editGroupAccess(["id"=>$this->id,"group_id"=>$params["group_id"]]);
                unset($authGroup);
            }
            $this->result["msg"]="新增成功";
        }
        return $this->result;
    }

    public function edit($params){
        $params=params_format($params,["password"]);
        $validate = Loader::validate('Admin');
        if(!$validate->scene("edit")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if(check_phone($params["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是手机号";
            return $this->result;
        }
        if(check_email($params["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是邮箱号";
            return $this->result;
        }
        $id=$params["id"];
        unset($params["id"]);
        $data=$this->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="数据不存在，修改失败";
            return $this->result;
        }
        $res=$data->allowField(true)->save($params);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="修改失败";
        }else{
            if(isset($params["group_id"])){
                $authGroup = new AuthGroup();
                $this->result=$authGroup->editGroupAccess(["id"=>$id,"group_id"=>$params["group_id"]]);
                unset($authGroup);
            }
            $this->result=$this->getById($id);
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }

    public function getById($id){
        $data=$this->field("id,username,true_name,mobile,email,img,status,create_time,last_login_time")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="用户不存在";
        }else{
            $this->result["data"]=$data->append(["status_name","group_name"])->toArray();
        }
        unset($data);
        return $this->result;
    }

    public function del($id){
        $data=$this->field("id,username,true_name,mobile,email,img,status")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="用户不存在";
            return $this->result;
        }
        if($id==1){
            $this->result["code"]=0;
            $this->result["msg"]="系统账号不可删除";
            return $this->result;
        }
        $res=$data->delete();
        unset($data);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="删除失败";
        }else{
            $this->result["msg"]="删除成功";
        }
        unset($data);
        return $this->result;
    }

    public function editStatus($params){

        $validate = Loader::validate('Admin');
        if(!$validate->scene("edit_status")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if($params["id"]==1){
            $this->result["code"]=0;
            $this->result["msg"]="系统账号不可以禁用";
            return $this->result;
        }
        $id=$params["id"];
        unset($params["id"]);
        $data=$this->field("id,status")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="数据不存在，修改失败";
            return $this->result;
        }
        $res=$data->allowField(["status","update_time"])->save($params);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="修改失败";
        }else{
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }

    public function getList($params){

        if(!isset($params["page"])) $params["page"]=1;
        if(!isset($params["limit"])) $params["limit"]=10;
        $where=[];
        $order="id desc";
        if(isset($params["keyword"]) && !empty($params["keyword"])) $where["username|true_name|mobile|email"]=["like","%{$params["keyword"]}%"];
        array_map(function ($value) use (&$where,$params){
                if(isset($params[$value]) && !empty($params[$value])) $where[$value]=$params[$value];
            },
            ["username","true_name","mobile","email","status"]
        );
        if(!isset($params["begin_time"])) $params["begin_time"]="";
        if(!isset($params["end_time"])) $params["end_time"]="";
        if(!empty($params["begin_time"])&&empty($params["end_time"])){
            $where["create_time"]=["egt",strtotime($params["begin_time"]." 00:00:00")];
        }elseif(empty($params["begin_time"])&&!empty($params["end_time"])){
            $where["create_time"]=["elt",strtotime($params["end_time"]." 23:59:59")];
        }elseif(!empty($params["begin_time"])&&!empty($params["end_time"])){
            $where["create_time"]=["between",[strtotime($params["begin_time"]." 00:00:00"),strtotime($params["end_time"]." 23:59:59")]];
        }
        if(isset($params["field"])){
            if(!empty($params["field"])){
                if($params["field"]=="status_name") $params["field"]="status";
                $order="{$params["field"]} {$params["order"]}";
            }
        }
        $list=$this->field("id,username,true_name,mobile,email,img,status,create_time,last_login_time,ip,area")->where($where)->page($params["page"],$params["limit"])->order($order)->select();
        $this->result["count"]=$this->where($where)->Count();
        unset($params,$where);
        if(empty($list)){
            $list=[];
        }else{
            foreach ($list as $key=>$value){
                $value->last_login_time=date("Y-m-d H:i:s",$value->last_login_time);
                $list[$key]=$value->append(["status_name","group_name"])->toArray();
            }
            unset($key,$value);
        }
        $this->result["list"]=$list;
        unset($list);
        return $this->result;
    }


    public function getAll(){
        $list=$this->order("id asc")->column("username,true_name,email,mobile,img,status","id");
        return array_values($list);
    }

}