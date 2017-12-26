<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 19:49
 */

namespace app\admin\controller;


use lib\MyRedis;
use think\Controller;
use think\Request;

class Test extends Controller {

    protected $redis;

    public function __construct(Request $request = null) {
        parent::__construct($request);

        $this->redis = new MyRedis();
    }

    public function index(){

        $this->redis->timeout = 1;

        dump($this->redis->ping());
        dump($this->redis->handler->keys("*"));
        dump($this->redis->handler()->keys("*"));

    }

}