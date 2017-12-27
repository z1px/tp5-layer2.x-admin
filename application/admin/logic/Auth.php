<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 2017/12/27
 * Time: 21:52
 */

namespace app\admin\logic;


use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use app\admin\service\Admin;
use think\Config;
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
        'auth_group'        => 'auth_group',        // 用户组数据表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
        'auth_rule'         => 'auth_rule',         // 权限规则表
        'auth_user'         => 'admin',             // 用户信息表
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

    /**
     * 检查权限
     * @param $name     //名称m
     * @param $uid      //用户id
     * @param int $type   //类型
     * @param string $mode  //
     * @param string $relation
     * @return bool
     */
    public function check($name, $uid, $type=1, $mode='url', $relation='or') {
        if (!$this->auth_on) return true;
        $authList = $this->getAuthList($uid,$type); //获取用户需要验证的所有有效规则列表
        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = []; //保存验证通过的规则名
        if ($mode=='url') {
            $REQUEST = unserialize( strtolower(serialize($_REQUEST)) );
        }
        foreach ( $authList as $auth ) {
            $query = preg_replace('/^.+\?/U','',$auth);
            //print_r($query);
            if ($mode=='url' && $query!=$auth ) {
                parse_str($query,$param); //解析规则中的param
                $intersect = array_intersect_assoc($REQUEST,$param);
                $auth = preg_replace('/\?.*$/U','',$auth);
                if ( in_array($auth,$name) && $intersect==$param ) {  //如果节点相符且url参数满足
                    $list[] = $auth ;
                }
            }else if (in_array($auth , $name)){
                $list[] = $auth ;
            }
        }
        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     *  根据用户id获取用户组,返回值为数组
     * @param $uid   用户id
     * @return array       用户所属的用户组 array(
     *     array('uid'=>'用户id','group_id'=>'用户组id','title'=>'用户组名称','rules'=>'用户组拥有的规则id,多个,号隔开'),
     *     ...)
     */
    public function getGroups($uid) {
        static $groups = [];
        if (isset($groups[$uid]))
            return $groups[$uid];
        $where=[
            'uid'=>$uid,
            'status'=>1,
        ];
        $user_groups =$this->authGroupAccess->alias('a')->where($where)->join("__AUTH_GROUP__ g "," a.group_id=g.id")->column("uid,group_id,title,rules","a.id");
        $groups[$uid]=$user_groups?array_values($user_groups):[];
        return $groups[$uid];
    }
    /**
     * 获取权限名称
     * @param $rules
     * @return mixed
     */
    public function getRules($rules,$order=[]){
        static $groups = [];
        if (isset($groups[$rules]))
            return $groups[$rules];
        $map['status']=array('eq',1);
        $map['menu']=array('eq',1);
        $map['id']=array('in',$rules);
        $user_groups = $this->authRule->where($map)->order($order)->column("*","id");
        foreach ($user_groups as $key => $value) {
            $user_groups[$key]['urls']=Url::build($value['url']);
        }
        return array_values($user_groups);
    }
    /**
     * 用户二级分类pid
     * @param $name
     * @return mixed
     */
    public function getId($name){
        $authRuleId = $this->authRule->where(["name"=>$name])->value("pid");
        if(empty($authRuleId)){
            return 0;
        }else{
            return $authRuleId['pid'];
        }
    }
    /**
     * 查找用户的一级分类pid
     * @param $id
     * @return mixed
     */
    public function getFirstId($id){
        $authRuleFirstId = $this->authRule->where(["id"=>$id])->value("pid");
        if(empty($authRuleFirstId)){
            return 0;
        }else{
            return $authRuleFirstId;
        }
    }
    /**
     * 获得权限列表
     * @param $uid  用户id
     * @param $type
     * @return array|mixed
     */
    protected function getAuthList($uid,$type) {
        static $_authList = []; //保存用户验证通过的权限列表
        $t = implode(',',(array)$type);
        if (isset($_authList[$uid.$t])) {
            return $_authList[$uid.$t];
        }
        $session=session('_AUTH_LIST_'.$uid.$t);
        if( $this->auth_type==2 && isset($session)){
            return $session;
        }
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = [];//保存用户所属用户组设置的所有权限规则id
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        if (empty($ids)) {
            $_authList[$uid.$t] = [];
            return [];
        }
        $map=array(
            'id'=>array('in',$ids),
            'type'=>$type,
            'status'=>1,
        );
        //读取用户组所有权限规则
        $rules = $this->authRule->where($map)->field('condition,name')->select();
        //循环规则，判断结果。
        $authList = [];   //
        foreach ($rules as $rule) {
            if (!empty($rule['condition'])) { //根据condition进行验证
                $user = $this->getUserInfo($uid);//获取用户信息,一维数组
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if (isset($condition) && $condition) {
                    $authList[] = strtolower($rule['name']);
                }
            } else {
                //只要存在就记录
                $authList[] = strtolower($rule['name']);
            }
        }
        $_authList[$uid.$t] = $authList;
        // print_r($_authList);exit;
        if($this->auth_type==2){
            //规则列表结果保存到session
            session('_AUTH_LIST_'.$uid.$t,$authList);
        }
        return array_unique($authList);
    }
    /**
     * 获取用户组的权限
     * @param $id
     * @param $order
     * @return array
     */
    public function  getRuleListById($id,$order){
        $rules = $this->getGroups($id);
        $rbac = $this->getRules($rules[0]['rules'],$order);
        return node_merge($rbac);
    }
    /**
     * 获得用户资料,根据自己的情况读取数据库
     * @param $uid    // 用户id
     * @return mixed
     */
    protected function getUserInfo($uid) {
        static $userInfo=[];
        if(!isset($userInfo[$uid])){
            $userInfo[$uid]=$this->admin->field("id,username,true_name,mobile,email,img,status,create_time,last_login_time")->where(["id"=>$uid])->find();
            if(!empty($userInfo[$uid])) $userInfo[$uid]=$userInfo[$uid]->toArray();
        }
        return $userInfo[$uid];
    }

}