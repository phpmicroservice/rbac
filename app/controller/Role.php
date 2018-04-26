<?php

namespace app\controller;


use app\Controller;
use app\logic\Alc;
use app\logic\Role as RoleLogic;

/**
 * 角色管理
 * Class Role
 * @package app\controller
 */
class Role extends Controller
{


    # 角色的传送信息
    private $parameter_role = [
        'identification' => ['post', 'identification', 'string', '', true],
        'name' => ['post', 'name', 'string', '名字', true],
        'sort' => ['post', 'sort', 'int', 0, true],
        'status' => ['post', 'status', 'int', '', true],
        'pid' => ['post', 'pid', 'int', 1, true],
        'can_delete' => ['post', 'can_delete', 'int', '', true]
    ];

    /**
     * 增加角色
     */
    public function add_role()
    {
        $data = $this->getData($this->parameter_role);
        $Role = new Role();
        $re = $Role->add_role($data);
        return $this->send($re);
    }

    /**
     * 编辑角色
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function edit_role()
    {
        $this->parameter_role['id'] = ['post', 'id', 'int', 0, true];
        $data = $this->getData($this->parameter_role);
        $Role = new Role();
        $re = $Role->edit_role($data);
        return $this->send($re);
    }

    /**
     * 删除角色
     */
    public function del_role()
    {
        $id = $this->request->get('id', 'int', 0);
        $Role = new Role();
        $re = $Role->del_role($id);
        return $this->send($re);

    }

    /**
     * 获取单个资源信息
     */
    public function role_info()
    {
        $id = $this->request->get('id', 'int', 0);
        $Role = new Role();
        $re = $Role->role_info($id);
        return $this->send($re);
    }

    /**
     * 角色列表
     */
    public function role_list()
    {
        $Role = new Role();
        $re = $Role->role_list();
        return $this->restful_success($re);
    }

}