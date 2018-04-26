<?php

namespace app\controller;

use app\Controller;
use app\logic\Alc;

/**
 * 权限管理
 * Class Authority
 * @package app\controller
 */
class Authority extends Controller
{


    private $parameter_auth = [
        'title' => ['post', 'title', 'string', '', true],
        'role' => ['post', 'role', 'int', 0, true],
        'resources' => ['post', 'resources', 'int', 0, true],
        'description' => ['post', 'description', 'string', '', true],
        'type' => ['post', 'type', 'int', 1, true],
        'status' => ['post', 'status', 'string', '', true],
        'condition' => ['post', 'condition', 'string', '', true],
    ];

    /**
     * 权限列表
     */
    public function auth_list()
    {
        $role = $this->request->get('role');
        $list = Alc::auths($role, 'list');
        return $this->restful_success($list);
    }

    /**
     * 增加权限
     */
    public function add_auth()
    {

        $data = $this->getData($this->parameter_auth);
        $re = Alc::add_auth($data);
        return $this->send($re);
    }

    /**
     * 编辑权限
     */
    public function edit_auth()
    {
        $id = $this->request->getPost('id', 'int', 0);
        $data = $this->getData($this->parameter_auth);
        $re = Alc::edit_auth($id, $data);
        if (is_string($re)) {
            return $this->restful_error($re);
        }
        return $this->restful_success($re);
    }

    /**
     * 获取单个权限信息
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function auth_info()
    {
        $id = $this->request->get('id', 'int', 0);
        $re = Alc::auth_info($id);
        if (is_string($re)) {
            return $this->restful_error($re);
        }
        return $this->restful_success($re);
    }

    /**
     * 权限删除
     */
    public function del_auth()
    {
        $id = $this->request->get('id', 'int', 0);
        $re = Alc::del_auth($id);
        return $this->send($re);
    }

    /**
     * 删除权限
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function del_auth2()
    {
        $role = $this->request->get('role', 'int', 0);
        $resources = $this->request->get('resources', 'int', 0);
        $re = Alc::del_auth2($role, $resources);

        return $this->send($re);
    }


}