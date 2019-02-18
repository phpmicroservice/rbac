<?php

namespace app\controller;

use app\Controller;
use app\logic\Alc2;
use app\logic\Auth;

/**
 * 权限管理
 * Class Authority
 * @package app\controller
 */
class Authority extends Controller
{


    /**
     * 权限列表
     */
    public function auth_list()
    {
        $role = $this->getData('role_id');
        $list = Auth::auths($role, 'list');
        return $this->send($list);
    }

    /**
     * 增加权限
     * 
     */
    public function add_auth()
    {
        $data = $this->getData();
        $re = Auth::add_auth($data);
        return $this->send($re);
    }

    /**
     * 编辑权限
     */
    public function edit_auth()
    {
        $id = $this->getData('id');
        $data = $this->getData();
        $re = Auth::edit_auth($id, $data);
        \pms\output($re, '46');
        if (is_string($re)) {
            return $this->connect->send_error($re);
        }
        return $this->send($re);
    }

    /**
     * 获取单个权限信息
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function auth_info()
    {
        $id = $this->getData('id');
        $re = Auth::auth_info($id);
        if (is_string($re)) {
            return $this->connect->send_error($re);
        }
        return $this->send($re);
    }

    /**
     * 权限删除
     */
    public function del_auth()
    {
        $id = $this->getData('id');
        $re = Auth::del_auth($id);
        if (is_string($re)) {
            return $this->connect->send_error($re);
        }
        return $this->send($re);
    }

    /**
     * 删除权限
     *
     */
    public function del_auth2()
    {
        $role = $this->getData('role_id');
        $resources = $this->getData('resources_id');
        $re = Auth::del_auth2($role, $resources);
        if (is_string($re)) {
            return $this->connect->send_error($re);
        }
        return $this->send($re);
    }


}