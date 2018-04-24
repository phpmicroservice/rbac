<?php

namespace app\controller;
/**
 * 配置处理
 */
class Demo extends \pms\Controller
{

    /**
     * @param $data
     */
    public function index($data)
    {
        $this->connect->send_succee([
            $data, "我是RBAC分组" . time()
        ]);
    }

    public function demo2($data)
    {
        $this->connect->send_succee([
            $data, "我是RBAC分组.demo2"
        ]);
    }
}