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

    /**
     * 增加角色
     */
    public function add_role()
    {
        $data = $this->getData();
        $Role = new RoleLogic();
        $re = $Role->add_role($data);
        return $this->send($re);
    }

    /**
     * 编辑角色
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function edit_role()
    {
        $data = $this->getData();
        $Role = new RoleLogic();
        $re = $Role->edit_role($data);
        return $this->send($re);
    }

    /**
     * 删除角色
     */
    public function del_role()
    {
        $id = $this->getData('id');
        $Role = new RoleLogic();
        $re = $Role->del_role($id);
        return $this->send($re);

    }

    /**
     * 获取单个资源信息
     */
    public function roleinfo()
    {
        $id = $this->getData('id');
        $Role = new RoleLogic();
        $re = $Role->role_info($id);
        return $this->send($re);
    }

    /**
     * 角色列表
     */
    public function role_list()
    {
        $Role = new RoleLogic();
        $re = $Role->role_list();
        return $this->send($re);
    }

}