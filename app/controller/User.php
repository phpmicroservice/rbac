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
        $page = $this->request->get('p', 'int', 1);
        $role_id = $this->request->get('role_id', 'int', 0);
        $re = $this->service->role_user_list($role_id, $page);
        return $this->send($re);

    }

    /**
     * 判断用户角色
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @throws \Phalcon\Validation\Exception
     */
    public function role_user_is()
    {
        $user_id = $this->request->get('user_id', 'int', 0);
        $role_name = $this->request->get('role_name', 'string', 0);
        $service = new \logic\rbac\Role();
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
        $data = $this->getData([
            'uid' => ['post', 'user_id', 'int', 0],
            'role_id' => ['post', 'role_id', 'int', 0],
            'end_date' => ['post', 'end_date', 'string', '0000-00-00'],
            'is_permanence' => ['post', 'is_permanence', 'int', 1],
        ]);


        $re = Role::add_user($data['uid'], $data['role_id']);
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