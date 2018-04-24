<?php
/**
 * Created by PhpStorm.
 * User: saisai
 * Date: 17-5-12
 * Time: 上午9:12
 */

namespace apps\admin\controllers;

use logic\rbac\Role;

/**
 * 用户角色管理
 * Class UserRoleController
 * @package apps\admin\controllers
 * @property \logic\rbac\Role $service
 * @author Dongasai<1514582970@qq.com>
 */
class UserroleController extends \core\CoreController
{

    private $service;

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->service = new Role();
    }

    /**
     * 角色的用户列表
     */
    public function role_user_list()
    {
        $page = $this->request->get('p', 'int', 1);
        $role_id = $this->request->get('role_id', 'int', 0);
        $re = $this->service->role_user_list($role_id, $page);
        return $this->restful_return($re);

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
        return $this->restful_return($re);
    }

    /**
     * 清空当前角色的用户信息
     */
    public function empty_user_role()
    {
        $role_id = $this->request->get('role_id', 'int', 0);
        $re = $this->service->empty_user_role($role_id);
        return $this->restful_return($re);
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
        return $this->restful_return($re);
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
        return $this->restful_return($re);
    }


    /**
     * 用户角色列表
     */
    public function user_role_list()
    {
        $user_id = $this->request->get('user_id', 'int', 0);
        $re = \logic\rbac\Role::user_roles_index($user_id);
        return $this->restful_return($re);

    }
}