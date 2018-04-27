<?php

namespace app\controller;

use app\Controller;
use app\logic\Role;

/**
 * 角色管理的用户管理
 * Class User
 * @package app\controller
 */
class User extends Controller
{

    /**
     * 角色的用户列表
     */
    public function role_user_list()
    {
        $page = $this->getData('p');
        $role_id = $this->getData('role_id');
        $service = new \app\logic\User();
        $re = $service->role_user_list((int)$role_id, (int)$page);
        return $this->send($re);
    }

    /**
     * 判断用户角色
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @throws \Phalcon\Validation\Exception
     */
    public function role_user_is()
    {
        $user_id = $this->getData('user_id');
        $role_name = $this->getData('role_name');
        $service = new \app\logic\User();
        $re = $service->role_user_is($user_id, $role_name);
        return $this->send($re);
    }

    /**
     * 清空当前角色的用户信息
     */
    public function empty_user_role()
    {
        $role_id = $this->request->get('role_id', 'int', 0);
        $re = $this->service->empty_user_role($role_id);
        return $this->send($re);
    }


    /**
     * 用户角色增加
     */
    public function user_add_role()
    {
        $data = $this->getData();
        $re = \app\logic\User::add_user($data['user_id'], $data['role_id']);
        return $this->send($re);
    }


    /**
     * 用户角色删除
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function user_del_role()
    {
        $user_id = $this->request->get('user_id', 'int', 0);
        $role_id = $this->request->get('role_id', 'int', 0);
        $re = \logic\rbac\Role::user_del_role($role_id, $user_id);
        return $this->send($re);
    }


    /**
     * 用户角色列表
     */
    public function user_role_list()
    {
        $user_id = $this->request->get('user_id', 'int', 0);
        $re = \logic\rbac\Role::user_roles_index($user_id);
        return $this->send($re);

    }

}