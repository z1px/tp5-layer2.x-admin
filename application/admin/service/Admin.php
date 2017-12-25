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

    public function editMyInfo($row){
        $row=params_format($row,["password"]);
        $row["id"]=Cookie::get("login_id");
        $validate = Loader::validate('Admin');
        if(!$validate->scene("edit")->check($row)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if(check_phone($row["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是手机号";
            return $this->result;
        }
        if(check_email($row["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是邮箱号";
            return $this->result;
        }
        $id=$row["id"];
        unset($row["id"]);
        $data=$this->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="数据不存在，修改失败";
            return $this->result;
        }
        $res=$data->allowField(true)->save($row);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="修改失败";
        }else{
//            $this->result=$this->getById($id);
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }


    public function add($row){
        $row=params_format($row,["password"]);
        $validate = Loader::validate('Admin');
        if(!$validate->scene("add")->check($row)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if(check_phone($row["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是手机号";
            return $this->result;
        }
        if(check_email($row["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是邮箱号";
            return $this->result;
        }
        $this->allowField(true)->isUpdate(false)->save($row);
        if(empty($this->id)){
            $this->result["code"]=0;
            $this->result["msg"]="新增失败";
        }else{
            $this->result=$this->getById($this->id);
            $this->result["msg"]="新增成功";
        }
        return $this->result;
    }

    public function edit($row){
        $row=params_format($row,["password"]);
        $validate = Loader::validate('Admin');
        if(!$validate->scene("edit")->check($row)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if(check_phone($row["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是手机号";
            return $this->result;
        }
        if(check_email($row["username"])){
            $this->result["code"]=0;
            $this->result["msg"]="用户名不能是邮箱号";
            return $this->result;
        }
        $id=$row["id"];
        unset($row["id"]);
        $data=$this->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="数据不存在，修改失败";
            return $this->result;
        }
        $res=$data->allowField(true)->save($row);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="修改失败";
        }else{
            $this->result=$this->getById($id);
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }

    public function getById($id){
        $data=$this->field("id,username,true_name,mobile,email,status,create_time,last_login_time")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="用户不存在";
        }else{
            $this->result["data"]=$data->append(["status_name"])->toArray();
        }
        unset($data);
        return $this->result;
    }

    public function del($id){
        $data=$this->field("id,username,true_name,mobile,email,status")->find($id);
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

    public function editStatus($row){

        $validate = Loader::validate('Admin');
        if(!$validate->scene("edit_status")->check($row)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        if($row["id"]==1){
            $this->result["code"]=0;
            $this->result["msg"]="系统账号不可以禁用";
            return $this->result;
        }
        $id=$row["id"];
        unset($row["id"]);
        $data=$this->field("id,status")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="数据不存在，修改失败";
            return $this->result;
        }
        $res=$data->allowField(["status","update_time"])->save($row);
        if(empty($res)){
            $this->result["code"]=0;
            $this->result["msg"]="修改失败";
        }else{
            $this->result=$this->getById($id);
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }

    public function getList($row){

        if(!isset($row["page"])) $row["page"]=1;
        if(!isset($row["limit"])) $row["limit"]=10;
        $where=[];
        $order="id desc";
        if(isset($row["keyword"]) && !empty($row["keyword"])) $where["username|true_name|mobile|email"]=["like","%{$row["keyword"]}%"];
        array_map(function ($value) use (&$where,$row){
                if(isset($row[$value]) && !empty($row[$value])) $where[$value]=$row[$value];
            },
            ["username","true_name","mobile","email","status"]
        );
        if(!isset($row["begin_time"])) $row["begin_time"]="";
        if(!isset($row["end_time"])) $row["end_time"]="";
        if(!empty($row["begin_time"])&&empty($row["end_time"])){
            $where["create_time"]=["egt",strtotime($row["begin_time"]." 00:00:00")];
        }elseif(empty($row["begin_time"])&&!empty($row["end_time"])){
            $where["create_time"]=["elt",strtotime($row["end_time"]." 23:59:59")];
        }elseif(!empty($row["begin_time"])&&!empty($row["end_time"])){
            $where["create_time"]=["between",[strtotime($row["begin_time"]." 00:00:00"),strtotime($row["end_time"]." 23:59:59")]];
        }
        if(isset($row["field"])){
            if(!empty($row["field"])){
                if($row["field"]=="status_name") $row["field"]="status";
                $order="{$row["field"]} {$row["order"]}";
            }
        }
        $list=$this->field("id,username,true_name,mobile,email,status,create_time,last_login_time,ip,area")->where($where)->page($row["page"],$row["limit"])->order($order)->select();
        $this->result["count"]=$this->where($where)->Count();
        unset($row,$where);
        if(empty($list)){
            $list=[];
        }else{
            foreach ($list as $key=>$value){
                $value->last_login_time=date("Y-m-d H:i:s",$value->last_login_time);
                $list[$key]=$value->append(["status_name"])->toArray();
            }
            unset($key,$value);
        }
        $this->result["list"]=$list;
        unset($list);
        return $this->result;
    }


    public function getAll(){
        $list=$this->order("id asc")->column("username,true_name,email,mobile,status","id");
        return array_values($list);
    }

}