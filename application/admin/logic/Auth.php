<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/28
 * Time: 20:16
 */

namespace app\admin\logic;


use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use app\admin\service\Admin;
use think\Config;
use think\Session;
use think\Url;

class Auth {

    //权限规则
    protected $admin;
    //权限规则
    protected $authRule;
    //权限分组
    protected $authGroup;
    //用户组明细表
    protected $authGroupAccess;
    //返回结果
    protected $result;
    //auth权限配置文件
    protected $config=[
        'auth_on'           => true,                      // 认证开关
        'auth_type'         => 1,                         // 认证方式，1为实时认证；2为登录认证。
    ];

    public function __construct(){

        $config = Config::get("auth_config");
        if(is_array($config) && !empty($config)) {
            $this->config  =  array_merge($this->config,$config);
        }
        unset($config);

        $this->admin = new Admin();
        $this->authRule = new AuthRule();
        $this->authGroup = new AuthGroup();
        $this->authGroupAccess = new AuthGroupAccess();
        $this->result=[
            "code"=>1,
            "msg"=>"data normal",
            "data"=>[],
        ];
    }

    public function __get($name){
        if(isset($this->config[$name])) {
            return $this->config[$name];
        }
        return null;
    }

    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    public function __isset($name){
        return isset($this->config[$name]);
    }

    //获得权限$name 可以是字符串或数组或逗号分割， uid为 认证的用户id， $or 是否为or关系，为true是， name为数组，只要数组中有一个条件通过则通过，如果为false需要全部条件通过。
    public function check($name, $uid, $relation='or') {
        if (!$this->auth_on) return true;

        $authList = $this->getAuthList($uid);
        if(!is_array($name)) $name = explode(',', $name);
        $list = []; //有权限的name
        foreach ($name as $key=>$value){
            $name[$key]=strtolower($value);
        }
        foreach ($authList as $val) {
            if (in_array(strtolower($val), $name))
                $list[] = $val;
        }
        if ($relation=='or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation=='and' and empty($diff)) {
            return true;
        }
        return false;
    }

    //获得用户组，外部也可以调用
    public function getGroups($uid) {
        static $groups = [];
        if (isset($groups[$uid])){
            return $groups[$uid];
        }
        $user_groups =$this->authGroupAccess->alias('a')->where(['uid'=>$uid,'status'=>1])->join("__AUTH_GROUP__ g "," a.group_id=g.id")->column("uid,group_id,title,rules","a.id");
        $groups[$uid]=$user_groups?array_values($user_groups):[];
        return $groups[$uid];
    }

    //获得权限列表
    protected function getAuthList($uid) {
        static $_authList = [];
        if (isset($_authList[$uid])) {
            return $_authList[$uid];
        }
        if(Session::has('_AUTH_LIST_'.$uid)){
            return Session::get('_AUTH_LIST_'.$uid);
        }
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = $this->authRule->where(["type"=>2])->column("id");
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid] = [];
            return [];
        }
        //读取用户组所有权限规则
        $rules = $this->authRule->where(["id"=>["in",$ids],'type'=>["in",[1,2]]])->column('condition,name,type',"id");
        //循环规则，判断结果。
        $authList = [];
        foreach ($rules as $r) {
            if ($r["type"]==1&&!empty($r['condition'])) {
                //条件验证
                $user = $this->getUserInfo($uid);
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $r['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if (isset($condition) && $condition) {
                    $authList[] = $r['name'];
                }
            } else {
                //存在就通过
                $authList[] = $r['name'];
            }
        }
        $_authList[$uid] = $authList;
        if($this->auth_type==2){
            //session结果
            Session::set('_AUTH_LIST_'.$uid,$authList);
        }
        return $authList;
    }

    //获得用户资料,根据自己的情况读取数据库
    protected function getUserInfo($uid) {
        static $userinfo=[];
        if(!isset($userinfo[$uid])){
            $userinfo[$uid]=$this->admin->field("id,username,mobile,email,status")->where(["id"=>$uid])->find();
            if(!empty($userInfo[$uid])) $userInfo[$uid]=$userInfo[$uid]->toArray();
        }
        return $userinfo[$uid];
    }

    protected function checkRules($rules,$uid){
        //循环规则，判断结果。
        $ruleList = [];
        foreach ($rules as $r) {
            if ($r["type"]==1&&!empty($r['condition'])) {
                //条件验证
                $user = $this->getUserInfo($uid);
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $r['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if (!isset($condition) || empty($condition)) {
                    continue;
                }
            }
            $r["url"]=filter_var($r["name"], FILTER_VALIDATE_URL)?$r["name"]:Url::build($r["name"]);
            $ruleList[] = $r;
        }
        return $ruleList;
    }

    /**
     * 获得顶部菜单列表
     * @param $uid
     * @return array
     */
    public function getOnelevel($uid){
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = [];
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) return [];
        //读取用户组所有权限规则
        $where = ["pid"=>0,"status"=>1];
        if($uid!=1){
            $where["id"]=["in",$ids];
            $where["type"]=["in",[1,2]];
        }
        $rules = $this->authRule->where($where)->order("id asc")->column('name,title,icon,condition,type,pid',"id");
        unset($where);
        if(empty($rules)){
            $rules=[];
        }else{
            $rules = $this->checkRules($rules,$uid);
        }
        return $rules;
    }

    /**
     * 获得左边菜单列表
     * @param $uid
     * @return array
     */
    public function getNavbar($uid) {
        $onelevel = $this->getOnelevel($uid);
        if(empty($onelevel)) return [];

        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = [];
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);

        $list = [];
        foreach ($onelevel as $value){

            //读取用户组所有权限规则
            $where = ["pid"=>$value["id"],"status"=>1];
            if($uid!=1){
                $where["id"]=["in",$ids];
                $where["type"]=["in",[1,2]];
            }
            $rules = $this->authRule->where($where)->order("id asc")->column('name,title,icon,condition,type,pid',"id");
            unset($where);
            if(empty($rules)){
                $list[$value["id"]]=[[]];
                continue;
            }
            //循环规则，判断结果。
            $ruleList = [];
            foreach ($rules as $r) {
                if ($r["type"]==1&&!empty($r['condition'])) {
                    //条件验证
                    $user = $this->getUserInfo($uid);
                    $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $r['condition']);
                    //dump($command);//debug
                    @(eval('$condition=(' . $command . ');'));
                    if (!isset($condition) || empty($condition)) {
                        continue;
                    }
                }
                $r["url"]=$r["url"]=filter_var($r["name"], FILTER_VALIDATE_URL)?$r["name"]:Url::build($r["name"]);
                $r["spread"]=true;
                //读取用户组所有权限规则
                $where = ["pid"=>$r["id"],"status"=>1];
                if($uid!=1){
                    $where["id"]=["in",$ids];
                    $where["type"]=["in",[1,2]];
                }
                $rules_children = $this->authRule->where($where)->order("id asc")->column('name,title,icon,condition,type,pid',"id");
                unset($where);
                $r["children"] = $this->checkRules($rules_children,$uid);
                $ruleList[] = $r;
                unset($rules_children);
            }
            $list[$value["id"]]=$ruleList;
            unset($ruleList);
        }
        return $list;
    }

    /**
     * 获得左边菜单列表
     * @param $uid
     * @return array
     */
    public function getNavbarByPid($uid,$pid) {

        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = [];
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);

        //读取用户组所有权限规则
        $where = ["pid"=>$pid,"status"=>1];
        if($uid!=1){
            $where["id"]=["in",$ids];
            $where["type"]=["in",[1,2]];
        }
        $rules = $this->authRule->where($where)->order("id asc")->column('name,title,icon,condition,type,pid',"id");
        unset($where);
        if(empty($rules)) return [[]];
        //循环规则，判断结果。
        $ruleList = [];
        foreach ($rules as $r) {
            if ($r["type"]==1&&!empty($r['condition'])) {
                //条件验证
                $user = $this->getUserInfo($uid);
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $r['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if (!isset($condition) || empty($condition)) {
                    continue;
                }
            }
            $r["url"]=$r["url"]=filter_var($r["name"], FILTER_VALIDATE_URL)?$r["name"]:Url::build($r["name"]);
            $r["spread"]=true;
            //读取用户组所有权限规则
            $where = ["pid"=>$r["id"],"status"=>1];
            if($uid!=1){
                $where["id"]=["in",$ids];
                $where["type"]=["in",[1,2]];
            }
            $rules_children = $this->authRule->where($where)->order("id asc")->column('name,title,icon,condition,type,pid',"id");
            unset($where);
            $r["children"] = $this->checkRules($rules_children,$uid);
            $ruleList[] = $r;
            unset($rules_children);
        }
        return $ruleList;
    }

}