<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 19:13
 */

namespace lib;


use BadFunctionCallException;
use Redis;

/**
 * Class MyRedis
 * @package lib
 * 单例模式
 */
class MyRedis {

    /** @var Redis */
    private $handler = null;

    private static $_instance = null;//属性值为对象,默认为null

    //默认配置
    private $config  = [
        'host'         => '127.0.0.1', // redis主机
        'port'         => 6379, // redis端口
        'password'     => '', // 密码
        'select'       => 0, // 操作库
        'timeout'      => 180, // 超时时间(秒)
        'persistent'   => true, // 是否长连接
    ];

    /**
     * 构造函数
     * __construct()方法到实例化时自动加载function
     */
    private function __construct($config = []) {
        if(is_array($config) && !empty($config)){
            $this->config = array_merge($this->config, $config);
        }
        $this->connect();
    }

    /**
     * 单例获取对象
     * @param array $config
     * @return MyRedis|null
     */
    public static function getInstance($config = []){
        if (empty(self::$_instance)) {
            self::$_instance = new self($config);
        }
        return self::$_instance;
    }

    /**
     * 单例获取服务器连接句柄，执行原生命令
     * @param array $config
     * @return Redis
     */
    public static function getHandler($config = []){
        if (empty(self::$_instance)) {
            self::$_instance = new self($config);
        }
        return self::$_instance->handler();
    }

    public function handler(){
        $this->ping();
        return $this->handler;
    }

    /**
     * 连接数据库
     * @return bool
     */
    public function connect() {
        // 检测php环境
        if (!extension_loaded('redis')) {
            throw new BadFunctionCallException('not support: redis');
        }

        $this->handler = new Redis;

        // 建立连接
        $func = $this->persistent ? 'pconnect' : 'connect';
        $this->handler->$func($this->host, $this->port, $this->timeout);

        if ('' != $this->password) {
            $this->handler->auth($this->password);
        }

        if (0 != $this->select) {
            $this->handler->select($this->select);
        }

        return true;
    }

    /**
     * 连接检测
     */
    public function ping(){
        try {
            //执行插入操作
            $this->handler->ping();
        } catch (\Exception $e) {
            // 捕捉异常，记录日志或其他的操作
            $this->connect();
        } /*finally {
            // 插入出错后继续执行的代码,如关闭数据库连接，返回给客户端错误信息等。

        }*/
        return true;
    }

    /**
     * 选择数据库
     * @return bool
     */
    public function select(){
        $this->ping();
        return $this->handler->select($this->select);
    }

    /**
     * 关闭连接
     * @access public
     */
    public function close() {
        $this->handler->close();
        $this->handler = null;
        return true;
    }



    //__get()方法用来获取私有属性
    public function __get($name){
        if(isset($this->config[$name])) {
            return $this->config[$name];
        }
        return null;
    }

    //__set()方法用来设置私有属性
    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    //__isset()方法用来检测私有成员属性是否被设定
    public function __isset($name){
        return isset($this->config[$name]);
    }

    //__unset()方法用来删除私有成员属性
    public function __unset($name){
        unset($this->config[$name]);
    }

    //__call()方法用来获取没有定义的function
    public function __call($name, $param){
        return false;
    }

    //__toString()方法用来获取类名
    public function __toString() {
        return __CLASS__;
    }

    // 覆盖__clone()方法，禁止克隆
    public function __clone(){
        return false;
    }

    /**
     * 析构函数
     * __destruct()删除类对象时自动会调用
     */
    public function __destruct() {
        $this->close();
    }

}