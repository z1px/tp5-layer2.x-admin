<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 11:33
 */

namespace app\admin\service;


use \app\admin\model\AuthRule as AuthRuleModel;
use think\Loader;

class AuthRule extends AuthRuleModel {

    public function add($params){
        $params=params_format($params);
        $validate = Loader::validate('AuthRule');
        if(!$validate->scene("add")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
            return $this->result;
        }
        $this->allowField(true)->isUpdate(false)->save($params);
        if(empty($this->id)){
            $this->result["code"]=0;
            $this->result["msg"]="新增失败";
        }else{
            $this->result["msg"]="新增成功";
        }
        return $this->result;
    }

    public function edit($params){
        $params=params_format($params);
        $validate = Loader::validate('AuthRule');
        if(!$validate->scene("edit")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
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

    public function getById($id){
        $data=$this->field("id,name,title,icon,type,status,condition,pid,create_time,update_time")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="规则不存在";
        }else{
            $this->result["data"]=$data->append(["type_name","status_name"])->toArray();
        }
        unset($data);
        return $this->result;
    }

    public function del($id){
        $data=$this->field("id,name,title,icon,type,status,condition,pid,create_time,update_time")->find($id);
        if(empty($data)){
            $this->result["code"]=0;
            $this->result["msg"]="规则不存在";
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

        $validate = Loader::validate('AuthRule');
        if(!$validate->scene("edit_status")->check($params)){
            $this->result["code"]=0;
            $this->result["msg"]=$validate->getError();
            unset($validate);
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
            $this->result=$this->getById($id);
            $this->result["msg"]="修改成功";
        }
        return $this->result;
    }

    public function getList($params){

        if(!isset($params["page"])) $params["page"]=1;
        if(!isset($params["limit"])) $params["limit"]=10;
        $where=[];
        $order="id desc";
        if(isset($params["keyword"]) && !empty($params["keyword"])) $where["name|title|condition"]=["like","%{$params["keyword"]}%"];
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=["like","%{$params[$value]}%"];
        },
            ["name","title","condition"]
        );
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=$params[$value];
        },
            ["type","status","pid"]
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
                if($params["field"]=="type_name") $params["field"]="type";
                if($params["field"]=="status_name") $params["field"]="status";
                $order="{$params["field"]} {$params["order"]}";
            }
        }
        $list=$this->field("id,name,title,icon,type,status,condition,pid,create_time,update_time")->where($where)->page($params["page"],$params["limit"])->order($order)->select();
        $this->result["count"]=$this->where($where)->Count();
        unset($params,$where);
        if(empty($list)){
            $list=[];
        }else{
            foreach ($list as $key=>$value){
                $list[$key]=$value->append(["type_name","status_name"])->toArray();
            }
            unset($key,$value);
        }
        $this->result["list"]=$list;
        unset($list);
        return $this->result;
    }


    /**
     * 用户组菜单列表
     * bool型json会转成0,1，zTree识别不出来，所以要加引号
     */
    public function getAll($params){
        $list=$this->order("id asc")->column("name,title,icon,type,status,condition,pid","id");
        if(!empty($list)){
            $rules=[];
            if(isset($params["group_id"]) && !empty($params["group_id"])){
                $authGroup=new AuthGroup();
                $rules=$authGroup->where(["id"=>$params["group_id"]])->value("rules");
                $rules=explode(",",$rules);
                unset($authGroup);
            }
            foreach ($list as $key=>$value){
                if(empty($value["pid"])){
                    $list[$key]["open"]='true';
                }else{
                    if(!isset($list[$key]["open"])) $list[$key]["open"]='false';
                    $list[$value["pid"]]["open"]='true';
                }
                if(in_array($value["id"],$rules)){
                    $list[$key]["checked"]='true';
                }else{
                    $list[$key]["checked"]='false';
                }
            }
            unset($key,$value,$rules);
        }
        return array_values($list);
    }

    /**
     * 菜单增加修改时选择上级菜单
     * @param
     */
    public function getRuleList($pid=0,$prefix="|—",$ptitle=false,$level=0){

        $field = "name,title,icon,type,status,condition,pid";
        if($ptitle&&!is_array($ptitle)){
            $ptitle = $this->column("title","id");
        }
        if($ptitle) $field .= ",create_time,update_time";
        $level++;
        $list=$this->where(["pid"=>$pid])->order("id asc")->column($field,"id");
        unset($field);
        $result=[];
        if(!empty($list)){
            foreach ($list as $key=>$value){
                $value["title"] = $prefix.$value["title"];
                if(isset($value["create_time"])&&!empty($value["create_time"])) $value["create_time"]=date("Y-m-d H:i:s",$value["create_time"]);
                if(isset($value["update_time"])&&!empty($value["update_time"])) $value["update_time"]=date("Y-m-d H:i:s",$value["update_time"]);
                $value["level"] = $level;
                if($ptitle){
                    $value["ptitle"]=empty($value["pid"])?"<font color='red'>顶级菜单</font>":(isset($ptitle[$value["pid"]])?$ptitle[$value["pid"]]:"ERROR");
                }
                $result[] = $value;
                $temp = $this->getRuleList($value["id"],$prefix." —",$ptitle,$level);
                if(!empty($temp)) $result = array_merge($result,$temp);
                unset($temp);
            }
        }
        unset($ptitle);
        return $result;
    }

}