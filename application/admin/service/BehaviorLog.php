<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/28
 * Time: 17:37
 */

namespace app\admin\service;


use \app\admin\model\BehaviorLog as BehaviorLogModel;

class BehaviorLog extends BehaviorLogModel {


    public function getList($params){

        if(!isset($params["page"])) $params["page"]=1;
        if(!isset($params["limit"])) $params["limit"]=10;
        $where=[];
        $order="id desc";
        if(isset($params["keyword"]) && !empty($params["keyword"])) $where["title|module|controller|action|url|request|response"]=["like","%{$params["keyword"]}%"];
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=["like","%{$params[$value]}%"];
        },
            ["title","request","response"]
        );
        array_map(function ($value) use (&$where,$params){
            if(isset($params[$value]) && !empty($params[$value])) $where[$value]=$params[$value];
        },
            ["module","controller","action","type","admin_id"]
        );
        if(isset($params["sort"]) && !empty($params["sort"])){
            $order="{$params["sort"]} {$params["order"]}";
        }
        if(isset($params["begin_end"])&&!empty($params["begin_end"])){
            $where["FROM_UNIXTIME(create_time,'%Y-%m-%d')"]=["between",array_map("trim",explode("~",$params["begin_end"]))];
        }

        if(isset($params["download"])&&$params["download"]==1) { // 导出到cvs文件并下载
            $order="id asc";
            $callback = function ($data){
                return array_values(array_map(function ($data){
                    return "\t{$data}";
                },$data));
            };
            if($params["page"]==1){
                $this->result["filename"]="BehaviorLog";
                $this->result["title"]=array_values([
                    "id"=>"\t编号",
                    "admin_id"=>"\t管理员ID",
                    "username"=>"\t管理员账号",
                    "title"=>"\t行为标题",
                    "module"=>"\t模块",
                    "controller"=>"\t控制器",
                    "action"=>"\t方法名",
                    "url"=>"\t请求地址",
                    "type"=>"\t请求类型",
                    "request"=>"\t请求参数",
                    "response"=>"\t响应结果",
                    "ip"=>"\tIP",
                    "area"=>"\tIP区域",
                    "create_time"=>"\t操作时间",
                ]);
            }else{
                unset($this->result["filename"],$this->result["title"]);
            }
        }else{
            $callback = function ($data){
                if(isset($data["request"])&&!empty($data["request"])) $data["request"]=var_export(json_decode($data["request"],true),true);
                if(isset($data["response"])&&!empty($data["response"])) $data["response"]=var_export(json_decode($data["response"],true),true);
                return $data;
            };
        }

        // 数据处理
        $func = function ($list) use ($callback){
            if(empty($list) || !is_array($list)) return [];
            return array_map(function ($data) use ($callback){
                return $callback($data->toArray());
            },$list);
        };

        $list=$this->field("id,admin_id,username,title,module,controller,action,url,type,request,response,ip,area,create_time")->where($where)->page($params["page"],$params["limit"])->order($order)->select();
        $this->result["count"]=$this->where($where)->Count();
        unset($params,$where);

        $this->result["list"]=$func($list);
        unset($list);
        return $this->result;
    }

}